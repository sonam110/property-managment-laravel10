<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\LeaseUtility;
use App\Models\PropertyPaymentSetting;
use App\Models\TenantContactInfo;
use Str;
use DB;
use PDF;
use Storage;
use Mail;
use Carbon\Carbon;
use App\Mail\SendInvoiceMail;
class SendInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $allTenantContacts = TenantContactInfo::select('tenant_contact_infos.*','leases.*', 'leases.id as lease_id', 'tenant_contact_infos.id as id')->join('leases','tenant_contact_infos.tenant_id','leases.tenant_id')->where('leases.status','Approved')->with('tenantInfo')->get();
       
        foreach ($allTenantContacts as $key => $contact) {
            if(!empty($contact->email)){
                if($contact->contact_type =='Rental' || $contact->contact_type =='All'){
                    $leasePartners = PropertyPaymentSetting::where('property_id',$contact->property_id)->get();

                    if($leasePartners->count() >0){
                        foreach ($leasePartners as $key => $part) {
                            $data = Invoice::where('property_id',$contact->property_id)->where('lease_id',$contact->lease_id)->where('partner_id',$part->user_id)->with('tenant','property','lease','partner')->where('invoice_type','rent')->whereMonth('invoice_generate_date',date('m'))->first();
                           
                            if(!empty($data)){
                                $invoice_date = date('M-d-Y',strtotime($data->invoice_date));
                                $grand_total = InvoiceDetail::where('invoice_id',$data->id)->sum('amount');
                                if($grand_total >0) {
                                    $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['rent','rent-gst'])->orderBy('id','ASC')->get();

                                    $rent_gts = InvoiceDetail::where('invoice_id',$data->id)->where('type','rent-gst')->get();
                                    $FileName = @$data->tenant->firm_name.'-Rent-'.$invoice_date.'.pdf';
                                    $pdf = PDF::loadView('invoice-new-1',compact('rent_invoices', 'data','rent_gts'));
                                    $FilePath = 'pdf/' . $FileName;
                                    \Storage::disk('public')->put($FilePath, $pdf->output(), 'public');

                                    $path = \Storage::path('public/'.$FilePath);
                                    
                                    $mime = "application/pdf";
                                    $content = [
                                        "FileName" => $FileName,
                                        "FilePath" => $path,
                                        "mime" => $mime,
                                        "subject" => 'Rent Invoice',
                                    ];
                                    $email = $contact->email;
        
                                    if (env('IS_MAIL_ENABLE', false) == true) {
                                        $recevier = Mail::to($email)->send(new SendInvoiceMail($content));
                                        if ($recevier) {
                                            \Log::channel('automation_emails_log')->info($email);
                                        }
                                    }

                                    $data->status = 'Sent';
                                    $data->invoice_date = date('Y-m-d');
                                    $data->save();
                                }

                                
                            }
                        }
                    }
                }
                if($contact->contact_type =='Cam' || $contact->contact_type =='All'){
                    $data = Invoice::where('property_id',$contact->property_id)->where('lease_id',$contact->lease_id)->where('invoice_type','cam')->whereMonth('invoice_generate_date',date('m'))->with('tenant','property','lease','partner')->first();
                        if(!empty($data)){
                            $grand_total = InvoiceDetail::where('invoice_id',$data->id)->sum('amount');
                            $invoice_date = date('M-d-Y',strtotime($data->invoice_date));
                            if($grand_total >0) {
                                $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['cam','cam-gst'])->orderBy('id','ASC')->get();

                                $rent_gts = InvoiceDetail::where('invoice_id',$data->id)->where('type','cam-gst')->get();
                                $FileName = @$data->tenant->firm_name.'-CAM-'.$invoice_date.'.pdf';
                                $pdf = PDF::loadView('invoice-cam-1',compact('rent_invoices', 'data','rent_gts'));
                                $FilePath = 'pdf/' . $FileName;
                                \Storage::disk('public')->put($FilePath, $pdf->output(), 'public');

                                $path = \Storage::path('public/'.$FilePath);
                                $mime = "application/pdf";
                                $content = [
                                    "FileName" => $FileName,
                                    "FilePath" => $path,
                                    "mime" => $mime,
                                    "subject" => 'CAM Invoice',
                                ];
                                $email = $contact->email;

                                if (env('IS_MAIL_ENABLE', false) == true) {
                                    $recevier = Mail::to($email)->send(new SendInvoiceMail($content));
                                    if ($recevier) {
                                        \Log::channel('automation_emails_log')->info($email);
                                    }
                                }
                                $data->status = 'Sent';
                                $data->invoice_date = date('Y-m-d');
                                $data->save();
                            }
                        }

                }
                if($contact->contact_type =='Utility' || $contact->contact_type =='All'){
                    $data = Invoice::where('property_id',$contact->property_id)->where('lease_id',$contact->lease_id)->where('invoice_type','utility')->whereMonth('invoice_generate_date',date('m'))->with('tenant','property','lease','partner')->first();
                        if(!empty($data)){
                            $invoice_date = date('M-d-Y',strtotime($data->invoice_date));
                            $grand_total = InvoiceDetail::where('invoice_id',$data->id)->sum('amount');
                            if($grand_total >0) {
                                $rent_invoices = InvoiceDetail::where('invoice_id',$data->id)->whereIn('type',['utility','utility-gst'])->orderBy('id','ASC')->get();
                                $FileName = @$data->tenant->firm_name.'-Utility-'.$invoice_date.'.pdf';
                                $pdf = PDF::loadView('invoice-utility-1',compact('rent_invoices', 'data'));
                                $FilePath = 'pdf/' . $FileName;
                                \Storage::disk('public')->put($FilePath, $pdf->output(), 'public');

                                $path = \Storage::path('public/'.$FilePath);
                                $mime = "application/pdf";
                                $content = [
                                    "FileName" => $FileName,
                                    "FilePath" => $path,
                                    "mime" => $mime,
                                    "subject" => 'Utility Invoice',
                                ];
                                $email = $contact->email;

                                if (env('IS_MAIL_ENABLE', false) == true) {
                                    $recevier = Mail::to($email)->send(new SendInvoiceMail($content));
                                    if ($recevier) {
                                        \Log::channel('automation_emails_log')->info($email);
                                    }
                                }
                                $data->status = 'Sent';
                                $data->invoice_date = date('Y-m-d');
                                $data->save();
                            }
                        }

                }

            }
        }
       
       
    }
}
