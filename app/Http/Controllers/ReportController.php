<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Exception;
use DB;
use Str;
use App\Models\Expense;
use App\Models\Property;
use App\Models\Payment;
use App\Models\InvoiceDetail;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:report-browse',['only' => ['index']]);
       
       
    }
	public function report()
    {   
        $propertyTypes = Property::get()->pluck('property_name', 'id');
        return View('report.index',compact('propertyTypes'));
    }
    public function reportList(Request $request)
    {
        $propertyId = $request->input('property_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query CAM and utility payments, grouped by year and month, with date filters
        $data = InvoiceDetail::join('invoices', 'invoice_details.invoice_id', 'invoices.id')
            ->when($propertyId, function($query) use ($propertyId) {
                return $query->where('invoices.property_id', $propertyId);
            })
            ->when($startDate, function($query) use ($startDate) {
                return $query->whereDate('invoice_details.created_at', '>=', $startDate);
            })
            ->when($endDate, function($query) use ($endDate) {
                return $query->whereDate('invoice_details.created_at', '<=', $endDate);
            })
            ->select(
                'invoices.property_id',
                DB::raw("YEAR(invoice_details.created_at) as year"),
                DB::raw("MONTH(invoice_details.created_at) as month"),
                DB::raw('SUM(CASE WHEN type IN ("cam","cam-gst") THEN invoice_details.amount ELSE 0 END) as cam_received'),
                DB::raw('SUM(CASE WHEN type IN ("utility","utility-gst") THEN invoice_details.amount ELSE 0 END) as utility_received')
            )
            ->groupBy('invoices.property_id', 'year', 'month')
            ->get();

        // Query CAM and utility expenses with date filters, grouped by property
        $expenses = Expense::when($propertyId, function($query) use ($propertyId) {
                return $query->where('property_id', $propertyId);
            })
            ->when($startDate, function($query) use ($startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function($query) use ($endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->select(
                'property_id',
                DB::raw("YEAR(created_at) as year"),
                DB::raw("MONTH(created_at) as month"),
                DB::raw('SUM(CASE WHEN type = "1" THEN price ELSE 0 END) as cam_expense'),
                DB::raw('SUM(CASE WHEN type = "2" THEN price ELSE 0 END) as utility_expense')
            )
            ->groupBy('property_id', 'year', 'month')
            ->get();

        // Convert expenses to an associative array with keys "propertyId-year-month" for easy lookup
        $expenseData = $expenses->mapWithKeys(function($expense) {
            $key = $expense->property_id . '-' . $expense->year . '-' . str_pad($expense->month, 2, '0', STR_PAD_LEFT);
            return [
                $key => [
                    'cam_expense' => $expense->cam_expense,
                    'utility_expense' => $expense->utility_expense,
                ]
            ];
        });

        // Merge payment data with expense data
        $report = $data->map(function($payment) use ($expenseData) {
            $period = $payment->year . '-' . str_pad($payment->month, 2, '0', STR_PAD_LEFT);
            $key = $payment->property_id . '-' . $period;
            $expense = $expenseData[$key] ?? ['cam_expense' => 0, 'utility_expense' => 0];

            // Calculate CAM profit/loss and generate the badge
            $camProfitLoss = $payment->cam_received - $expense['cam_expense'];
            $camSign = $camProfitLoss >= 0 ? '+' : '-';
            $camColor = $camProfitLoss >= 0 ? 'success' : 'danger';
            $camBadge = $camSign . ' ' . formatIndianCurrency(abs($camProfitLoss));

            // Calculate Utility profit/loss and generate the badge (fix issue here)
            $utilityProfitLoss = $payment->utility_received - $expense['utility_expense'];
            $utilitySign = $utilityProfitLoss >= 0 ? '+' : '-';
            $utilityColor = $utilityProfitLoss >= 0 ? 'success' : 'danger';  // Fixed to use $utilityProfitLoss
            $utilityBadge = $utilitySign . ' ' . formatIndianCurrency(abs($utilityProfitLoss));

            $property = Property::find($payment->property_id);
            
            return [
                'property' => $property ? $property->property_name . '(' . $property->property_code . ')' : 'Unknown Property',
                'period' => $period,
                'cam_received' => formatIndianCurrency($payment->cam_received),
                'cam_expense' => formatIndianCurrency($expense['cam_expense']),
                'cam_profit_loss' =>  $camBadge,
                'utility_received' => formatIndianCurrency($payment->utility_received),
                'utility_expense' => formatIndianCurrency($expense['utility_expense']),
                'utility_profit_loss' =>  $utilityBadge,

            ];
        });



        return DataTables::of($report)
        ->make(true);
    }


}
