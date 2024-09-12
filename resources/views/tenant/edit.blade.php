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
                  <div class="step" data-target="#contact-info">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-currency-dollar ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Contact Info </span>
                       
                      </span>
                    </button>
                  </div>

                </div>
                <div class="bs-stepper-content">
                  <form id="wizard-property-listing-form" onSubmit="return false">
                    {!! Form::hidden('id',$tenant->id,array('class'=>'form-control')) !!}
                    @csrf
                    <!-- Tenant Details -->
                    <div id="tenant-info" class="content active">
                      <div class="row g-3">
                        <div class="col-sm-6">
                            {{ Form::label('full_name', __('Company Name'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                            {{ Form::text('full_name', $tenant->full_name, ['class' => 'form-control', 'placeholder' => __('Company Name')]) }}
                            @error('full_name')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('firm_name', __('Firm Name'), ['class' => 'form-label']) }}  <span class="requiredLabel">*</span>
                            {{ Form::text('firm_name', $tenant->firm_name, ['class' => 'form-control', 'placeholder' => __('Firm Name')]) }}
                            @error('firm_name')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                       
                        <div class="col-sm-6">
                            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                            {{ Form::text('email', $tenant->email, ['class' => 'form-control', 'placeholder' => __('User Email')]) }}
                            @error('email')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                           
                        </div>
                    
                        <div class="col-sm-6">
                            {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
                            {{ Form::text('phone', $tenant->phone, ['class' => 'form-control', 'placeholder' => __('User Phone')]) }}
                            @error('phone')
                                <small class="invalid-email" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                           {{ Form::label('pan_no', __('PAN NO.'), ['class' => 'form-label']) }}
                            {{ Form::text('pan_no', $tenant->pan_no, ['class' => 'form-control','id'=>'pan_no', 'placeholder' => __('PAN No')]) }}
                            @error('pan_no')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                         <div class="col-sm-4">
                           {{ Form::label('gst_no', __('GST NO.'), ['class' => 'form-label']) }}
                            {{ Form::text('gst_no', $tenant->gst_no, ['class' => 'form-control','id'=>'gst_no', 'placeholder' => __('GST NO')]) }}
                            @error('gst_no')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                        <div class="col-sm-4">
                           {{ Form::label('business_name', __('Business name'), ['class' => 'form-label']) }}
                            {{ Form::text('business_name', $tenant->business_name, ['class' => 'form-control','id'=>'business_name', 'placeholder' => __('Business name')]) }}
                            @error('business_name')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-4">
                           {{ Form::label('business_industry', __('Business industry'), ['class' => 'form-label']) }}
                            {{ Form::text('business_industry',  $tenant->business_industry, ['class' => 'form-control','id'=>'business_industry', 'placeholder' => __('Business industry')]) }}
                            @error('business_industry')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-4">
                            {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                               {!! Form::select('state', $statsList, $tenant->state, ['class' => 'form-control select state select2 form-select', 'required' => 'required']) !!}
                       
                        </div>
                        <div class="col-sm-4">
                                {{ Form::label('city', __('City'), ['class' => 'form-label']) }}
                                {{ Form::text('city', $tenant->city, ['class' => 'form-control', 'placeholder' => __('User City')]) }}
                                @error('city')
                                    <small class="invalid-email" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                        </div>
                        

                         <div class="col-sm-12">
                           {{ Form::label('business_address', __('Business Address'), ['class' => 'form-label']) }}
                            {{ Form::textarea('business_address', $tenant->business_address, ['class' => 'form-control','id'=>'business_address','rows'=>'2', 'placeholder' => __('Business Address')]) }}
                            @error('business_address')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                        <div class="col-sm-12">
                           {{ Form::label('company_address', __('Company Address'), ['class' => 'form-label']) }}
                            {{ Form::textarea('company_address',  $tenant->company_address, ['class' => 'form-control','id'=>'company_address','rows'=>'2', 'placeholder' => __('Company Address')]) }}
                            @error('company_address')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>

                        <div class="col-sm-12">
                           {{ Form::label('business_description', __('Business description'), ['class' => 'form-label']) }}
                            {{ Form::textarea('business_description',  $tenant->business_description, ['class' => 'form-control','id'=>'business_description','rows'=>'2', 'placeholder' => __('Business description')]) }}
                            @error('business_description')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
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

                    <!-- Contact Info -->
                    <div id="contact-info" class="content">
                      <div class="row g-3">
                
                         <div class="col-sm-12">
                        
                            <div id="contactInfoContainer" class="">
                                @foreach($tenantContactInfo as $key=>  $info)
                                  <div class="row g-3 textBoxWrapper"><br>
                                    <div class="col-sm-4">
                                      <label class="form-label" for="contact_type">Type</label>
                                      <select id="contact_type" name="contact_type[]" class="form-control select2 form-select" data-allow-clear="true">
                                        <option value="">Select</option>
                                        <option value="All" @if(@$info->contact_type == 'All' ) selected @endif >All</option>
                                        <option value="Rental"  @if(@$info->contact_type == 'Rental' ) selected @endif>Rental</option>
                                        <option value="Cam"  @if(@$info->contact_type == 'Cam' ) selected @endif>Cam</option>
                                        <option value="Utility"  @if(@$info->contact_type == 'Utility' ) selected @endif>Utility</option>

                                      </select>
                                    </div>
                                    <div class="col-sm-4">
                                       {{ Form::label('fullname', __('Full Name'), ['class' => 'form-label']) }}
                                        {{ Form::text('fullname[]', $info->full_name, ['class' => 'form-control','id'=>'fullname', 'placeholder' => __('Full Name')]) }}
                                        @error('fullname')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                          @enderror
                                    </div>

                                    <div class="col-sm-4">
                                       {{ Form::label('contact_email', __('Email'), ['class' => 'form-label']) }}
                                        {{ Form::text('contact_email[]', $info->email, ['class' => 'form-control','id'=>'contact_email', 'placeholder' => __('Email')]) }}
                                        @error('contact_email')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                          @enderror
                                    </div>

                                    <div class="col-sm-4">
                                       {{ Form::label('contact_phone', __('Phone'), ['class' => 'form-label']) }}
                                        {{ Form::text('contact_phone[]', $info->phone, ['class' => 'form-control','id'=>'contact_phone', 'placeholder' => __('Phone')]) }}
                                        @error('phone')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                          @enderror
                                    </div>
                                    <div class="col-sm-4">
                                       {{ Form::label('position', __('Position'), ['class' => 'form-label']) }}
                                        {{ Form::text('position[]',$info->position, ['class' => 'form-control','id'=>'position', 'placeholder' => __('Position')]) }}
                                        @error('position')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                          @enderror
                                    </div>
                                    <div class="col-sm-4"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px"><i class="ti ti-trash text-white"></i></button>  </div>
                                         <hr class="my-20" />
                                  </div>
                                @endforeach
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addContactInfo">+ Add More Contact</button>
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
    <script src="{{ asset('assets/js/tenant-listing.js') }}"></script>
    <script>
   // Initialize Select2
  $(document).ready(function() {
     getState();
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
      var country_id = '101'; // Get the selected value from Select2

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

$("#addContactInfo").click(function(){
    var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-4"> <label class="form-label" for="contact_type">Type</label> <select id="contact_type" name="contact_type[]" class="form-control select2 form-select" data-allow-clear="true"> <option value="">Select</option> <option value="All">All</option> <option value="Rental">Rental</option> <option value="Cam">Cam</option> <option value="Utility">Utility</option> </select> </div> <div class="col-sm-4"> <label for="fullname" class="form-label">Full Name</label> <input class="form-control" id="fullname" placeholder="Full Name" name="fullname[]" type="text"> </div> <div class="col-sm-4"> <label for="contact_email" class="form-label">Email </label> <input class="form-control" id="contact_email" placeholder="Email" name="contact_email[]" type="text"> </div> <div class="col-sm-4"> <label for="contact_phone" class="form-label">Phone</label> <input class="form-control" id="contact_phone" placeholder="Phone" name="contact_phone[]" type="text"> </div> <div class="col-sm-4"> <label for="position" class="form-label">Position</label> <input class="form-control" id="position" placeholder="Position" name="position[]" type="text"> </div><div class="col-sm-4"><label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger" ><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
    $("#contactInfoContainer").append(textBoxHtml);
});

// Remove text box
$("#contactInfoContainer").on("click", ".removeButton", function(){
    $(this).closest(".textBoxWrapper").remove();
});
    </script>
@endsection