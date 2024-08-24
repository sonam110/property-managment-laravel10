@extends('layouts.master')
@section('page-title')
    {{__('Property Settings')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('app-setting.index')}}">{{__('Settings')}}</a></li>
    <li class="breadcrumb-item">{{__('User Profile')}}</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-3">
            @include('includes.system_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">

                <div class="row">
                    <div class="col">
                      <h6 class="mt-4"> {{__('User Profile')}}</h6>
                      <div class="card mb-3">
                        <div class="card-header pt-2">
                          <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                              <button
                                class="nav-link {{ (request()->is('user-profile') ? 'active' : '')}}"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-General"
                                role="tab"
                                aria-selected="true">
                                General
                              </button>
                            </li>
                            <li class="nav-item">
                              <button
                                class="nav-link {{ (request()->is('change-password') ? 'active' : '')}}"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-ChangePassword"
                                role="tab"
                                aria-selected="false">
                                Change Password
                              </button>
                            </li>
                            
                          </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade {{ (request()->is('user-profile') ? 'active show' : '')}} mb-4" id="form-tabs-General" role="tabpanel">
                             {{Form::model($user,array('route' => array('user-profile.update', $user->id), 'method' => 'PUT','enctype'=>'multipart/form-data', 'files'=>true)) }}
                             <input type="hidden" name="old_profile_pic" value="{{ $user->profile_pic }}">
                                <div class="card-body">
                                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <img
                                          src="{{url('/')}}/{{$user->profile_pic}}"
                                          alt="user-avatar"
                                          class="d-block w-px-100 h-px-100 rounded"
                                          id="uploadedAvatar" />
                                        <div class="button-wrapper">
                                          <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new logo</span>
                                            <i class="ti ti-upload d-block d-sm-none"></i>
                                            <input
                                              type="file"
                                              id="upload"
                                              name="profile_pic"
                                              class="account-file-input"
                                              hidden
                                              accept="image/png, image/jpeg"  />
                                          </label>
                                          <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                          </button>

                                          <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                        </div>
                                      </div>
                                </div>
                                <hr class="my-0" />
                            <div class="card-body table-border-style">
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('first_name', __('First Name'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                                        {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => __('First Name'), 'required' => 'required']) }}
                                        @error('first_name')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('email', __('Email'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                                        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('User Email'), 'required' => 'required']) }}
                                        @error('email')
                                            <small class="invalid-email" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('mobile', __('Phone'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                                        {{ Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => __('User Phone'), 'required' => 'required']) }}
                                        @error('mobile')
                                            <small class="invalid-email" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                    {{ Form::label('country', __('Country'), ['class' => 'form-label']) }}
                                     <select name="country"id="multicol-country" class="form-control country select2 form-select"   data-allow-clear="true"  style="height: 47px;"
                                         onChange="getState();">
                                         <option value="" selected>--Country--</option>
                                         @foreach($countries as $county)
                                         <option value="{{ $county->id }}" countryid="{{ $county->id }}" @if($user->country == $county->id ) selected @endif >
                                            {{ ucfirst($county->name) }}
                                         </option>
                                         @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                    {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                                       {!! Form::select('state', $statsList, $user->state, ['class' => 'form-control select state select2 form-select', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                
                                 <div class="col-md-12">
                                    <div class="mb-3">
                                        {{ Form::label('national_id_no', __('National Id/ Passport'), ['class' => 'form-label']) }}
                                        {{ Form::text('national_id_no', null, ['class' => 'form-control', 'placeholder' => __('NationalId')]) }}
                                        
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        {{ Form::label('postal_address', __('Postal Address'), ['class' => 'form-label']) }}
                                        {{ Form::textarea('postal_address', null, ['class' => 'form-control', 'placeholder' => __('Postal Address'),'rows'=>3]) }}
                                      
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        {{ Form::label('residential_address', __('Residential Address'), ['class' => 'form-label']) }}
                                        {{ Form::textarea('residential_address', null, ['class' => 'form-control', 'placeholder' => __('Residential Address'),'rows'=>3]) }}
                                      
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                                    
                                </div>
                               
                            </div>
                            </div>
                      {{Form::close()}}
                          </div>
                          <div class="tab-pane fade {{ (request()->is('change-password') ? 'active show' : '')}}" id="form-tabs-ChangePassword" role="tabpanel">
                             <div class="card-body">
                            {{ Form::open(array('route' => 'change-password-update', 'class'=> 'form-horizontal')) }}
                            @csrf
                               
                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Old Password <span class="requiredLabel">*</span></label>
                                    {!! Form::password('old_password',array('id'=>'old_password','class'=> $errors->has('old_password') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Old Password', 'autocomplete'=>'off','required'=>'required')) !!}
                                    @if ($errors->has('old_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password <span class="requiredLabel">*</span></label>
                                    {!! Form::password('new_password',array('id'=>'new_password','class'=>$errors->has('new_password') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'New Password', 'autocomplete'=>'off','required'=>'required')) !!}
                                    @if ($errors->has('new_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm Password <span class="requiredLabel">*</span></label>
                                    {!! Form::password('new_password_confirmation',array('id'=>'new_password_confirmation','class'=>$errors->has('new_password_confirmation') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Confirm Password', 'autocomplete'=>'off','required'=>'required')) !!}
                                    @if ($errors->has('new_password_confirmation'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Update Password</button>
                                    
                            {{ Form::close() }}
                        </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
              </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extrajs')
 <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
<script type="text/javascript">
    
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