@extends('layouts.master')
@section('extracss')
<link rel="stylesheet" href="{{ asset('assets/js/bootstrap-fileupload.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('page-title')
    {{ __('Manage Property') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('property.index')}}">{{__('Property Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Property')}}</li>
@endsection

@section('content')
    <div id="wizard-property-listing" class="bs-stepper vertical mt-2">
                <div class="bs-stepper-header">
                  <div class="step active" data-target="#property-detail">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-users ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Property Detail</span>
                      
                      </span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#payment-setting">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-circle"><i class="ti ti-currency-dollar ti-sm"></i></span>
                      <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Payment Setting </span>
                       
                      </span>
                    </button>
                  </div>

                </div>
                <div class="bs-stepper-content">
                  <form id="wizard-property-listing-form" onSubmit="return false">
                     {!! Form::hidden('id',null,array('class'=>'form-control')) !!}
                    @csrf
                    <!-- Personal Details -->
                    <div id="property-detail" class="content active">
                      <div class="row g-3">
                        <div class="col-sm-6">
                            {{ Form::label('property_name', __('Property Name'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                            {{ Form::text('property_name', null, ['class' => 'form-control','id'=>'property_name','placeholder' => __('Property Name')]) }}
                            @error('property_name')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                           {{ Form::label('property_code', __('Property Code'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                            {{ Form::text('property_code', null, ['class' => 'form-control','id'=>'property_code', 'placeholder' => __('Property Code')]) }}
                            @error('property_code')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        <div class="col-sm-6">
                           {{ Form::label('property_location', __('Location'), ['class' => 'form-label']) }}
                            {{ Form::text('property_location', null, ['class' => 'form-control','id'=>'property_location', 'placeholder' => __('Location')]) }}
                            @error('property_location')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        
                        <!-- <div class="col-sm-6">
                            {{ Form::label('partners[]', __('Partners'), ['class' => 'form-label']) }}
                            <div class="select2-primary">
                                {!! Form::select('partners[]', $partners, null, [
                                    'class' => 'form-control select2 form-select',
                                    'id' => 'select2Primary',
                                    'multiple' => 'multiple', 
                                    'required' => 'required'
                                ]) !!}
                            </div>
                        </div> -->
                        
                        <div class="col-sm-12">
                          
                            <label for="units">Units</label>
                            <div id="unitsContainer">
                                <!-- Unit rows will be added here dynamically -->
                            </div>
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addUnitButton">+ Add Unit</button>

                              <span class="btn btn-outline-primary btn-file">
                              <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Import Excel</span>
                              {!! Form::file('file',array('id'=>'file','data-icon'=>'false', 'accept'=>'',  'onchange'=> 'readURL(this)')) !!}
                              </span> 
                           
                            </div>
                            
                       
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

                    <!-- Property Details -->
                    <div id="payment-setting" class="content">
                      <div class="row g-3">
                        
                        
                        <div class="col-sm-3">
                            {{ Form::label('partners[]', __('Partners'), ['class' => 'form-label']) }}
                            <div class="select2-primary">
                                {!! Form::select('partners[]', $partners, null, [
                                    'class' => 'form-control select2 form-select',
                                    'id' => 'select2Primary',
                                    'required' => 'required'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                           {{ Form::label('commission_value', __('Partner\'s share'), ['class' => 'form-label']) }}
                            {{ Form::number('commission_value[]', null, ['class' => 'form-control','id'=>'commission_value', 'placeholder' => __('Partner\'s share')]) }}
                            @error('commission_value')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                              @enderror
                        </div>
                        
                        <div class="col-sm-3">
                          <label class="form-label" for="commission_type"> Type</label>
                          <select id="commission_type" name="commission_type[]" class="form-control select2 form-select" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="1">Fixed Value</option>
                            <option value="2">% of Total Rent</option>
                          </select>
                        </div>
                        
                        <div class="col-sm-12">
                        
                            <div id="paymentContainer" class="">
                                <!-- Unit rows will be added here dynamically -->
                            </div>
                             
                            <div class="text-right mt-3">
                                <button class="btn btn-primary" id="addPartnerButton">+ Add Payment</button>
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
 <!-- Modal -->
      <div class="modal fade unitModal" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="unitModalLabel">Enter Unit Name</h5>
                        <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="unitForm">
                            <div class="row">
                             <div class="col-sm-12 mb-3">
                                {{ Form::label('unit_type', __('Unit Type'), ['class' => 'form-label']) }}
                                   {!! Form::select('unit_type', $unitTypes, null, ['class' => 'form-control select unit_type select2 form-select unit_type','id'=>'unit_type', 'required' => 'required']) !!}
                           
                            </div>
                            
                            <div class="col-sm-12 mb-3">
                                {{ Form::label('unit_floor', __('Unit Floor'), ['class' => 'form-label']) }}
                                {{ Form::text('unit_floor', null, ['class' => 'form-control unit_floor', 'id'=>'unit_floor', 'required' => 'required','placeholder' => __('Unit Floor')]) }}
                           
                            </div>
                            <div class="col-sm-6 mb-3">
                                {{ Form::label('unit_name_prefix', __('Number Prefix'), ['class' => 'form-label']) }}
                                {{ Form::text('unit_name_prefix', null, ['class' => 'form-control unit_name_prefix', 'required' => 'required', 'id'=>'unit_name_prefix','placeholder' => __('Number Prefix')]) }}
                           
                            </div>
                           
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    {{ Form::label('total_shop', __('Total Shop'), ['class' => 'form-label']) }}
                                    {{ Form::number('total_shop', null, ['class' => 'form-control total_shop', 'id'=>'total_shop','placeholder' => __('Total Rooms')]) }}
                                </div>
                           
                            </div>
                            
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="continueButton">Continue</button>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('extrajs')  
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/wizard-ex-property-listing.js') }}"></script>
    <script>
   $(document).ready(function() {
    let unitCount = 0;
    let currentInputId = '';
    let isCopyAction = false;

    function openUnitModal(inputId = '') {
        currentInputId = inputId;
        console.log(inputId);
        $('#unitModal').modal('show');

        // Pre-fill the modal with existing data if updating
        if (inputId) {
            const newInput = inputId.split('_')[1];
            const unitFloorInput = $(`#unitFloorInput_${newInput}`).val();
            const unitPrefixInput = $(`#unitPrefixInput_${newInput}`).val();
            const unitTypeInput = $(`#unitTypeInput_${newInput}`).val();
            const totalShopInput = $(`#totalShopInput_${newInput}`).val();
           
            
            $('#unit_floor').val(unitFloorInput);
            $('#unit_name_prefix').val(unitPrefixInput);
            $('#unit_type').val(unitTypeInput).trigger('change'); // Update unit type dropdown
            $('#total_shop').val(totalShopInput);
            
        } else {
            // Clear the modal fields for adding new unit
            
            $('#unit_floor').val('')
            $('#unit_name_prefix').val('');
            $('#unit_type').val('').trigger('change'); // Clear unit type dropdown
            $('#total_rooms').val('');
            $('#total_shop').val('');
        }
    }

    $('#continueButton').on('click', function() {
        const unit_floor = $('#unit_floor').val();
        const unit_name_prefix = $('#unit_name_prefix').val();
        const unit_type = $('#unit_type').val();
        const total_shop = $('#total_shop').val();

        if (currentInputId) {
            // For updating existing unit
            const newInput = currentInputId.split('_')[1];
            $(`#unitFloorInput_${newInput}`).val(unit_floor);
            $(`#unitPrefixInput_${newInput}`).val(unit_name_prefix);
            $(`#unitTypeInput_${newInput}`).val(unit_type);
            $(`#totalShopInput_${newInput}`).val(total_shop);;
        } else {
            // For adding new unit
            addUnitRow(unit_floor, unit_name_prefix, unit_type, total_shop);
        }
        $('#unitModal').modal('hide');
        currentInputId = '';
    });

    function addUnitRow(unit_floor = '', unit_name_prefix = '', unit_type = '', total_shop = '') {
        unitCount++;
        const unitRow = `
            <div class="unit-row row" id="unitRow_${unitCount}">
                <div class="col-md-9">
                    <input type="text" class="form-control" name="unit_floor[]" id="unitFloorInput_${unitCount}" value="${unit_floor}" >
                    <input type="hidden" class="form-control" name="unit_name_prefix[]" id="unitPrefixInput_${unitCount}" value="${unit_name_prefix}" >
                    <input type="hidden" class="form-control" name="unit_type[]" id="unitTypeInput_${unitCount}" value="${unit_type}" >
                    <input type="hidden" class="form-control" name="total_shop[]" id="totalShopInput_${unitCount}" value="${total_shop}" >
                </div>
                <div class="unit-actions col-md-3">
                    <button class="btn btn-secondary btn-sm copy-btn" data-id="unitInput_${unitCount}"><i class="ti ti-copy text-white"></i></button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="unitRow_${unitCount}"><i class="ti ti-trash text-white"></i></button>
                </div>
            </div><br>
        `;
        $('#unitsContainer').append(unitRow);
    }

    $('#addUnitButton').on('click', function() {
        openUnitModal();
    });

    $('#unitsContainer').on('click', 'input', function() {
        const inputId = $(this).attr('id');
        openUnitModal(inputId);
    });

    $('#unitsContainer').on('click', '.copy-btn', function() {
        const inputId = $(this).data('id');
        const newInputId = inputId.split('_')[1];
        const unit_floor = $(`#unitFloorInput_${newInputId}`).val();
        const unit_name_prefix = $(`#unitPrefixInput_${newInputId}`).val();
        const unit_type = $(`#unitTypeInput_${newInputId}`).val();
        const total_shop = $(`#totalShopInput_${newInputId}`).val();

        addUnitRow(unit_floor, unit_name_prefix, unit_type, total_shop);
        isCopyAction = true;
    });

    $('#unitsContainer').on('click', '.delete-btn', function() {
        const rowId = $(this).data('id');
        $(`#${rowId}`).remove(); // Remove the unit row
    });

    $('input[name="unit"]').on('change', function() {
        if ($('.residential').is(':checked')) {
            $('.onlyforcommercial').show();
        } else {
            $('.onlyforcommercial').hide();
        }
    });
});

 // Add text box
  $(document).ready(function(){
    /*----------------------Partner Payment-------------------*/
        $("#addPartnerButton").click(function(){
            var textBoxHtml = '<div class="row g-3 textBoxWrapper"><br><hr class="my-0" /><br> <div class="col-sm-3"> <label for="partners" class="form-label">Partners</label> <div class="select2-primary"> <select class="form-control select2 form-select"  required="required" name="partners[]"><?php foreach ($partners as $key =>  $row): ?><option value="<?php echo $key ?>"><?php echo $row ?></option><?php endforeach ?></select> </div> </div> <div class="col-sm-3"> <label for="commission_value" class="form-label">\Partner\'s share</label> <input class="form-control" id="commission_value" placeholder="\Partner\'s share" name="commission_value[]" type="text"> </div> <div class="col-sm-3"> <label class="form-label" for="commission_type">Type</label> <select id="commission_type" name="commission_type[]" class="form-control select2 form-select" > <option value="">Select</option> <option value="1">Fixed Value</option> <option value="2">% of Total Rent</option> <option value="3">% of Total collected Rent</option> </select> </div>  <div class="col-sm-3"><label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger" ><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
            $("#paymentContainer").append(textBoxHtml);
        });

        // Remove text box
        $("#paymentContainer").on("click", ".removeButton", function(){
            $(this).closest(".textBoxWrapper").remove();
        });

      

  });   
    </script>
@endsection