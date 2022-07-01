<form action="{{ route('admin.customer.autrize') }}" method="post">
     @csrf
     <input type="hidden" name="id" value="{{ $customer->id }}" />
     <input type="hidden" value="{{ ($customer->name)?  $customer->name : '' }}" id="name">
     <input type="hidden" value="{{ ($customer->dob)? $customer->dob : '' }}" id="dob">
     <input type="hidden" value="{{ ($customer->country->id)? $customer->country->id: '' }}" id="country">

    @php
        $checkValue = App\Models\SanctionCheck::findorFail(1);
    @endphp
    @if($customer->sanction_score > $checkValue->sanction_value)
        <div class="col-12">
            <div class="form-group">
                <label for="message-text" class="col-form-label">Please provide the reason to authorise sanction data:</label>
                <input type="text" name="remarks" class="form-control field" id="remarks">
            </div>
        </div>
    @endif

     <div class="col-12">
         <div class="form-group">
             <label>Sanction screening result (%)</label>
             <input type="text" name="sanctionsScreening" id="sanctionsScreening" class="form-control text-danger font-weight-bold" readonly />
             @error('sanctionsScreening')
             <span class="text-danger">{{ $message }}</span>
             @enderror
             <input type="hidden" name="sanction_table" id="sanction_table">
         </div>
     </div>
     <div class="modal-footer">
         <button type="button" onclick="authSubmit()" class="btn btn-success authorize_btn">Authorize</button>
     </div>
</form>


