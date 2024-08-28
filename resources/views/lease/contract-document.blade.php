@extends('layouts.master')
@section('extracss')
<!-- include summernote css/js -->
<!-- Summernote CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">



@endsection
@section('page-title')
    {{ __('Contract Document') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('users.index')}}">{{__('Lease Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Contract Document')}}</li>
@endsection
@section('content')

<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-3"></h5>
      <div class="row">
          <div class="col-sm-9">
              <div class="form-group">
                  <label for="content">Content:</label>
                  <textarea id="content" name="content" class="form-control">fhgjhj{!! $appSetting->document !!}</textarea>
              </div>
          </div>
          <div class="col-sm-3">
            <div class="card rounded-0 shadow-sm border-0 h-100 tag-div"> 
              <div class="card-header fw-500">  Tags </div> 
              <div class="card-body"> 
               <div class="row mb-3"> 
                
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{owner_name}</small></span> </div>
                </div> 
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{owner_address}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{owner_phone}</small></span> </div>
                </div>
               
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{owner_email}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{property_name}</small></span> </div>
                </div> 
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{property_code}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_area_of_sq}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{property_address}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{tenant_name}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{tenant_address}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{tenant_phone}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{tenant_email}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_start_date}</small></span> </div>
                </div>
               
                 <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{monthly_rent_amount}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_area_of_sq}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_price_per_sq}</small></span> </div>
                </div>
               
                 <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_units}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_end}</small></span> </div>
                </div>
                 <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_cam}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_deposit}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_extra_charges}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_utilities}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_total_deposit}</small></span> </div>
                </div>
                <div class="col-sm-12"> 
                  <div class=" alert-light  py-1 mb-0 rounded-0 " > <span class="fw-500"><small>{lease_total_extra_charge}</small></span> </div>
                </div>
                <br>
                <br>

                <div class="col-sm-12"> 
                    {{ Form::label('lease_id', __('Select Lease'), ['class' => 'form-label']) }} <span class="requiredLabel">*</span>
                      {!! Form::select('lease_id', ['' => __('Select Lease')] + $data, null, ['class' => 'form-control select lease_id select2 form-select', 'id' => 'lease_id']) !!}
                      @error('lease_id')
                          <small class="invalid-email" role="alert">
                              <strong class="text-danger">{{ $message }}</strong>
                          </small>
                      @enderror
                  
                </div>
                 &nbsp;&nbsp;&nbsp;

                <button class="btn btn-primary btn-next" id="pdfPreviewButton" >
                      <span class="align-middle d-sm-inline-block d-none me-sm-1">PDF PREVIEW</span>
                      <i class="ti ti-arrow-right ti-xs"></i>
                    </button>
              </div>
      </div> 
  </div>
  
</div>
<!-- PDF Preview Modal -->
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfPreviewModalLabel">PDF Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfIframe" src="" style="width: 100%; height: 600px;" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extrajs')     
 
<!-- Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Summernote
        $('#content').summernote({
            height: 1000, // Set the height of the editor
            // Customize options here
        });

        // Fetch lease data and update Summernote content
        $('#lease_id').change(function() {
            var leaseId = $(this).val();
            var content = $('#content').val();
            if (leaseId) {
                $.ajax({
                    url: '{{ route('leases.fetch') }}', // Route to fetch lease data
                    type: 'POST',
                    data: { id: leaseId,content:content },
                    success: function(response) {
                        // Update Summernote with lease content
                        $('#content').summernote('code', response.content);
                        $('#pdfPreviewButton').prop('disabled', false); // Enable PDF preview button
                    }
                });
            } else {
                $('#content').summernote('code', '');
                $('#pdfPreviewButton').prop('disabled', true); // Disable PDF preview button
            }
        });

        // Open PDF preview modal
        $('#pdfPreviewButton').click(function() {
            var leaseId = $('#lease_id').val();
            if (leaseId) {
                var content = $('#content').summernote('code');
                var pdfUrl = '{{ route('leases.preview', ':id') }}'.replace(':id', leaseId);

                // Send content to server to generate PDF
                $.ajax({
                    url: pdfUrl,
                    type: 'POST',
                    data: {
                        content: content,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Assuming response contains the URL to the generated PDF
                        $('#pdfIframe').attr('src', response.pdfUrl);
                        $('#pdfPreviewModal').modal('show');
                    }
                });
            }
        });

    });
</script>
@endsection