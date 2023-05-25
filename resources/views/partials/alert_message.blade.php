{{-- @if (session()->has('success')) --}}
      <div class="row justify-content-center mt-3 d-none" id="success-alert">
          <div class="col-6">
            <div class="alert alert-success" role="alert" id="alert-message">
                <i class="mdi mdi-check-all me-2"></i>
            </div>
          </div>
      </div>
        
{{-- @endif --}}
{{-- @if (session()->has('error')) --}}
   {{-- <div class="row justify-content-center mt-3 d-none" id='error-alert'>
          <div class="col">
            <div class="alert alert-danger" role="alert" id="alert-message-error">
                <i class="mdi mdi-block-helper me-2"></i> error
            </div>
          </div>
      </div> --}}
{{-- @endif --}}