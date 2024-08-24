@extends('layouts.master')
@section('content')
  <div class="row">
    <!-- Sales last year -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <h5 class="card-title mb-0">Sales</h5>
          <small class="text-muted">Last Year</small>
        </div>
        <div id="salesLastYear"></div>
        <div class="card-body pt-0">
          <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
            <h4 class="mb-0">175k</h4>
            <small class="text-danger">-16.2%</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Sessions Last month -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <h5 class="card-title mb-0">Sessions</h5>
          <small class="text-muted">Last Month</small>
        </div>
        <div class="card-body">
          <div id="sessionsLastMonth"></div>
          <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
            <h4 class="mb-0">45.1k</h4>
            <small class="text-success">+12.6%</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Profit -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="badge p-2 bg-label-danger mb-2 rounded">
            <i class="ti ti-currency-dollar ti-md"></i>
          </div>
          <h5 class="card-title mb-1 pt-2">Total Profit</h5>
          <small class="text-muted">Last week</small>
          <p class="mb-2 mt-1">1.28k</p>
          <div class="pt-1">
            <span class="badge bg-label-secondary">-12.2%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Sales -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="badge p-2 bg-label-info mb-2 rounded"><i class="ti ti-chart-bar ti-md"></i></div>
          <h5 class="card-title mb-1 pt-2">Total Sales</h5>
          <small class="text-muted">Last week</small>
          <p class="mb-2 mt-1">$4,673</p>
          <div class="pt-1">
            <span class="badge bg-label-secondary">+25.2%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Revenue Growth -->
    <div class="col-xl-4 col-md-8 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
                <h5 class="mb-1 text-nowrap">Revenue Growth</h5>
                <small>Weekly Report</small>
              </div>
              <div class="chart-statistics">
                <h3 class="card-title mb-1">$4,673</h3>
                <span class="badge bg-label-success">+15.2%</span>
              </div>
            </div>
            <div id="revenueGrowth"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earning Reports Tabs-->
    
    <!-- Sales last 6 months -->
   
  </div>
          
 @endsection