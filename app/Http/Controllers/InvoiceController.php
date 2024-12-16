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
use App\Models\Expense;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
use PDF;
use Storage;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\Artisan;
class InvoiceController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:invoice-browse',['only' => ['invoice']]);
      
    }

    public function invoice()
    {
        if (\Auth::user()->can('invoice-browse')) {
            $leases = Lease::get()->pluck('unique_id', 'id');
            $propertyTypes = Property::get()->pluck('property_name', 'id');
            $tenants = Tenant::get()->pluck('firm_name', 'id');
            $partners = User::get()->pluck('first_name', 'id');

            $invoice = Payment::query();
            $countData['totalInvoice']= Invoice::count();
            $countData['totalInVoiceAmount']= InvoiceDetail::whereIn('type',['rent','rent-gst'])->sum('amount');
            $countData['totalPaid']= Payment::where('invoice_type','rent')->whereIn('status',['Full','Partial'])->sum('amount');
            $countData['totalUnPaid']=    $countData['totalInVoiceAmount']-$countData['totalPaid'];

            $countData['totalCamInVoiceAmount']= InvoiceDetail::whereIn('type',['cam','cam-gst'])->sum('amount');
            $countData['totalCamPaid']= Payment::where('invoice_type','cam')->whereIn('status',['Full','Partial'])->sum('amount');
            $countData['totalCamUnPaid']= $countData['totalCamInVoiceAmount']-$countData['totalCamPaid'];

            $countData['totalUtilityInVoiceAmount']= InvoiceDetail::where('type','electricity')->sum('amount');
            $countData['totalUtilityPaid']= Payment::where('invoice_type','electricity')->whereIn('status',['Full','Partial'])->sum('amount');
            $countData['totalUtilityUnPaid']=  $countData['totalUtilityInVoiceAmount']-$countData['totalUtilityPaid'];
            
            return View('invoice.index',compact('propertyTypes','leases','partners','countData','tenants'));
        } else {
            return redirect()->back();
        }
    }
    public function invoiceList(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $query = Invoice::select('invoices.*')
        ->when($startDate, function($query) use ($startDate) {
                return $query->whereDate('invoices.invoice_date', '>=', $startDate);
        })
        ->when($endDate, function($query) use ($endDate) {
            return $query->whereDate('invoices.invoice_date', '<=', $endDate);
        })->orderBy('invoices.id','DESC')->with('property','tenant','partner','lease');
       
        if(!empty($request->property_id))
        {
            $query->where('invoices.property_id', $request->property_id);
        }
        if(!empty($request->tenant_id))
        {
            $query->where('invoices.tenant_id', $request->tenant_id);
        }
        if(!empty($request->lease_id))
        {
            $query->where('invoices.lease_id', $request->lease_id);
        }

        if($request->status!='')
        {
            $query->where('invoices.payment_status', $request->status);
        }
        if($request->type!='')
        {
            $query->where('invoices.invoice_type', $request->type);
        }
        return datatables($query)
            ->editColumn('property_id', function ($query)
            {
                
                return $query->property->property_name;
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
             ->editColumn('invoice_type', function ($query)
            {
                
                return ucfirst($query->invoice_type);
            })
            ->editColumn('grand_total', function ($query)
            {
                $grand_total = InvoiceDetail::where('invoice_id',$query->id)->sum('amount');
                  
                return formatIndianCurrency($query->grand_total);
            })
            ->addColumn('total_paid', function ($query)
            {
                $payment = Payment::query();
                $totalPaid= $payment->where('invoice_id',$query->id)->where('invoice_type',$query->invoice_type)->whereIn('status',['Full','Partial'])->sum('amount');

                 return formatIndianCurrency($totalPaid);
          
            })
             ->editColumn('invoice_date', function ($query)
            {
                
                return date('M d ,Y',strtotime($query->invoice_date));
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
                $payment ='';
                $utilityview ='';
                if (\Gate::allows('invoice-view')) {
                    $view =' <a class="btn btn-sm btn-info" href="'.route('invoice-view', $query->id) .'" data-bs-toggle="tooltip" data-placement="top" title="View" data-original-title="view">View</a>';
                }
                if (\Gate::allows('payment-add')) {
                    if($query->payment_status!='Full' && $query->status=='Sent') {
                        $payment= '<button
                        class="btn btn-primary payment-model"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#addPaymentOffcanvas"   data-id="'.$query->id.'">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"
                           data-id="'.$query->id.'">Add Payment</span
                        >
                      </button>';
                  }
                }

                
                



                return '<div class="btn-group btn-group-xs">'.$view.$payment.'</div>';
            })
        ->escapeColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }
     public function invoiceView($id)
    {
        if (\Auth::user()->can('invoice-browse')) {
          
            $data = Invoice::with('tenant','property','lease','partner','TenantPropertyUtility')->findOrFail($id);
            if($data->invoice_type=='rent'){
                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['rent','rent-gst'])->orderBy('id','ASC')->get();
                return View('invoice.show',compact('data','rent_invoices'));

            }
            if($data->invoice_type=='cam'){

                
                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['cam','cam-gst'])->orderBy('id','ASC')->get();
            
                return View('invoice.cam-invoice',compact('data','rent_invoices'));
            }
            if($data->invoice_type=='utility'){
                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['utility','utility-gst'])->get();
           
                return View('invoice.utility-invoice',compact('data','rent_invoices'));

            }
            if($data->invoice_type=='electricity'){
                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','electricity')->get();
           
                return View('invoice.electricity-invoice',compact('data','rent_invoices'));

            }
        } else {
            return redirect()->back();
        }
    }
    
    public function invoiceEdit($id)
    {
        if (\Auth::user()->can('invoice-browse')) {
            $data = Invoice::with('tenant','property','lease','partner')->findOrFail($id);
            if($data->status =='Sent'){
                return redirect()->back()->with('error', __('You can not edit this invoice.'));
            }
            if($data->invoice_type=='rent'){
               $rent_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['rent','rent-gst'])->orderBy('id','ASC')->get();

               
               

            }
            if($data->invoice_type=='cam'){

                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['cam','cam-gst'])->orderBy('id','ASC')->get();

            
              
            }
            if($data->invoice_type=='utility'){
                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['utility','utility-gst'])->get();
           
               

            }
            if($data->invoice_type=='electricity'){
                $rent_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','electricity')->get();

           

            }
            return View('invoice.edit',compact('data','rent_invoices'));
        } else {
            return redirect()->back();
        }
    }
    public function invoiceTemplate($id)
    {
       
        if (\Auth::user()->can('invoice-browse')) {
            $numberToWords = new NumberToWords();
            // Get the number transformer
            $numberTransformer = $numberToWords->getNumberTransformer('en'); 
            $data = Invoice::with('tenant','property','lease','partner','TenantPropertyUtility')->findOrFail($id);
            if(!empty($data)) {
                if($data->invoice_type=='rent'){
              
                        if($data->is_gst=='1') {
                            $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['rent','rent-gst'])->orderBy('id','ASC')->get();
                        }
                        else{
                            $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->where('type','rent')->orderBy('id','ASC')->get();
                        }

                        return View('invoice-new-1',compact('data','rent_invoices'));
                }
                if($data->invoice_type=='cam'){
              
                        if($data->is_gst=='1') {
                            $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['cam','cam-gst'])->orderBy('id','ASC')->get();
                        }
                        else{
                            $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->where('type','cam')->orderBy('id','ASC')->get();
                        }

                        return View('invoice-cam-1',compact('data','rent_invoices'));
                }
                if($data->invoice_type=='utility'){
              
                        if($data->is_gst=='1') {
                            $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['utility','utility-gst'])->orderBy('id','ASC')->get();
                        }
                        else{
                            $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->where('type','utility')->orderBy('id','ASC')->get();
                        }

                        return View('invoice-utility-1',compact('data','rent_invoices'));
                }

            }

        } else {
            return redirect()->back();
        }
    }

    public function downloadPdf(Request $request)
    {
        $data = Invoice::where('id',$request->id)->with('tenant','TenantPropertyUtility')->first();
        if(!empty($data)) {
            $invoice_date = date('M-d-Y',strtotime($data->invoice_date));
            $directory = '';
            if (Storage::disk('public')->exists($directory)) {
                $directories = Storage::disk('public')->allDirectories($directory);
                    // Loop through and delete each directory
                    foreach ($directories as $dir) {
                        Storage::disk('public')->deleteDirectory($dir);
                    }
               
            }
            if($data->invoice_type=='rent'){
              
                $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['rent','rent-gst'])->orderBy('id','ASC')->get();
                

                $FileName = @$data->tenant->firm_name.'-Rent-'.$invoice_date.'.pdf';
                $pdf = PDF::loadView('invoice-new-1',compact('rent_invoices', 'data'));
                $FilePath = 'pdf/' . $FileName;
                \Storage::disk('public')->put($FilePath, $pdf->output(), 'public');

                $path = \Storage::path('public/'.$FilePath);
                
                
                return response()->json([
                    'pdfUrl' => Storage::disk('public')->url($FilePath)
                ]);
                   
                
            }
            if($data->invoice_type=='cam'){
       
                $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['cam','cam-gst'])->orderBy('id','ASC')->get();
                
                $FileName = @$data->tenant->firm_name.'-CAM-'.$invoice_date.'.pdf';
                $pdf = PDF::loadView('invoice-cam-1',compact('rent_invoices', 'data'));
                $FilePath = 'pdf/' . $FileName;
                \Storage::disk('public')->put($FilePath, $pdf->output(), 'public');

                $path = \Storage::path('public/'.$FilePath);
                
                return response()->json([
                    'pdfUrl' => Storage::disk('public')->url($FilePath)
                ]);
                
            }
            if($data->invoice_type=='utility'){
                
                $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['utility','utility-gst'])->orderBy('id','ASC')->get();
                $FileName = @$data->tenant->firm_name.'-Utility-'.$invoice_date.'.pdf';
                $pdf = PDF::loadView('invoice-utility-1',compact('rent_invoices', 'data'));
                $FilePath = 'pdf/' . $FileName;
                \Storage::disk('public')->put($FilePath, $pdf->output(), 'public');

                $path = \Storage::path('public/'.$FilePath);
                
                
                return response()->json([
                    'pdfUrl' => Storage::disk('public')->url($FilePath)
                ]);
                   
                
            }
            if($data->invoice_type=='electricity'){
                
                $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->where('type','electricity')->orderBy('id','ASC')->get();
                $FileName = @$data->tenant->firm_name.'-Elec-'.$invoice_date.'.pdf';
                $pdf = PDF::loadView('invoice-electricity',compact('rent_invoices', 'data'));
                $FilePath = 'pdf/' . $FileName;
                \Storage::disk('public')->put($FilePath, $pdf->output(), 'public');

                $path = \Storage::path('public/'.$FilePath);
                
                
                return response()->json([
                    'pdfUrl' => Storage::disk('public')->url($FilePath)
                ]);
                   
                
            }
        }

    }

    public function saveInvoice(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id' => 'required|exists:invoices,id',
            'invoiceData' => 'required|array',
            'invoiceData.*.description' => 'required|string|max:255',
            'invoiceData.*.quantity' => 'required|numeric|min:1',
            'invoiceData.*.rate' => 'required|numeric|min:0',
            'invoiceData.*.amount' => 'required|numeric|min:0',
        ]);
      
        DB::beginTransaction();
        //dd($request->all());
        try{
        $inVoice = Invoice::where('id',$request->id)->first();
        $total = str_replace('₹', '', $request->total);
        $totalAmount = floatval(str_replace(',', '', $total));
     
        if(count($request->invoiceData) >0) {
            $deleteOld = InvoiceDetail::where('invoice_id',$request->id)->delete();
            foreach ($request->invoiceData as $item) {
                $quantity = (!empty($item['quantity'])) ? $item['quantity'] :'1';
                if($inVoice->invoice_type=='rent' ){
                    $invoice_type =($item['item_type']=='') ? 'rent' :'rent-gst';
                }
                elseif($inVoice->invoice_type=='cam'){
                    $invoice_type =($item['item_type']=='') ? 'cam' :'cam-gst';
                } else{
                     $invoice_type =($item['item_type']=='') ? 'utility' :'utility';
                }
                
                $subTotal = $quantity*$item['rate'];
                InvoiceDetail::create([
                    'invoice_id' => $request->id,
                    'random_id' => $inVoice->random_no,
                    'item_desc' => $item['description'],
                    'quantity' => $quantity,
                    'rate' => $item['rate'],
                    'amount' => $item['amount'],
                    'partner_share' => ($invoice_type =='rent') ? $inVoice->partner_per :'',
                    'term' => 'Month',
                    'type' => $invoice_type,
                    'item_type' => $item['item_type'] ,
                    'sub_total' => $subTotal ,
                    
                ]);
            }
        }


       
        if($inVoice->invoice_type=='rent' ){
            $rentInfo = InvoiceDetail::where('invoice_id',$request->id)->where('type','rent')->whereNull('item_type')->first();
            if($request->is_gst=='1'){
                $cgst = InvoiceDetail::where('invoice_id',$request->id)->where('type','rent-gst')->where('item_type','cgst')->first();
                $sgst = InvoiceDetail::where('invoice_id',$request->id)->where('type','rent-gst')->where('item_type','sgst')->first();
                
                $rent_cgst_per = $cgst->rate;
                $rent_cgst_amount = $cgst->quantity* $cgst->rate;
                $rent_sgst_per = $sgst->rate;
                $rent_sgst_amount = $sgst->quantity* $sgst->rate;
                $rent_total_amount = $rentInfo->rate+$cgst->quantity* $cgst->rate+$sgst->quantity* $sgst->rate;
            } else{
                $rent_cgst_per =0;
                $rent_cgst_amount =0;
                $rent_sgst_per =0;
                $rent_sgst_amount =0;
                $rent_total_amount = $rentInfo->rate;
            }
            $inVoice->rent_total =  $rentInfo->rate;
            $inVoice->rent_cgst_per = $rent_cgst_per;
            $inVoice->rent_cgst_amount =$rent_cgst_amount;
            $inVoice->rent_sgst_per = $rent_sgst_per;
            $inVoice->rent_sgst_amount = $rent_sgst_amount;
            $inVoice->rent_total_amount = $rent_total_amount;
            $inVoice->total_amount = $totalAmount;
            $inVoice->remaining_amount = $totalAmount;
            $inVoice->grand_total = $totalAmount;
            $inVoice->save();
        }
        if($inVoice->invoice_type=='cam'){
            $camInfo =  InvoiceDetail::where('invoice_id',$request->id)->where('type','cam')->whereNull('item_type')->first();

            $cgst =  InvoiceDetail::where('invoice_id',$request->id)->where('type','cam-gst')->where('item_type','cgst')->first();
            $sgst =  InvoiceDetail::where('invoice_id',$request->id)->where('type','cam-gst')->where('item_type','sgst')->first();
            $cam_cgst_per = $cgst->rate;
            $cam_cgst_amount = $cgst->quantity* $cgst->rate;
            $cam_sgst_per = $sgst->rate;
            $cam_sgst_amount = $sgst->quantity* $sgst->rate;
            $cam_total_amount =  $camInfo->rate+$cgst->quantity* $cgst->rate+$sgst->quantity* $sgst->rate;
        
            $inVoice->cam_total =  $camInfo->rate;
            $inVoice->cam_cgst_per = $cam_cgst_per;
            $inVoice->cam_cgst_amount =$cam_cgst_amount;
            $inVoice->cam_sgst_per = $cam_sgst_per;
            $inVoice->cam_sgst_amount = $cam_sgst_amount;
            $inVoice->cam_total_amount = $cam_total_amount;
            $inVoice->total_amount = $totalAmount;
            $inVoice->remaining_amount = $totalAmount;
            $inVoice->grand_total = $totalAmount;
            $inVoice->save();
        }
        if($inVoice->invoice_type=='utility'){
            $inVoice->total_amount = $totalAmount;
            $inVoice->remaining_amount = $totalAmount;
            $inVoice->grand_total = $totalAmount;
            $inVoice->save();
        }
       

       if($inVoice) {
         DB::commit();
        return response()->json([
            'message' => 'Invoice updated Successfully!'
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

    public function generateInvoice()
    {
        try {
           
            Invoice::orderby('id','DESC')->delete();
            InvoiceDetail::orderby('id','DESC')->delete();
            Payment::orderby('id','DESC')->delete();
            Expense::orderby('id','DESC')->delete();

             // Reset AUTO_INCREMENT counters for each table
            \DB::statement('ALTER TABLE invoices AUTO_INCREMENT = 1');
            \DB::statement('ALTER TABLE invoice_details AUTO_INCREMENT = 1');
            \DB::statement('ALTER TABLE payments AUTO_INCREMENT = 1');
           
            Artisan::call('app:generate-invoice 2'); 
            Artisan::call('app:generate-invoice 1'); 
            Artisan::call('app:electricity-utility'); 


            return redirect()->route('invoice')->with('success', __('Generated successfully.'));
            
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Invoice generation failed: ' . $e->getMessage());

            return redirect()->back()->with('error', __('Something went wrong.'));
        }
    }
    public function sendInvoice()
    {
        try {
           
           Invoice::orderby('id','DESC')->update(['status'=>'Sent']);

            return redirect()->route('invoice')->with('success', __('Sent successfully.'));
            
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Invoice generation failed: ' . $e->getMessage());

            return redirect()->back()->with('error', __('Something went wrong.'));
        }
    }
    public function invoiceModel(Request $request)
    {
        $id = $request->id;
        $data = Invoice::with('tenant','property','lease','partner','TenantPropertyUtility')->findOrFail($id);
        $grand_total = InvoiceDetail::where('invoice_id',$id)->sum('amount');
        $invoiceBalance = (!empty($data->remaining_amount)) ? $data->remaining_amount : formatIndianCurrency($grand_total);
      
        return view('invoice.payment', compact('data','invoiceBalance','grand_total'));
    }


    
}
