@extends('layouts.master')
@section('extracss')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<style type="text/css">
.floor {
    display: grid;
    grid-template-columns: repeat(9, 1fr);
    gap: 4px;
    border: 1px solid #c9c9c9;
    padding: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.unit {
    border-radius: 6px;
    font-size: 10px;
    width: 32px;
    position: relative;
    background-color: #f9f9f9;
    border: 1px solid ;
    padding: 0px;
    aspect-ratio: 1 / 1; /* Keeps the box square */
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}
.unit input[type="checkbox"] {
    position: absolute;
    opacity: 0; /* Hide the default checkbox */
}
.unit input[type="checkbox"] + label {
    position: relative;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    text-align: center;
    line-height: 1.5;
}
.unit input[type="checkbox"]:checked + label {
    background-color: #4CAF50;
    color: white;
}


</style>
@endsection
@section('page-title')
    {{ __('Lease Property') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('leases.index')}}">{{__('Lease Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Lease')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
    
          <a href="{{ url()->previous() }}"  data-title="{{__('Back')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Go To Back')}}"  class="btn btn-sm btn-primary">
              <i class="ti ti-arrow-left"></i>
          </a>
       
    </div>
@endsection
@section('content')
    <div id="wizard-property-listing" class="bs-stepper vertical mt-2">
                <div class="bs-stepper-header">
                  <div class="step active" data-target="#lease-info">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-users ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Tenant Info</span>
                      
                      </span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#lease-rent">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-currency-dollar ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Lease Rent </span>
                       
                      </span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#cam">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-bookmarks ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">CAM</span>
                       
                      </span>
                    </button>
                  </div>
                   <div class="line"></div>
                  <div class="step" data-target="#payment-setting">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-currency-dollar ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Payment Setting </span>
                       
                      </span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#security-deposit">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-bookmarks ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Security Deposit</span>
                       
                      </span>
                    </button>
                  </div>

                  <div class="line"></div>
                  <div class="step" data-target="#extra-charges">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-map-pin ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Extra Charges</span>
                      
                      </span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#utilities">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-home ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Utilities</span>
                        
                      </span>
                    </button>
                  </div>
                <div class="line"></div>
                  <div class="step" data-target="#documents">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-upload"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Documents</span>
                        
                      </span>
                    </button>
                  </div>
                 
                </div>
                <div class="bs-stepper-content">
                  <form id="wizard-property-listing-form"  enctype="multipart/form-data"  files ="true" onSubmit="return false">
                     {!! Form::hidden('id',null,array('class'=>'form-control')) !!}
                    @csrf
                    <!-- lease Details -->
                    <div id="lease-info" class="content active">
                      <div class="row g-3">
                        <div class="col-sm-12">
                            {{ Form::label('tenant_id', __('Tenants'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                            {!! Form::select('tenant_id', ['' => __('Select Tenant')] + $tenants, null, ['class' => 'form-control select tenant_id select2 form-select', 'id' => 'tenant_id']) !!}
                            @error('tenant_id')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            {{ Form::label('property_id', __('Properties'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                            {!! Form::select('property_id', ['' => __('Select Property')] + $properties, $property_id, ['class' => 'form-control select property_id select2 form-select', 'id' => 'property_id']) !!}
                            @error('property_id')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>

                        <div class="col-sm-12">
                            <div class="unit_ids">
                                <label for="unit_ids" class="form-label">Property Units</label> <span class="requiredLabel">*</span>
                                
                            </div>
                        </div>
                        
                       
                        <!-- <div class="col-sm-6">
                            <div class="mb-3">
                                {{ Form::label('rent_amount', __('Rent amount'), ['class' => 'form-label']) }}
                                {{ Form::text('rent_amount', null, ['class' => 'form-control', 'placeholder' => __('Rent Amount')]) }}
                                @error('rent_amount')
                                    <small class="invalid-email" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div> -->
                        <div class="col-sm-6">
                            {{ Form::label('start_date', __('Start date'), ['class' => 'form-label']) }}<span class="requiredLabel">*</span>
                            {{ Form::date('start_date', date('Y-m-d'), ['class' => 'form-control', 'placeholder' => __('Start date')]) }}
                            @error('start_date')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('end_month', __('Expiry (In Month)'), ['class' => 'form-label']) }}<span class="requiredLabel">*</span>
                            {{ Form::number('end_month', 12, ['class' => 'form-control end_month', 'placeholder' => __('End months')]) }}
                            @error('end_month')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('due_on', __('Due on(Day of month)'), ['class' => 'form-label']) }}<span class="requiredLabel">*</span>
                            {{ Form::number('due_on', 10, ['class' => 'form-control', 'placeholder' => __('Due on(Day of month)')]) }}
                            @error('due_on')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('load_taken', __('Electricity Load Taken(KV)'), ['class' => 'form-label']) }}<span class="requiredLabel">*</span>
                            {{ Form::number('load_taken', null, ['class' => 'form-control', 'placeholder' => __('Load Taken')]) }}
                            @error('load_taken')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('lease_invoice_type', __('Invoice Type'), ['class' => 'form-label']) }}
                            <select name="lease_invoice_type" class="form-control select2 form-select">
                                <option  value="2" selected>Current Month</option>
                                <option  value="1" >Advance Month</option>
                               
                            </select>
                        </div>


                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-primary btn-prev" disabled>
                            <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                          </button>
                          <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                            <i class="ti ti-arrow-right ti-xs"></i>
                          </button>
                        </div>
                      </div>
                    </div>

                    <!-- lease rent -->
                    <div id="lease-rent" class="content">
                      <div class="row g-3 rent-increment-row">
                        <div id="unit-rent-details"></div>
                          <div class="col-sm-4">
                           {{ Form::label('total_square', __('Total Area of Square Foot'), ['class' => 'form-label']) }}
                            {{ Form::number('total_square',null, ['class' => 'form-control','id'=>'total_square','min'=>'1','readonly'=>'readonly', 'placeholder' => __('Total Square')]) }}
                            @error('total_square')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                          </div>
                          <div class="col-sm-4">
                         <!--   {{ Form::label('price', __('Price/Square foot'), ['class' => 'form-label']) }} -->
                            {{ Form::hidden('price', null, ['class' => 'form-control','id'=>'price','min'=>'1','readonly'=>'readonly', 'placeholder' => __('Price/Square')]) }}
                            @error('price')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                          </div>
                          <div class="col-sm-4">
                           {{ Form::label('final_total', __('Total Rent'), ['class' => 'form-label']) }}
                            {{ Form::number('final_total', null, ['class' => 'form-control','id'=>'final_total','min'=>'1','readonly'=>'readonly', 'placeholder' => __('Total')]) }}
                            @error('final_total')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                          </div>
                     
                        <hr class="my-5" />
                        
                        <div class="col-sm-12">
                            <h6> Rent Incremental Term:</h6>
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('from_month', __('From Month'), ['class' => 'form-label']) }}
                            {{ Form::number('from_month[]', null, ['class' => 'form-control from_month','id'=>'from_month','min'=>'1','step'=>'1', 'placeholder' => __('From Month')]) }}
                            @error('from_month')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('to_month', __('To Month'), ['class' => 'form-label']) }}
                            {{ Form::number('to_month[]', null, ['class' => 'form-control to_month','id'=>'to_month','min'=>'1','step'=>'1','placeholder' => __('To Month')]) }}
                            @error('to_month')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                         <div class="col-sm-3">
                           {{ Form::label('set_price', __('Percentage'), ['class' => 'form-label']) }}
                            {{ Form::number('set_price[]', null, ['class' => 'form-control set_price','id'=>'set_price','step'=>'any', 'placeholder' => __('Percentage')]) }}
                            @error('set_price')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('inc_rent_amount', __('Rent Amount'), ['class' => 'form-label']) }}
                            {{ Form::number('inc_rent_amount[]', null, ['class' => 'form-control inc_rent_amount','id'=>'inc_rent_amount','step'=>'any','readonly'=>'readonly', 'placeholder' => __('Rent Amount')]) }}
                            @error('inc_rent_amount')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        
                        <div class="col-sm-12">
                        
                            <div id="RentCalContainer" class="">
                                <!-- Unit rows will be added here dynamically -->
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addRentCalButton">+ Add More</button>
                            </div>
                        
                        </div>
                      
                        
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-primary btn-prev">
                            <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                          </button>
                          <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                            <i class="ti ti-arrow-right ti-xs"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- CAM -->
                    <div id="cam" class="content">
                       <div class="row g-3 cam-increment-row">
                        <div id="cam-details"></div>
                         <div class="col-sm-4">
                           {{ Form::label('cam_square_foot', __('Total Area of Square Foot'), ['class' => 'form-label']) }}
                            {{ Form::number('cam_square_foot', null, ['class' => 'form-control','readonly'=>'readonly','id'=>'cam_square_foot','min'=>'1', 'placeholder' => __('Total Area of Square Foot')]) }}
                            @error('cam_square_foot')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                         <div class="col-sm-4">
                         <!--   {{ Form::label('camp_price', __('Price/Square foot'), ['class' => 'form-label']) }} -->
                            {{ Form::hidden('camp_price', null, ['class' => 'form-control','readonly'=>'readonly','id'=>'camp_price','min'=>'1', 'placeholder' => __('Price/Square')]) }}
                            @error('camp_price')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-4">
                           {{ Form::label('camp_total', __('Total CAM'), ['class' => 'form-label']) }}
                            {{ Form::number('camp_total', null, ['class' => 'form-control','readonly'=>'readonly','id'=>'camp_total','min'=>'1', 'placeholder' => __('Total')]) }}
                            @error('camp_total')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                         <hr class="my-5" />
                        <div class="col-sm-12">
                            <h6> CAM Incremental Term:</h6>
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('cam_from_month', __('From Month'), ['class' => 'form-label']) }}
                            {{ Form::number('cam_from_month[]', null, ['class' => 'form-control cam_from_month','id'=>'cam_from_month','min'=>'1','step'=>'1', 'placeholder' => __('From Month')]) }}
                            @error('cam_from_month')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('cam_to_month', __('To Month'), ['class' => 'form-label']) }}
                            {{ Form::number('cam_to_month[]', null, ['class' => 'form-control cam_to_month','id'=>'cam_to_month','min'=>'1','step'=>'1','placeholder' => __('To Month')]) }}
                            @error('cam_to_month')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                         <div class="col-sm-3">
                           {{ Form::label('cam_set_price', __('Percentage'), ['class' => 'form-label']) }}
                            {{ Form::number('cam_set_price[]', null, ['class' => 'form-control cam_set_price','id'=>'cam_set_price','step'=>'any', 'placeholder' => __('Percentage')]) }}
                            @error('cam_set_price')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('inc_cam_amount', __('CAM Amount'), ['class' => 'form-label']) }}
                            {{ Form::number('inc_cam_amount[]', null, ['class' => 'form-control inc_cam_amount','id'=>'inc_cam_amount','step'=>'any','readonly'=>'readonly', 'placeholder' => __('CAM Amount')]) }}
                            @error('inc_cam_amount')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        
                        <div class="col-sm-12">
                        
                            <div id="CamCalContainer" class="">
                                <!-- Unit rows will be added here dynamically -->
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addCamCalButton">+ Add More</button>
                            </div>
                        
                        </div>
                        
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-primary btn-prev">
                            <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                          </button>
                          <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                            <i class="ti ti-arrow-right ti-xs"></i>
                          </button>
                        </div>
                      </div>
                    </div>

                     <!-- Property Details -->
                    <div id="payment-setting" class="content">
                      <div class="row g-3 textBoxWrapper">
                        <div class="col-sm-3">
                            {{ Form::label('partners[]', __('Partners'), ['class' => 'form-label']) }}
                            <div class="select2-primary">
                                {!! Form::select('partners[]', $partners, null, [
                                    'class' => 'form-control select2 form-select',
                                    'id' => 'select2Primary',
                                    'required' => 'required'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('commission_value', __('Partner\'s share'), ['class' => 'form-label']) }}
                            {{ Form::number('commission_value[]', null, ['class' => 'form-control commission-input','id'=>'commission_value','step'=>'any', 'placeholder' => __('Partner\'s share')]) }}
                            @error('commission_value')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        
                        <div class="col-sm-3">
                          <label class="form-label" for="commission_type"> Type</label>
                          <select id="commission_type" name="commission_type[]" class="form-control  select2 form-select commission-type" >
                            <option value="">Select</option>
                            <option value="1">Fixed Value</option>
                            <option value="2" selected>% of Total Rent</option>
                          </select>
                        </div>
                        <div class="col-sm-2">
                            <p style="margin-top: 20px;">
                                <input class="form-check-input gst-checkbox" type="checkbox" id="is_gst"  name="is_gst[]" checked  value="1"/>
                                <label class="form-check-label" for="is_gst">GST Invoice </label>
                                <br>
                                <input class="form-check-input default_partner-checkbox" type="radio" id="default_partner"  name="default_partner[]"  value="1"/ checked>
                                <label class="form-check-label" for="default_partner"> Default Partner </label>
                            </p>
                        </div>
                        
                        <div class="col-sm-12">
                        
                            <div id="paymentContainer" class="">
                                <!-- Unit rows will be added here dynamically -->
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addPartnerButton">+ Add Payment</button>
                            </div>
                        
                        </div>
                        
                        
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-primary btn-prev">
                            <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                          </button>
                          <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                            <i class="ti ti-arrow-right ti-xs"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div id="security-deposit" class="content">
                      <div class="row g-3">
                        <div class="row g-3 textBoxWrapper">
                          <div class="col-sm-4">
                              {{ Form::label('utility[]', __('Utility Name'), ['class' => 'form-label']) }}
                              <div class="select2-primary">
                                  {!! Form::select('utility[]', $utilities, null, [
                                      'class' => 'form-control select2 form-select',
                                      'id' => 'select2Primary',
                                      'required' => 'required'
                                  ]) !!}
                              </div>
                          </div>
                          <div class="col-sm-4">
                             {{ Form::label('deposit_amount', __('Deposit Amount'), ['class' => 'form-label']) }}
                              {{ Form::text('deposit_amount[]', null, ['class' => 'form-control','id'=>'deposit_amount', 'placeholder' => __('Deposit Amount')]) }}
                              @error('deposit_amount')
                                  <small class="invalid-name" role="alert">
                                      <strong class="text-danger">{{ $message }}</strong>
                                  </small>
                                @enderror
                          </div>
                         <div class="col-sm-3"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div>
                        </div>
                        <div class="col-sm-12">
                        
                            <div id="securityDepositContainer" class="">
                                <!-- Unit rows will be added here dynamically -->
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addsecurityDepositButton">+ Add More</button>
                            </div>
                        
                        </div>
                        
                        
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-primary btn-prev">
                            <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                          </button>
                          <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                            <i class="ti ti-arrow-right ti-xs"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    

                     <!-- extra charge -->
                    <div id="extra-charges" class="content">
                       <div class="row g-3">
                        <div class="row g-3 textBoxWrapper">
                          <div class="col-sm-3">
                              {{ Form::label('extra_charge_id[]', __('Extra Charge Name'), ['class' => 'form-label']) }}
                              <div class="select2-primary">
                                  {!! Form::select('extra_charge_id[]', $extraCharges, null, [
                                      'class' => 'form-control select2 form-select',
                                      'id' => 'select2Primary',
                                      'required' => 'required'
                                  ]) !!}
                              </div>
                          </div>
                          <div class="col-sm-3">
                             {{ Form::label('extra_charge_value', __('Extra Charge Value'), ['class' => 'form-label']) }}
                              {{ Form::text('extra_charge_value[]', null, ['class' => 'form-control','id'=>'extra_charge_value', 'placeholder' => __('Extra Charge Value')]) }}
                              @error('extra_charge_value')
                                  <small class="invalid-name" role="alert">
                                      <strong class="text-danger">{{ $message }}</strong>
                                  </small>
                                @enderror
                          </div>
                          
                          <div class="col-sm-3">
                            <label class="form-label" for="extra_charge_type">Extra Charge Type</label>
                            <select id="extra_charge_type" name="extra_charge_type[]" class="form-control select2 form-select" data-allow-clear="true">
                              <option value="">Select</option>
                              <option value="1">Fixed Value</option>
                              <option value="2">% of Total Rent</option>
                            </select>
                          </div>
                          <div class="col-sm-2">
                            <label class="form-label" for="frequency">Frequency</label>
                            <select id="frequency" name="frequency[]" class="form-control select2 form-select" data-allow-clear="true">
                              <option value="">Select</option>
                              <option value="1">Onetime</option>
                              <option value="2">Monthly</option>
                            </select>
                          </div>
                          <div class="col-sm-1"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div>
                        </div>
                        <div class="col-sm-12">
                        
                            <div id="extraChargeContainer" class="">
                                <!-- Unit rows will be added here dynamically -->
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addExtraChargeButton">+ Add Extra Charge</button>
                            </div>
                        
                        </div>
                        
                        
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-primary btn-prev">
                            <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                          </button>
                          <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                            <i class="ti ti-arrow-right ti-xs"></i>
                          </button>
                        </div>
                      </div>
                    </div>

                

                    <!-- utilities -->
                    <div id="utilities" class="content">
                 
                      <div class="row g-3">
                        <div class="row g-3 textBoxWrapper">
                          <div class="col-sm-3">
                              {{ Form::label('utility_id[]', __('Utility Name'), ['class' => 'form-label']) }}
                              <div class="select2-primary">
                                  {!! Form::select('utility_id[]', $utilities, null, [
                                      'class' => 'form-control select2 form-select',
                                      'id' => 'select2Primary',
                                      'required' => 'required'
                                  ]) !!}
                              </div>
                          </div>
                          <div class="col-sm-3">
                             {{ Form::label('variable_cost', __('Variable Cost'), ['class' => 'form-label']) }}
                              {{ Form::text('variable_cost[]', null, ['class' => 'form-control','id'=>'variable_cost', 'placeholder' => __('Variable Cost')]) }}
                              @error('variable_cost')
                                  <small class="invalid-name" role="alert">
                                      <strong class="text-danger">{{ $message }}</strong>
                                  </small>
                                @enderror
                          </div>
                          <div class="col-sm-3">
                             {{ Form::label('fixed_cost', __('Fixed Cost'), ['class' => 'form-label']) }}
                              {{ Form::text('fixed_cost[]', null, ['class' => 'form-control','id'=>'fixed_cost', 'placeholder' => __('Fixed Cost')]) }}
                              @error('fixed_cost')
                                  <small class="invalid-name" role="alert">
                                      <strong class="text-danger">{{ $message }}</strong>
                                  </small>
                                @enderror
                          </div>
                          <div class="col-sm-3"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div>
                        </div>
                        <div class="col-sm-12">
                        
                            <div id="utilityContainer" class="">
                                <!-- Unit rows will be added here dynamically -->
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addUtilityButton">+ Add More</button>
                            </div>
                        
                        </div>
                        
                        
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-primary btn-prev">
                            <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                          </button>
                          <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                            <i class="ti ti-arrow-right ti-xs"></i>
                          </button>
                        </div>
                      </div>
                    </div>

                    <div id="documents" class="content">
                       <div class="row g-3">
                         <div class="card-body">
                              <div class="d-flex align-items-start align-items-sm-center gap-4">
                                
                                <div class="button-wrapper">
                                  <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                    <span id="file-name" class="d-none d-sm-block">Upload new Documents</span>
                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                    <input
                                      type="file"
                                      id="upload"
                                      name="documents[]"
                                      class="account-file-input"
                                      hidden
                                      multiple
                                      onchange="updateFileName()"

                                      />
                                  </label>
                                  <button type="button" class="btn btn-label-primary account-image-reset mb-3" onclick="resetFileName()">
                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                  </button>

                                
                                </div>
                                <div id="file-preview" class="mt-3">
                                  <!-- Uploaded file previews will appear here -->
                                </div>
                              </div>
                        </div>
                        </div>
    
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-primary btn-prev">
                            <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                          </button>
                          <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Create</span>
                            <i class="ti ti-arrow-right ti-xs"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

@endsection
@section('extrajs')  
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/wizard-ex-lease-listing.js') }}"></script>


    <script>
    function updateFileName() {
    const fileInput = document.getElementById('upload');
    const fileNameElement = document.getElementById('file-name');
    const files = fileInput.files;

    if (files.length > 0) {
      // Show the first selected file name
      fileNameElement.textContent = files.length + " file(s) selected";
      fileNameElement.classList.remove('d-none'); // Show the file name label
    } else {
      fileNameElement.textContent = 'Upload new Documents';
      fileNameElement.classList.add('d-none'); // Hide if no file selected
    }
  }
function initializePreCheckedUnits() {

    // Get all the checkboxes (assuming they have the class 'unit-checkbox')
    const checkboxes = document.querySelectorAll('.unit-checkbox');
    // Loop through all checkboxes and invoke unitCheckboxClicked for checked ones
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
        
            unitCheckboxClicked(checkbox); // Trigger the function for pre-selected checkboxes
        }

        // Add event listener for changes on click
       
    });
}
  function resetFileName() {
    const fileInput = document.getElementById('upload');
    const fileNameElement = document.getElementById('file-name');
    fileInput.value = '';  // Clear the file input
    fileNameElement.textContent = 'Upload new Documents';  // Reset label text
    fileNameElement.classList.add('d-none');  // Hide the file name label
  }
    $(document).ready(function() {
      var pid = '{{ $property_id }}';
        if (pid!='') {
            
            updateUnitsDropdown(pid);
        }
        // Function to handle the "Select All" button click
         $(document).on('click', '.select-all', function() { 
          var floor = $(this).data('floor');

          var checkboxes = $('.floor[data-floor="' + floor + '"] input[type="checkbox"]:not(:disabled)');
          var allChecked = checkboxes.filter(':checked').length === checkboxes.length;
  
          checkboxes.prop('checked', !allChecked);
          if (allChecked) {
              $(this).text('Select All'); 
          } else {
              $(this).text('Unselect All'); 
          }

          // Call any additional functions if needed
          clearPreviousUnits();
          initializePreCheckedUnits();
      });
    });


 $(document).off('change', '.property_id').on('change', '.property_id', function () {
      var property_id = $(this).val();
      updateUnitsDropdown(property_id);
      clearPreviousUnits();
  });


  function updateUnitsDropdown(property_id) {
        $.ajax({
            url: appurl + "get-units",
            type: "post",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: { property_id: property_id },
            success: function (response) {
                $(".unit_ids").html(response); // Populate the dropdown
            },
            error: function (xhr) {
                console.error('Error fetching units:', xhr.responseText);
            }
        });
    }


 function unitCheckboxClicked(checkbox) {

    const unitDetailsDiv = document.getElementById('unit-rent-details');
    const unitDetailsCamDiv = document.getElementById('cam-details');
    
    const unitId = checkbox.dataset.name; // Get the unique unit ID
    
    if (checkbox.checked) {
       

        // Create new divs for the unit and cam info
        const newUnitDiv = document.createElement('div');
        newUnitDiv.className = 'unit-info';
        newUnitDiv.id = `unit-${unitId}`; // Set a unique ID for this unit's div

        const newCamDiv = document.createElement('div');
        newCamDiv.className = 'cam-info';
        newCamDiv.id = `cam-${unitId}`; // Set a unique ID for this unit's cam div
        
        // Create the HTML for the new unit section
        newUnitDiv.innerHTML = `
            <div class="row g-3 textBoxWrapper"><br><br>
                <div class="col-sm-3">
                    <label for="unitn" class="form-label">Unit</label>
                    <input type="text" name="unitn[]" value="${unitId}" placeholder="Selected Unit ID" class="form-control" readonly>
                </div>
                <div class="col-sm-3">
                    <label for="square_feet" class="form-label">Total Square</label>
                    <input type="number" step="any" name="square_feet[]" placeholder="Square Feet" class="total-square-feet form-control" onchange="calculateSum()">
                </div>
                <div class="col-sm-3">
                    <label for="rate" class="form-label">Rate/Square</label>
                    <input type="number" step="any" name="rate[]" placeholder="Unit Price" class="unit-price form-control" onchange="calculateSum()">
                </div>
                <div class="col-sm-3">
                    <label for="renttotal" class="form-label">Total</label>
                    <input type="number" step="any" name="renttotal[]" placeholder="Total" class="renttotal form-control" readonly>
                </div>
            </div><br>
        `;

        // Create the HTML for the new CAM section
        newCamDiv.innerHTML = `
            <div class="row g-3 textBoxWrapper"><br><br>
                <div class="col-sm-3">
                    <label for="unitncam" class="form-label">Unit</label>
                    <input type="text" name="unitncam[]" value="${unitId}" placeholder="Selected Unit ID" class="form-control" readonly>
                </div>
                 <div class="col-sm-3">
                    <label for="cam_square_feet" class="form-label">Total Square</label>
                    <input type="number" step="any" name="cam_square_feet[]" placeholder="Square Feet" class="cam-square-feet form-control" onchange="calculateSum()">
                </div>
                <div class="col-sm-3">
                    <label for="cam_rate" class="form-label">Cam Rate</label>
                    <input type="number" step="any" name="cam_rate[]" placeholder="Cam Price" class="cam-price form-control" onchange="calculateSum()">
                </div>
                 <div class="col-sm-3">
                    <label for="camtotal" class="form-label"> Total</label>
                    <input type="number" step="any" name="camtotal[]" placeholder="Total" class="camtotal form-control" readonly>
                </div>
            </div><br>
        `;

        // Append the new divs to their respective parent containers
        unitDetailsDiv.appendChild(newUnitDiv);
        unitDetailsCamDiv.appendChild(newCamDiv);
        // Get the Square Feet input in the rent and CAM sections
        const squareFeetInput = newUnitDiv.querySelector('.total-square-feet');
        const camSquareFeetInput = newCamDiv.querySelector('.cam-square-feet');

        // Copy the value from the rent square feet input to the CAM square feet input
        squareFeetInput.addEventListener('input', function() {
            camSquareFeetInput.value = squareFeetInput.value;
            calculateSum();
             calculateIncreRent();
             calculateIncreCam();
        });

    } else {
        // Remove the corresponding divs when the checkbox is unchecked
        const unitDivToRemove = document.getElementById(`unit-${unitId}`);
        const camDivToRemove = document.getElementById(`cam-${unitId}`);

        // Check if these elements exist before attempting to remove them
        if (unitDivToRemove) {
            unitDetailsDiv.removeChild(unitDivToRemove);
        }
        if (camDivToRemove) {
            unitDetailsCamDiv.removeChild(camDivToRemove);
        }
    }

    calculateSum();
    calculateIncreRent();
    calculateIncreCam();
}

function clearPreviousUnits() {
    const unitDetailsDiv = document.getElementById('unit-rent-details');
    const unitDetailsCamDiv = document.getElementById('cam-details');

    // Clear all previous unit and cam details
    unitDetailsDiv.innerHTML = '';
    unitDetailsCamDiv.innerHTML = '';
}

function calculateSum() {
    const unitRows = document.querySelectorAll('.unit-info');
    const camRows = document.querySelectorAll('.cam-info');

    let totalSquareSum = 0;
    let totalCamSquareSum = 0;
    let totalPriceSum = 0;
    let totalPriceCamSum = 0;

    // Calculate total for each row in unit details
    unitRows.forEach(row => {
        const squareFeetInput = row.querySelector('.total-square-feet');
        const rateInput = row.querySelector('.unit-price');
        const rentTotalInput = row.querySelector('.renttotal');

        const squareFeet = parseFloat(squareFeetInput.value) || 0;
        const rate = parseFloat(rateInput.value) || 0;
        const rowTotal = squareFeet * rate;

        rentTotalInput.value = rowTotal.toFixed(2); // Update rent total for this row

        totalSquareSum += squareFeet;
        totalPriceSum += rowTotal;
    });

    // Calculate total for each row in CAM details
    camRows.forEach(row => {
        const camSquareFeetInput = row.querySelector('.cam-square-feet');
        const camRateInput = row.querySelector('.cam-price');
        const camTotalInput = row.querySelector('.camtotal');

        const camSquareFeet = parseFloat(camSquareFeetInput.value) || 0;
        const camRate = parseFloat(camRateInput.value) || 0;
        const camRowTotal = camSquareFeet * camRate;

        camTotalInput.value = camRowTotal.toFixed(2); // Update cam total for this row

        totalCamSquareSum += camSquareFeet;
        totalPriceCamSum += camRowTotal;
    });

    // Update the overall totals on the page
    document.getElementById('total_square').value = totalSquareSum.toFixed(2);
    document.getElementById('price').value = totalPriceSum.toFixed(2);
    document.getElementById('final_total').value = totalPriceSum.toFixed(2);
    document.getElementById('cam_square_foot').value = totalCamSquareSum.toFixed(2);
    document.getElementById('camp_price').value = totalPriceCamSum.toFixed(2);
    document.getElementById('camp_total').value = totalPriceCamSum.toFixed(2);
    calculateIncreRent();
    calculateIncreCam();
}




$(document).on('input paste change', 'input[name="final_total"],input[name="set_price[]"]', function() {
      calculateIncreRent();
   
});
$(document).on('input paste change', 'input[name="camp_total"],input[name="cam_set_price[]"]', function() {

      calculateIncreCam();
});
function calculateIncreRent() {
    const rows = $(".rent-increment-row");
    const finalTotal = parseFloat($("#final_total").val()) || 0;

    rows.each(function (index, row) {
        const setPercentage = parseFloat($(row).find(".set_price").val()) || 0;
        const previousRent = index > 0 
            ? parseFloat($(rows[index - 1]).find(".inc_rent_amount").val()) || finalTotal
            : finalTotal;

        const rentIncrementAmount = (previousRent * setPercentage) / 100;

       
        //console.log(rentIncrementAmount);
        const newRent = previousRent + rentIncrementAmount;
        $(row).find(".inc_rent_amount").val(newRent.toFixed(2));
    });
}
function calculateIncreCam() {
    const rows = $(".cam-increment-row");
    const finalTotal = parseFloat($("#camp_total").val()) || 0;

    rows.each(function (index, row) {
        const setPercentage = parseFloat($(row).find(".cam_set_price").val()) || 0;
        const previousRent = index > 0 
            ? parseFloat($(rows[index - 1]).find(".inc_cam_amount").val()) || finalTotal
            : finalTotal;

        const camIncrementAmount = (previousRent * setPercentage) / 100;

       
        console.log(camIncrementAmount);
        const newRent = previousRent + camIncrementAmount;
        $(row).find(".inc_cam_amount").val(newRent.toFixed(2));
    });
}


 // Add text box
$(document).ready(function() {
    let totalPercentage = 0;
    let totalFixedAmount = 0;

    // Add Partner Button Click Event
    $("#addPartnerButton").click(function() {
        let textBoxHtml = `
            <div class="row g-3 textBoxWrapper">
                <br><hr class="my-0" /><br>
                <div class="col-sm-3">
                    <label for="partners" class="form-label">Partners</label>
                    <div class="select2-primary">
                        <select class="form-control select2 form-select" required="required" name="partners[]">
                            <?php foreach ($partners as $key => $row): ?>
                                <option value="<?php echo $key ?>"><?php echo $row ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="commission_value" class="form-label">Partner share</label>
                    <input class="form-control commission-input" step="any" placeholder="Partner's share" name="commission_value[]" type="number" min="0">
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="commission_type">Type</label>
                    <select class="form-control select2 form-select commission-type" name="commission_type[]" required>
                        <option value="">Select</option>
                        <option value="1">Fixed Value</option>
                        <option value="2" selected>% of Total Rent</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <p style="margin-top: 20px;">
                        <input class="form-check-input gst-checkbox" type="checkbox" id="is_gst" name="is_gst[]" checked value="1"/>
                        <label class="form-check-label" for="is_gst">GST Invoice</label><br>
                        <input class="form-check-input default_partner-checkbox" type="radio" id="default_partner" name="default_partner[]" value="1"/>
                        <label class="form-check-label" for="default_partner">Default Partner</label>
                    </p>
                </div>
                <div class="col-sm-1">
                    <label for="button" class="form-label">&nbsp;</label>
                    <button type="button" class="removeButton btn btn-sm btn-danger" style="margin:10px; margin-top: 28px;">
                        <i class="ti ti-trash text-white"></i>
                    </button>
                </div>
            </div><br>`;

        $("#paymentContainer").append(textBoxHtml);
    });

    // Function to calculate total percentage or fixed value based on type selection
    function calculateTotals() {
        totalPercentage = 0;
        totalFixedAmount = 0;
        const finalTotal = parseFloat($("#final_total").val()) || 0;
        let validInput = true;
        const type = $(this).find('.commission-type').val();
        $('.textBoxWrapper').each(function() {
            const type = $(this).find('.commission-type').val();
            const inputField = $(this).find('.commission-input');
            let value = parseFloat(inputField.val()) || 0;

            if (type === "2") { // % of Total Rent
                totalPercentage += value;
                if (totalPercentage > 100) {
                    toastr.error("Total partner percentage for '% of Total Rent' cannot exceed 100%. Adjusting the value.");
                 
                    inputField.val(0);
                    totalPercentage -= value;
                    validInput = false;
                }
            } else if (type === "1") { // Fixed Value
                totalFixedAmount += value;
                if (totalFixedAmount > finalTotal) {
                    toastr.error("Total 'Fixed Value' cannot exceed the 'Total Rent'. Adjusting the value.");

                    inputField.val(0);
                    totalFixedAmount -= value;
                    validInput = false;
                }
            }
        });
        // Validation for % of Total Rent
        if (totalPercentage != 100 && type == "2") {
            toastr.error("Total partner percentage must equal exactly 100%. Please adjust the values.");
          
            validInput = false;
        }

        // Validation for Fixed Value (sum should equal final rent)
        if (totalFixedAmount != finalTotal && type == "1") {
            toastr.error("Total fixed value must equal the Final Rent. Please adjust the values.");
           
            validInput = false;
        }

        return validInput;
    }

    // Update totals as values are entered

    $(document).on('keyup click input paste', '.commission-input', function() {
        calculateTotals();
    });

    $(document).on('keyup click input paste', '.commission-type', function() {
        calculateTotals();
    });

    // Remove partner row and recalculate totals
    $(document).on('click', '.removeButton', function() {
        $(this).closest('.textBoxWrapper').remove();
        calculateTotals();
    });
});



  $(document).ready(function(){

        /*--------------Rent--------------------------------*/
        
        $("#addRentCalButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper rent-increment-row"><br><hr class="my-0" /><br>  <div class="col-sm-3"> <label for="from_month" class="form-label">From Month</label> <input class="form-control from_month" id="from_month" placeholder="From Month" name="from_month[]" type="number" step="1" min="1"> </div><div class="col-sm-3"> <label for="to_month" class="form-label">To Month</label> <input class="form-control to_month" id="to_month" placeholder="To Month" name="to_month[]" type="number" step="1" min="1"> </div><div class="col-sm-3"> <label for="set_price" class="form-label">Percentage</label> <input class="form-control set_price" id="set_price" placeholder="Percentage" name="set_price[]" type="number" step="any" > </div> <div class="col-sm-3"> <label for="set_price" class="form-label">Rent Amount</label> <input class="form-control inc_rent_amount" id="inc_rent_amount" placeholder="Rent Amount" name="inc_rent_amount[]" type="number" step="any"  readonly> </div> <div class="col-sm-3"> <label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger"  style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#RentCalContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#RentCalContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });
        $("#lease-rent").on("input", "#from_month, #to_month", function() {
          var value = parseInt($(this).val());
          var expiry_month = $('.end_month').val();
          if (value > expiry_month) {
             toastr.error("Month cannot exceed "+expiry_month+".");
           
              $(this).val(''); // Clear the invalid input
          }
         });

        $("#RentCalContainer").on("change", ".from_month, .to_month", function () {
            const rows = $(".rent-increment-row");
            let isValid = true;

            rows.each(function (index, row) {
                const fromMonth = parseInt($(row).find(".from_month").val());
                const toMonth = parseInt($(row).find(".to_month").val());
                const prevToMonth = index > 0 ? parseInt($(rows[index - 1]).find(".to_month").val()) : 0;
                if (index > 0 && fromMonth !== prevToMonth + 1) {
                    toastr.error(`From Month must be ${prevToMonth + 1}`);
                    $(row).find(".from_month").val(""); // Clear invalid input
                    isValid = false;
                }

                if (toMonth && toMonth < fromMonth) {
                    toastr.error("To Month must be greater than or equal to From Month.");
                    $(row).find(".to_month").val(""); // Clear invalid input
                    isValid = false;
                }

                const maxMonth = $('#end_month').val(); 
                if (toMonth && toMonth > maxMonth) {
                    toastr.error(`To Month cannot exceed ${maxMonth}.`);
                    $(row).find(".to_month").val(""); // Clear invalid input
                    isValid = false;
                }
            });

            return isValid;
        });


        $("#cam").on("input", "#cam_from_month, #cam_to_month", function() {
          var value = parseInt($(this).val());
          var expiry_month = $('.end_month').val();
          if (value > expiry_month) {
               toastr.error("Month cannot exceed "+expiry_month+".");
              $(this).val(''); // Clear the invalid input
          }
         });

        $("#addCamCalButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper cam-increment-row"><br><hr class="my-0" /><br>  <div class="col-sm-3"> <label for="cam_from_month" class="form-label">From Month</label> <input class="form-control cam_from_month" id="cam_from_month" placeholder="From Month" name="cam_from_month[]" type="number" step="1" min="1"> </div><div class="col-sm-3"> <label for="cam_to_month" class="form-label">To Month</label> <input class="form-control cam_to_month" id="cam_to_month" placeholder="To Month" name="cam_to_month[]" type="number" step="1" min="1"> </div><div class="col-sm-3"> <label for="cam_set_price" class="form-label">Percentage</label> <input class="form-control cam_set_price" id="cam_set_price" placeholder="Percentage" name="cam_set_price[]" type="number" step="any" > </div> <div class="col-sm-3"> <label for="inc_cam_amount" class="form-label">Cam Total</label> <input class="form-control inc_cam_amount" id="inc_cam_amount" placeholder="Cam Total" name="inc_cam_amount[]" type="number" step="any" > </div> <div class="col-sm-3"> <label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger"  style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#CamCalContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#CamCalContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });

        $("#CamCalContainer").on("change", ".cam_from_month, .cam_to_month", function () {
            const rows = $(".cam-increment-row");
            let isValid = true;

            rows.each(function (index, row) {
                const fromMonth = parseInt($(row).find(".cam_from_month").val());
                const toMonth = parseInt($(row).find(".cam_to_month").val());
                const prevToMonth = index > 0 ? parseInt($(rows[index - 1]).find(".cam_to_month").val()) : 0;
                if (index > 0 && fromMonth !== prevToMonth + 1) {
                    toastr.error(`From Month must be ${prevToMonth + 1}`);
                    $(row).find(".cam_from_month").val(""); // Clear invalid input
                    isValid = false;
                }

                if (toMonth && toMonth < fromMonth) {
                    toastr.error("To Month must be greater than or equal to From Month.");
                    $(row).find(".cam_to_month").val(""); // Clear invalid input
                    isValid = false;
                }

                const maxMonth = $('#end_month').val(); 
                if (toMonth && toMonth > maxMonth) {
                    toastr.error(`To Month cannot exceed ${maxMonth}.`);
                    $(row).find(".cam_to_month").val(""); // Clear invalid input
                    isValid = false;
                }
            });

            return isValid;
        });



        /*$("#addPartnerButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-3"> <label for="partners" class="form-label">Partners</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="partners[]"><?php foreach ($partners as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="commission_value" class="form-label">\Partner\'s share</label> <input class="form-control" id="commission_value" step="any" placeholder="\Partner\'s share" name="commission_value[]" type="text"> </div> <div class="col-sm-3"> <label class="form-label" for="commission_type">Type</label> <select id="commission_type" name="commission_type[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Fixed Value</option> <option value="2" selected>% of Total Rent</option>  </select> </div><div class="col-sm-2"> <p style="margin-top: 20px;"> <input class="form-check-input gst-checkbox" type="checkbox" id="is_gst"  name="is_gst[]"  checked value="1"/> <label class="form-check-label" for="is_gst">GST Invoice </label><br> <input class="form-check-input default_partner-checkbox" type="radio" id="default_partner"  name="default_partner[]"  value="1"/> <label class="form-check-label" for="default_partner"> Default Partner </label> </p></div>  <div class="col-sm-1"><label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger" style="margin:10px; margin-top: 28px;" ><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#paymentContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#paymentContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });*/


        /*--------------utility--------------------------------*/
        $("#addsecurityDepositButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-4"> <label for="utility" class="form-label">Utility Name</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="utility[]"><?php foreach ($utilities as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-4"> <label for="deposit_amount" class="form-label">Deposit Amount</label> <input class="form-control" id="deposit_amount" placeholder="Deposit Amount" name="deposit_amount[]" type="text"> </div>  <div class="col-sm-4"> <label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger"  style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#securityDepositContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#securityDepositContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });
        

        /*--------------Extra charge--------------------------------*/
        $("#addExtraChargeButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-3"> <label for="partners" class="form-label">Extra Charge Name</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="extra_charge_id[]"><?php foreach ($extraCharges as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="extra_charge_value" class="form-label">Extra Charge Value</label> <input class="form-control" id="extra_charge_value" placeholder="Etxra Charge Value" name="extra_charge_value[]" type="text"> </div> <div class="col-sm-3"> <label class="form-label" for="extra_charge_type">Extra Charge Type</label> <select id="extra_charge_type" name="extra_charge_type[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Fixed Value</option> <option value="2">% of Total Rent</option>  </select> </div> <div class="col-sm-2"> <label class="form-label" for="frequency">Frequency</label> <select id="frequency" name="frequency[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Onetime</option> <option value="2">Monthly</option>  </select> </div> <div class="col-sm-1"><label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger"  style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#extraChargeContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#extraChargeContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });




         /*--------------utility--------------------------------*/
        $("#addUtilityButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-4"> <label for="utility_id" class="form-label">Utility Name</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="utility_id[]"><?php foreach ($utilities as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="variable_cost" class="form-label">Variable cost</label> <input class="form-control" id="variable_cost" placeholder="Variable cost" name="variable_cost[]" type="text"> </div> <div class="col-sm-3"> <label for="fixed_cost" class="form-label">Fixed cost</label> <input class="form-control" id="fixed_cost" placeholder="Fixed cost" name="fixed_cost[]" type="text"> </div> <div class="col-sm-2"> <label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger"  style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#utilityContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#utilityContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });
       
        
    });

     
    </script>
@endsection