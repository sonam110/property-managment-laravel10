@extends('layouts.master')
@section('extracss')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<style type="text/css">
.floor {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 4px;
    border: 1px solid grey;
    padding: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.unit {
    width: 48px;
    position: relative;
    background-color: #f9f9f9;
    border: 1px solid grey;
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
                            {!! Form::select('property_id', ['' => __('Select Property')] + $properties, null, ['class' => 'form-control select property_id select2 form-select', 'id' => 'property_id']) !!}
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
                            {{ Form::label('start_date', __('Start date'), ['class' => 'form-label']) }}
                            {{ Form::date('start_date', null, ['class' => 'form-control', 'placeholder' => __('Start date')]) }}
                            @error('start_date')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('end_month', __('End months'), ['class' => 'form-label']) }}
                            {{ Form::number('end_month', null, ['class' => 'form-control', 'placeholder' => __('End months')]) }}
                            @error('end_month')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('due_on', __('Due on(Day of month)'), ['class' => 'form-label']) }}
                            {{ Form::number('due_on', null, ['class' => 'form-control', 'placeholder' => __('Due on(Day of month)')]) }}
                            @error('due_on')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                            <select name="status" class="form-control select2 form-select">
                                <option  value="Pending" selected>Pending</option>
                                <option  value="Processing" >Processing</option>
                                <option  value="Approved" >Approved</option>
                            </select>
                        </div>


                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-secondary btn-prev" disabled>
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
                      <div class="row g-3">
                        
                        <div class="col-sm-4">
                           {{ Form::label('total_square', __('Total Area of Square Foot'), ['class' => 'form-label']) }}
                            {{ Form::number('total_square', null, ['class' => 'form-control','id'=>'total_square','min'=>'1', 'placeholder' => __('Total Square')]) }}
                            @error('total_square')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        
                        <div class="col-sm-4">
                           {{ Form::label('price', __('Price/Square foot'), ['class' => 'form-label']) }}
                            {{ Form::number('price', null, ['class' => 'form-control','id'=>'price','min'=>'1', 'placeholder' => __('Price/Square')]) }}
                            @error('price')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                       <!--  <div class="col-sm-4">
                           {{ Form::label('fixed_price', __('Fixed Price'), ['class' => 'form-label']) }}
                            {{ Form::number('fixed_price', null, ['class' => 'form-control','id'=>'fixed_price','min'=>'1','step'=>'1', 'placeholder' => __('Fixed Price')]) }}
                            @error('fixed_price')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div> -->
                        <hr class="my-5" />
                        <div class="col-sm-12">
                            <h6> Rent Incremental Term:</h6>
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('from_month', __('From Month'), ['class' => 'form-label']) }}
                            {{ Form::number('from_month[]', null, ['class' => 'form-control','id'=>'from_month','min'=>'1','step'=>'1', 'placeholder' => __('From Month')]) }}
                            @error('from_month')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('to_month', __('To Month'), ['class' => 'form-label']) }}
                            {{ Form::number('to_month[]', null, ['class' => 'form-control','id'=>'to_month','min'=>'1','step'=>'1','placeholder' => __('To Month')]) }}
                            @error('to_month')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                         <div class="col-sm-3">
                           {{ Form::label('set_price', __('Price'), ['class' => 'form-label']) }}
                            {{ Form::number('set_price[]', null, ['class' => 'form-control','id'=>'set_price','step'=>'any', 'placeholder' => __('Price')]) }}
                            @error('set_price')
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
                          <button class="btn btn-label-secondary btn-prev">
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
                       <div class="row g-3">
                          <div class="col-sm-6">
                           {{ Form::label('camp_price', __('Price/Square foot'), ['class' => 'form-label']) }}
                            {{ Form::number('camp_price', null, ['class' => 'form-control','id'=>'camp_price','min'=>'1', 'placeholder' => __('Price/Square')]) }}
                            @error('price')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        
                       <!--  <div class="col-sm-4">
                           {{ Form::label('camp_fixed_price', __('Fixed Price'), ['class' => 'form-label']) }}
                            {{ Form::number('camp_fixed_price', null, ['class' => 'form-control','id'=>'camp_fixed_price','min'=>'1','step'=>'1', 'placeholder' => __('Square Foot')]) }}
                            @error('camp_fixed_price')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div> -->
                         <hr class="my-5" />
                        <div class="col-sm-12">
                            <h6> CAM Incremental Term:</h6>
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('cam_from_month', __('From Month'), ['class' => 'form-label']) }}
                            {{ Form::number('cam_from_month[]', null, ['class' => 'form-control','id'=>'cam_from_month','min'=>'1','step'=>'1', 'placeholder' => __('From Month')]) }}
                            @error('from_month')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('cam_to_month', __('To Month'), ['class' => 'form-label']) }}
                            {{ Form::number('cam_to_month[]', null, ['class' => 'form-control','id'=>'cam_to_month','min'=>'1','step'=>'1','placeholder' => __('To Month')]) }}
                            @error('to_month')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                         <div class="col-sm-3">
                           {{ Form::label('cam_set_price', __('Price'), ['class' => 'form-label']) }}
                            {{ Form::number('cam_set_price[]', null, ['class' => 'form-control','id'=>'cam_set_price','step'=>'any', 'placeholder' => __('Price')]) }}
                            @error('set_price')
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
                          <button class="btn btn-label-secondary btn-prev">
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
                      <div class="row g-3">
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
                            {{ Form::number('commission_value[]', null, ['class' => 'form-control','id'=>'commission_value','step'=>'any', 'placeholder' => __('Partner\'s share')]) }}
                            @error('commission_value')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        
                        <div class="col-sm-3">
                          <label class="form-label" for="commission_type"> Type</label>
                          <select id="commission_type" name="commission_type[]" class="form-control select2 form-select" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="1">Fixed Value</option>
                            <option value="2">% of Total Rent</option>
                          </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label" for="is_gst"> &nbsp;</label>
                            <input class="form-check-input gst-checkbox" type="checkbox" id="is_gst"  name="is_gst[]"  value="1"/>
                            <label class="form-check-label" for="is_gst">Gst Invoice </label>
                            <br>
                            <input class="form-check-input default_partner-checkbox" type="radio" id="default_partner"  name="default_partner[]"  value="1"/ checked>
                            <label class="form-check-label" for="default_partner"> Default Partner </label>
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
                          <button class="btn btn-label-secondary btn-prev">
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
                        
                        <div class="col-sm-12">
                        
                            <div id="securityDepositContainer" class="">
                                <!-- Unit rows will be added here dynamically -->
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addsecurityDepositButton">+ Add More</button>
                            </div>
                        
                        </div>
                        
                        
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-secondary btn-prev">
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
                        <div class="col-sm-3">
                          <label class="form-label" for="frequency">Frequency</label>
                          <select id="frequency" name="frequency[]" class="form-control select2 form-select" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="1">Onetime</option>
                            <option value="2">Period to Period</option>
                            <option value="3">Daily</option>
                            <option value="4">Weekly</option>
                            <option value="5">Monthly</option>
                          </select>
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
                          <button class="btn btn-label-secondary btn-prev">
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
                        
                        <div class="col-sm-12">
                        
                            <div id="utilityContainer" class="">
                                <!-- Unit rows will be added here dynamically -->
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addUtilityButton">+ Add More</button>
                            </div>
                        
                        </div>
                        
                        
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-secondary btn-prev">
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
                                    <span class="d-none d-sm-block">Upload new Documents</span>
                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                    <input
                                      type="file"
                                      id="upload"
                                      name="documents[]"
                                      class="account-file-input"
                                      hidden
                                      multiple/>
                                  </label>
                                  <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                  </button>

                                
                                </div>
                              </div>
                        </div>
                        </div>
    
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-secondary btn-prev">
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

    $(document).ready(function() {
        // Function to handle the "Select All" button click
         $(document).on('click','.select-all',function() { 
            // Get the floor value from the button's data attribute
            var floor = $(this).data('floor');
            //alert(floor);
            // Select all checkboxes in the corresponding floor section
            $('.floor[data-floor="' + floor + '"] input[type="checkbox"]:not(:disabled)').prop('checked', true);
        });
    });


  $(document).on('change','.property_id',function() {
      var property_id = $('.property_id').val(); // Get the selected value from Select2
      //alert(property_id);
      $.ajax({
          url: appurl + "get-units",
          type: "post",
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          data: { property_id: property_id },
          success: function(response) {
              $(".unit_ids").html(response);
          }
      });
    });

 // Add text box
  $(document).ready(function(){
          /*--------------Rent--------------------------------*/
        $("#addRentCalButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br>  <div class="col-sm-3"> <label for="from_month" class="form-label">From Month</label> <input class="form-control" id="from_month" placeholder="From Month" name="from_month[]" type="number" step="1" min="1"> </div><div class="col-sm-3"> <label for="to_month" class="form-label">To Month</label> <input class="form-control" id="to_month" placeholder="From Month" name="to_month[]" type="number" step="1" min="1"> </div><div class="col-sm-3"> <label for="set_price" class="form-label">Price</label> <input class="form-control" id="price" placeholder="From Month" name="set_price[]" type="number" step="any" > </div>  <div class="col-sm-3"> <label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger" ><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#RentCalContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#RentCalContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });

        $("#addCamCalButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br>  <div class="col-sm-3"> <label for="cam_from_month" class="form-label">From Month</label> <input class="form-control" id="cam_from_month" placeholder="From Month" name="cam_from_month[]" type="number" step="1" min="1"> </div><div class="col-sm-3"> <label for="cam_to_month" class="form-label">To Month</label> <input class="form-control" id="cam_to_month" placeholder="From Month" name="cam_to_month[]" type="number" step="1" min="1"> </div><div class="col-sm-3"> <label for="cam_set_price" class="form-label">Price</label> <input class="form-control" id="price" placeholder="From Month" name="cam_set_price[]" type="number" step="any" > </div>  <div class="col-sm-3"> <label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger" ><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#CamCalContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#CamCalContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });



          $("#addPartnerButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-3"> <label for="partners" class="form-label">Partners</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="partners[]"><?php foreach ($partners as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="commission_value" class="form-label">\Partner\'s share</label> <input class="form-control" id="commission_value" step="any" placeholder="\Partner\'s share" name="commission_value[]" type="text"> </div> <div class="col-sm-3"> <label class="form-label" for="commission_type">Type</label> <select id="commission_type" name="commission_type[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Fixed Value</option> <option value="2">% of Total Rent</option>  </select> </div><div class="col-sm-2"> <label class="form-label" for="is_gst"> &nbsp;</label> <input class="form-check-input gst-checkbox" type="checkbox" id="is_gst"  name="is_gst[]"  value="1"/> <label class="form-check-label" for="is_gst">Gst Invoice </label><br> <input class="form-check-input default_partner-checkbox" type="radio" id="default_partner"  name="default_partner[]"  value="1"/> <label class="form-check-label" for="default_partner"> Default Partner </label> </div>  <div class="col-sm-1"><label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger" ><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#paymentContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#paymentContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });

        /*--------------utility--------------------------------*/
        $("#addsecurityDepositButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-4"> <label for="utility" class="form-label">Utility Name</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="utility[]"><?php foreach ($utilities as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-4"> <label for="deposit_amount" class="form-label">Deposit Amount</label> <input class="form-control" id="deposit_amount" placeholder="Deposit Amount" name="deposit_amount[]" type="text"> </div>  <div class="col-sm-4"> <label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger" ><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#securityDepositContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#securityDepositContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });
        

        /*--------------Extra charge--------------------------------*/
        $("#addExtraChargeButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-3"> <label for="partners" class="form-label">Extra Charge Name</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="extra_charge_id[]"><?php foreach ($extraCharges as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="extra_charge_value" class="form-label">Extra Charge Value</label> <input class="form-control" id="extra_charge_value" placeholder="Etxra Charge Value" name="extra_charge_value[]" type="text"> </div> <div class="col-sm-3"> <label class="form-label" for="extra_charge_type">Extra Charge Type</label> <select id="extra_charge_type" name="extra_charge_type[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Fixed Value</option> <option value="2">% of Total Rent</option> <option value="3">% of Total Amount Over Due</option> </select> </div> <div class="col-sm-2"> <label class="form-label" for="frequency">Frequency</label> <select id="frequency" name="frequency[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Onetime</option> <option value="2">Period to Period</option> <option value="3">Daily</option> <option value="4">Weekly</option><option value="5">Monthly</option>  </select> </div> <div class="col-sm-1"><label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger" ><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#extraChargeContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#extraChargeContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });




         /*--------------utility--------------------------------*/
        $("#addUtilityButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-4"> <label for="utility_id" class="form-label">Utility Name</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="utility_id[]"><?php foreach ($utilities as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="variable_cost" class="form-label">Variable cost</label> <input class="form-control" id="variable_cost" placeholder="Variable cost" name="variable_cost[]" type="text"> </div> <div class="col-sm-3"> <label for="fixed_cost" class="form-label">Fixed cost</label> <input class="form-control" id="fixed_cost" placeholder="Fixed cost" name="fixed_cost[]" type="text"> </div> <div class="col-sm-2"> <label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger" ><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#utilityContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#utilityContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });
       
        
    });

     
    </script>
@endsection