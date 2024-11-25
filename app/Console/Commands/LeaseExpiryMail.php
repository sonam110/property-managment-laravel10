<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lease;
use Mail;
use Log;
use DB;
use Carbon\Carbon;
use App\Mail\SendLeaseExpiryMail;
class LeaseExpiryMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lease-expiry-mail';

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
        $allLeases = Lease::with('property', 'tenant')->get();
        $currentDate = Carbon::now();

        foreach ($allLeases as $lease) {
            $leaseStartDate = Carbon::parse($lease->start_date);  
            $monthsToAdd = $lease->end_month; 

            $leaseEndDate = $leaseStartDate->copy()->addMonths($monthsToAdd); 
            $reminderDate = $leaseEndDate->copy()->subMonth(1); 
            // Log information for debugging
           /* Log::info("Processing lease ID: {$lease->id}");
            Log::info("Lease Start Date: " . $leaseStartDate->format('Y-m'));
            Log::info("Lease End Date: " . $leaseEndDate->format('Y-m'));
            Log::info("Current Date: " . $currentDate->format('Y-m'));
            Log::info("Reminder Date: " . $reminderDate->format('Y-m'));*/

            // Check if the lease has expired
            if ($currentDate->greaterThan($leaseEndDate) && $lease->status !== 'Expired') {
                // Update only the 'status' field to "Expired"
                DB::table('leases')->where('id', $lease->id)->update(['status' => 'Expired']);
                Log::info("Lease status updated to Expired for lease ID: {$lease->id}");
            }

            // Send a reminder email one month before lease end date
            if ($currentDate->format('Y-m') == $reminderDate->format('Y-m') || $currentDate->format('Y-m') == $leaseEndDate->format('Y-m')) {
                $content = [
                    "tenantName" => $lease->tenant->full_name ?? 'Tenant',
                    "leaseEndDate" => $leaseEndDate->format('F Y'),
                    "propertyName" => $lease->property->property_name ?? 'Property',
                ];
                $email = $lease->tenant->email;

                // Send reminder email if mail is enabled
                if (env('IS_MAIL_ENABLE', false)) {
                    Mail::to($email)->send(new SendLeaseExpiryMail($content));
                    Log::channel('automation_emails_log')->info("Reminder email sent to: {$email} for lease ID: {$lease->id}");
                }
            }
        }}
    }
