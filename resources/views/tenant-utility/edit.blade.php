

{{Form::model($tenantUtility,array('route' => array('tenant-utility.update', $tenantUtility->id), 'method' => 'PUT','enctype'=>'multipart/form-data', 'files'=>true)) }}
<div class="modal-body">
    <div class="row">
      
        <div class="col-sm-6">
            <div class="mb-3">
                {{ Form::label('property_id', __('Properties'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                {!! Form::select('property_id', ['' => __('Select Property')] + $properties, $tenantUtility->property_id, ['class' => 'form-control select property_id select2 form-select', 'id' => 'property_id']) !!}
               
                @error('property_id')
                    <small class="invalid-email" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
         <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('bill_date', __('Date'), ['class' => 'form-label']) }}<span class="requiredLabel">*</span>
                {{ Form::date('bill_date',null, ['class' => 'form-control','required'=>'required', 'placeholder' => __('Date')]) }}
                @error('bill_date')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('energy_charge', __('Energy Charge'), ['class' => 'form-label']) }}
                {{ Form::number('energy_charge', null, ['class' => 'form-control','id'=>'energy_charge','required'=>'required', 'placeholder' => __('Energy Charge')]) }}
                @error('energy_charge')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('fppas', __('FPPAS'), ['class' => 'form-label']) }}
                {{ Form::number('fppas', null, ['class' => 'form-control','id'=>'fppas','required'=>'required', 'placeholder' => __('FPPAS')]) }}
                @error('fppas')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('energy_duty', __('Energy Duty'), ['class' => 'form-label']) }}
                {{ Form::number('energy_duty', null, ['class' => 'form-control','id'=>'energy_duty','required'=>'required', 'placeholder' => __('Energy Duty')]) }}
                @error('energy_duty')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
         <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('tod_net_sum', __('TOD (Net sum)'), ['class' => 'form-label']) }}
                {{ Form::number('tod_net_sum', null, ['class' => 'form-control','id'=>'tod_net_sum','required'=>'required', 'placeholder' => __('TOD (Net sum)')]) }}
                @error('tod_net_sum')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('energy_charge_as_per_bill', __('Energy Charge As Per Bill'), ['class' => 'form-label']) }}
                {{ Form::number('energy_charge_as_per_bill', null, ['class' => 'form-control','id'=>'energy_charge_as_per_bill','readonly'=>'readonly', 'placeholder' => __('Energy Charge As Per Bill')]) }}
                @error('energy_charge_as_per_bill')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::label('total_units', __('Total Units Consumed As per bill'), ['class' => 'form-label']) }}
                {{ Form::number('total_units', null, ['class' => 'form-control','id'=>'total_units','required'=>'required', 'placeholder' => __('Total Units Consumed As per bill')]) }}
                @error('total_units')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
       
        <div id="tenantUnitContainer" class=""> 
            @foreach($tenantDetails as $key=> $detail)
                <div class="row g-3 textBoxWrapper">
                <div class="col-md-4">
                    <div class="mb-3">
                        {{ Form::label('tenant_id', __('Tenant'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                        {!! Form::select('tenant_id[]', ['' => __('Select Tenant')] + $tenants, $detail['tenant_id'], ['class' => 'form-control select tenant_id select2 form-select', 'id' => 'tenant_id']) !!}
                        @error('tenant_id')
                            <small class="invalid-email" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        {{ Form::label('no_units_consume', __('No of Units Consumed'), ['class' => 'form-label']) }}<span class="requiredLabel">*</span>
                        {{ Form::number('no_units_consume[]', $detail['no_units_consume'], ['class' => 'form-control no_units_consume', 'required' => 'required', 'placeholder' => __('No of units consumed')]) }}
                        @error('no_units_consume')
                            <small class="invalid-name" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                 <div class="col-sm-1"><button type="button" class="removeButton btn btn-danger btn-sm" style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div>
                @if($key+1 ==1)
                 <div class="col-md-3" style="margin-top: 23px;">
                    <div class="mb-3">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary" id="addMoreButton">+ Add More</button>
                    </div>
                </div>
                @endif
            </div>
                @endforeach
        </div>
            

         <div class="col-md-4">
                <div class="mb-3">
                    {{ Form::label('per_unit_charge', __('Per Unit Charge'), ['class' => 'form-label']) }}
                    {{ Form::text('per_unit_charge', null, ['class' => 'form-control', 'id' => 'per_unit_charge', 'readonly' => 'readonly']) }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    {{ Form::label('unit_lost', __('Units Lost'), ['class' => 'form-label']) }}
                    {{ Form::text('unit_lost', null, ['class' => 'form-control', 'id' => 'unit_lost', 'readonly' => 'readonly']) }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    {{ Form::label('energy_losses', __('Energy Losses'), ['class' => 'form-label']) }}
                    {{ Form::text('energy_losses', null, ['class' => 'form-control', 'id' => 'energy_losses', 'readonly' => 'readonly']) }}
                </div>
            </div>
             <div class="col-md-4">
                <div class="mb-3">
                    {{ Form::label('energy_losses_per_tenant_unit', __('Energy Losses Per Tenant unit'), ['class' => 'form-label']) }}
                    {{ Form::text('energy_losses_per_tenant_unit', null, ['class' => 'form-control', 'id' => 'energy_losses_per_tenant_unit', 'readonly' => 'readonly']) }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    {{ Form::label('energy_unit_per_unit', __('Energy Unit Per Unit'), ['class' => 'form-label']) }}
                    {{ Form::text('energy_unit_per_unit', null, ['class' => 'form-control', 'id' => 'energy_unit_per_unit', 'readonly' => 'readonly']) }}
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
    var i =0
  $("#addMoreButton").click(function(){
    i++;
        var textBoxHtml = '<div class="row g-3 textBoxWrapper"> <div class="col-sm-4"> <div class="mb-3"> <label for="tenant_id" class="form-label">Tenant</label><span class="requiredLabel">*</span> <select name="tenant_id[]" class="form-control select tenant_id select2 form-select" id="tenant_id'+i+'"> <option value="">Select Tenant</option> </select> </div> </div> <div class="col-md-4"> <div class="mb-3"> <label for="no_units_consume" class="form-label">No of Units Consumed</label><span class="requiredLabel">*</span> <input type="number" name="no_units_consume[]" class="form-control no_units_consume" required="required" placeholder="No of units consumed" /> </div> </div>  <div class="col-sm-4"> <label for="button" class="form-label">&nbsp;<label><button type="button" class="removeButton btn btn-sm btn-danger"  style="margin:10px; margin-top: 28px;"><i class="ti ti-trash text-white"></i></button>  </div></div> <br>';
        
        gettenants(i);
        $("#tenantUnitContainer").append(textBoxHtml);
    });

    // Remove text box
    $("#tenantUnitContainer").on("click", ".removeButton", function(){
        $(this).closest(".textBoxWrapper").remove();
        validateTotalUnits();
    });

$(document).on("input change", ".no_units_consume", function () {
    validateTotalUnits();
});
function validateTotalUnits() {
        let totalUnitsAllowed = parseFloat($("#total_units").val()) || 0; // Total units from the input
        let totalUnitsEntered = 0;

        // Sum up all entered units
        $(".no_units_consume").each(function () {
            totalUnitsEntered += parseFloat($(this).val()) || 0;
        });

        // Validation check
        if (totalUnitsEntered > totalUnitsAllowed) {
            $(".no_units_consume").addClass("is-invalid"); // Highlight invalid fields if needed
            toastr.error("The total units consumed cannot exceed the Total Units.");
            //alert("The total units consumed cannot exceed the Total Units.");
        } else {
            $(".no_units_consume").removeClass("is-invalid"); // Remove invalid highlighting
        }
    }
$("form").on("submit", function (e) {
    let totalUnitsAllowed = parseFloat($("#total_units").val()) || 0;
    let totalUnitsEntered = 0;

    $(".no_units_consume").each(function () {
        totalUnitsEntered += parseFloat($(this).val()) || 0;
    });

    if (totalUnitsEntered > totalUnitsAllowed) {
        e.preventDefault(); // Prevent form submission
         toastr.error("Fix the total units before submitting the form.");
        
    }
});

 $('.property_id').change(function() {
        var property_id = $(this).val();
        //alert(tenantId);
        if (property_id) {
            $.ajax({
              url: appurl + "get-tenant-list",
              type: "post",
              headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              data: { property_id: property_id },
              success: function(response) {
                  $(".tenant_id").html(response);
              }
          });
           
        } else {
            $('.tenant_id').empty().append('<option value="">{{ __("Select tenant") }}</option>');
        }
    });
});

function gettenants(divid){
    var property_id = $('.property_id').val();
    //alert(tenantId);
    if (property_id) {
        $.ajax({
          url: appurl + "get-tenant-list",
          type: "post",
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          data: { property_id: property_id },
          success: function(response) {
              $("#tenant_id"+divid).html(response);
          }
      });
       
    } else {
        $('.tenant_id').empty().append('<option value="">{{ __("Select tenant") }}</option>');
    }
}

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
  $(document).on("input chnage keyup", "#energy_charge,#fppas,#energy_duty,#tod_net_sum ,#total_units,.no_units_consume", function () {
    calculateEnergyDetails();
});

function calculateEnergyDetails() {

    // Fetch input values
    let energyCharge = parseFloat($("#energy_charge").val()) || 0;
    
    let fppas = parseFloat($("#fppas").val()) || 0;
    let energy_duty = parseFloat($("#energy_duty").val()) || 0;
    let tod_net_sum = parseFloat($("#tod_net_sum").val()) || 0;
     console.log(tod_net_sum);
    let energy_charge_as_per_bill = energyCharge+fppas+energy_duty+(tod_net_sum);
    $("#energy_charge_as_per_bill").val(energy_charge_as_per_bill);
    let totalUnits = parseFloat($("#total_units").val()) || 0;
    let totalTenantUnit = 0;

    // Calculate total units consumed by tenants
    $(".no_units_consume").each(function () {
        totalTenantUnit += parseFloat($(this).val()) || 0;
    });

    // Perform calculations
    if (totalUnits > 0 && totalTenantUnit > 0) {
        let perUnitCharge = energy_charge_as_per_bill / totalUnits;
        let unitLost = totalUnits - totalTenantUnit;
        let energyLosses = unitLost * perUnitCharge;
        let energyLossesPerTenantUnit = energyLosses / totalTenantUnit;
        let energyUnitPerUnit = perUnitCharge + energyLossesPerTenantUnit;

        // Update calculated fields
        $("#per_unit_charge").val(perUnitCharge.toFixed(2));
        $("#unit_lost").val(unitLost.toFixed(2));
        $("#energy_losses").val(energyLosses.toFixed(2));
        $("#energy_losses_per_tenant_unit").val(energyLossesPerTenantUnit.toFixed(2));
        $("#energy_unit_per_unit").val(energyUnitPerUnit.toFixed(2));
    } else {
        // Clear fields if inputs are invalid
        $("#per_unit_charge").val("");
        $("#unit_lost").val("");
        $("#energy_losses").val("");
        $("#energy_losses_per_tenant_unit").val("");
        $("#energy_unit_per_unit").val("");
    }
}
</script>