<h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
{{ Form::open(['url' => 'users', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-4">
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
                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('User Email'), 'required' => 'required']) }}
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
                {!! Form::password('confirm-password',array('id'=>'confirm-password','class'=> $errors->has('confirm-password') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Confirm Password', 'autocomplete'=>'off','required'=>'required')) !!}
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
                {{ Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => __('User Phone'), 'required' => 'required']) }}
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
                {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => __('User City')]) }}
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
                {!! Form::select('role_id', $roles, null, ['class' => 'form-control select', 'required' => 'required']) !!}
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
                {{ Form::text('gst_no', null, ['class' => 'form-control', 'placeholder' => __('GST NO')]) }}
                
            </div>
        </div>
        <div class="col-md-4">
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
       <!--  <div class="col-md-12">
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
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>

{{ Form::close() }}


<script type="text/javascript">
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