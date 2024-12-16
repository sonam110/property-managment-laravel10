
<div class="modal-body">
    <div class="row">
        <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="4" class="text-center bg-primary text-white">Basic Information</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>First Name</th>
                <td>{{ $user->first_name }}</td>
                <th>Middle Name</th>
                <td>{{ $user->middle_name }}</td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td>{{ $user->last_name }}</td>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $user->mobile }}</td>
                <th>City</th>
                <td>{{ $user->city }}</td>
            </tr>
            <tr>
                <th>User Role</th>
                <td>{{ $user->role->name }}</td>
                <th>GST NO</th>
                <td>{{ $user->role->gst_no }}</td>
            </tr>
            <tr>
                <th>PAN NO</th>
                <td>{{ $user->role->pan_no }}</td>
                <th>Postal Address</th>
                <td>{{ $user->role->postal_address }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th colspan="8" class="text-center bg-primary text-white">Banking Information</th>
            </tr>
            <tr>
                <th>#</th>
                <th>For Invoice</th>
                <th>Bank Nick Name</th>
                <th>Bank Name</th>
                <th>Account Holder Name</th>
                <th>Account No</th>
                <th>IFSC Code</th>
                <th>Bank Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach($partnerBanks as $key => $detail)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>
                    @if($detail->for_type == 1) Rent
                    @elseif($detail->for_type == 2) CAM
                    @elseif($detail->for_type == 3) Utility
                    @else - 
                    @endif
                </td>
                <td>{{ $detail->bank_se_name }}</td>
                <td>{{ $detail->bank_name }}</td>
                <td>{{ $detail->account_holder_name }}</td>
                <td>{{ $detail->account_no }}</td>
                <td>{{ $detail->bank_ifsc_code }}</td>
                <td>{{ $detail->bank_address }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>

