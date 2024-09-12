{{Form::model($expense,array('route' => array('expense.update', $expense->id), 'method' => 'PUT','enctype'=>'multipart/form-data', 'files'=>true)) }}
<input type="hidden" name="old_receipt" value="{{ $expense->receipt }}">
<div class="modal-body">
    <div class="row">
        <div class="col-sm-6">
            {{ Form::label('property_id', __('Properties'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
            {!! Form::select('property_id', ['' => __('Select Property')] + $properties, $expense->property_id, ['class' => 'form-control select property_id select2 form-select', 'id' => 'property_id','required'=>'required']) !!}
            @error('property_id')
                <small class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
            @enderror
        </div>
         <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('type', __('Type'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                <select class="form-select" id="payment-type"  name="type" required>
                    <option value="" selected disabled>Select Type</option>
                    <option value="1" {{($expense->type=='1')?'selected' :'' }}>CAM</option>
                    <option value="2" {{($expense->type=='2')?'selected' :'' }} >Utility</option>
                  

                  </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('price', __('Price'), ['class' => 'form-label']) }}
                {{ Form::number('price', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Price')]) }}
                @error('price')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        
       
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('ex_date', __('Date'), ['class' => 'form-label']) }}
                {{ Form::date('ex_date',date('Y-m-d',strtotime($expense->ex_date)), ['class' => 'form-control','required'=>'required', 'placeholder' => __('Date')]) }}
                @error('ex_date')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Description'),'rows'=>3]) }}
                @error('description')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                {{ Form::label('note', __('Note'), ['class' => 'form-label']) }}
                {{ Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __('Note'),'rows'=>3]) }}
                @error('note')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                {{ Form::label('receipt', __('receipt'), ['class' => 'form-label']) }}
                {{ Form::file('receipt', null, ['class' => 'form-control', 'placeholder' => __('receipt'),'rows'=>3]) }}
                @error('receipt')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
                @if(!empty($expense->receipt))
                <span><a href="{{url('/')}}/{{ $expense->receipt}}" download><i class="fa fa-download"></i></a></span>
                @endif
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