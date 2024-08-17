
{{Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="mb-3">
            {{Form::label('name',__('Name'))}}
            {{Form::text('name',$permission->se_name,array('class'=>'form-control','placeholder'=>__('Enter Permission Name')))}}
            @error('name')
            <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
            @enderror
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn green'))}}
</div>
{{Form::close()}}
