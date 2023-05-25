@extends('layouts.app', ['title' => 'POS | Change Password'])

@section('content')
    <div class="content">
        <div class="container-fluid">
             {{-- @include('partials.alert_message') --}}
               <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Change Password</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Change Password</h4>
                                </div>
                            </div>
                            <div class="col-lg-8 col-xl-8">
                                <div class="card">
                                    <div class="card-body">
                                          <form id='form-password'>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="old_password" class="form-label">Current Password</label>
                                                                <input type="text" name="old_password" class="form-control" id="old_password" placeholder="Enter current password">
                                                              
                                                            </div>
                                                        </div>
                                                    </div> <!-- end row -->

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                             <div class="mb-3">
                                                                <label for="password" class="form-label">New Password</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input type="password" id="password" class="form-control" placeholder="Enter your new password" name="password">
                                                                    <div class="input-group-text" data-password="false">
                                                                        <span class="password-eye"></span>
                                                                    </div>
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                             <div class="mb-3">
                                                                <label for="password-confirmation" class="form-label">Confirmation Password</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input type="password" id="password_confirmation" class="form-control" placeholder="Enter your password confirmation" name="password_confirmation">
                                                                    <div class="input-group-text" data-password="false">
                                                                        <span class="password-eye"></span>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="text-end">
                                                        <button id="save" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                                    </div>
                                                </form>
                                    </div>
                                </div> <!-- end card-->

                            </div> <!-- end col -->
        </div>
        
    </div>
@endsection

@push('scripts')
   <script>
    $(document).ready(function(){
        $('#save').click(function(e){
           
            e.preventDefault();
            
            let form = $('#form-password')[0]
            let formData = new FormData(form)
            
            
            $.ajax({
                url: '{{ route("change-password.update") }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(res){
                    console.log(res)
                     toastr.options= {
             "progressBar":true,
             "positionClass":"toast-top-right",
             "onclick":null,
             "showDuration":"300",
             "hideDuration":"1000",
             "timeOut":"3000",
             "extendedTimeOut":"1000",
             "showEasing":"swing",
             "hideEasing":"linear",
             "showMethod":"fadeIn",
             "hideMethod":"fadeOut"
           }
           toastr.success(res.message, 'Success !');
                   
                   
                  
                    form.reset()
                    $('.form-control').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                },
                error: function(err){
                   
                    $('.invalid-feedback').remove()
                    if(err.status == 422){
                        if(err == undefined){
                        return;
                    }
                    $.each(err.responseJSON.errors, function(name, value){
                        $(`#${name}`).addClass('is-invalid')
                        $(`<small class="text-danger invalid-feedback">${value[0]}</small>`).insertAfter(`#${name}`)
                       
                    return;
                    })
                }
                    
                    
                }
            })
        })
    })
   </script>
@endpush