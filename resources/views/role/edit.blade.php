{{Form::model($role,array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="mb-3">
                {{Form::label('name',__('Name'),['class'=>'form-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Role Name'),'required' => 'required'))}}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
            <div class="col-12">
              <h5>Role Permissions</h5>
              <!-- Permission table -->
              <div class="table-responsive">
                <table class="table table-flush-spacing">
                  <tbody>
                    <tr>
                      <td class="text-nowrap fw-medium">
                        Administrator Access
                        <i
                          class="ti ti-info-circle"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="Allows a full access to the system"></i>
                      </td>
                      <td>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="selectAll" />
                          <label class="form-check-label" for="selectAll"> Select All </label>
                        </div>
                      </td>
                    </tr>
                    @foreach($permissions as $permi)
                    <tr>
                      <td class="text-nowrap fw-medium">{{ ucfirst($permi->group_name )}} Management</td>
                      <td>
                        <div class="d-flex">
                            @php

                            $permission = \DB::table('permissions')->where('group_name',$permi->group_name)->get();

                            @endphp

                            @foreach($permission as $per)
                            @php
                            $namep = explode('-',$per->name);

                            @endphp
                          <div class="form-check me-3 me-lg-5">
                            {{ Form::checkbox('permissions[]', $per->id, in_array($per->id, $rolePermissions) ? true : false, array('class' => 'form-check-input permission-checkbox', 'id'=>'')) }}

                            <label class="form-check-label" for="{{ $per->name }}"> {{ (!empty(@$namep[1])) ? @$namep[1] : $per->name  }} </label>
                          </div>
                          @endforeach
                         
                        </div>
                      </td>
                    </tr>
                    @endforeach
                   
                  </tbody>
                </table>
              </div>
              <!-- Permission table -->
            </div>

            
                
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}


<script>
    $(document).ready(function() {
        const $selectAll = $('#selectAll');
        const $permissionCheckboxes = $('.permission-checkbox');

        if ($selectAll.length === 0) return; // If selectAll is not found, exit early

        // When "Select All" checkbox is changed
        $selectAll.on('change', function() {
            $permissionCheckboxes.prop('checked', $(this).prop('checked'));
        });

        // When any individual checkbox is changed
        $permissionCheckboxes.on('change', function() {
            const allChecked = $permissionCheckboxes.length === $permissionCheckboxes.filter(':checked').length;
            $selectAll.prop('checked', allChecked);
        });
    });
</script>