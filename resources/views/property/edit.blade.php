@extends('layouts.master')
@section('extracss')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('page-title')
    {{ __('Manage Property') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('property.index')}}">{{__('Property Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Property')}}</li>
@endsection

@section('content')
    <div id="wizard-property-listing" class="bs-stepper vertical mt-2">
                <div class="bs-stepper-header">
                  <div class="step active" data-target="#property-detail">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-users ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Property Detail</span>
                      
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
                  <div class="step" data-target="#extra-charges">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-bookmarks ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Extra Charges</span>
                       
                      </span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#late-fees">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-map-pin ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Late Fees</span>
                      
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
                </div>
                <div class="bs-stepper-content">
                  <form id="wizard-property-listing-form" onSubmit="return false">
                     {!! Form::hidden('id',$property->id,array('class'=>'form-control')) !!}
                    @csrf
                    <!-- Personal Details -->
                    <div id="property-detail" class="content active">
                      <div class="row g-3">
                        <div class="col-sm-6">
                            {{ Form::label('property_name', __('Property Name'), ['class' => 'form-label']) }}
                            {{ Form::text('property_name', $property->property_name, ['class' => 'form-control','id'=>'property_name','placeholder' => __('Property Name')]) }}
                            @error('property_name')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                           {{ Form::label('property_code', __('Property Code'), ['class' => 'form-label']) }}
                            {{ Form::text('property_code', $property->property_code, ['class' => 'form-control','id'=>'property_code', 'placeholder' => __('Property Code')]) }}
                            @error('property_code')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-6">
                           {{ Form::label('property_location', __('Location'), ['class' => 'form-label']) }}
                            {{ Form::text('property_location', $property->property_location, ['class' => 'form-control','id'=>'property_location', 'placeholder' => __('Location')]) }}
                            @error('property_location')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                         <div class="col-md-6">
                            {{ Form::label('property_type', __('Property Type'), ['class' => 'form-label']) }}
                               {!! Form::select('property_type', $propertyTypes, $property->property_type, ['class' => 'form-control select property_type select2 form-select','id'=>'property_type']) !!}
                           
                        </div>
                       
                        
                        <div class="col-sm-12">
                          
                            <label for="units">Units</label>
                            <div id="unitsContainer">
                                @foreach($propertyUnit as $key=>  $unit)
                                <div class="unit-row row" id="unitRow_{{ $key+1 }}">
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="unit_name[]" id="unitInput_{{ $key+1 }}" value="{{ $unit->unit_name }}" readonly>
                                    <input type="hidden" class="form-control" name="unit[]" id="radioInput_{{ $key+1 }}" value="{{ $unit->unit }}" >
                                    <input type="hidden" class="form-control" name="unit_floor[]" id="unitFloorInput_{{ $key+1 }}" value="{{ $unit->unit_floor }}" >
                                    <input type="hidden" class="form-control" name="rent_amount[]" id="rentAmountInput_{{ $key+1 }}" value="{{ $unit->rent_amount }}" >
                                    <input type="hidden" class="form-control" name="unit_type[]" id="unitTypeInput_{{ $key+1 }}" value="{{ $unit->unit_type }}" >
                                    <input type="hidden" class="form-control" name="bed_rooms[]" id="bedRoomInput_{{ $key+1 }}" value="{{ $unit->bed_rooms }}" >
                                    <input type="hidden" class="form-control" name="bath_rooms[]" id="bathRoomInput_{{ $key+1 }}" value="{{ $unit->bath_rooms }}" >
                                    <input type="hidden" class="form-control" name="total_rooms[]" id="totalRoomInput_{{ $key+1 }}" value="{{ $unit->total_rooms }}" >
                                    <input type="hidden" class="form-control" name="square_foot[]" id="squareRoomInput_{{ $key+1 }}" value="{{ $unit->square_foot }}" >
                                </div>
                                <div class="unit-actions col-md-3">
                                    <button class="btn btn-secondary btn-sm copy-btn" data-id="unitInput_${unitCount}"><i class="ti ti-copy text-white"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="unitRow_${unitCount}"><i class="ti ti-trash text-white"></i></button>
                                </div>
                            </div><br>
                                @endforeach
                            </div>
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addUnitButton">+ Add Unit</button>
                            </div>
                       
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

                    <!-- Property Details -->
                    <div id="payment-setting" class="content">
                      <div class="row g-3">

                        <div class="col-sm-12">
    
                            <div id="paymentContainer" class="">
                                @foreach($paymentSetting as $key=>  $payment)
                                    <div class="row g-3 textBoxWrapper"><br>
                                        <div class="col-sm-3">
                                            {{ Form::label('partners[]', __('Partners'), ['class' => 'form-label']) }}
                                            <div class="select2-primary">
                                                {!! Form::select('partners[]', $partners,$payment->user_id, [
                                                    'class' => 'form-control select2 form-select',
                                                    'id' => 'select2Primary',
                                                    'required' => 'required'
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                           {{ Form::label('commission_value', __('Comsission Value'), ['class' => 'form-label']) }}
                                            {{ Form::text('commission_value[]', $payment->commission_value, ['class' => 'form-control','id'=>'commission_value', 'placeholder' => __('Comsission Value')]) }}
                                            @error('commission_value')
                                                <small class="invalid-name" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </small>
                                              @enderror
                                        </div>
                                        
                                        <div class="col-sm-2">
                                          <label class="form-label" for="commission_type"> Type</label>
                                          <select id="commission_type" name="commission_type[]" class="form-control select2 form-select" data-allow-clear="true">
                                            <option value="">Select</option>
                                            <option value="1" @if(@$payment->commission_type == '1' ) selected @endif>Fixed Value</option>
                                            <option value="2" @if(@$payment->commission_type == '2' ) selected @endif>% of Total Rent</option>
                                            <option value="3" @if(@$payment->commission_type == '3' ) selected @endif>% of Total collected Rent</option>
                                          </select>
                                        </div>
                                        <div class="col-sm-3">
                                          <label class="form-label" for="payment_methods">Payment Method</label>
                                          <select id="payment_methods" name="payment_methods[]" class="form-control select2 form-select" data-allow-clear="true">
                                            <option value="">Select</option>
                                            <option value="1"  @if(@$payment->payment_methods == '1' ) selected @endif>Cash</option>
                                            <option value="2"  @if(@$payment->payment_methods == '2' ) selected @endif>Online</option>
                                            <option value="3"  @if(@$payment->payment_methods == '3' ) selected @endif>Cheque</option>
                                            <option value="4"  @if(@$payment->payment_methods == '4' ) selected @endif>DD</option>
                                          </select>
                                        </div>
                                        <div class="col-sm-1"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px"><i class="ti ti-trash text-white"></i></button>  </div>
                                         <hr class="my-20" />
                                    </div>
                                    @endforeach
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

                    <!-- Property Features -->
                    <div id="extra-charges" class="content">
                       <div class="row g-3">
                       

                        <div class="col-sm-12">
                        
                            <div id="extraChargeContainer" class="">
                                <div class="row g-3 textBoxWrapper">
                                    @foreach($propertyExtraCharges as $key=>  $charge)

                                         <div class="col-sm-3">
                                            {{ Form::label('extra_charge_id[]', __('Extra Charge Name'), ['class' => 'form-label']) }}
                                            <div class="select2-primary">
                                                {!! Form::select('extra_charge_id[]', $extraCharges, $charge->extra_charge_id, [
                                                    'class' => 'form-control select2 form-select',
                                                    'id' => 'select2Primary',
                                                    'required' => 'required'
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                           {{ Form::label('extra_charge_value', __('Extra Charge Value'), ['class' => 'form-label']) }}
                                            {{ Form::text('extra_charge_value[]',$charge->extra_charge_value, ['class' => 'form-control','id'=>'extra_charge_value', 'placeholder' => __('Extra Charge Value')]) }}
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
                                            <option value="1" @if(@$charge->extra_charge_type == '1' ) selected @endif>Fixed Value</option>
                                            <option value="2" @if(@$charge->extra_charge_type == '2' ) selected @endif>% of Total Rent</option>
                                            <option value="3" @if(@$charge->extra_charge_type == '3' ) selected @endif>% of Total Amount Over Due</option>
                                          </select>
                                        </div>
                                        <div class="col-sm-2">
                                          <label class="form-label" for="frequency">Frequency</label>
                                          <select id="frequency" name="frequency[]" class="form-control select2 form-select" data-allow-clear="true">
                                            <option value="">Select</option>
                                            <option value="1" @if(@$charge->frequency == '1' ) selected @endif>Onetime</option>
                                            <option value="2" @if(@$charge->frequency == '2' ) selected @endif>Period to Period</option>
                                            <option value="3" @if(@$charge->frequency == '3' ) selected @endif>Daily</option>
                                            <option value="4" @if(@$charge->frequency == '4' ) selected @endif>Weekly</option>
                                            <option value="5" @if(@$charge->frequency == '5' ) selected @endif>Monthly</option>
                                          </select>
                                        </div>

                                        <div class="col-sm-1"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px"><i class="ti ti-trash text-white"></i></button>  </div>
                                        <hr class="my-20" />
                                    @endforeach
                                </div>
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

                    <!-- Property Area -->
                    <div id="late-fees" class="content">
                      <div class="row g-3">
                        
                        <div class="col-sm-12">
                        
                            <div id="lateFeeContainer" class="">
                                <div class="row g-3 textBoxWrapper">
                                @foreach($propertyLateFees as $key=>  $fees)

                                    <div class="col-sm-3">
                                        {{ Form::label('late_fee_id[]', __('Late Fee Name'), ['class' => 'form-label']) }}
                                        <div class="select2-primary">
                                            {!! Form::select('late_fee_id[]', $lateFees, $fees->late_fee_id, [
                                                'class' => 'form-control select2 form-select',
                                                'id' => 'select2Primary',
                                                'required' => 'required'
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                       {{ Form::label('late_fee_value', __('Late Fee Value'), ['class' => 'form-label']) }}
                                        {{ Form::text('late_fee_value[]', $fees->late_fee_value, ['class' => 'form-control','id'=>'late_fee_value', 'placeholder' => __('Late Fee Value')]) }}
                                        @error('late_fee_value')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                          @enderror
                                    </div>
                                    
                                     <div class="col-sm-3">
                                          <label class="form-label" for="late_fee_type">Late Fee Type</label>
                                          <select id="late_fee_type" name="late_fee_type[]" class="form-control select2 form-select" data-allow-clear="true">
                                            <option value="">Select</option>
                                            <option value="1" @if(@$fees->late_fee_type == '1' ) selected @endif>Fixed Value</option>
                                            <option value="2" @if(@$fees->late_fee_type == '2' ) selected @endif>% of Total Rent</option>
                                            <option value="3" @if(@$fees->late_fee_type == '3' ) selected @endif>% of Total Amount Over Due</option>
                                          </select>
                                        </div>
                                        <div class="col-sm-2">
                                          <label class="form-label" for="frequency">Frequency</label>
                                          <select id="frequency" name="frequency[]" class="form-control select2 form-select" data-allow-clear="true">
                                            <option value="">Select</option>
                                            <option value="1" @if(@$fees->frequency == '1' ) selected @endif>Onetime</option>
                                            <option value="2" @if(@$fees->frequency == '2' ) selected @endif>Period to Period</option>
                                            <option value="3" @if(@$fees->frequency == '3' ) selected @endif>Daily</option>
                                            <option value="4" @if(@$fees->frequency == '4' ) selected @endif>Weekly</option>
                                            <option value="5" @if(@$fees->frequency == '5' ) selected @endif>Monthly</option>
                                          </select>
                                        </div>
                                     <div class="col-sm-1"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px"><i class="ti ti-trash text-white"></i></button>  </div>
                                        <hr class="my-20" />

                                    @endforeach
                                </div>
                             </div>
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addLateFeeButton">+ Add Late Fee</button>
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

                    <!-- Price Details -->
                    <div id="utilities" class="content">
                 
                      <div class="row g-3">
                    
                        <div class="col-sm-12">
                        
                            <div id="utilityContainer" class="">
                                @foreach($propertyUtility as $key=>  $utility)
                                    <div class="row g-3 textBoxWrapper">
                                        <div class="col-sm-3">
                                            {{ Form::label('utility_id[]', __('Utility Name'), ['class' => 'form-label']) }}
                                            <div class="select2-primary">
                                                {!! Form::select('utility_id[]', $utilities, $utility->utility_id, [
                                                    'class' => 'form-control select2 form-select',
                                                    'id' => 'select2Primary',
                                                    'required' => 'required'
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                           {{ Form::label('variable_cost', __('Variable Cost'), ['class' => 'form-label']) }}
                                            {{ Form::text('variable_cost[]', $utility->variable_cost, ['class' => 'form-control','id'=>'variable_cost', 'placeholder' => __('Variable Cost')]) }}
                                            @error('variable_cost')
                                                <small class="invalid-name" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </small>
                                              @enderror
                                        </div>
                                        <div class="col-sm-3">
                                           {{ Form::label('fixed_cost', __('Fixed Cost'), ['class' => 'form-label']) }}
                                            {{ Form::text('fixed_cost[]', $utility->fixed_cost, ['class' => 'form-control','id'=>'fixed_cost', 'placeholder' => __('Fixed Cost')]) }}
                                            @error('fixed_cost')
                                                <small class="invalid-name" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </small>
                                              @enderror
                                        </div>
                                        <div class="col-sm-3"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px"><i class="ti ti-trash text-white"></i></button>  </div>
                        
                                    </div>
                                @endforeach
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addUtilityButton">+ Add Utility</button>
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
 <!-- Modal -->
      <div class="modal fade unitModal" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="unitModalLabel">Enter Unit Name</h5>
                        <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="unitForm">
                             <div class="row">
                                <div class="col-12">
                                  <div class="row pb-2">
                                    <div class="col-md mb-md-0 mb-2">
                                      <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioBuilder">
                                          <span class="custom-option-body">
                                           <svg
                                            width="100"
                                            height="100"
                                            viewBox="0 0 64 64"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none">
                                            <!-- Roof -->
                                            <polygon
                                                points="32,8 8,32 56,32"
                                                fill="#ff6f61" />
                                            <!-- Body -->
                                            <rect
                                                x="16"
                                                y="32"
                                                width="32"
                                                height="24"
                                                fill="#4a90e2" />
                                            <!-- Door -->
                                            <rect
                                                x="28"
                                                y="40"
                                                width="8"
                                                height="16"
                                                fill="#fff" />
                                        </svg>


                                            <span class="custom-option-title">Residential</span>
                                           
                                          </span>
                                          <input
                                            name="unit"
                                            class="form-check-input residential unit"
                                            type="radio"
                                            value="1"
                                            id="customRadioBuilder"
                                             />
                                        </label>
                                      </div>
                                    </div>
                                    <div class="col-md mb-md-0 mb-2">
                                      <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioOwner">
                                          <span class="custom-option-body">
                                            <svg
                                              width="41"
                                              height="40"
                                              viewBox="0 0 41 40"
                                              fill="none"
                                              xmlns="http://www.w3.org/2000/svg">
                                              <path
                                                d="M22.75 33.75V6.25C22.75 5.91848 22.6183 5.60054 22.3839 5.36612C22.1495 5.1317 21.8315 5 21.5 5H6.5C6.16848 5 5.85054 5.1317 5.61612 5.36612C5.3817 5.60054 5.25 5.91848 5.25 6.25V33.75"
                                                fill="currentColor"
                                                fill-opacity="0.2" />
                                              <path
                                                d="M2.75 32.75C2.19772 32.75 1.75 33.1977 1.75 33.75C1.75 34.3023 2.19772 34.75 2.75 34.75V32.75ZM37.75 34.75C38.3023 34.75 38.75 34.3023 38.75 33.75C38.75 33.1977 38.3023 32.75 37.75 32.75V34.75ZM21.75 33.75C21.75 34.3023 22.1977 34.75 22.75 34.75C23.3023 34.75 23.75 34.3023 23.75 33.75H21.75ZM21.5 5V4V5ZM5.25 6.25H4.25H5.25ZM4.25 33.75C4.25 34.3023 4.69772 34.75 5.25 34.75C5.80228 34.75 6.25 34.3023 6.25 33.75H4.25ZM34.25 33.75C34.25 34.3023 34.6977 34.75 35.25 34.75C35.8023 34.75 36.25 34.3023 36.25 33.75H34.25ZM22.75 14C22.1977 14 21.75 14.4477 21.75 15C21.75 15.5523 22.1977 16 22.75 16V14ZM10.25 10.25C9.69772 10.25 9.25 10.6977 9.25 11.25C9.25 11.8023 9.69772 12.25 10.25 12.25V10.25ZM15.25 12.25C15.8023 12.25 16.25 11.8023 16.25 11.25C16.25 10.6977 15.8023 10.25 15.25 10.25V12.25ZM12.75 20.25C12.1977 20.25 11.75 20.6977 11.75 21.25C11.75 21.8023 12.1977 22.25 12.75 22.25V20.25ZM17.75 22.25C18.3023 22.25 18.75 21.8023 18.75 21.25C18.75 20.6977 18.3023 20.25 17.75 20.25V22.25ZM10.25 26.5C9.69772 26.5 9.25 26.9477 9.25 27.5C9.25 28.0523 9.69772 28.5 10.25 28.5V26.5ZM15.25 28.5C15.8023 28.5 16.25 28.0523 16.25 27.5C16.25 26.9477 15.8023 26.5 15.25 26.5V28.5ZM27.75 26.5C27.1977 26.5 26.75 26.9477 26.75 27.5C26.75 28.0523 27.1977 28.5 27.75 28.5V26.5ZM30.25 28.5C30.8023 28.5 31.25 28.0523 31.25 27.5C31.25 26.9477 30.8023 26.5 30.25 26.5V28.5ZM27.75 20.25C27.1977 20.25 26.75 20.6977 26.75 21.25C26.75 21.8023 27.1977 22.25 27.75 22.25V20.25ZM30.25 22.25C30.8023 22.25 31.25 21.8023 31.25 21.25C31.25 20.6977 30.8023 20.25 30.25 20.25V22.25ZM2.75 34.75H37.75V32.75H2.75V34.75ZM23.75 33.75V6.25H21.75V33.75H23.75ZM23.75 6.25C23.75 5.65326 23.5129 5.08097 23.091 4.65901L21.6768 6.07322C21.7237 6.12011 21.75 6.18369 21.75 6.25H23.75ZM23.091 4.65901C22.669 4.23705 22.0967 4 21.5 4V6C21.5663 6 21.6299 6.02634 21.6768 6.07322L23.091 4.65901ZM21.5 4H6.5V6H21.5V4ZM6.5 4C5.90326 4 5.33097 4.23705 4.90901 4.65901L6.32322 6.07322C6.37011 6.02634 6.4337 6 6.5 6V4ZM4.90901 4.65901C4.48705 5.08097 4.25 5.65326 4.25 6.25H6.25C6.25 6.1837 6.27634 6.12011 6.32322 6.07322L4.90901 4.65901ZM4.25 6.25V33.75H6.25V6.25H4.25ZM36.25 33.75V16.25H34.25V33.75H36.25ZM36.25 16.25C36.25 15.6533 36.013 15.081 35.591 14.659L34.1768 16.0732C34.2237 16.1201 34.25 16.1837 34.25 16.25H36.25ZM35.591 14.659C35.169 14.2371 34.5967 14 34 14V16C34.0663 16 34.1299 16.0263 34.1768 16.0732L35.591 14.659ZM34 14H22.75V16H34V14ZM10.25 12.25H15.25V10.25H10.25V12.25ZM12.75 22.25H17.75V20.25H12.75V22.25ZM10.25 28.5H15.25V26.5H10.25V28.5ZM27.75 28.5H30.25V26.5H27.75V28.5ZM27.75 22.25H30.25V20.25H27.75V22.25Z"
                                                fill="currentColor" />
                                            </svg>
                                            
                                            <span class="custom-option-title"> Commercial </span>
                                           
                                          </span>
                                          <input
                                            name="unit"
                                            class="form-check-input commercial unit"
                                            type="radio"
                                            value="2"
                                            id="customRadioOwner" />
                                        </label>
                                      </div>
                                    </div>
                                   
                                  </div>
                                </div>
                            <div class="col-sm-12 mb-3">
                                {{ Form::label('unitName', __('Unit Name'), ['class' => 'form-label']) }}
                                {{ Form::text('unitName', null, ['class' => 'form-control unitName', 'id'=>'unitName','placeholder' => __('Unit Name'), 'required' => 'required']) }}
                                @error('unit_name')
                                    <small class="invalid-name" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-12 mb-3">
                                {{ Form::label('unit_floor', __('Unit Floor'), ['class' => 'form-label']) }}
                                {{ Form::number('unit_floor', null, ['class' => 'form-control unit_floor', 'id'=>'unit_floor','min'=>'1','step'=>'1','placeholder' => __('Unit Floor')]) }}
                           
                            </div>
                            <div class="col-sm-12 mb-3">
                                {{ Form::label('rent_amount', __('Rent Amount'), ['class' => 'form-label']) }}
                                {{ Form::number('rent_amount', null, ['class' => 'form-control rent_amount', 'id'=>'rent_amount','placeholder' => __('Rent Amount')]) }}
                           
                            </div>
                            <div class="col-sm-12 mb-3">
                                {{ Form::label('unit_type', __('Unit Type'), ['class' => 'form-label']) }}
                                   {!! Form::select('unit_type', $unitTypes, null, ['class' => 'form-control select unit_type select2 form-select unit_type','id'=>'unit_type', 'required' => 'required']) !!}
                           
                            </div>
                            <div class="col-sm-6 onlyforcommercial" id="onlyforcommercial">
                                <div class="mb-3">
                                    {{ Form::label('bed_rooms', __('Bed Rooms'), ['class' => 'form-label']) }}
                                    {{ Form::number('bed_rooms', null, ['class' => 'form-control bed_rooms', 'id'=>'bed_rooms','placeholder' => __('Bed Rooms')]) }}
                                </div>
                           
                            </div>
                            <div class="col-sm-6 onlyforcommercial" id="onlyforcommercial">
                                <div class="mb-3">
                                    {{ Form::label('bath_rooms', __('Bath Rooms'), ['class' => 'form-label']) }}
                                    {{ Form::number('bath_rooms', null, ['class' => 'form-control', 'id'=>'bath_rooms','placeholder' => __('Bath Rooms')]) }}
                                </div>
                           
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    {{ Form::label('total_rooms', __('Total Rooms'), ['class' => 'form-label']) }}
                                    {{ Form::number('total_rooms', null, ['class' => 'form-control total_rooms', 'id'=>'total_rooms','placeholder' => __('Total Rooms')]) }}
                                </div>
                           
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    {{ Form::label('square_foot', __('Square Foot'), ['class' => 'form-label']) }}
                                    {{ Form::number('square_foot', null, ['class' => 'form-control square_foot', 'id'=>'square_foot','placeholder' => __('Square Foot')]) }}
                                </div>
                           
                            </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="continueButton">Continue</button>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('extrajs')  
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/wizard-ex-property-listing.js') }}"></script>
    <script>
   $(document).ready(function() {
    let unitCount = parseInt($('#unitsContainer .unit-row').length) || 0;
    let currentInputId = '';
    let isCopyAction = false;

    function openUnitModal(inputId = '') {
        currentInputId = inputId;
        console.log(inputId);
        $('#unitModal').modal('show');

        if ($('.residential').is(':checked')) {
            $('.onlyforcommercial').show();
        } else {
            $('.onlyforcommercial').hide();
        }
        // Pre-fill the modal with existing data if updating
        if (inputId) {
            const newInput = inputId.split('_')[1];
            const unitName = $(`#${inputId}`).val();
            const radioInput = $(`#radioInput_${newInput}`).val();
            const unitFloorInput = $(`#unitFloorInput_${newInput}`).val();
            const rentAmountInput = $(`#rentAmountInput_${newInput}`).val();
            const unitTypeInput = $(`#unitTypeInput_${newInput}`).val();
            const bedRoomInput = $(`#bedRoomInput_${newInput}`).val();
            const bathRoomInput = $(`#bathRoomInput_${newInput}`).val();
            const totalRoomInput = $(`#totalRoomInput_${newInput}`).val();
            const squareRoomInput = $(`#squareRoomInput_${newInput}`).val();

            $('#unitName').val(unitName);
            $(`.unit[value="${radioInput}"]`).prop('checked', true); // Select the correct radio button
            $('#unit_floor').val(unitFloorInput);
            $('#rent_amount').val(rentAmountInput);
            $('#unit_type').val(unitTypeInput).trigger('change'); // Update unit type dropdown
            $('#bed_rooms').val(bedRoomInput);
            $('#bath_rooms').val(bathRoomInput);
            $('#total_rooms').val(totalRoomInput);
            $('#square_foot').val(squareRoomInput);
        } else {
            // Clear the modal fields for adding new unit
            $('#unitName').val('');
            $('.unit').prop('checked', false); // Deselect all radio buttons
            $('#unit_floor').val('');
            $('#rent_amount').val('');
            $('#unit_type').val('').trigger('change'); // Clear unit type dropdown
            $('#bed_rooms').val('');
            $('#bath_rooms').val('');
            $('#total_rooms').val('');
            $('#square_foot').val('');
        }
    }

    $('#continueButton').on('click', function() {
        const unitName = $('#unitName').val();
        const unit = $('.unit:checked').val();
        console.log(unit);
        const unit_floor = $('#unit_floor').val();
        const rent_amount = $('#rent_amount').val();
        const unit_type = $('#unit_type').val();
        const bed_rooms = $('#bed_rooms').val();
        const bath_rooms = $('#bath_rooms').val();
        const total_rooms = $('#total_rooms').val();
        const square_foot = $('#square_foot').val();

        if (currentInputId) {
            // For updating existing unit
            const newInput = currentInputId.split('_')[1];
            $(`#${currentInputId}`).val(unitName);
            $(`#radioInput_${newInput}`).val(unit);
            $(`#unitFloorInput_${newInput}`).val(unit_floor);
            $(`#rentAmountInput_${newInput}`).val(rent_amount);
            $(`#unitTypeInput_${newInput}`).val(unit_type);
            $(`#bedRoomInput_${newInput}`).val(bed_rooms);
            $(`#bathRoomInput_${newInput}`).val(bath_rooms);
            $(`#totalRoomInput_${newInput}`).val(total_rooms);
            $(`#squareRoomInput_${newInput}`).val(square_foot);
        } else {
            // For adding new unit
            addUnitRow(unitName, unit, unit_floor, rent_amount, unit_type, bed_rooms, bath_rooms, total_rooms, square_foot);
        }
        $('#unitModal').modal('hide');
        currentInputId = '';
    });

    function addUnitRow(unitName = '', unit = '', unit_floor = '', rent_amount = '', unit_type = '', bed_rooms = '', bath_rooms = '', total_rooms = '', square_foot = '') {
        unitCount++;
        const unitRow = `
            <div class="unit-row row" id="unitRow_${unitCount}">
                <div class="col-md-9">
                    <input type="text" class="form-control" name="unit_name[]" id="unitInput_${unitCount}" value="${unitName}" readonly>
                    <input type="hidden" class="form-control" name="unit[]" id="radioInput_${unitCount}" value="${unit}" >
                    <input type="hidden" class="form-control" name="unit_floor[]" id="unitFloorInput_${unitCount}" value="${unit_floor}" >
                    <input type="hidden" class="form-control" name="rent_amount[]" id="rentAmountInput_${unitCount}" value="${rent_amount}" >
                    <input type="hidden" class="form-control" name="unit_type[]" id="unitTypeInput_${unitCount}" value="${unit_type}" >
                    <input type="hidden" class="form-control" name="bed_rooms[]" id="bedRoomInput_${unitCount}" value="${bed_rooms}" >
                    <input type="hidden" class="form-control" name="bath_rooms[]" id="bathRoomInput_${unitCount}" value="${bath_rooms}" >
                    <input type="hidden" class="form-control" name="total_rooms[]" id="totalRoomInput_${unitCount}" value="${total_rooms}" >
                    <input type="hidden" class="form-control" name="square_foot[]" id="squareRoomInput_${unitCount}" value="${square_foot}" >
                </div>
                <div class="unit-actions col-md-3">
                    <button class="btn btn-secondary btn-sm copy-btn" data-id="unitInput_${unitCount}"><i class="ti ti-copy text-white"></i></button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="unitRow_${unitCount}"><i class="ti ti-trash text-white"></i></button>
                </div>
            </div><br>
        `;
        $('#unitsContainer').append(unitRow);
    }

    $('#addUnitButton').on('click', function() {
        openUnitModal();
    });

    $('#unitsContainer').on('click', 'input', function() {
        const inputId = $(this).attr('id');
        openUnitModal(inputId);
    });

    $('#unitsContainer').on('click', '.copy-btn', function() {
        const inputId = $(this).data('id');
        const newInputId = inputId.split('_')[1];
        const unitName = $(`#unitInput_${newInputId}`).val();
        const unit = $(`#radioInput_${newInputId}`).val();
        const unit_floor = $(`#unitFloorInput_${newInputId}`).val();
        const rent_amount = $(`#rentAmountInput_${newInputId}`).val();
        const unit_type = $(`#unitTypeInput_${newInputId}`).val();
        const bed_rooms = $(`#bedRoomInput_${newInputId}`).val();
        const bath_rooms = $(`#bathRoomInput_${newInputId}`).val();
        const total_rooms = $(`#totalRoomInput_${newInputId}`).val();
        const square_foot = $(`#squareRoomInput_${newInputId}`).val();

        addUnitRow(unitName, unit, unit_floor, rent_amount, unit_type, bed_rooms, bath_rooms, total_rooms, square_foot);
        isCopyAction = true;
    });

    $('#unitsContainer').on('click', '.delete-btn', function() {
        const rowId = $(this).data('id');
        $(`#${rowId}`).remove(); // Remove the unit row
    });

    $('input[name="unit"]').on('change', function() {
        if ($('.residential').is(':checked')) {
            $('.onlyforcommercial').show();
        } else {
            $('.onlyforcommercial').hide();
        }
    });


});

 // Add text box
  $(document).ready(function(){
    /*----------------------Partner Payment-------------------*/
        $("#addPartnerButton").click(function(){
            var textBoxHtml = '<br><div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-3"> <label for="partners" class="form-label">Partners</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="partners[]"><?php foreach ($partners as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="commission_value" class="form-label">Comsission Value</label> <input class="form-control" id="commission_value" placeholder="Comsission Value" name="commission_value[]" type="text"> </div> <div class="col-sm-2"> <label class="form-label" for="commission_type">Type</label> <select id="commission_type" name="commission_type[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Fixed Value</option> <option value="2">% of Total Rent</option> <option value="3">% of Total collected Rent</option> </select> </div> <div class="col-sm-3"> <label class="form-label" for="payment_methods">Payment Method</label> <select id="payment_methods" name="payment_methods[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Cash</option> <option value="2">Online</option> <option value="3">Cheque</option> <option value="4">DD</option> </select> </div> <div class="col-sm-1"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#paymentContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#paymentContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });

        /*--------------Extra charge--------------------------------*/
        $("#addExtraChargeButton").click(function(){
            var textBoxHtml = '<br><div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-3"> <label for="partners" class="form-label">Extra Charge Name</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="extra_charge_id[]"><?php foreach ($extraCharges as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="extra_charge_value" class="form-label">Extra Charge Value</label> <input class="form-control" id="extra_charge_value" placeholder="Etxra Charge Value" name="extra_charge_value[]" type="text"> </div> <div class="col-sm-3"> <label class="form-label" for="extra_charge_type">Extra Charge Type</label> <select id="extra_charge_type" name="extra_charge_type[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Fixed Value</option> <option value="2">% of Total Rent</option> <option value="3">% of Total Amount Over Due</option> </select> </div> <div class="col-sm-2"> <label class="form-label" for="frequency">Frequency</label> <select id="frequency" name="frequency[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Onetime</option> <option value="2">Period to Period</option> <option value="3">Daily</option> <option value="4">Weekly</option><option value="5">Monthly</option>  </select> </div> <div class="col-sm-1"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#extraChargeContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#extraChargeContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });


        /*--------------Late Fee--------------------------------*/
        $("#addLateFeeButton").click(function(){
            var textBoxHtml = '<br><div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-3"> <label for="late_fee_id" class="form-label">Late Fee Name</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="late_fee_id[]"><?php foreach ($lateFees as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="late_fee_value" class="form-label">Late Fee Value</label> <input class="form-control" id="late_fee_value" placeholder="Late Fee Value" name="late_fee_value[]" type="text"> </div> <div class="col-sm-3"> <label class="form-label" for="late_fee_type">Late Fee Type</label> <select id="late_fee_type" name="late_fee_type[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Fixed Value</option> <option value="2">% of Total Rent</option> <option value="3">% of Total Amount Over Due</option> </select> </div> <div class="col-sm-2"> <label class="form-label" for="frequency">Frequency</label> <select id="frequency" name="frequency[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Onetime</option> <option value="2">Period to Period</option> <option value="3">Daily</option> <option value="4">Weekly</option><option value="5">Monthly</option>  </select> </div> <div class="col-sm-1"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#lateFeeContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#lateFeeContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });


         /*--------------utility--------------------------------*/
        $("#addUtilityButton").click(function(){
            var textBoxHtml = '<br><div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-4"> <label for="utility_id" class="form-label">Utility Name</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="utility_id[]"><?php foreach ($utilities as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="variable_cost" class="form-label">Variable cost</label> <input class="form-control" id="variable_cost" placeholder="Variable cost" name="variable_cost[]" type="text"> </div> <div class="col-sm-3"> <label for="fixed_cost" class="form-label">Fixed cost</label> <input class="form-control" id="fixed_cost" placeholder="Fixed cost" name="fixed_cost[]" type="text"> </div> <div class="col-sm-2"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:25px"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#utilityContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#utilityContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });
       
        
    });

     
    </script>
@endsection