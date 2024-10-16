<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyPaymentSetting;
use App\Models\PropertyType;
use App\Models\PropertyUnit;
use App\Models\PropertyExtraCharges;
use App\Models\PropertyLateFees;
use App\Models\PropertyUtility;
use App\Models\UnitType;
use App\Models\Utility;
use App\Models\ExtraCharge;
use App\Models\LateFees;
use App\Models\Lease;
use App\Models\LeaseType;
use App\Models\Tenant;
use App\Models\LeaseUtilityDeposite;
use App\Models\LeaseExtraCharge;
use App\Models\LeaseUtility;
use App\Models\AppSetting;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
use PDF;
use NumberToWords\NumberToWords;

class InvoiceController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:lease-browse',['only' => ['index']]);
        $this->middleware('permission:lease-add', ['only' => ['store']]);
        $this->middleware('permission:lease-edit', ['only' => ['update']]);
        $this->middleware('permission:lease-read', ['only' => ['show']]);
        $this->middleware('permission:lease-delete', ['only' => ['destroy']]);
    }

    public function invoice()
    {
        if (\Auth::user()->can('invoice-browse')) {
            $data = Lease::get();
            $propertyTypes = Property::get()->pluck('property_name', 'id');
            $partners = User::get()->pluck('first_name', 'id');

            $invoice = Payment::query();
            $countData['totalInvoice']= Invoice::count();
            $countData['totalInVoiceAmount']= $invoice->sum('grand_total');
            $countData['totalPaid']= $invoice->whereIn('status',['Full','Partial'])->sum('amount');
            $countData['totalUnPaid']= $invoice->whereIn('status',['Full','Partial'])->sum('remaining_amount');
            
            return View('invoice.index',compact('propertyTypes','data','partners','countData'));
        } else {
            return redirect()->back();
        }
    }
    public function invoiceList(Request $request)
    {
        $query = Invoice::orderBy('id','DESC')->with('property','tenant','partner','lease');
       
        if(!empty($request->property_id))
        {
            $query->where('property_id', $request->property_id);
        }
        if(!empty($request->tenant_id))
        {
            $query->where('tenant_id', $request->tenant_id);
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
            ->editColumn('invoice_no', function ($query)
            {
                
                return '<a class="" href="'.route('invoice-view', $query->id) .'">'.$query->invoice_no.'</a>';
            })
            ->editColumn('tenant_id', function ($query)
            {
                
                return $query->tenant->firm_name;
            })
            ->editColumn('lease_id', function ($query)
            {
                
                return '<a class="" href="'.route('invoice-view', $query->id) .'">'.$query->lease->unique_id.'</a>';
            })
            ->editColumn('partner_id', function ($query)
            {
                
                return @$query->partner->first_name.'  '.@$query->partner->lastname;
            })
            ->editColumn('grand_total', function ($query)
            {
                  if($query->partner_type=='1')
                    {
                      $total_amount = $query->partner_per;
                      $persign = '';
                    } else{
                      $total_amount = ($query->rent_total * $query->partner_per)/100;
                     
                    }
                    $cgst = ($total_amount*$query->rent_cgst_per)/100;
                    $sgst = ($total_amount*$query->rent_sgst_per)/100;
                    if($query->is_gst =='1' && $query->invoice_type=='rent'){
                        $grand_total = $total_amount+$cgst+$sgst;
                    } else{
                        $grand_total = $total_amount;
                    }
                    if($query->invoice_type=='cam'){

                        $grand_total = $query->cam_total_amount;
                    }
                    if($query->invoice_type=='utility'){
                        $ucgst = ($query->utility_total*$query->rent_cgst_per)/100;
                        $usgst = ($query->utility_total*$query->rent_sgst_per)/100;
                        $grand_total = $query->utility_total+ $ucgst+$usgst;
                    }
                  
                return formatIndianCurrency($grand_total);
            })
            ->addColumn('total_paid', function ($query)
            {
                $payment = Payment::query();
                $totalPaid= $payment->where('invoice_id',$query->id)->whereIn('status',['Full','Partial'])->sum('amount');

                 return formatIndianCurrency($totalPaid);
          
            })
             ->addColumn('total_unpaid', function ($query)
            {
                
                return formatIndianCurrency($query->remaining_amount);

            })
            ->editColumn('status', function ($query)
            {
                if ($query->status == 'Sent')
                {
                    $status = 'Sent';
                    $class='bg-label-success';
                }
                elseif ($query->status == 'Failed')
                {
                    $status = 'Failed';
                    $class='bg-label-warning';
                }
                else
                {
                    $status = 'Generated';
                    $class='bg-label-primary';
                }

                return '<span class="badge '.$class.' text-capitalize ">' . $status . '</span>';
            })
            ->editColumn('payment_status', function ($query)
            {
                if ($query->payment_status == 'Full')
                {
                    $status = 'Paid';
                    $class='bg-label-success';
                }
                elseif ($query->payment_status == 'Partial')
                {
                    $status = 'Partial';
                    $class='bg-label-info';
                }
                else
                {
                    $status = 'UnPaid';
                    $class='bg-label-warning';
                }

                return '<span class="badge '.$class.' text-capitalize ">' . $status . '</span>';
            })

            ->addColumn('action', function ($query)
            {

                
                $view ='';
                $campview ='';
                $utilityview ='';
                if (\Gate::allows('invoice-rent')) {
                    $view =' <a class="btn btn-sm btn-info" href="'.route('invoice-view', $query->id) .'" data-bs-toggle="tooltip" data-placement="top" title="View" data-original-title="view">View</a>';
                }
                



                return '<div class="btn-group btn-group-xs">'.$view.'</div>';
            })
        ->escapeColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }
     public function invoiceView($id)
    {
        if (\Auth::user()->can('invoice-browse')) {
          
            $data = Invoice::with('tenant','property','lease','partner')->findOrFail($id);
            if($data->invoice_type=='rent'){
                if($data->is_gst=='1') {
                    $rent_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['rent','rent-gst'])->orderBy('id','ASC')->get();
                }
                else{
                    $rent_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','rent')->orderBy('id','ASC')->get();
                }

               
                return View('invoice.show',compact('data','rent_invoices'));

            }
            if($data->invoice_type=='cam'){

                if($data->is_gst=='1') {
                    $cam_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['cam','cam-gst'])->orderBy('id','ASC')->get();
                }
                else{
                    $cam_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','cam')->orderBy('id','ASC')->get();
                }

            
                return View('invoice.cam-invoice',compact('data','cam_invoices'));
            }
            if($data->invoice_type=='utility'){
                $utility_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','utility')->get();
           
                return View('invoice.utility-invoice',compact('data','utility_invoices'));

            }
        } else {
            return redirect()->back();
        }
    }
    public function camInvoice($id)
    {
        if (\Auth::user()->can('invoice-browse')) {
    
            $data = Invoice::with('tenant','property','lease','partner')->findOrFail($id);
            if($data->is_gst=='1') {
                $cam_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['cam','cam-gst'])->orderBy('id','ASC')->get();
            }
            else{
                $cam_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','cam')->orderBy('id','ASC')->get();
            }

        
            return View('invoice.cam-invoice',compact('data','cam_invoices'));
        } else {
            return redirect()->back();
        }
    }
     public function utilityInvoice($id)
    {
        if (\Auth::user()->can('invoice-browse')) {
            $data = Invoice::with('tenant','property','lease','partner')->findOrFail($id);
            $utility_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','utility')->get();
           
            return View('invoice.utility-invoice',compact('data','utility_invoices'));
        } else {
            return redirect()->back();
        }
    }
    public function invoiceEdit($id)
    {
        if (\Auth::user()->can('invoice-browse')) {
            $numberToWords = new NumberToWords();
            // Get the number transformer
            $numberTransformer = $numberToWords->getNumberTransformer('en'); 
            $data = Invoice::with('tenant','property','lease','partner')->findOrFail($id);
            if($data->is_gst=='1') {
                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['rent','rent-gst'])->orderBy('id','ASC')->get();
            }
            else{
                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','rent')->orderBy('id','ASC')->get();
            }

            $rent_gts = InvoiceDetail::where('invoice_id',$id)->where('type','rent-gst')->get();
            $cam_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','cam')->get();
            $utility_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','utility')->get();
           
            return View('invoice.edit',compact('data','rent_invoices','cam_invoices','utility_invoices','numberTransformer','rent_gts'));
        } else {
            return redirect()->back();
        }
    }
    public function invoiceTemplate()
    {
        $id='1';
        if (\Auth::user()->can('invoice-browse')) {
            $numberToWords = new NumberToWords();
            // Get the number transformer
            $numberTransformer = $numberToWords->getNumberTransformer('en'); 
            $data = Invoice::with('tenant','property','lease','partner')->findOrFail($id);
            if($data->is_gst=='1') {
                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['rent','rent-gst'])->orderBy('id','ASC')->get();
            }
            else{
                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','rent')->orderBy('id','ASC')->get();
            }

            $rent_gts = InvoiceDetail::where('invoice_id',$id)->where('type','rent-gst')->get();
            $cam_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','cam')->get();
            $utility_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','utility')->get();
           
            return View('invoice-new-1',compact('data','rent_invoices','cam_invoices','utility_invoices','numberTransformer','rent_gts'));
        } else {
            return redirect()->back();
        }
    }

    public function downloadPdf(Request $request)
    {
        $data = Invoice::where('id',$request->id)->first();
        if(!empty($data)) {
            if($data->invoice_type=='rent'){
              
                if($data->is_gst=='1') {
                    $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['rent','rent-gst'])->orderBy('id','ASC')->get();
                }
                else{
                    $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->where('type','rent')->orderBy('id','ASC')->get();
                }
                
                $FileName = 'Rent'.'-'.$data->invoice_no.'-'.time().'.pdf';
                $pdf = PDF::loadView('invoice-new-1',compact('rent_invoices', 'data'));
                $FilePath = 'pdf/' . $FileName;
                \Storage::disk('pdf_uploads')->put($FilePath, $pdf->output(), 'public');

                $path = \Storage::path('public/'.$FilePath);
                
                return response()->json([
                    'pdfUrl' => asset('storage/pdf/' . $FileName)
                ]);
                   
                
            }
            if($data->invoice_type=='cam'){
       
                if($data->is_gst=='1') {
                    $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['cam','cam-gst'])->orderBy('id','ASC')->get();
                }
                else{
                    $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->where('type','cam')->orderBy('id','ASC')->get();
                }
                
                $FileName = 'Cam'.'-'.$data->invoice_no.'-'.time().'.pdf';
                $pdf = PDF::loadView('invoice-cam-1',compact('rent_invoices', 'data'));
                $FilePath = 'pdf/' . $FileName;
                \Storage::disk('pdf_uploads')->put($FilePath, $pdf->output(), 'public');

                $path = \Storage::path('public/'.$FilePath);
                
                return response()->json([
                    'pdfUrl' => asset('storage/pdf/' . $FileName)
                ]);
                
            }
            if($data->invoice_type=='utility'){
           
                $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->where('type','utility')->orderBy('id','ASC')->get();
                
                $FileName = 'Utility'.'-'.$data->invoice_no.'-'.time().'.pdf';
                $pdf = PDF::loadView('invoice-utility-1',compact('rent_invoices', 'data'));
                $FilePath = 'pdf/' . $FileName;
                \Storage::disk('pdf_uploads')->put($FilePath, $pdf->output(), 'public');

                $path = \Storage::path('public/'.$FilePath);
                
                return response()->json([
                    'pdfUrl' => asset('storage/pdf/' . $FileName)
                ]);
                   
                
            }
        }

    }

    
}
