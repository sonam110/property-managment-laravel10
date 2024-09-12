{{Form::model($payment,array('route' => array('payment-update', $payment->id), 'method' => 'POST')) }}

<div class="modal-body">
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                {{ Form::label('total_amount', __('Invoice Amount'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                {{ Form::number('total_amount', null, ['class' => 'form-control', 'placeholder' => __('Invoice Amount'), 'readonly' => 'readonly']) }}
                @error('total_amount')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                {{ Form::label('amount', __('Paid Amount'), ['class' => 'form-label']) }}
                {{ Form::number('amount', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Paid Amount')]) }}
                @error('amount')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                {{ Form::label('status', __('Payment Status'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                <select class="form-select" id="payment-status"  name="status" required>
                    <option value="" selected disabled>Select Payment Status</option>
                    <option value="Full" {{($payment->status=='Full')?'selected' :'' }}>Full</option>
                    <option value="Partial" {{($payment->status=='Partial')?'selected' :'' }}>Partial</option>
                  

                  </select>
            </div>
        </div>
    

        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('payment_method', __('Payment Method'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
               <select class="form-select" id="payment-method" name="payment_method">
                    <option value="" selected disabled>Select payment method</option>
                    <option value="Cash" {{($payment->payment_method=='Cash')?'selected' :'' }}>Cash</option>
                    <option value="Bank Transfer" {{($payment->payment_method=='Bank Transfer')?'selected' :'' }}>Bank Transfer</option>
                    <option value="Debit Card" {{($payment->payment_method=='Debit Card')?'selected' :'' }}>Debit Card</option>
                    <option value="Credit Card" {{($payment->payment_method=='Credit Card')?'selected' :'' }}>Credit Card</option>

                  </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('payment_date', __('Payment Date'), ['class' => 'form-label']) }}
                {{ Form::date('payment_date',date('Y-m-d',strtotime($payment->payment_date)), ['class' => 'form-control','required'=>'required', 'placeholder' => __('Payment Date')]) }}
                @error('payment_date')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('reference_no', __('Transaction Id'), ['class' => 'form-label']) }}
                {{ Form::text('reference_no', null, ['class' => 'form-control', 'placeholder' => __('Transaction Id')]) }}
                @error('reference_no')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                {{ Form::label('note', __('Note'), ['class' => 'form-label']) }}
                {{ Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __('Note')]) }}
                @error('note')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        
    </div>

</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script type="text/javascript">
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