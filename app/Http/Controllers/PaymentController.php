<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
use PDF;
use App\Models\AppSetting;
use App\Models\Lease;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Property;
class PaymentController extends Controller
{

     public function index($id = NULL)
    {
        if (\Auth::user()->can('lease-browse')) {
            $data = Payment::get();
            $propertyTypes = Property::get()->pluck('property_name', 'id');
            $leases = Lease::get()->pluck('unique_id ', 'id');
            $partners = User::get()->pluck('first_name', 'id');
            $tenants = Tenant::get()->pluck('firm_name', 'id');
            $id = $id;
            return View('payment.index',compact('propertyTypes','data','partners','tenants','id','leases'));
        } else {
            return redirect()->back();
        }
    }
     public function paymentHistoryList(Request $request)
    {
        $query = Payment::orderBy('id','DESC')->with('property','tenant','lease','invoice');
       
        if(!empty($request->property_id))
        {
            $query->where('property_id', $request->property_id);
        }
        if(!empty($request->lease_id))
        {
            $query->where('lease_id', $request->lease_id);
        }
        if($request->status!='')
        {
            $query->where('status', $request->status);
        }
        return datatables($query)
            ->editColumn('property_id', function ($query)
            {
                
                return $query->property->property_code;
            })
             ->editColumn('lease_id', function ($query)
            {
                
                return $query->lease->unique_id ;
            })
            ->editColumn('invoice_id', function ($query)
            {
                $invoice_id = ($query->invoice) ? $query->invoice->invoice_no.'('.$query->invoice->invoice_type.')' :'';
                
                return $invoice_id;
            })
           
            ->editColumn('status', function ($query)
            {
                if ($query->status == 'Full')
                {
                    $status = 'Full';
                    $class='bg-label-success';
                }
                elseif ($query->status == 'Partial')
                {
                    $status = 'Partial';
                    $class='bg-label-info';
                }
                else
                {
                    $status = 'Pending';
                    $class='bg-label-primary';
                }

                return '<span class="badge '.$class.' text-capitalize ">' . $status . '</span>';
            })

            ->addColumn('action', function ($query)
            {

                $checkTotalPay = Payment::where('invoice_id',$query->invoice_id)->sum('amount');
                $edit ='';
                $delete ='';
                if($checkTotalPay < $query->grand_total) {

                $edit =' <a href="#!" data-size="lg"
                                data-url="'.route('edit-payment', $query->id) .'" 
                                data-ajax-popup="true" class=" btn btn-sm btn-primary"
                                data-bs-original-title="Payment Edit">
                                <i class="ti ti-pencil"></i>
                            </a>';
                $delete = '<a 
                                href="'.route('payment-delete', $query->id) .'" 
                                 class=" btn btn-sm btn-danger"
                                onClick="return confirm(\'Are you sure you want to delete this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="ti ti-trash"></i>
                            </a>';
                }

                $download =' <a class="btn btn-sm btn-primary" href="'.route('download-recipt', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-download"></i></a>';

                return '<div class="btn-group btn-group-xs">'.$edit.$delete.$download.'</div>';
            })
        ->escapeColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }

     public function addPayment(Request $request)
    {

        $validator = \Validator::make(
            $request->all(), [
                'id' => 'required|exists:invoices,id',
                'invoiceAmount' => 'required',
                'paymentDate' => 'required',
                'paymentStatus' => 'required',
                
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        
        DB::beginTransaction();
        try{

                $addPayment = new Payment;
                
               
                $invoice = Invoice::where('id',$request->id)->first();
                
                $totalAmount = floatval(str_replace(',', '', $request->totalAmount));
                $invoiceAmount = floatval(str_replace(',', '', $request->invoiceAmount));
                $grand_total = floatval(str_replace(',', '', $request->grand_total));
                
                if($invoiceAmount > $totalAmount){
                    return response()->json([
                        'errors' => 'Payment amount exceeds invoice balance!'
                    ], 500);
                }
                $addPayment->invoice_id       = $request->id;
                $addPayment->partner_id       = $invoice->partner_id;
                $addPayment->lease_id       = $invoice->lease_id;
                $addPayment->property_id       = $invoice->property_id;
                $addPayment->tenant_id       = $invoice->tenant_id;
                $addPayment->payment_date       = (!empty($request->payment_date)) ? $request->payment_date :date('Y-m-d H:i:s');
                $addPayment->grand_total       = $grand_total;
                $addPayment->total_amount       = $totalAmount;
                $addPayment->amount       = $invoiceAmount;
                $addPayment->remaining_amount = $totalAmount - $invoiceAmount;
                $addPayment->invoice_type = $invoice->invoice_type;

                $addPayment->payment_method       = $request->paymentMethod;
                $addPayment->note       = $request->paymentNote;
                $addPayment->status       = $request->paymentStatus;
                $addPayment->reference_no       = $request->reference_no;
                $addPayment->note       = $request->paymentNote;
                $addPayment->paid_by       = auth()->user()->id;
                $addPayment->save();


                //Update Invoice
                $checkTotalPay = Payment::where('invoice_id',$request->id)->sum('amount');
                $pStatus = ($checkTotalPay >= $grand_total) ?'Full'  :'Partial';
                $invoice->payment_status = $pStatus;
                $invoice->total_amount       = $totalAmount - $invoiceAmount;
                $invoice->amount       = $invoiceAmount;
                $invoice->remaining_amount = $totalAmount - $invoiceAmount;

                $invoice->save();


                if($addPayment) {
                 DB::commit();
                return response()->json([
                    'message' => 'Payment Added Successfully!'
                ], 200);
                } else {
                    return response()->json([
                        'errors' => 'Something went wrong!'
                    ], 500);
                }
        
        } catch (Exception $exception) {
            \Log::info($exception->getMessage());
            return response()->json([
                'errors' => $exception->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return View('payment.edit',compact('payment'));
    }
    public function  update(Request $request, $id)
    {

        $validator = \Validator::make(
            $request->all(), [
                'amount' => 'required',
                'payment_date' => 'required',
                'status' => 'required',
                
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        
        DB::beginTransaction();
        try{

                $editPayment =  Payment::findOrFail($id);
                if($request->amount > $editPayment->total_amount){

                    return redirect()->route('payment-history')->with('error', __('Payment amount exceeds invoice balance!.'));
                   
                }

                
                $editPayment->payment_date       = (!empty($request->payment_date)) ? $request->payment_date :date('Y-m-d H:i:s');
                $editPayment->amount       = $request->amount;
                $editPayment->remaining_amount = $editPayment->total_amount - $request->amount;

                $editPayment->payment_method       = $request->payment_method;
                $editPayment->note       = $request->note;
                $editPayment->status       = $request->status;
                $editPayment->reference_no       = $request->reference_no;
                $editPayment->note       = $request->note;
                $editPayment->save();
                if($editPayment) {

                //Update Invoice
                $checkTotalPay = Payment::where('invoice_id',$request->id)->sum('amount');
                $pStatus = ($checkTotalPay >= $editPayment->grand_total) ?'Full'  :'Partial';

                $invoice = Invoice::findOrFail($editPayment->invoice_id);
                $invoice->payment_status = $pStatus;
                $invoice->amount       = $request->amount;
                $invoice->remaining_amount = $editPayment->total_amount - $request->amount;
                $invoice->save();


                DB::commit();
                return redirect()->route('payment-history')->with('success', __('Payment successfully updated.'));
                } else {
                return redirect()->route('payment-history')->with('error', __('Something went wrong!.'));
                }
        
        } catch (Exception $exception) {
            \Log::error($e);
            DB::rollback();
             return redirect()->back()->with('error', $e->getMessage());
        }
    }

     public function destroy($id)
    {
      $payment = Payment::findOrFail($id);
        if ($payment) {

           
            
            $invoice = Invoice::findOrFail($payment->invoice_id);
            $invoice->total_amount       = $payment->total_amount;
            $invoice->amount       = $invoice->amount;
            $invoice->remaining_amount = $invoice->remaining_amount+$payment->amount;
            $invoice->save();
            $payment->delete();

            $checkTotalPay = Payment::where('invoice_id',$payment->invoice_id)->sum('amount');
            $pStatus = ($checkTotalPay >= $payment->grand_total) ?'Full'  :'Partial';
            $invoicen = Invoice::findOrFail($payment->invoice_id);
            $invoicen->payment_status = $pStatus;
            $invoicen->save();

            return redirect()->route('payment-history')->with('success', __('Payment successfully deleted .'));
        } else {
            return redirect()->back()->with('error', __('Record not found.'));
        }
       
    }
    public function download($id)
    {
       $payment = Payment::with('invoice')->findOrFail($id);
        if ($payment) {

            $pdf = PDF::loadView('receipt',compact('payment'));

            $fileName = $payment->id.'-'.time().'.pdf';
            // Save the PDF to a temporary location
            $pdfPath = storage_path('app/public/uploads/' . $fileName);

            return $pdf->download($fileName);
        } else {
            return redirect()->back()->with('error', __('Record not found.'));
        }

       
    }
}
