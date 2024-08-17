@extends('layouts.master')
@section('extracss')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

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
                    <!-- Personal Details -->
                    <div id="property-detail" class="content active">
                      <div class="row g-3">
                        <div class="col-sm-12">
                            {{ Form::label('property_name', __('Property Name'), ['class' => 'form-label']) }}
                            {{ Form::text('property_name', null, ['class' => 'form-control', 'placeholder' => __('Property Name')]) }}
                            @error('property_name')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                           {{ Form::label('property_code', __('Property Code'), ['class' => 'form-label']) }}
                            {{ Form::text('property_code', null, ['class' => 'form-control', 'placeholder' => __('Property Code')]) }}
                            @error('property_code')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-6">
                           {{ Form::label('property_location', __('Location'), ['class' => 'form-label']) }}
                            {{ Form::text('property_location', null, ['class' => 'form-control', 'placeholder' => __('Location')]) }}
                            @error('property_location')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                         <div class="col-md-6">
                            {{ Form::label('property_type', __('Property Type'), ['class' => 'form-label']) }}
                               {!! Form::select('property_type', $propertyTypes, null, ['class' => 'form-control select property_type select2 form-select', 'required' => 'required']) !!}
                           
                        </div>
                        <!-- <div class="col-sm-6 input-group input-group-merge">
                            {{ Form::label('partners[]', __('Partners'), ['class' => 'form-label']) }}
                            <div class="select2-primary">
                                {!! Form::select('partners[]', $partners, null, [
                                    'class' => 'form-control select2 form-select',
                                    'id' => 'select2Primary',
                                    'multiple' => 'multiple', 
                                    'required' => 'required'
                                ]) !!}
                            </div>
                        </div> -->
                        
                        <div class="col-sm-12">
                          
                            <label for="units">Units</label>
                            <div id="unitsContainer">
                                <!-- Unit rows will be added here dynamically -->
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
                        <div class="col-sm-6">
                          <label class="form-label" for="plZipCode">Zip Code</label>
                          <input
                            type="number"
                            id="plZipCode"
                            name="plZipCode"
                            class="form-control"
                            placeholder="99950" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="plCountry">Country</label>
                          <select id="plCountry" name="plCountry" class="select2 form-select" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="Australia">Australia</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Brazil">Brazil</option>
                            <option value="Canada">Canada</option>
                            <option value="China">China</option>
                            <option value="France">France</option>
                            <option value="Germany">Germany</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Japan">Japan</option>
                            <option value="Korea">Korea, Republic of</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Russia">Russian Federation</option>
                            <option value="South Africa">South Africa</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                          </select>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="plState">State</label>
                          <input
                            type="text"
                            id="plState"
                            name="plState"
                            class="form-control"
                            placeholder="California" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="plCity">City</label>
                          <input type="text" id="plCity" name="plCity" class="form-control" placeholder="Los Angeles" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="plLandmark">Landmark</label>
                          <input
                            type="text"
                            id="plLandmark"
                            name="plLandmark"
                            class="form-control"
                            placeholder="Nr. Hard Rock Cafe" />
                        </div>
                        <div class="col-lg-12">
                          <label class="form-label" for="plAddress">Address</label>
                          <textarea
                            id="plAddress"
                            name="plAddress"
                            class="form-control"
                            rows="2"
                            placeholder="12, Business Park"></textarea>
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
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plBedrooms">Bedrooms</label>
                          <input type="number" id="plBedrooms" name="plBedrooms" class="form-control" placeholder="3" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="plFloorNo">Floor No</label>
                          <input type="number" id="plFloorNo" name="plFloorNo" class="form-control" placeholder="12" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plBathrooms">Bathrooms</label>
                          <input
                            type="number"
                            id="plBathrooms"
                            name="plBathrooms"
                            class="form-control"
                            placeholder="4" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="plFurnishedStatus">Furnished Status</label>
                          <select id="plFurnishedStatus" name="plFurnishedStatus" class="form-select">
                            <option selected disabled value="">Select furnished status</option>
                            <option value="1">Fully furnished</option>
                            <option value="2">Furnished</option>
                            <option value="3">Semi furnished</option>
                            <option value="4">Unfurnished</option>
                          </select>
                        </div>
                        <div class="col-lg-12">
                          <label class="form-label" for="plFurnishingDetails">Furnishing Details</label>
                          <input
                            id="plFurnishingDetails"
                            name="plFurnishingDetails"
                            class="form-control"
                            placeholder="select options"
                            value="Fridge, AC, TV, WiFi" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label">Is there any common area?</label>
                          <div class="form-check mb-2">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plCommonAreaRadio"
                              id="plCommonAreaRadioYes"
                              checked />
                            <label class="form-check-label" for="plCommonAreaRadioYes">Yes</label>
                          </div>
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plCommonAreaRadio"
                              id="plCommonAreaRadioNo" />
                            <label class="form-check-label" for="plCommonAreaRadioNo">No</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label">Is there any attached balcony?</label>
                          <div class="form-check mb-2">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plAttachedBalconyRadio"
                              id="plAttachedBalconyRadioYes"
                              checked />
                            <label class="form-check-label" for="plAttachedBalconyRadioYes">Yes</label>
                          </div>
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plAttachedBalconyRadio"
                              id="plAttachedBalconyRadioNo" />
                            <label class="form-check-label" for="plAttachedBalconyRadioNo">No</label>
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
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plTotalArea">Total Area</label>
                          <div class="input-group input-group-merge">
                            <input
                              type="number"
                              class="form-control"
                              id="plTotalArea"
                              name="plTotalArea"
                              placeholder="1000"
                              aria-describedby="pl-total-area" />
                            <span class="input-group-text" id="pl-total-area">sq-ft</span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plCarpetArea">Carpet Area</label>
                          <div class="input-group input-group-merge">
                            <input
                              type="number"
                              class="form-control"
                              id="plCarpetArea"
                              name="plCarpetArea"
                              placeholder="800"
                              aria-describedby="pl-carpet-area" />
                            <span class="input-group-text" id="pl-carpet-area">sq-ft</span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plPlotArea">Plot Area</label>
                          <div class="input-group input-group-merge">
                            <input
                              type="number"
                              class="form-control"
                              id="plPlotArea"
                              name="plPlotArea"
                              placeholder="800"
                              aria-describedby="pl-plot-area" />
                            <span class="input-group-text" id="pl-plot-area">sq-yd</span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plAvailableFrom">Available From</label>
                          <input
                            type="text"
                            id="plAvailableFrom"
                            name="plAvailableFrom"
                            class="form-control flatpickr"
                            placeholder="YYYY-MM-DD" />
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label">Possession Status</label>
                          <div class="form-check mb-2">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plPossessionStatus"
                              id="plUnderConstruction"
                              checked />
                            <label class="form-check-label" for="plUnderConstruction">Under Construction</label>
                          </div>
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plPossessionStatus"
                              id="plReadyToMoveRadio" />
                            <label class="form-check-label" for="plReadyToMoveRadio">Ready to Move</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label">Transaction Type</label>
                          <div class="form-check mb-2">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plTransectionType"
                              id="plNewProperty"
                              checked />
                            <label class="form-check-label" for="plNewProperty">New Property</label>
                          </div>
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plTransectionType"
                              id="plResaleProperty" />
                            <label class="form-check-label" for="plResaleProperty">Resale</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label">Is Property Facing Main Road?</label>
                          <div class="form-check mb-2">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plRoadFacingRadio"
                              id="plRoadFacingRadioYes"
                              checked />
                            <label class="form-check-label" for="plRoadFacingRadioYes">Yes</label>
                          </div>
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plRoadFacingRadio"
                              id="plRoadFacingRadioNo" />
                            <label class="form-check-label" for="plRoadFacingRadioNo">No</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label">Gated Colony?</label>
                          <div class="form-check mb-2">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plGatedColonyRadio"
                              id="plGatedColonyRadioYes"
                              checked />
                            <label class="form-check-label" for="plGatedColonyRadioYes">Yes</label>
                          </div>
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plGatedColonyRadio"
                              id="plGatedColonyRadioNo" />
                            <label class="form-check-label" for="plGatedColonyRadioNo">No</label>
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
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plExpeactedPrice">Expected Price</label>
                          <div class="input-group input-group-merge">
                            <input
                              type="number"
                              class="form-control"
                              id="plExpeactedPrice"
                              name="plExpeactedPrice"
                              placeholder="25,000"
                              aria-describedby="pl-expeacted-price" />
                            <span class="input-group-text" id="pl-expeacted-price">$</span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plPriceSqft">Price per Sqft</label>
                          <div class="input-group input-group-merge">
                            <input
                              type="number"
                              class="form-control"
                              id="plPriceSqft"
                              name="plPriceSqft"
                              placeholder="500"
                              aria-describedby="pl-price-sqft" />
                            <span class="input-group-text" id="pl-price-sqft">$</span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plMaintenenceCharge">Maintenance Charge</label>
                          <div class="input-group input-group-merge">
                            <input
                              type="number"
                              class="form-control"
                              id="plMaintenenceCharge"
                              name="plMaintenenceCharge"
                              placeholder="50"
                              aria-describedby="pl-mentenence-charge" />
                            <span class="input-group-text" id="pl-mentenence-charge">$</span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="plMaintenencePer">Maintenance</label>
                          <select id="plMaintenencePer" name="plMaintenencePer" class="form-select">
                            <option value="1" selected>Monthly</option>
                            <option value="2">Quarterly</option>
                            <option value="3">Yearly</option>
                            <option value="3">One-time</option>
                            <option value="3">Per sqft. Monthly</option>
                          </select>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plBookingAmount">Booking/Token Amount</label>
                          <div class="input-group input-group-merge">
                            <input
                              type="number"
                              class="form-control"
                              id="plBookingAmount"
                              name="plBookingAmount"
                              placeholder="250"
                              aria-describedby="pl-booking-amount" />
                            <span class="input-group-text" id="pl-booking-amount">$</span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label d-block" for="plOtherAmount">Other Amount</label>
                          <div class="input-group input-group-merge">
                            <input
                              type="number"
                              class="form-control"
                              id="plOtherAmount"
                              name="plOtherAmount"
                              placeholder="500"
                              aria-describedby="pl-other-amount" />
                            <span class="input-group-text" id="pl-other-amount">$</span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label">Show Price as</label>
                          <div class="form-check mb-2">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="plShowPriceRadio"
                              id="plNagotiablePrice"
                              checked />
                            <label class="form-check-label" for="plNagotiablePrice">Negotiable</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="plShowPriceRadio" id="plCallForPrice" />
                            <label class="form-check-label" for="plCallForPrice">Call for Price</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label">Price includes</label>
                          <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="plCarParking" id="plCarParking" />
                            <label class="form-check-label" for="plCarParking">Car Parking</label>
                          </div>
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="checkbox"
                              name="plClubMembership"
                              id="plClubMembership" />
                            <label class="form-check-label" for="plClubMembership">Club Membership</label>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="plOtherCharges" id="plOtherCharges" />
                            <label class="form-check-label" for="plOtherCharges"
                              >Stamp Duty & Registration charges excluded.</label
                            >
                          </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-4">
                          <button class="btn btn-label-secondary btn-prev">
                            <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                          </button>
                          <button class="btn btn-success btn-submit btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Submit</span
                            ><i class="ti ti-check ti-xs"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
 <!-- Modal -->
      <div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
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
                                            class="form-check-input residential"
                                            type="radio"
                                            value="1"
                                            id="customRadioBuilder"
                                            checked />
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
                                            class="form-check-input commercial"
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
                                {{ Form::text('unitName', null, ['class' => 'form-control', 'id'=>'unitName','placeholder' => __('Unit Name')]) }}
                                @error('unit_name')
                                    <small class="invalid-name" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-sm-12 mb-3">
                                {{ Form::label('unit_floor', __('Unit Floor'), ['class' => 'form-label']) }}
                                {{ Form::number('unit_floor', null, ['class' => 'form-control', 'id'=>'unit_floor','min'=>'1','step'=>'1','placeholder' => __('Unit Floor')]) }}
                           
                            </div>
                            <div class="col-sm-12 mb-3">
                                {{ Form::label('rent_amount', __('Rent Amount'), ['class' => 'form-label']) }}
                                {{ Form::number('rent_amount', null, ['class' => 'form-control', 'id'=>'rent_amount','placeholder' => __('Rent Amount')]) }}
                           
                            </div>
                            <div class="col-sm-12 mb-3">
                                {{ Form::label('unit_type', __('Unit Type'), ['class' => 'form-label']) }}
                                   {!! Form::select('unit_type', $unitTypes, null, ['class' => 'form-control select unit_type select2 form-select','id'=>'unit_type', 'required' => 'required']) !!}
                           
                            </div>
                            <div class="col-sm-6 onlyforcommercial" id="onlyforcommercial">
                                <div class="mb-3">
                                    {{ Form::label('bed_rooms', __('Bed Rooms'), ['class' => 'form-label']) }}
                                    {{ Form::number('bed_rooms', null, ['class' => 'form-control', 'id'=>'bed_rooms','placeholder' => __('Bed Rooms')]) }}
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
                                    {{ Form::number('total_rooms', null, ['class' => 'form-control', 'id'=>'total_rooms','placeholder' => __('Total Rooms')]) }}
                                </div>
                           
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    {{ Form::label('square_foot', __('Square Foot'), ['class' => 'form-label']) }}
                                    {{ Form::number('square_foot', null, ['class' => 'form-control', 'id'=>'square_foot','placeholder' => __('Square Foot')]) }}
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
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/js/wizard-ex-property-listing.js') }}"></script>
    <script>
        $(document).ready(function() {
    let unitCount = 0;
    let currentInputId = '';
    let isCopyAction = false;

    function openUnitModal(inputId) {
        currentInputId = inputId;
        isCopyAction = false; // Reset copy action flag
        $('#unitModal').modal('show');
    }

    $('#continueButton').on('click', function() {
        let unitName = $('#unitName').val();
        if (currentInputId) {
            if (isCopyAction) {
                // For copy action, add a new unit row with the copied data
                addUnitRow(unitName);
                isCopyAction = false; // Reset after copying
            } else {
                // For regular input action, update the existing unit
                $(`#${currentInputId}`).val(unitName);
            }
        } else {
            addUnitRow(unitName);
        }
        $('#unitModal').modal('hide');
        $('#unitName').val('');
        currentInputId = '';
    });

    function addUnitRow(unitName = '') {
        unitCount++;
        let unitRow = `
            <div class="unit-row row" id="unitRow_${unitCount}">
                <div class="col-md-9 input-group input-group-merge">
                    <input type="text" class="form-control" id="unitInput_${unitCount}" value="${unitName}" readonly>
                </div>
                <div class="unit-actions col-md-3 input-group input-group-merge">
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
        let inputId = $(this).attr('id');
        openUnitModal(inputId);
    });

    $('#unitsContainer').on('click', '.copy-btn', function() {
            let inputId = $(this).data('id');
            let unitName = $(`#${inputId}`).val();
            addUnitRow(unitName); // Add new unit with copied content
            $('#unitName').val(unitName); 
            $('#unit_floor').val(unitName); 
            $('#rent_amount').val(unitName); 
            $('#unit_type').val(unitName); 
            $('#bed_rooms').val(unitName); 
            $('#bath_rooms').val(unitName); 
            $('#total_rooms').val(unitName); 
            $('#square_foot').val(unitName); 
            isCopyAction = true; // Set flag to true for copy action
            //openUnitModal(inputId); // Open modal for new entry
        });

    $('#unitsContainer').on('click', '.delete-btn', function() {
        let rowId = $(this).data('id');
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

     
    </script>
@endsection