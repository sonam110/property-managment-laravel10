
  <div class="row" id="propertyContainer">
    @foreach($allProperties as $property)
    @php  
          $id = $property->id;
          $totalOccupied = App\Models\PropertyUnit::where('property_id',$property->id)->where('is_rented','1')->count();  
          $totalFree = App\Models\PropertyUnit::where('property_id',$property->id)->where('is_rented','0')->count(); 
          $totalInvoce = App\Models\Invoice::where('property_id',$property->id)
            ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('created_at', '<=', $toDate);
            })->count();

          $totalLease = App\Models\Lease::where('property_id',$property->id)
            ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('created_at', '<=', $toDate);
            })->count();

          

          $countData['totalInVoiceAmount']=  App\Models\InvoiceDetail::join('invoices','invoice_details.invoice_id','invoices.id')->where('invoices.property_id', $id)->whereIn('invoice_details.type',['rent','rent-gst'])
           ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('invoices.created_at', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('invoices.created_at', '<=', $toDate);
            })
          ->sum('invoice_details.amount');
          if($countData['totalInVoiceAmount']==0){
            $countData['totalInVoiceAmount'] = App\Models\Lease::where('property_id',$id)
            ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('created_at', '<=', $toDate);
            })
            ->sum('total_rent');

          }

          $countData['totalPaid']= App\Models\Payment::where('property_id',$id)->where('invoice_type','rent')->whereIn('status',['Full','Partial'])
          ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('payment_date', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('payment_date', '<=', $toDate);
            })
          ->sum('amount');
          $countData['totalUnPaid']= $countData['totalInVoiceAmount']-$countData['totalPaid'];

          $countData['totalCamInVoiceAmount']=  App\Models\InvoiceDetail::join('invoices','invoice_details.invoice_id','invoices.id')->where('invoices.property_id', $id)->whereIn('invoice_details.type',['cam','cam-gst'])
           ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('invoices.created_at', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('invoices.created_at', '<=', $toDate);
            })
          ->sum('invoice_details.amount');
          if($countData['totalCamInVoiceAmount']==0){
            $countData['totalCamInVoiceAmount'] = App\Models\Lease::where('property_id',$id)
            ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('created_at', '<=', $toDate);
            })
            ->sum('total_cam');

          }

          $countData['totalCamPaid']= App\Models\Payment::where('property_id',$id)->where('invoice_type','cam')->whereIn('status',['Full','Partial'])
           ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('payment_date', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('payment_date', '<=', $toDate);
            })
          ->sum('amount');
          $countData['totalCamUnPaid']= $countData['totalCamInVoiceAmount']-$countData['totalCamPaid'];

          $countData['totalUtilityInVoiceAmount']=  App\Models\InvoiceDetail::join('invoices','invoice_details.invoice_id','invoices.id')->where('invoices.property_id', $id)->whereIn('invoice_details.type',['utility','utility-gst'])
           ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('invoices.created_at', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('invoices.created_at', '<=', $toDate);
            })
          ->sum('invoice_details.amount');
          $countData['totalUtilityPaid']= App\Models\Payment::where('property_id',$id)->where('invoice_type','utility')->whereIn('status',['Full','Partial'])
          ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('payment_date', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('payment_date', '<=', $toDate);
            })
          ->sum('amount');
          $countData['totalUtilityUnPaid']= $countData['totalUtilityInVoiceAmount']-$countData['totalUtilityPaid'];
          
          $camExpense= App\Models\Expense::where('property_id',$id)->where('type','1')
          ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('ex_date', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('ex_date', '<=', $toDate);
            })
          ->sum('price');
          $utilityExpense= App\Models\Expense::where('property_id',$id)->where('type','2')
           ->when($fromDate, function($query) use ($fromDate) {
                return $query->whereDate('ex_date', '>=', $fromDate);
            })
            ->when($toDate, function($query) use ($toDate) {
                return $query->whereDate('ex_date', '<=', $toDate);
            })
          ->sum('price');

    @endphp
    <div class="col-xl-12 mb-4 col-lg-12 col-12 property-card-data" data-name="{{ strtolower($property->property_name) }}">
           <div class="card">
            <h4 class="text-center property-header">
              <a
               href="{{ route('property-units',$property->id) }}">
              {{ strtolower($property->property_name) }} ( {{ $property->property_code }})
              </a>
            </h4>

            <div >
                 <div class="card mb-4">
                    <div class="card-widget-separator-wrapper">
                      <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                          <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('property-units',$property->id) }}">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                              
                              <div>
                                <h5 class="mb-1">{{ $property->units_count }}</h5>
                                <p class="mb-0">Total Units</p>
                              </div>

                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"
                                  ><i class="ti ti-home ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                            <hr class="d-none d-sm-block d-lg-none me-4" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('property-units',$property->id) }}">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ $totalFree }}</h5>
                                <p class="mb-0">Free</p>
                              </div>
                              <span class="avatar me-lg-4">
                                <span class="avatar-initial bg-label-warning rounded"
                                  ><i class="ti ti-file-invoice ti-md"></i
                                ></span>
                              </span>
                            </div>
                           </a>
                            <hr class="d-none d-sm-block d-lg-none" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('property-units',$property->id) }}">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ $totalOccupied }}</h5>
                                <p class="mb-0">Occupied</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                          </div>
                           <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('leases.index') }}">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ $totalLease }}</h5>
                                <p class="mb-0">Total Lease</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="menu-icon tf-icons ti ti-server"></i></span>
                              </span>
                            </div>
                          </a>
                          </div>
                        
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mb-4">
                    <div class="card-widget-separator-wrapper">
                      <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                           <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('invoice') }}">
                            <div class="d-flex justify-content-between align-items-start">
                              <div>
                                <h5 class="mb-1">{{ $totalInvoce }}</h5>
                                <p class="mb-0">Total Invoice</p>
                              </div>
                              <span class="avatar">
                                <span class="avatar-initial bg-label-danger rounded"
                                  ><i class="menu-icon tf-icons ti ti-file-invoice"></i></span>
                              </span>
                            </div>
                          </a>
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('invoice') }}">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalInVoiceAmount']) }}</h5>
                                <p class="mb-0">Total Rent</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"
                                  ><i class="ti ti-home ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                            <hr class="d-none d-sm-block d-lg-none me-4" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('invoice') }}">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalPaid']) }}</h5>
                                <p class="mb-0">Rent Paid</p>
                              </div>
                              <span class="avatar me-lg-4">
                                <span class="avatar-initial bg-label-warning rounded"
                                  ><i class="ti ti-file-invoice ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                            <hr class="d-none d-sm-block d-lg-none" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('invoice') }}">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalUnPaid']) }}</h5>
                                <p class="mb-0">Rent Unpaid</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mb-4">
                    <div class="card-widget-separator-wrapper">
                      <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                          <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('invoice') }}">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalCamInVoiceAmount']) }}</h5>
                                <p class="mb-0">Total CAM</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"
                                  ><i class="ti ti-home ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                            <hr class="d-none d-sm-block d-lg-none me-4" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('invoice') }}">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalCamPaid']) }}</h5>
                                <p class="mb-0">CAM Paid</p>
                              </div>
                              <span class="avatar me-lg-4">
                                <span class="avatar-initial bg-label-warning rounded"
                                  ><i class="ti ti-file-invoice ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                            <hr class="d-none d-sm-block d-lg-none" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('invoice') }}">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalCamUnPaid']) }}</h5>
                                <p class="mb-0">CAM Unpaid</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                          </div>
                           <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('expense.index') }}">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($camExpense) }}</h5>
                                <p class="mb-0">CAM Expense</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                   <div class="card mb-4">
                    <div class="card-widget-separator-wrapper">
                      <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                          <div class="col-sm-6 col-lg-3">
                             <a href="{{ route('invoice') }}">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalUtilityInVoiceAmount']) }}</h5>
                                <p class="mb-0">Total Utility</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"
                                  ><i class="ti ti-home ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                            <hr class="d-none d-sm-block d-lg-none me-4" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                             <a href="{{ route('invoice') }}">
                            <div
                              class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalUtilityPaid']) }}</h5>
                                <p class="mb-0">Utility Paid</p>
                              </div>
                              <span class="avatar me-lg-4">
                                <span class="avatar-initial bg-label-warning rounded"
                                  ><i class="ti ti-file-invoice ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                            <hr class="d-none d-sm-block d-lg-none" />
                          </div>
                          <div class="col-sm-6 col-lg-3">
                             <a href="{{ route('invoice') }}">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($countData['totalUtilityUnPaid']) }}</h5>
                                <p class="mb-0">Utility Unpaid</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                          </div>
                          <div class="col-sm-6 col-lg-3">
                             <a href="{{ route('expense.index') }}">
                            <div
                              class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                              <div>
                                <h5 class="mb-1">{{ formatIndianCurrency($utilityExpense) }}</h5>
                                <p class="mb-0">Utility Expense</p>
                              </div>
                              <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-info rounded"
                                  ><i class="ti ti-checks ti-md"></i
                                ></span>
                              </span>
                            </div>
                          </a>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                             
            
             
            </div>
          </div>
        

    
    </div>
  
    @endforeach
    
   
  </div>
          
 