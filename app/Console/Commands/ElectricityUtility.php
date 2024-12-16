<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lease;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\InvoiceDetail;
use App\Models\TenantPropertyUtility;
use App\Models\PropertyPaymentSetting;
use Carbon\Carbon;
class ElectricityUtility extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:electricity-utility';

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
        $currentDate = Carbon::now();
        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;
        $lesaeTenantsBill = Lease::select('leases.*','tenant_property_utilities.*','tenant_property_utilities.id as tenat_u_id','leases.id as id')->join('tenant_property_utilities','leases.property_id','tenant_property_utilities.property_id')
            ->where('leases.status','Approved')
            ->whereMonth('tenant_property_utilities.bill_date', $previousMonth)
            ->whereYear('tenant_property_utilities.bill_date', $previousYear)
            ->groupBy('tenant_property_utilities.property_id')
            ->get();
         

        foreach ($lesaeTenantsBill as $key => $lease) {
            $tenatJsonData =  json_decode($lease->tenants_units, true);

            $random_no = \Str::random(15);
            foreach ($tenatJsonData as $key => $jdata) {
                $getTenant = Tenant::where('id',$jdata['tenant_id'])->first();
                $getLease = Lease::where('property_id',$lease->property_id)->where('tenant_id',$getTenant->id)->first();
                $tenant_code = (!empty(@$getTenant->unique_id)) ?  $getTenant->unique_id.'/':'';

                $default_partner = PropertyPaymentSetting::where('lease_id',$getLease->id)->where('default_partner','1')->first();
                if(empty($default_partner)){
                    $default_partner = PropertyPaymentSetting::where('lease_id',$getLease->id)->first();

                }

                $invoice = new Invoice;
                $invoice->random_no = $random_no;
                $invoice->invoice_no = $tenant_code.date('M').'/'.date('Y').'/'.rand(0,9999);
                $invoice->user_id = '1';
                $invoice->lease_id = $getLease->id;
                $invoice->partner_id = $default_partner->user_id;
                $invoice->partner_per = $default_partner->commission_value;
                $invoice->partner_type = $default_partner->commission_type;
                $invoice->is_gst = $default_partner->is_gst;
                $invoice->property_id = $getLease->property_id;
                $invoice->tenant_id = $getTenant->id;
                $invoice->invoice_date = date('Y-m-d');
                $invoice->invoice_generate_date = date('Y-m-d');
                $invoice->invoice_type = 'electricity';
                $invoice->tenant_property_utility_id = $lease->tenat_u_id;
                $invoice->save();
                if($invoice) {
                    $avalue = $getLease->load_taken*0.9*501;
                    $electricityInvoice = new InvoiceDetail;
                    $electricityInvoice->invoice_id = $invoice->id;
                    $electricityInvoice->random_id = $random_no;
                    $electricityInvoice->item_desc = 'Fixed Charge';
                    $electricityInvoice->quantity = 1;
                    $electricityInvoice->rate = $avalue;
                    $electricityInvoice->amount = $avalue;
                    $electricityInvoice->sub_total = $avalue;
                    $electricityInvoice->type = 'electricity';
                    $electricityInvoice->item_type = 'rent';
                    $electricityInvoice->save();

                    $avalue1 = $jdata['no_units_consume']*$lease->energy_unit_per_unit;
                    $electricityInvoice1 = new InvoiceDetail;
                    $electricityInvoice1->invoice_id = $invoice->id;
                    $electricityInvoice1->random_id = $random_no;
                    $electricityInvoice1->item_desc = 'Energy Charges';
                    $electricityInvoice1->quantity = 1;
                    $electricityInvoice1->rate = $avalue1;
                    $electricityInvoice1->amount = $avalue1;
                    $electricityInvoice1->sub_total = $avalue1;
                    $electricityInvoice1->type = 'electricity';
                    $electricityInvoice1->item_type = 'rent';
                    $electricityInvoice1->save();


                    $totalUnitLoad = $getLease->load_taken*100;
                    $totalTenantUnits = $jdata['no_units_consume'];
                    $avalue2 = 0;
                    if($totalTenantUnits < $totalUnitLoad){
                        $valAmount = $totalUnitLoad-$totalTenantUnits;
                        $avalue2 = $valAmount*$lease->energy_unit_per_unit;
                    }
                   
                    $electricityInvoice2 = new InvoiceDetail;
                    $electricityInvoice2->invoice_id = $invoice->id;
                    $electricityInvoice2->random_id = $random_no;
                    $electricityInvoice2->item_desc = 'TMM Difference (if any)';
                    $electricityInvoice2->quantity = 1;
                    $electricityInvoice2->rate = $avalue2;
                    $electricityInvoice2->amount = $avalue2;
                    $electricityInvoice2->sub_total = $avalue2;
                    $electricityInvoice2->type = 'electricity';
                    $electricityInvoice2->item_type = 'rent';
                    $electricityInvoice2->save();

                    $totalAmount = $avalue+$avalue1+$avalue2;

                    $updateAmount= Invoice::find($invoice->id);
                    $updateAmount->total_amount = $totalAmount;
                    $updateAmount->amount = 0;
                    $updateAmount->remaining_amount = $totalAmount;
                    $updateAmount->grand_total = $totalAmount;
                    $updateAmount->save();


                }


             
            }




        }

    }
}
