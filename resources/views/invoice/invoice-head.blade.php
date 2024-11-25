<div class="card">
    <div class="card-body">
     <!--  <button
        class="btn btn-primary"
        data-bs-toggle="offcanvas"
        data-bs-target="#sendInvoiceOffcanvas">
        <span class="d-flex align-items-center justify-content-center text-nowrap"
          ><i class="ti ti-send ti-xs me-2"></i>Send Invoice</span
        >
      </button> -->
      <button class="btn btn-label-primary"  data-ttype="dropdown" id="downloadPdfButton">Download</button>
      <a
        class="btn btn-label-danger"
        id="downloadPdfButton"
        data-ttype="print"
        href="javascript:;">
        Print
      </a>
      @if($data->status !='Paid' && $data->status !='Sent')
      <a href="{{ route('invoice-edit',$data->id) }}" class="btn btn-label-warning">
        Edit Invoice
      </a>
         @endif
      @if($data->payment_status!='Full' && $data->status=='Sent')
      <button
        class="btn btn-primary"
        data-bs-toggle="offcanvas"
        data-bs-target="#addPaymentOffcanvas">
        <span class="d-flex align-items-center justify-content-center text-nowrap"
          >Add Payment</span
        >
      </button>
      @endif

    </div>
  </div>