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
            return View('invoice.index',compact('propertyTypes','data','partners'));
        } else {
            return redirect()->back();
        }
    }
    public function invoiceList(Request $request)
    {
        $query = Invoice::orderBy('id','DESC')->with('property','tenant','partner');
       
        if(!empty($request->property_id))
        {
            $query->where('property_id', $request->property_id);
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
            ->editColumn('tenant_id', function ($query)
            {
                
                return $query->tenant->firm_name;
            })
            ->editColumn('lease_id', function ($query)
            {
                
                return $query->lease->unique_id;
            })
            ->editColumn('partner_id', function ($query)
            {
                
                return $query->partner->first_name.'  '.$query->partner->lastname;
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
                    if($query->is_gst =='1'){
                        $grand_total = $total_amount+$cgst+$sgst;
                    } else{
                        $grand_total = $total_amount;
                    }
                  
                return formatIndianCurrency($grand_total);
            })
           
            ->editColumn('status', function ($query)
            {
                if ($query->status == 'Paid')
                {
                    $status = 'Approved';
                    $class='bg-label-success';
                }
                elseif ($query->status == 'UnPaid')
                {
                    $status = 'Processing';
                    $class='bg-label-info';
                }
                else
                {
                    $status = 'Pending';
                    $class='bg-label-primary';
                }

                return '<span class="badge '.$class.' text-capitalize ">' . $status . '</span>';
            })
            ->editColumn('status', function ($query)
            {
                if ($query->status == 'Paid')
                {
                    $status = 'Approved';
                    $class='bg-label-success';
                }
                elseif ($query->status == 'UnPaid')
                {
                    $status = 'Processing';
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

                if($query->status != 'Paid') {
                    $edit =' <a class="btn btn-sm btn-primary" href="'.route('invoice-edit', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                } else{
                    $edit ='';
                }
                
                $view =' <a class="btn btn-sm btn-info" href="'.route('invoice-view', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="view"><i class="fa fa-eye"></i></a>';
                $campview =' <a class="btn btn-sm btn-warning" href="'.route('cam-invoice', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="view"><i class="fa fa-eye"></i></a>';



                return '<div class="btn-group btn-group-xs">'.$edit.$view.$campview.'</div>';
            })
        ->escapeColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }
     public function invoiceView($id)
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
           
            return View('invoice.show',compact('data','rent_invoices','cam_invoices','utility_invoices','numberTransformer','rent_gts'));
        } else {
            return redirect()->back();
        }
    }
    public function camInvoice($id)
    {
        if (\Auth::user()->can('invoice-browse')) {
            $numberToWords = new NumberToWords();
            // Get the number transformer
            $numberTransformer = $numberToWords->getNumberTransformer('en'); 
            $data = Invoice::with('tenant','property','lease','partner')->findOrFail($id);
            if($data->is_gst=='1') {
                $cam_invoices = InvoiceDetail::where('invoice_id',$id)->whereIn('type',['cam','cam-gst'])->orderBy('id','ASC')->get();
            }
            else{
                $cam_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','cam')->orderBy('id','ASC')->get();
            }

            $rent_gts = InvoiceDetail::where('invoice_id',$id)->where('type','rent-gst')->get();
           
            $utility_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','utility')->get();
           
            return View('invoice.cam-invoice',compact('data','cam_invoices','utility_invoices','numberTransformer','rent_gts'));
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
            $data = Invoice::with('tenant','property','lease')->findOrFail($id);
            $rent_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','rent')->get();
            $cam_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','cam')->get();
            $utility_invoices = InvoiceDetail::where('invoice_id',$id)->where('type','utility')->get();
           
            return View('invoice.edit',compact('data','rent_invoices','cam_invoices','utility_invoices','numberTransformer'));
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
           
            return View('invoice',compact('data','rent_invoices','cam_invoices','utility_invoices','numberTransformer','rent_gts'));
        } else {
            return redirect()->back();
        }
    }
}
