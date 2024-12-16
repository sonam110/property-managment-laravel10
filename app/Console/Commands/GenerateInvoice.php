<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lease;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\LeaseUtility;
use App\Models\PropertyPaymentSetting;
use App\Models\AppSetting;
use App\Models\LeaseExtraCharge;
use Carbon\Carbon;
class GenerateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-invoice {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate invoices for leases based on type';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        if(!empty($type)){
            $allLease = Lease::with('property','tenant')->where('lease_invoice_type',$type)->where('status','Approved')->get();
            
        } else{
            $allLease = Lease::with('property','tenant')->where('status','Approved')->get();
        }
        $appSetting = AppSetting::find(1);
        $currentDate = Carbon::now(); 
        $daysInMonth = $currentDate->daysInMonth;          

        foreach ($allLease as $key => $lease) {
            $leaseStarts = Carbon::parse($lease->start_date);  
            $leaseStartDate = Carbon::parse($lease->start_date);  
            $monthsToAdd = $lease->end_month; 
            
            $leaseEndDate = $leaseStartDate->addMonths($monthsToAdd);
           
            if ($currentDate->lessThanOrEqualTo($leaseEndDate)) {

                $leasePartners = PropertyPaymentSetting::where('lease_id',$lease->id)->get();
                if($leasePartners->count() >0){
                    $random_no = \Str::random(15);
                    if($lease->lease_invoice_type =='1'){
                        $firstDayOfMonth = new \DateTime('first day of next month'); 
                        $firstDateFormatted = $firstDayOfMonth->format('F j, Y');

                        $lastDayOfMonth = new \DateTime('last day of next month');
                        $lastDateFormatted = $lastDayOfMonth->format('F j, Y');
                    } else{
                        $firstDayOfMonth = new \DateTime('first day of this month');
                        $firstDateFormatted = $firstDayOfMonth->format('F j, Y');

                        $lastDayOfMonth = new \DateTime('last day of this month');
                        $lastDateFormatted = $lastDayOfMonth->format('F j, Y');

                    }
                    
                  
                    if ($currentDate->month == $leaseStarts->month && $currentDate->year == $leaseStarts->year) {
                        $startDay = $leaseStarts->day;         
                       
                        $remainingDays = $daysInMonth - $startDay + 1; 
                        $perDayRent = $lease->total_rent/$daysInMonth; 
                        $perDayCam= $lease->total_cam/$daysInMonth; 
                          
                        $totalRent = $perDayRent * $remainingDays;
                        $totalCam = $perDayCam * $remainingDays;
                        $lease_price = $totalRent;
                        $cam_price = $totalCam;
                        \Log::info("Partial First Month Rent for Lease {$lease->id}: {$totalRent}");
                    }

                    elseif($currentDate->month == $leaseEndDate->month && $currentDate->year == $leaseEndDate->year) {
                        $endDay = $leaseEndDate->day;                 
                        $remainingDays = $daysInMonth - $endDay + 1;                        
                        $perDayRent = $lease->total_rent/$daysInMonth; 
                        $perDayCam= $lease->total_cam/$daysInMonth; 
                        // Adjust rent and other amounts
                        $totalRent = $perDayRent * $remainingDays;
                        $totalCam = $perDayCam * $remainingDays;
                        $lease_price = $totalRent;
                        $cam_price = $totalCam;

                        \Log::info("Partial Last Month Rent for Lease {$lease->id}: {$totalRent}");
                    } else{
                        $totalRent =$lease->total_rent;
                        $totalCam =$lease->total_cam;
                        $lease_price = $lease->price;
                        $cam_price = $lease->cam_price;
                        \Log::info("full  Month Rent for Lease {$lease->id}: {$totalRent}");
                    }
                  
                   

                    $total_amount = $totalRent;
                    $cgst_amount = ($total_amount*$appSetting->tax_per)/100;
                    $sgst_amount = ($total_amount*$appSetting->tax_per)/100;


                    $cam_total_amount = $totalCam;
                    $cam_cgst_amount = ($cam_total_amount*$appSetting->tax_per)/100;
                    $cam_sgst_amount = ($cam_total_amount*$appSetting->tax_per)/100;


                    $tenant_code = (!empty(@$lease->tenant->unique_id)) ?  $lease->tenant->unique_id.'/':'';
                    foreach ($leasePartners as $key => $part) {
                        $invoice_no = $tenant_code.date('M').'/'.date('Y').'/'.rand(0,9999);
                        //\Log::info($part->is_gst);
                        if($part->is_gst == '1'){
                            $paid_amount = $total_amount+$cgst_amount+$sgst_amount;
                        } else{
                            $paid_amount = $total_amount;
                        }
                       
                        if($part->commission_type=='1'){
                            $commission_value = $part->commission_value;
                            $cgst_amount = ($commission_value*$appSetting->tax_per)/100;
                            $sgst_amount = ($commission_value*$appSetting->tax_per)/100;
                            if($part->is_gst == '1'){
                                $invoice_amount = $commission_value+$cgst_amount+$sgst_amount;
                            } else{
                                $invoice_amount = $commission_value;
                            }
                        } else{
                            $invoice_amount = ($paid_amount*$part->commission_value)/100;
                        }
                        
                        //\Log::info($invoice_amount);
                        $invoice = new Invoice;
                        $invoice->random_no = $random_no;
                        $invoice->invoice_no =  $tenant_code.date('M').'/'.date('Y').'/'.rand(0,9999);
                        $invoice->user_id = '1';
                        $invoice->lease_id = $lease->id;
                        $invoice->partner_id = $part->user_id;
                        $invoice->partner_per = $part->commission_value;
                        $invoice->partner_type = $part->commission_type;
                        $invoice->is_gst = $part->is_gst;
                        $invoice->property_id = $lease->property_id;
                        $invoice->tenant_id = $lease->tenant_id;
                        $invoice->invoice_date = date('Y-m-d');
                        $invoice->invoice_generate_date = date('Y-m-d');
                        $invoice->invoice_type = 'rent';
                        $invoice->total_amount = $invoice_amount;
                        $invoice->amount = 0;
                        $invoice->remaining_amount = $invoice_amount;
                        $invoice->grand_total = $invoice_amount;
                        $invoice->save();
                        if($invoice) {
                            
                            if($part->commission_type=='1'){
                                $amountp = $part->commission_value;
                            } else{
                                $amountp = ($total_amount*$part->commission_value)/100;
                            }
                            $cgst_amount_p = ($amountp*$appSetting->tax_per)/100;
                            $sgst_amount_p = ($amountp*$appSetting->tax_per)/100;

                            $rentInvoice = new InvoiceDetail;
                            $rentInvoice->invoice_id = $invoice->id;
                            $rentInvoice->random_id = $random_no;
                            $rentInvoice->item_desc = 'RENT INCOME -'.$firstDateFormatted.'-'.$lastDateFormatted;
                            $rentInvoice->quantity = $lease->total_square;
                            $rentInvoice->rate = $lease_price;
                            $rentInvoice->amount = $amountp;
                            $rentInvoice->sub_total = $total_amount;
                            $rentInvoice->partner_share = $part->commission_value;;
                            $rentInvoice->type = 'rent';
                            $rentInvoice->item_type = 'rent';
                            $rentInvoice->save();

                            if($part->is_gst == '1'){
                                $rentInvoice1 = new InvoiceDetail;
                                $rentInvoice1->invoice_id = $invoice->id;
                                $rentInvoice1->random_id = $random_no;
                                $rentInvoice1->item_desc = 'OUTPUT-CGST ON RENT';
                                $rentInvoice1->rate = $appSetting->tax_per;
                                $rentInvoice1->amount = $cgst_amount_p;
                                $rentInvoice1->sub_total = $cgst_amount;
                                $rentInvoice1->type = 'rent-gst';
                                $rentInvoice1->item_type = 'cgst';
                                $rentInvoice1->save();

                                $rentInvoice2 = new InvoiceDetail;
                                $rentInvoice2->invoice_id = $invoice->id;
                                $rentInvoice2->random_id = $random_no;
                                $rentInvoice2->item_desc = 'OUTPUT-SGST ON RENT';
                                $rentInvoice2->rate = $appSetting->tax_per;
                                $rentInvoice2->amount = $sgst_amount_p;
                                $rentInvoice2->sub_total = $sgst_amount;
                                $rentInvoice2->type = 'rent-gst';
                                $rentInvoice2->item_type = 'sgst';
                                $rentInvoice2->save();

                           }
                          


                        }


                        
                    }

                    $default_partner = PropertyPaymentSetting::where('lease_id',$lease->id)->where('default_partner','1')->first();
                    if(empty($default_partner)){
                        $default_partner = PropertyPaymentSetting::where('lease_id',$lease->id)->first();

                    }

                    
                    $cam_paid_amount = $cam_total_amount+$cam_cgst_amount+$cam_sgst_amount;
                   
                    $addCamInvoice = new Invoice;
                    $addCamInvoice->random_no = $random_no;
                    $addCamInvoice->invoice_no =  $tenant_code.date('M').'/'.date('Y').'/'.rand(0,999999);
                    $addCamInvoice->user_id = '1';
                    $addCamInvoice->lease_id = $lease->id;
                    $addCamInvoice->partner_id = $default_partner->user_id;
                    $addCamInvoice->partner_per = $default_partner->commission_value;
                    $addCamInvoice->partner_type = $default_partner->commission_type;
                    $addCamInvoice->is_gst = $default_partner->is_gst;
                    $addCamInvoice->property_id = $lease->property_id;
                    $addCamInvoice->tenant_id = $lease->tenant_id;
                    $addCamInvoice->invoice_date = date('Y-m-d');
                    $addCamInvoice->invoice_generate_date = date('Y-m-d');
                    $addCamInvoice->invoice_type = 'cam';
                    $addCamInvoice->total_amount = $cam_paid_amount;
                    $addCamInvoice->amount = 0;
                    $addCamInvoice->remaining_amount = $cam_paid_amount;
                    $addCamInvoice->grand_total = $cam_paid_amount;
                    $addCamInvoice->save();
                    if($addCamInvoice) {

                        $camInvoice = new InvoiceDetail;
                        $camInvoice->invoice_id = $addCamInvoice->id;
                        $camInvoice->random_id = $random_no;
                        $camInvoice->item_desc = 'CAM CHARGES -'.$firstDateFormatted.'-'.$lastDateFormatted;
                        $camInvoice->quantity = $lease->total_square;
                        $camInvoice->rate = $cam_price;
                        $camInvoice->amount = $cam_total_amount;
                        $camInvoice->sub_total = $cam_total_amount;
                        $camInvoice->type = 'cam';
                        $camInvoice->item_type = 'rent';
                        $camInvoice->save();

                        $camInvoice1 = new InvoiceDetail;
                        $camInvoice1->invoice_id = $addCamInvoice->id;
                        $camInvoice1->random_id = $random_no;
                        $camInvoice1->item_desc = 'OUTPUT-CGST ON CAM';
                        $camInvoice1->rate = $appSetting->tax_per;
                        $camInvoice1->amount = $cam_cgst_amount;
                        $camInvoice1->sub_total = $cam_cgst_amount;
                        $camInvoice1->type = 'cam-gst';
                        $camInvoice1->item_type = 'cgst';
                        $camInvoice1->save();

                        $camInvoice2 = new InvoiceDetail;
                        $camInvoice2->invoice_id = $addCamInvoice->id;
                        $camInvoice2->random_id = $random_no;
                        $camInvoice2->item_desc = 'OUTPUT-SGST ON CAM';
                        $camInvoice2->rate = $appSetting->tax_per;
                        $camInvoice2->amount = $cam_sgst_amount;
                        $camInvoice2->sub_total = $cam_sgst_amount;
                        $camInvoice2->type = 'cam-gst';
                        $camInvoice2->item_type = 'sgst';
                        $camInvoice2->save();
                        

                       


                    }

                    $billDate = Carbon::now()->subMonth();
                    $bmonth = $billDate->format('F');         
                    $bcurrentYear = $billDate->format('y');  
                    $bnextYear = $billDate->copy()->addYear()->format('y');
                    $brandomNumber = rand(0, 99); // Adjust as needed
                   // $invoice_no = "{$bmonth}/{$bcurrentYear}-{$bnextYear}/{$brandomNumber}";

                    $addUtilityInvoice = new Invoice;
                    $addUtilityInvoice->random_no = $random_no;
                    $addUtilityInvoice->invoice_no = $tenant_code.date('M').'/'.date('Y').'/'.rand(0,9999999);
                    $addUtilityInvoice->user_id = '1';
                    $addUtilityInvoice->lease_id = $lease->id;
                    $addUtilityInvoice->partner_id = $default_partner->user_id;
                    $addUtilityInvoice->partner_per = $default_partner->commission_value;
                    $addUtilityInvoice->partner_type = $default_partner->commission_type;
                    $addUtilityInvoice->is_gst = $default_partner->is_gst;
                    $addUtilityInvoice->property_id = $lease->property_id;
                    $addUtilityInvoice->tenant_id = $lease->tenant_id;
                    $addUtilityInvoice->invoice_date = date('Y-m-d');
                    $addUtilityInvoice->invoice_generate_date = date('Y-m-d');
                    $addUtilityInvoice->invoice_type = 'utility';
                    $addUtilityInvoice->save();
                    if($addUtilityInvoice) {
                        $utilityTotal = 0;
                        $extrautilityTotal = 0;
                        
                        $allUtilities =LeaseUtility::where('lease_id',$lease->id)->with('utilityInfo')->get();
                            foreach ($allUtilities as $key => $utility) {
                                $costNew = (!empty($utility->variable_cost)) ? $utility->variable_cost: $utility->fixed_cost;
                                $utilityTotal += $costNew;
                                $utilityinvoice = new InvoiceDetail;
                                $utilityinvoice->invoice_id = $addUtilityInvoice->id;
                                $utilityinvoice->random_id = $random_no;
                                $utilityinvoice->item_desc = $utility->utilityInfo->name;
                                $utilityinvoice->rate = $costNew;
                                $utilityinvoice->amount = $costNew;
                                $utilityinvoice->sub_total = $costNew;
                                $utilityinvoice->type = 'utility';
                                $utilityinvoice->item_type = 'rent';
                                $utilityinvoice->save();
                            }
                        $leaseExtraCharges = LeaseExtraCharge::where('lease_id',$lease->id)->with('extraCharge')->get();
                        if(count($leaseExtraCharges) > 0){
                            $checkInvoiceCount = Invoice::where('lease_id',$lease->id)->where('invoice_type','cam')->count();

                            foreach ($leaseExtraCharges as $key => $charge) {
                                if($charge->extra_charge_type == '1'){
                                    $amount = $charge->extra_charge_value;
                                } else{
                                    $amount =  ($total_amount * $charge->extra_charge_value) / 100;
                                }
                                if ($charge->frequency == '1' &&  $checkInvoiceCount =='1') {
                                    $utilityTotal += $amount;
                                    $extraChargeSave = new InvoiceDetail;
                                    $extraChargeSave->invoice_id = $addUtilityInvoice->id;
                                    $extraChargeSave->random_id = $random_no;
                                    $extraChargeSave->item_desc = @$charge->extraCharge->name;
                                    $extraChargeSave->rate = $amount;
                                    $extraChargeSave->amount = $amount;
                                    $extraChargeSave->sub_total = $amount;
                                    $extraChargeSave->type = 'utility';
                                    $extraChargeSave->item_type = 'extra';
                                    $extraChargeSave->save();
                                } 
                                if ($charge->frequency == '2')  {
                                    $utilityTotal += $amount;
                                    $extraChargeSave = new InvoiceDetail;
                                    $extraChargeSave->invoice_id = $addUtilityInvoice->id;
                                    $extraChargeSave->random_id = $random_no;
                                    $extraChargeSave->item_desc = @$charge->extraCharge->name;
                                    $extraChargeSave->rate = $amount;
                                    $extraChargeSave->amount = $amount;
                                    $extraChargeSave->sub_total = $amount;
                                    $extraChargeSave->type = 'utility';
                                    $extraChargeSave->item_type = 'extra';
                                    $extraChargeSave->save();
                                   
                                }
                            }
                        }


                    }



                    $ucgst = ($utilityTotal*$appSetting->tax_per)/100;
                    $usgst = ($utilityTotal*$appSetting->tax_per)/100;
                    if($default_partner->is_gst == '1'){
                        $utility_paid_amount = $utilityTotal+$ucgst+$usgst;
                    } else{
                        $utility_paid_amount = $utilityTotal;
                    }
                    $addUtilityUpdate= Invoice::find($addUtilityInvoice->id);
                    $addUtilityUpdate->total_amount = $utilityTotal;
                    $addUtilityUpdate->amount = 0;
                    $addUtilityUpdate->remaining_amount = $utilityTotal;
                    $addUtilityUpdate->grand_total = $utilityTotal;
                    $addUtilityUpdate->save();


                    $grand_total = $total_amount+ $cgst_amount + $sgst_amount + $cam_total_amount + $cam_cgst_amount+ $cam_sgst_amount+ $utilityTotal;
                   
                   \DB::table('invoices')
                    ->where('random_no', $random_no)
                    ->update([
                        'rent_total' => $total_amount,
                        'rent_cgst_per' => $appSetting->tax_per,
                        'rent_cgst_amount' => $cgst_amount,
                        'rent_sgst_per' => $appSetting->tax_per,
                        'rent_sgst_amount' => $sgst_amount,
                        'rent_total_amount' => $total_amount + $cgst_amount + $sgst_amount,
                        'cam_total' => $cam_total_amount,
                        'cam_cgst_per' => $appSetting->tax_per,
                        'cam_cgst_amount' => $cam_cgst_amount,
                        'cam_sgst_per' => $appSetting->tax_per,
                        'cam_sgst_amount' => $cam_sgst_amount,
                        'cam_total_amount' => $cam_total_amount + $cam_cgst_amount + $cam_sgst_amount,
                        'utility_total' => $utilityTotal,
                    ]);




               }
            }
        

        }
    
    }
}
