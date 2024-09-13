<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lease;
use App\Models\RentCal;
class LeasePriceUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lease-price-update';

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
        $leases = Lease::where('status','Approved')->get();
        foreach ($leases as $lease) {
             $startDate = new \DateTime($lease->start_date);
            $numberOfMonths = $lease->end_month;

            // Calculate the end date based on start date and number of months
            $endDate = clone $startDate;
            $endDate->add(new \DateInterval('P' . $numberOfMonths . 'M'));

            // Get the current date
            $currentDate = new \DateTime();

            // Determine the effective end date for calculation
            $effectiveEndDate = $currentDate < $endDate ? $currentDate : $endDate;

            // Calculate the number of months that have elapsed
            $currentMonth = $this->getCurrentLeaseMonth($startDate, $effectiveEndDate);

           
            $priceRange = RentCal::where('from_month', '<=', $currentMonth)
                ->where('to_month', '>=', $currentMonth)
                 ->where('type','1')
                 ->where('lease_id',$lease->id)
                ->first();

            $CamRange = RentCal::where('from_month', '<=', $currentMonth)
                ->where('to_month', '>=', $currentMonth)
                 ->where('type','2')
                 ->where('lease_id',$lease->id)
                ->first();
          
            if (!empty($priceRange)) {
                // Update rent price
                $lease->price = $priceRange->price;
                $lease->save();
            }
            if (!empty($CamRange)) {
                // Update cam price
                $lease->camp_price = $priceRange->price;
                $lease->save();
            }
            
           
        }

    }
    private function getCurrentLeaseMonth(\DateTime $startDate, \DateTime $effectiveEndDate)
    {
        $diff = $startDate->diff($effectiveEndDate);
        return ($diff->y * 12) + $diff->m + 1; // Add 1 to convert to 1-based month
    }
}
