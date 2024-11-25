{{Form::model($user,array('route' => array('users.update', $user->id), 'method' => 'PUT','id'=>'addNewUserForm')) }}

<div class="modal-body">
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                {{ Form::label('first_name', __('First Name'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => __('First Name')]) }}
                @error('first_name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
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
        
        <div class="col-md-4">
            <div class="mb-3">
                {{ Form::label('email', __('Email'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('User Email')]) }}
                @error('email')
                    <small class="invalid-email" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
    

        <div class="col-md-4">
            <div class="mb-3">
                {{ Form::label('mobile', __('Phone'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                {{ Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => __('User Phone')]) }}
                @error('mobile')
                    <small class="invalid-email" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <!-- <div class="col-md-4">
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
        </div> -->
        <div class="col-md-4">
            <div class="mb-3">

            {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
            {!! Form::select('state', ['' => __('Select State')] + $statsList, $user->state, ['class' => 'form-control select state select2 form-select', 'id' => 'state']) !!}

              
            </div>
        </div>
        <div class="col-md-3">
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
        <div class="col-md-3 ">
            <div class="mb-3">
                {{ Form::label('role_id', __('User Role'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                {!! Form::select('role_id', $roles, $user->role_id, ['class' => 'form-control select']) !!}
                @error('role_id')
                    <small class="invalid-role" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
          <div class="col-md-3">
            <div class="mb-3">
                {{ Form::label('gst_no', __('GST NO'), ['class' => 'form-label']) }}
                {{ Form::text('gst_no', null, ['class' => 'form-control', 'placeholder' => __('GST NO')]) }}
                
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                {{ Form::label('pan_no', __('PAN NO'), ['class' => 'form-label']) }}
                {{ Form::text('pan_no', null, ['class' => 'form-control', 'placeholder' => __('PAN NO')]) }}
                
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                {{ Form::label('postal_address', __('Postal Address'), ['class' => 'form-label']) }}
                {{ Form::textarea('postal_address', null, ['class' => 'form-control', 'placeholder' => __('Postal Address'),'rows'=>2]) }}
              
            </div>
        </div>
        <!-- <div class="col-md-12">
            <div class="mb-3">
                {{ Form::label('residential_address', __('Residential Address'), ['class' => 'form-label']) }}
                {{ Form::textarea('residential_address', null, ['class' => 'form-control', 'placeholder' => __('Residential Address'),'rows'=>3]) }}
              
            </div>
        </div> -->
        <div class="col-md-3">
            <div class="mb-3">
                {{ Form::label('bank_name', __('Bank Name'), ['class' => 'form-label']) }}
                {{ Form::text('bank_name', null, ['class' => 'form-control', 'placeholder' => __('Bank Name')]) }}
                
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                {{ Form::label('account_no', __('Account Holder name'), ['class' => 'form-label']) }}
                {{ Form::text('account_holder_name', null, ['class' => 'form-control', 'placeholder' => __('Account Holder name')]) }}
                
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                {{ Form::label('account_no', __('Account No'), ['class' => 'form-label']) }}
                {{ Form::text('account_no', null, ['class' => 'form-control', 'placeholder' => __('Account No')]) }}
                
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                {{ Form::label('bank_ifsc_code', __('IFSC code'), ['class' => 'form-label']) }}
                {{ Form::text('bank_ifsc_code', null, ['class' => 'form-control', 'placeholder' => __('IFSC code')]) }}
                
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                {{ Form::label('bank_address', __('Bank Address'), ['class' => 'form-label']) }}
                {{ Form::textarea('bank_address', null, ['class' => 'form-control','rows'=>'2', 'placeholder' => __('Bank Address')]) }}
                
            </div>
        </div>
       
    </div>

</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script type="text/javascript"> var appurl = '{{url("/")}}/';
(function () {
  const phoneMaskList = document.querySelectorAll('.phone-mask'),
    addNewUserForm = document.getElementById('addNewUserForm');

  // Phone Number
  if (phoneMaskList) {
    phoneMaskList.forEach(function (phoneMask) {
      new Cleave(phoneMask, {
        phone: true,
        phoneRegionCode: 'IN'
      });
    });
  }
  // Add New User Form Validation
  const fv = FormValidation.formValidation(addNewUserForm, {
    fields: {
      first_name: {
        validators: {
          notEmpty: {
            message: 'Please enter first name '
          }
        }
      },
      email: {
                validators: {
                    notEmpty: {
                        message: 'Please enter your email'
                    },
                    emailAddress: {
                        message: 'The value is not a valid email address'
                    },
                    remote: {
                        url: appurl+'check-email', // Adjust your URL as needed
                        type: 'GET', // Ensure this is set to POST
                        data: {
                            email: function() {
                                return $('#email').val(); // Ensure to get the email field value
                            },
                             id: '{{ $user->id }}',
                            _token: '{{ csrf_token() }}'
                        },
                       message: 'This email is already taken',
                        // Custom response handling
                        dataType: 'json', // Expecting a JSON response
                        success: function(response) {
                            return response.valid; // Directly use the response valid state
                        }
                    }
                }
            },
     
      
      mobile: {
        validators: {
          notEmpty: {
            message: 'Please enter phone number '
          },
           regexp: {
                    // Regex to check for exactly 10 digits
                    message: 'The phone number must be exactly 10 digits',
                    regexp: /^[0-9]{10}$/
                }
        }
      },
      role_id: {
        validators: {
          notEmpty: {
            message: 'Please select user role '
          }
        }
    }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        eleValidClass: '',
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          return '.mb-3';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }

  }).on('core.form.valid', function () {
    addNewUserForm.submit()
    
    });

})();
      $(document).ready(function() {
        //getState();
      
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
</script>