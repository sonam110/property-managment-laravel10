@extends('layouts.master')
@section('extracss')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('page-title')
    {{ __('Manage Tenant') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('tenants.index')}}">{{__('Lease Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Tenant')}}</li>
@endsection

@section('content')

 <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
          <!-- User Card -->
          <div class="card mb-4">
            <div class="card-body">
        
              <h5 class="mt-4 small text-uppercase text-muted">Details</h5>
              <div class="info-container">
                <ul class="list-unstyled">
                  <li class="mb-2">
                    <span class="fw-medium me-1">Full Name:</span>
                    <span>{{ $tenant->full_name }}</span>
                  </li>
                  <li class="mb-2">
                    <span class="fw-medium me-1">Firm Name:</span>
                    <span>{{ $tenant->firm_name }}</span>
                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">Email:</span>
                        <span>{{ $tenant->email }}</span>

                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">Phone No:</span>
                        <span>{{ $tenant->phone }}</span>

                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">GST No:</span>
                    <span class="badge bg-label-success">{{ $tenant->gst_no }}</span>
                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">PAN No:</span>
                    <span class="badge bg-label-warning">{{ $tenant->pan_no }}</span>
                  </li>
                  
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">City:</span>
                    <span>{{ $tenant->city }}</span>
                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">Business name:</span>
                    <span>{{ $tenant->business_name }}</span>
                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">Business industry:</span>
                    <span>{{ $tenant->business_industry }}</span>
                  </li>
                  <li class="mb-2 pt-1">
                    <span class="fw-medium me-1">Business Address:</span>
                    <span>{{ $tenant->business_address }}</span>
                  </li>
                  <li class="pt-1">
                    <span class="fw-medium me-1">Business description:</span>
                    <span>{{ $tenant->business_description }}</span>
                  </li>
                </ul>
                <div class="d-flex justify-content-center">
                  <a
                    href="{{ route('tenants.edit',$tenant->id) }}"
                    class="btn btn-primary me-3"
                    title="Edit"
                    >Edit</a
                  >
                  
                </div>
              </div>
            </div>
          </div>
          <!-- /User Card -->
         
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        
          <!-- Project table -->
          <div class="card mb-4">
            <!-- Notifications -->
            <h5 class="card-header pb-1">Contact Information</h5>
            <div class="card-body">
            </div>
            <div class="table-responsive">
              <table class="table table-striped border-top">
                <thead>
                  <tr>
                    <th class="text-nowrap">Type</th>
                    <th class="text-nowrap text-center">Full Name</th>
                    <th class="text-nowrap text-center">Email</th>
                    <th class="text-nowrap text-center">Phone</th>
                    <th class="text-nowrap text-center">Position</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($tenantContactInfo as $key=>  $info)
                  <tr>
                    <td class="text-nowrap">{{ $info->contact_type }}</td>
                    <td>
                      {{ $info->full_name }}
                    </td>
                    <td>
                      {{ $info->email }}
                    </td>
                    <td>
                     {{ $info->phone }}
                    </td>
                    <td>
                     {{ $info->position }}
                    </td>
                  </tr>
                  @endforeach
                 
                </tbody>
              </table>
            </div>
           
            <!-- /Notifications -->
          </div>
          <!-- /Project table -->
        </div>
        <!--/ User Content -->
      </div>
@endsection
@section('extrajs')  

 @endsection