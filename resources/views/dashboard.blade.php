@extends('layouts.master')
@section('content')
  <div class="row">
   

    <!-- Revenue Growth -->
    @foreach($allProperties as $property)
    @php  $totalOccupied = App\Models\PropertyUnit::where('property_id',$property->id)->where('is_rented','1')->count();  
          $totalFree = App\Models\PropertyUnit::where('property_id',$property->id)->where('is_rented','0')->count(); 
          $invoice = App\Models\Payment::query();
          $totalInvoce = App\Models\Invoice::where('property_id',$property->id)->count();
          $totalLease = App\Models\Lease::where('property_id',$property->id)->count();
          $totalRent= $invoice->where('property_id',$property->id)->where('invoice_type','rent')->sum('grand_total');
          $totalCam= $invoice->where('property_id',$property->id)->where('invoice_type','cam')->sum('grand_total');
          $totalUtility= $invoice->where('property_id',$property->id)->where('invoice_type','utility')->sum('grand_total');
          $expense = App\Models\Expense::query();
          $camExpense = $expense->where('property_id',$property->id)->where('type','CAM')->sum('price');
          $utilityExpense= $expense->where('property_id',$property->id)->where('type','Utility')->sum('price');

    @endphp
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
                <a href="{{ route('property-units',$property->id) }}"><h5 class="mb-1 text-nowrap">{{ ucfirst($property->property_name)  }}  </h5></a>
                <a href="{{ route('property-units',$property->id) }}"><small>Property Code : {{ $property->property_code  }}</small></a><br>
                 <a href="{{ route('property-units',$property->id) }}"><h3 class="card-title mb-1">UNITS:{{ $property->units_count }}</h3></a>
                <a href="{{ route('property-units',$property->id) }}"> <span class="badge bg-label-success">Free : {{ $totalFree }}</span></a>
                <a href="{{ route('property-units',$property->id) }}"><span class="badge bg-label-danger">Occupied : {{ $totalOccupied }}</span></a>
              
              </div>
              <br>
               <div class="chart-statistics">
                <a href="{{ route('property-units',$property->id) }}"> <span class="badge bg-label-primary">Total Lease : {{ $totalLease }}</span></a>
                <a href="{{ route('property-units',$property->id) }}"><span class="badge bg-label-primary">Total Invoice : {{ $totalInvoce }}</span></a>
                </div>
               
             
            </div>
            <div id="revenueGrowth"><div class="d-flex flex-column">
              <div class="card-title mb-auto">
                 <br>
                <div class="chart-statistics">
                <a href="{{ route('property-units',$property->id) }}"><span class="badge bg-label-primary">Total Rent : {{ formatIndianCurrency($totalRent) }}</span></a>
                <a href="{{ route('property-units',$property->id) }}"><span class="badge bg-label-primary">Total CAM : {{ formatIndianCurrency($totalCam) }}</span></a>
               </div>
               <br>
               <div class="chart-statistics">
                <a href="{{ route('property-units',$property->id) }}"><span class="badge bg-label-primary">Total Utility : {{ formatIndianCurrency($totalUtility) }}</span></a>
                <a href="{{ route('property-units',$property->id) }}"><span class="badge bg-label-primary">Total CAM Expense : {{ formatIndianCurrency($camExpense) }}</span></a>
                </div><br>
                <div class="chart-statistics">
                <a href="{{ route('property-units',$property->id) }}"><span class="badge bg-label-primary">Total Utility Expense : {{ formatIndianCurrency($utilityExpense) }}</span></a>
                </div>
              </div>
             
            </div></div>
          </div>
        </div>
      </div>
    </div>

    @endforeach
    <!-- Earning Reports Tabs-->
    
    <!-- Sales last 6 months -->
   
  </div>
          
 @endsection