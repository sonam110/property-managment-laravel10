<!-- Add Payment Sidebar -->
          
          <div class="offcanvas offcanvas-end" id="addPaymentOffcanvas" aria-hidden="true">


            <div class="offcanvas-header mb-3">
              <h5 class="offcanvas-title">Add Payment</h5>
              <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
               {!! Form::hidden('invoice_id',$data->id,array('class'=>'form-control invoice_id')) !!}
             {!! Form::hidden('type',$data->invoice_type,array('class'=>'form-control type')) !!}
             {!! Form::hidden('grand_total',$grand_total,array('class'=>'form-control grand_total')) !!}
             {!! Form::hidden('totalAmount',$invoiceBalance,array('class'=>'form-control totalAmount')) !!}
              <div class="d-flex justify-content-between bg-lighter p-2 mb-3">
                <p class="mb-0">Invoice Balance:</p>
                <p class="fw-medium mb-0 invoice-balance" > {{ formatIndianCurrency($invoiceBalance) }}</p>
              </div>

               <div class="d-flex justify-content-between bg-lighter p-2 mb-3">
                <p class="mb-0">Remaining Balance:</p>
                <p class="fw-medium mb-0 remaining">{{ (!empty($data->remaining_amount)) ?  formatIndianCurrency($data->remaining_amount) : 0 }}</p>
              </div>
              <form>
                
                <div class="mb-3">
                  <label class="form-label" for="invoiceAmount">Payment Amount</label><span class="requiredLabel">*</span>
                  <div class="input-group">
                    <span class="input-group-text"> </span>
                    <input
                      type="text"
                      id="invoiceAmount"
                      name="invoiceAmount"
                      class="form-control invoice-amount"
                      placeholder=""  required/>
                  </div>
                </div>
                <span class="warning" style="color:red"></span>
                <div class="mb-3">
                  <label class="form-label" for="payment-date">Payment Date</label> <span class="requiredLabel">*</span>
                  <input id="payment-date"  class="form-control invoice-date" type="date"  required/>
                </div>
                
                <div class="mb-3">
                  <label class="form-label" for="payment-method">Payment Method</label><span class="requiredLabel">*</span>
                  <select class="form-select" id="payment-method" required>
                    <option value="" selected >Select payment method</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="Credit Card">Credit Card</option>
                     <option value="UPI">UPI</option>
                    <option value="cheque">Cheque</option>

                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="reference_no">Transaction Id</label>
                  <div class="input-group">
                    <span class="input-group-text"> </span>
                    <input
                      type="text"
                      id="reference_no"
                      name="reference_no"
                      class="form-control reference_no"
                      placeholder=""  />
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="payment_image">Payment Receipt </label>
                  <input id="payment_image" class="form-control payment_image" type="file" >
                  
                  </select>
                </div>
                <div class="mb-4">
                  <label class="form-label" for="payment-note">Internal Payment Note</label>
                  <textarea class="form-control" id="payment-note" rows="2"></textarea>
                </div>
                <div class="mb-3 d-flex flex-wrap">
                  <button type="button" class="btn btn-primary me-3 submitForm" data-bs-dismiss="offcanvas" data-type="submit">Save</button>
                  <button type="button" class="btn btn-primary me-3 submitForm" data-bs-dismiss="offcanvas" data-type="send">Save & Send</button>
                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /Add Payment Sidebar -->
