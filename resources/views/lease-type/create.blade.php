{{Form::open(array('url'=>'lease-type','method'=>'post'))}}
<div class="modal-body">

    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                {{Form::label('name',__('Name'),['class'=>'form-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter  Name'),'required'=> 'required'))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                {{Form::label('display_name',__('Display Name'),['class'=>'form-label'])}}
                {{Form::text('display_name',null,array('class'=>'form-control','placeholder'=>__('Display Name'),'required'=> 'required'))}}
                @error('display_name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>  
        <div class="col-12">
            <div class="mb-3">
                 {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Description'),'rows'=>3]) }}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>    
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
    {{Form::close()}}

