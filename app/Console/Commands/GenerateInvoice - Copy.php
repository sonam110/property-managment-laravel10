<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lease;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\LeaseUtility;
use App\Models\PropertyPaymentSetting;
class GenerateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-invoice';

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
        $allLease = Lease::where('status','Approved')->with('property','tenant')->get();
        foreach ($allLease as $key => $lease) {
            $leasePartners = PropertyPaymentSetting::where('property_id',$lease->property_id)->get();
           if($leasePartners->count() >0){

                $random_no = \Str::random(15);
                $firstDayOfMonth = new \DateTime('first day of this month');
                // Format the date as 'August 1, 2024'
                $firstDateFormatted = $firstDayOfMonth->format('F j, Y');

                // Create a DateTime object for the last day of the current month
                $lastDayOfMonth = new \DateTime('last day of this month');
                $lastDateFormatted = $lastDayOfMonth->format('F j, Y');

                $total_amount = $lease->total_square*$lease->price;
                $cgst_amount = ($total_amount*9)/100;
                $sgst_amount = ($total_amount*9)/100;

                $cam_total_amount = $lease->total_square * $lease->camp_price;
                $cam_cgst_amount = ($cam_total_amount*9)/100;
                $cam_sgst_amount = ($cam_total_amount*9)/100;
                foreach ($leasePartners as $key => $part) {

                    $invoice = new Invoice;
                    $invoice->random_no = $random_no;
                    $invoice->invoice_no = date('M').'/'.date('Y').'/'.rand(0,9999);
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
                    $invoice->save();
                    if($invoice) {
        
                        $rentInvoice = new InvoiceDetail;
                        $rentInvoice->invoice_id = $invoice->id;
                        $rentInvoice->random_id = $random_no;
                        $rentInvoice->item_desc = 'RENT INCOME -'.$firstDateFormatted.'-'.$lastDateFormatted;
                        $rentInvoice->quantity = $lease->total_square;
                        $rentInvoice->rate = $lease->price;
                        $rentInvoice->amount = $total_amount;
                        $rentInvoice->type = 'rent';
                        $rentInvoice->save();


                        $rentInvoice1 = new InvoiceDetail;
                        $rentInvoice1->invoice_id = $invoice->id;
                        $rentInvoice1->random_id = $random_no;
                        $rentInvoice1->item_desc = 'OUTPUT-CGST ON RENT';
                        $rentInvoice1->rate = '9';
                        $rentInvoice1->amount = $cgst_amount;
                        $rentInvoice1->type = 'rent-gst';
                        $rentInvoice1->save();

                        $rentInvoice2 = new InvoiceDetail;
                        $rentInvoice2->invoice_id = $invoice->id;
                        $rentInvoice2->random_id = $random_no;
                        $rentInvoice2->item_desc = 'OUTPUT-SGST ON RENT';
                        $rentInvoice2->rate = '9';
                        $rentInvoice2->amount = $sgst_amount;
                        $rentInvoice2->type = 'rent-gst';
                        $rentInvoice2->save();



                        $camInvoice = new InvoiceDetail;
                        $camInvoice->invoice_id = $invoice->id;
                        $camInvoice->random_id = $random_no;
                        $camInvoice->item_desc = 'CAM CHARGES -'.$firstDateFormatted.'-'.$lastDateFormatted;
                        $camInvoice->quantity = $lease->total_square;
                        $camInvoice->rate = $lease->camp_price;
                        $camInvoice->amount = $lease->total_square*$lease->camp_price;
                        $camInvoice->type = 'cam';
                        $camInvoice->save();


                        $camInvoice1 = new InvoiceDetail;
                        $camInvoice1->invoice_id = $invoice->id;
                        $camInvoice1->random_id = $random_no;
                        $camInvoice1->item_desc = 'OUTPUT-CGST ON CAM';
                        $camInvoice1->rate = '9';
                        $camInvoice1->amount = $cam_cgst_amount;
                        $camInvoice1->type = 'cam-gst';
                        $camInvoice1->save();

                        $camInvoice2 = new InvoiceDetail;
                        $camInvoice2->invoice_id = $invoice->id;
                        $camInvoice2->random_id = $random_no;
                        $camInvoice2->item_desc = 'OUTPUT-SGST ON CAM';
                        $camInvoice2->rate = '9';
                        $camInvoice2->amount = $cam_sgst_amount;
                        $camInvoice2->type = 'cam-gst';
                        $camInvoice2->save();

                        $utilityTotal = 0;
                        $allUtilities =LeaseUtility::where('lease_id',$lease->id)->with('utilityInfo')->get();
                        foreach ($allUtilities as $key => $utility) {
                            $costNew = (!empty($utility->variable_cost)) ? $utility->variable_cost: $utility->fixed_cost;
                            $utilityTotal += $costNew;
                            $utilityinvoice = new InvoiceDetail;
                            $utilityinvoice->invoice_id = $invoice->id;
                            $utilityinvoice->random_id = $random_no;
                            $utilityinvoice->item_desc = $utility->utilityInfo->name;
                            $utilityinvoice->amount = $costNew;
                            $utilityinvoice->type = 'utility';
                            $utilityinvoice->save();
                        }



                        $grand_total = $total_amount+ $cgst_amount + $sgst_amount + $cam_total_amount + $cam_cgst_amount+ $cam_sgst_amount+ $utilityTotal;
                        $updateInvoice = Invoice::find($invoice->id);
                        $updateInvoice->rent_total = $total_amount;
                        $updateInvoice->rent_cgst_per = '9';
                        $updateInvoice->rent_cgst_amount = $cgst_amount;
                        $updateInvoice->rent_sgst_per = '9';
                        $updateInvoice->rent_sgst_amount = $sgst_amount;
                        $updateInvoice->rent_total_amount = $total_amount+$cgst_amount+ $sgst_amount;

                        $updateInvoice->cam_total = $cam_total_amount;
                        $updateInvoice->cam_cgst_per = '9';
                        $updateInvoice->cam_cgst_amount = $cam_cgst_amount;
                        $updateInvoice->cam_sgst_per = '9';
                        $updateInvoice->cam_sgst_amount = $cam_sgst_amount;
                        $updateInvoice->cam_total_amount = $cam_total_amount+$cam_cgst_amount+$cam_sgst_amount;
                        $updateInvoice->utility_total = $utilityTotal;
                        $updateInvoice->grand_total = $grand_total;
                        $updateInvoice->save();


                   }
                    
                }

           }
        

        }
    
    }
}
