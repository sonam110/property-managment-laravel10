<h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
{{ Form::open(['url' => 'users', 'method' => 'post','id'=>'addNewUserForm']) }}
 @csrf
<div class="modal-body">
    <ul class="nav nav-tabs" id="userFormTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="basic-info-tab" data-bs-toggle="tab" data-bs-target="#basic-info" type="button" role="tab" aria-controls="basic-info" aria-selected="true">Basic Information</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="banking-info-tab" data-bs-toggle="tab" data-bs-target="#banking-info" type="button" role="tab" aria-controls="banking-info" aria-selected="false">Banking Information</button>
        </li>
    </ul>
    <div class="tab-content" id="userFormTabsContent">
        <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        {{ Form::label('first_name', __('First Name'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                        {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => __('First Name'), 'required' => 'required']) }}
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
                        {{ Form::text('middle_name', old('middle_name'), ['class' => 'form-control', 'placeholder' => __('Middle Name')]) }}
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
                        {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => __('Last Name')]) }}
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
                        {{ Form::text('email', old('email'), ['class' => 'form-control','id'=>'email', 'placeholder' => __('User Email'), 'required' => 'required']) }}
                        @error('email')
                            <small class="invalid-email" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
            
                <div class="col-md-4">
                    <div class="mb-3">
                        {{ Form::label('password', __('Password'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Password'), 'minlength' => '4']) }}
                        @error('password')
                            <small class="invalid-password" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                 <div class="col-md-4 ">
                    <div class="mb-3">
                        {{ Form::label('confirm-password', __('Confirm Password'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                        {!! Form::password('confirm_password',array('id'=>'confirm_password','class'=> $errors->has('confirm-password') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Confirm Password', 'autocomplete'=>'off','required'=>'required')) !!}
                        @error('confirm-password')
                            <small class="invalid-password" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        {{ Form::label('mobile', __('Phone'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                        {{ Form::text('mobile', old('mobile'), ['class' => 'form-control phone-mask', 'placeholder' => __('User Phone'), 'required' => 'required']) }}
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
                </div> -->
                <div class="col-md-4">
                    <div class="mb-3">
                    {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                        <select name="state" id="state" class="form-control state select2 form-select"  data-allow-clear="true">     
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        {{ Form::label('city', __('City'), ['class' => 'form-label']) }}
                        {{ Form::text('city', old('city'), ['class' => 'form-control', 'placeholder' => __('User City')]) }}
                        @error('city')
                            <small class="invalid-email" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="mb-3">
                        {{ Form::label('role_id', __('User Role'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                        {!! Form::select('role_id', $roles, old('role_id'), ['class' => 'form-control select', 'required' => 'required']) !!}
                        @error('role_id')
                            <small class="invalid-role" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="mb-3">
                        {{ Form::label('gst_no', __('GST NO'), ['class' => 'form-label']) }}
                        {{ Form::text('gst_no', old('gst_no'), ['class' => 'form-control', 'placeholder' => __('GST NO')]) }}
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        {{ Form::label('pan_no', __('PAN NO'), ['class' => 'form-label']) }}
                        {{ Form::text('pan_no',  old('pan_no'), ['class' => 'form-control', 'placeholder' => __('PAN NO')]) }}
                        
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        {{ Form::label('postal_address', __('Postal Address'), ['class' => 'form-label']) }}
                        {{ Form::textarea('postal_address',  old('postal_address'), ['class' => 'form-control', 'placeholder' => __('Postal Address'),'rows'=>2]) }}
                      
                    </div>
                </div>
              
            </div>
        </div>
        <div class="tab-pane fade" id="banking-info" role="tabpanel" aria-labelledby="banking-info-tab">
            <div class="row">
                 <div class="col-md-3">
                    <div class="mb-3">
                        {{ Form::label('bank_name', __('For Invoice'), ['class' => 'form-label']) }}
                       <select name="for_type[]" class="form-control select2">
                        <option value="">Please Select</option>
                        <option value="1">Rent</option>
                        <option value="2">CAM</option>
                        <option value="3">Utility</option>
                       </select>
                        
                    </div>
                </div>
               <div class="col-md-3">
                    <div class="mb-3">
                        {{ Form::label('bank_se_name', __('Bank Nick Name'), ['class' => 'form-label']) }}
                        {{ Form::text('bank_se_name[]', old('bank_se_name'), ['class' => 'form-control', 'placeholder' => __('Bank Nick Name')]) }}
                        
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        {{ Form::label('bank_name', __('Bank Name'), ['class' => 'form-label']) }}
                        {{ Form::text('bank_name[]', old('bank_name'), ['class' => 'form-control', 'placeholder' => __('Bank Name')]) }}
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        {{ Form::label('account_holder_name', __('Account Holder name'), ['class' => 'form-label']) }}
                        {{ Form::text('account_holder_name[]', old('account_holder_name'), ['class' => 'form-control', 'placeholder' => __('Account Holder name')]) }}
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        {{ Form::label('account_no', __('Account No'), ['class' => 'form-label']) }}
                        {{ Form::text('account_no[]', old('account_no'), ['class' => 'form-control', 'placeholder' => __('Account No')]) }}
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        {{ Form::label('bank_ifsc_code', __('IFSC code'), ['class' => 'form-label']) }}
                        {{ Form::text('bank_ifsc_code[]',  old('bank_ifsc_code'), ['class' => 'form-control', 'placeholder' => __('IFSC code')]) }}
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        {{ Form::label('bank_address', __('Bank Address'), ['class' => 'form-label']) }}
                        {{ Form::text('bank_address[]',  old('bank_address'), ['class' => 'form-control','rows'=>'2', 'placeholder' => __('Bank Address')]) }}
                        
                    </div>
                </div>
                <div class="col-md-3" style="margin-top: 23px;">
                    <div class="mb-3">
                        <label>&nbsp;</label>
                        <button  type="button" class="btn btn-primary" id="addMoreButton">+ Add More</button>
                    </div>
                </div>
                <div id="bankContainer" class=""> 
                </div>


            </div>
        </div>
    </div>


</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>

{{ Form::close() }}


<script type="text/javascript">
$(document).ready(function() {
      getState();
    var i =0
  $("#addMoreButton").click(function(){
    i++;
        var textBoxHtml = '<div class="row g-3 textBoxWrapper"> <div class="col-md-3"> <div class="mb-3"> <label for="for_type" class="form-label">For Invoice</label> <select name="for_type[]" class="form-control select2" id="for_type"> <option value="">Please Select</option> <option value="1">Rent</option> <option value="2">CAM</option> <option value="3">Utility</option> </select> </div> </div> <div class="col-md-3"> <div class="mb-3"> <label for="bank_se_name[]" class="form-label">Bank Nick Name</label> <input type="text"name="bank_se_name[]"id="bank_se_name"class="form-control"placeholder="Bank Nick Name"value="{{ old('bank_se_name') }}"> </div> </div> <div class="col-md-3"> <div class="mb-3"> <label for="bank_name" class="form-label">Bank Name</label> <input type="text"name="bank_name[]" id="bank_name"class="form-control"placeholder="Bank Name"value="{{ old('bank_name') }}"> </div> </div> <div class="col-md-3"> <div class="mb-3"> <label for="account_holder_name" class="form-label">Account Holder Name</label> <input type="text"name="account_holder_name[]" id="account_holder_name"class="form-control"placeholder="Account Holder Name"value="{{ old('account_holder_name') }}"> </div> </div> <div class="col-md-3"> <div class="mb-3"> <label for="account_no" class="form-label">Account No</label> <input type="text"name="account_no[]" id="account_no"class="form-control"placeholder="Account No"value="{{ old('account_no') }}"> </div> </div> <div class="col-md-3"> <div class="mb-3"> <label for="bank_ifsc_code" class="form-label">IFSC Code</label> <input type="text"name="bank_ifsc_code[]"id="bank_ifsc_code"class="form-control"placeholder="IFSC Code"value="{{ old('bank_ifsc_code') }}"> </div> </div> <div class="col-md-3"> <div class="mb-3"> <label for="bank_address" class="form-label">Bank Address</label> <input type="text"name="bank_address[]"id="bank_address"class="form-control"placeholder="Bank Address"value="{{ old('bank_address') }}"> </div> </div> <div class="col-sm-3"> <label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger"  style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
        $("#bankContainer").append(textBoxHtml);
    });

    // Remove text box
    $("#bankContainer").on("click", ".removeButton", function(){
        $(this).closest(".textBoxWrapper").remove();
       
    });
 });
 var appurl = '{{url("/")}}/';
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
                            id:'',
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
      password: {
        validators: {
          notEmpty: {
            message: 'Please enter Password '
          },
            stringLength: {
                min: 8,
                message: 'The password must be at least 8 characters long'
            }

        }
      },
      confirm_password: {
        validators: {
          notEmpty: {
            message: 'Please enter confirm Password '
          },
            identical: {
                    compare: function() {
                        return addNewUserForm.querySelector('[name="password"]').value;
                    },
                    message: 'The password and confirmation do not match'
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
</script>