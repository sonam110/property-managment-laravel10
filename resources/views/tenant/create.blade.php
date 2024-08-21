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
    <li class="breadcrumb-item"><a href="{{route('tenants.index')}}">{{__('Tenant Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Tenant')}}</li>
@endsection

@section('content')
    <div id="wizard-property-listing" class="bs-stepper vertical mt-2">
                <div class="bs-stepper-header">
                  <div class="step active" data-target="#tenant-info">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-users ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Tenant Info</span>
                      
                      </span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#kin-relation">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-currency-dollar ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Kin & Relation </span>
                       
                      </span>
                    </button>
                  </div>

                  <div class="line"></div>
                  <div class="step" data-target="#employment">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-bookmarks ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Employment</span>
                       
                      </span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#business-details">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-map-pin ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Business Details</span>
                      
                      </span>
                    </button>
                  </div>
                  
                </div>
                <div class="bs-stepper-content">
                  <form id="wizard-property-listing-form" onSubmit="return false">
                    {!! Form::hidden('id',null,array('class'=>'form-control')) !!}
                    @csrf
                    <!-- Tenant Details -->
                    <div id="tenant-info" class="content active">
                      <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                {{ Form::label('first_name', __('First Name'), ['class' => 'form-label']) }}
                                {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => __('First Name')]) }}
                                @error('first_name')
                                    <small class="invalid-name" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                {{ Form::label('middle_name', __('Middle Name'), ['class' => 'form-label']) }}
                                {{ Form::text('middle_name', null, ['class' => 'form-control', 'placeholder' => __('Middle Name')]) }}
                                @error('middle_name')
                                    <small class="invalid-name" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                {{ Form::label('last_name', __('Last Name'), ['class' => 'form-label']) }}
                                {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('Last Name')]) }}
                                @error('last_name')
                                    <small class="invalid-name" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="mb-3">
                                {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('User Email')]) }}
                                @error('email')
                                    <small class="invalid-email" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="col-sm-6">
                            <div class="mb-3">
                                {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}
                                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Password'), 'minlength' => '6']) }}
                                @error('password')
                                    <small class="invalid-password" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                         <div class="col-sm-6 ">
                            <div class="mb-3">
                                {{ Form::label('confirm_password', __('Confirm Password'), ['class' => 'form-label']) }}
                                {!! Form::password('confirm_password',array('id'=>'confirm_password','class'=> $errors->has('confirm_password') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Confirm Password', 'autocomplete'=>'off')) !!}
                                @error('confirm_password')
                                    <small class="invalid-password" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                {{ Form::label('mobile', __('Phone'), ['class' => 'form-label']) }}
                                {{ Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => __('User Phone')]) }}
                                @error('mobile')
                                    <small class="invalid-email" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                            {{ Form::label('country', __('Country'), ['class' => 'form-label']) }}
                             <select name="country"   id="multicol-country" class="form-control country select2 form-select"   data-allow-clear="true"  style="height: 47px;"
                                 onChange="getState();">
                                 <option value="" selected>--Country--</option>
                                 @foreach($countries as $county)
                                 <option value="{{ $county->id }}" countryid="{{ $county->id }}">
                                    {{ ucfirst($county->name) }}
                                 </option>
                                 @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                            {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                                <select name="state" id="state" class="form-control state select2 form-select"  data-allow-clear="true">     
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                {{ Form::label('city', __('City'), ['class' => 'form-label']) }}
                                {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => __('User City')]) }}
                                @error('city')
                                    <small class="invalid-email" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            {{ Form::label('tenant_type', __('Tenant Type'), ['class' => 'form-label']) }}
                               {!! Form::select('tenant_type', $tenantTypes, null, ['class' => 'form-control select tenant_type select2 form-select','id'=>'tenant_type']) !!}
                           
                        </div>
                        <div class="col-sm-6">
                          <label class="form-label" for="gender">Gender</label>
                          <select id="gender" name="gender" class="form-control select2 form-select" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                          </select>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                {{ Form::label('merital_status', __('Merital status'), ['class' => 'form-label']) }}
                                {{ Form::text('merital_status', null, ['class' => 'form-control', 'placeholder' => __('Merital status')]) }}
                                
                            </div>
                        </div>
                         <div class="col-sm-6">
                            <div class="mb-3">
                                {{ Form::label('national_id_no', __('National Id/ Passport'), ['class' => 'form-label']) }}
                                {{ Form::text('national_id_no', null, ['class' => 'form-control', 'placeholder' => __('NationalId')]) }}
                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                {{ Form::label('postal_address', __('Postal Address'), ['class' => 'form-label']) }}
                                {{ Form::textarea('postal_address', null, ['class' => 'form-control', 'placeholder' => __('Postal Address'),'rows'=>3]) }}
                              
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                {{ Form::label('residential_address', __('Residential Address'), ['class' => 'form-label']) }}
                                {{ Form::textarea('residential_address', null, ['class' => 'form-control', 'placeholder' => __('Residential Address'),'rows'=>3]) }}
                              
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

                    <!-- kin-relation -->
                    <div id="kin-relation" class="content">
                      <div class="row g-3">
                        
                        <div class="col-sm-4">
                           {{ Form::label('kin_name', __('Next of Kin name'), ['class' => 'form-label']) }}
                            {{ Form::text('kin_name', null, ['class' => 'form-control','id'=>'kin_name', 'placeholder' => __('Next of Kin name')]) }}
                            @error('kin_name')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-4">
                           {{ Form::label('kin_mobile', __('Next of Kin Phone'), ['class' => 'form-label']) }}
                            {{ Form::text('kin_mobile', null, ['class' => 'form-control','id'=>'kin_mobile', 'placeholder' => __('Next of Kin Phone')]) }}
                            @error('kin_mobile')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                        <div class="col-sm-4">
                           {{ Form::label('kin_relation', __('Next of Kin Relation'), ['class' => 'form-label']) }}
                            {{ Form::text('kin_relation', null, ['class' => 'form-control','id'=>'kin_relation', 'placeholder' => __('Next of Kin Relation')]) }}
                            @error('kin_relation')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                        <div class="col-sm-4">
                           {{ Form::label('emergency_contact_name', __('Emergency Name'), ['class' => 'form-label']) }}
                            {{ Form::text('emergency_contact_name', null, ['class' => 'form-control','id'=>'emergency_contact_name', 'placeholder' => __('Emergency name')]) }}
                            @error('emergency_contact_name')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-4">
                           {{ Form::label('emergency_contact_mobile', __('Emergency Phone'), ['class' => 'form-label']) }}
                            {{ Form::text('emergency_contact_mobile', null, ['class' => 'form-control','id'=>'emergency_contact_mobile', 'placeholder' => __('Emergency Phone')]) }}
                            @error('emergency_contact_mobile')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                        <div class="col-sm-4">
                           {{ Form::label('emergency_contact_email', __('Emergency Email'), ['class' => 'form-label']) }}
                            {{ Form::text('emergency_contact_email', null, ['class' => 'form-control','id'=>'emergency_contact_email', 'placeholder' => __('Emergency Email')]) }}
                            @error('emergency_contact_email')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                         <div class="col-sm-4">
                           {{ Form::label('emergency_contact_relationship', __('Emergency Relation'), ['class' => 'form-label']) }}
                            {{ Form::text('emergency_contact_relationship', null, ['class' => 'form-control','id'=>'emergency_contact_relationship', 'placeholder' => __('Emergency Relation')]) }}
                            @error('emergency_contact_relationship')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-4">
                           {{ Form::label('emergency_postal_address', __('Emergency Postal Address'), ['class' => 'form-label']) }}
                            {{ Form::text('emergency_postal_address', null, ['class' => 'form-control','id'=>'emergency_postal_address', 'placeholder' => __('Emergency Postal Address')]) }}
                            @error('emergency_postal_address')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                        <div class="col-sm-4">
                           {{ Form::label('emergency_residential_address', __('Emergency Residential Address'), ['class' => 'form-label']) }}
                            {{ Form::text('emergency_residential_address', null, ['class' => 'form-control','id'=>'emergency_residential_address', 'placeholder' => __('Emergency Residential Address')]) }}
                            @error('emergency_residential_address')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
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

                    <!-- employment -->
                    <div id="employment" class="content">
                       <div class="row g-3">
                        
                        <div class="col-sm-4">
                           {{ Form::label('employment_status', __('Employment status'), ['class' => 'form-label']) }}
                            {{ Form::text('employment_status', null, ['class' => 'form-control','id'=>'employment_status', 'placeholder' => __('Employment status')]) }}
                            @error('employment_status')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-4">
                           {{ Form::label('employment_status_mobile', __('Employment Phone'), ['class' => 'form-label']) }}
                            {{ Form::text('employment_status_mobile', null, ['class' => 'form-control','id'=>'employment_status_mobile', 'placeholder' => __('Employment Phone')]) }}
                            @error('employment_status_mobile')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                         <div class="col-sm-4">
                           {{ Form::label('employment_status_email', __('Employment Email'), ['class' => 'form-label']) }}
                            {{ Form::text('employment_status_email', null, ['class' => 'form-control','id'=>'employment_status_email', 'placeholder' => __('Employment Email')]) }}
                            @error('employment_status_email')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-4">
                           {{ Form::label('employment_postal_address', __('Employment Postal Address'), ['class' => 'form-label']) }}
                            {{ Form::text('employment_postal_address', null, ['class' => 'form-control','id'=>'employment_postal_address', 'placeholder' => __('Employment Postal Address')]) }}
                            @error('employment_postal_address')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                        <div class="col-sm-4">
                           {{ Form::label('employment_residential_address', __('Employment Residentia Address'), ['class' => 'form-label']) }}
                            {{ Form::text('employment_residential_address', null, ['class' => 'form-control','id'=>'employment_residential_address', 'placeholder' => __('Employment Residentia  Address')]) }}
                            @error('employment_residential_address')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
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

                    <!-- business-details -->
                    <div id="business-details" class="content">
                      <div class="row g-3">
                        
                        <div class="col-sm-4">
                           {{ Form::label('business_name', __('Business name'), ['class' => 'form-label']) }}
                            {{ Form::text('business_name', null, ['class' => 'form-control','id'=>'business_name', 'placeholder' => __('Business name')]) }}
                            @error('business_name')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-4">
                           {{ Form::label('business_industry', __('Business industry'), ['class' => 'form-label']) }}
                            {{ Form::text('business_industry', null, ['class' => 'form-control','id'=>'business_industry', 'placeholder' => __('Business industry')]) }}
                            @error('business_industry')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                        <div class="col-sm-4">
                           {{ Form::label('license_no', __('license No'), ['class' => 'form-label']) }}
                            {{ Form::text('license_no', null, ['class' => 'form-control','id'=>'license_no', 'placeholder' => __('license No')]) }}
                            @error('license_no')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                         <div class="col-sm-4">
                           {{ Form::label('tax_id', __('Tax id'), ['class' => 'form-label']) }}
                            {{ Form::text('tax_id', null, ['class' => 'form-control','id'=>'tax_id', 'placeholder' => __('Tax id')]) }}
                            @error('tax_id')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                         <div class="col-sm-4">
                           {{ Form::label('business_address', __('Business Address'), ['class' => 'form-label']) }}
                            {{ Form::text('business_address', null, ['class' => 'form-control','id'=>'business_address', 'placeholder' => __('Business Address')]) }}
                            @error('business_address')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                        <div class="col-sm-4">
                           {{ Form::label('business_description', __('Business description'), ['class' => 'form-label']) }}
                            {{ Form::text('business_description', null, ['class' => 'form-control','id'=>'business_description', 'placeholder' => __('Business description')]) }}
                            @error('business_description')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
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
    <script src="{{ asset('assets/js/tenant-listing.js') }}"></script>
    <script>
   // Initialize Select2
  $(document).ready(function() {
      $('#multicol-country').select2();

      // Attach event handler to Select2 dropdown
      $('#multicol-country').on('change', function() {
          getState();
      });
  });
    // Select2 Country
  var select2 = $('.select2');
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Select value',
        dropdownParent: $this.parent()
      });
    });
  }
  function getState() {
      var country_id = $('#multicol-country').val(); // Get the selected value from Select2

      $.ajax({
          url: appurl + "get-state",
          type: "post",
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          data: { country_id: country_id },
          success: function(response) {
              $(".state").html(response);
          }
      });
  }
    </script>
@endsection