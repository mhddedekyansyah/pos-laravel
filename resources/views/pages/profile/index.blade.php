@extends('layouts.app', ['title' => 'POS | Profile'])

@section('content')
    <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            @include('partials.alert_message')
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Profile</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <img id="image-profile" src="{{ empty($user->image) ? asset('assets/images/no_image.jpg') : Storage::url($user->image->image) }}" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image">

                                        <h4 class="mb-0" id="profile-name">{{ $user->name ?? '-' }}</h4>
                                        <p class="text-muted">@webdesigner</p>

                                        

                                        <div class="text-start mt-3">
                                        
                                            <p class="text-muted mb-2 font-13 "><strong>Full Name :</strong> <span class="ms-2 name">{{ $user->name }}</span></p>
                                        
                                            <p class="text-muted mb-2 font-13 "><strong>Mobile :</strong><span class="ms-2 phone">{{ $user->phone }}</span></p>
                                        
                                            <p class="text-muted mb-2 font-13 "><strong>Email :</strong> <span class="ms-2 email">{{ $user->email }}</span></p>
                                        
                                        </div>                                      
                                    </div>                                 
                                </div> <!-- end card -->


                            </div> <!-- end col-->

                            <div class="col-lg-8 col-xl-8">
                                <div class="card">
                                    <div class="card-body">
                                          <form id='form-profile' enctype="multipart/form-data">

                                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal Info</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Full Name</label>
                                                                <input type="text" name="name" value="{{ old('name') ?? $user->name }}" class="form-control" id="name" placeholder="Enter Full Name">
                                                                <small class="text-muted"><p class="text-danger" id="name-error"></p></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="phone" class="form-label">Phone</label>
                                                                <input type="number" name="phone" value="{{ old('phone') ?? $user->phone }}" class="form-control" id="phone" placeholder="Enter Phone Number">
                                                                <small class="text-muted"><p class="text-danger" id="name-error"></p></small>
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="useremail" class="form-label">Email Address</label>
                                                                <input type="email" disabled name="email" value="{{ $user->email }}" class="form-control" id="useremail" placeholder="Enter email">
                                                                <small class="text-muted">Email tidak bisa di ubah</small>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="image" class="form-label">Image</label>
                                                            <input type="file" name="image" id="image" class="form-control">
                                                            <small class="text-muted"><p class="text-danger" id="name-error"></p></small>
                                                            <img id="image-preview" src="{{ empty($user->image) ? asset('assets/images/no_image.jpg') : Storage::url($user->image->image) }}" alt="pic" class="mt-3 rounded-circle avatar-lg img-thumbnail"/>
                                                        </div>
                                                    </div> <!-- end row -->
    
                                                    <div class="text-end">
                                                        <button id="save-profile" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                                    </div>
                                                </form>
                                    </div>
                                </div> <!-- end card-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->
@endsection

@push('scripts')
    <script>    
$(document).ready(()=>{
      $('#image').change(function(){
        const file = this.files[0];
       
        if (file){
          let reader = new FileReader();
          reader.onload = function(event){
           
            $('#image-preview').attr('src', event.target.result);
          }
          reader.readAsDataURL(file);
        }
      });
    });

    $(document).ready(function(){

        $('#save-profile').click(function(event){
            event.preventDefault();
            
            let form = $('#form-profile')[0]
            let formData = new FormData(form)
            console.log(formData)
           
            
            $.ajax({
                url: '{{ route("profile.update") }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(res){
                    console.log(res)
                    showAlert(res.message, 'success')
                    resetForm(form)
                    $('#profile-name').text(res.data.name)
                    if(res.data.image){
                        $('#image-profile').attr('src', `{{ Storage::url('${res.data.image.image}') }}`)
                        $('.image-profile').attr('src', `{{ Storage::url('${res.data.image.image}') }}`)
                    }
 
                    $.each(res.data, function(name, value){
                        $(`.${name}`).text(value)
                        $(`[name=${name}]`).val(value)
                    })

                },
                error: function(err){
                    console.log(err)
                    if(err.status == 422){
                        loopErrors(err.responseJSON.errors)
                        return;
                    }
                }
            })

        })
    })

    function showAlert(message, type){
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

           if(type == 'error'){
               toastr.error(message, 'Failed !');
            }
            toastr.success(message, 'Success !');
        }

        function loopErrors(errors){
            $('.invalid-feedback').remove();

            if(errors == undefined){
                return;
            }

             $.each(errors, function(name, value){
                    $(`#${name}`).addClass('is-invalid')
                    $(`<small class="text-danger invalid-feedback">${value[0]}</small>`).insertAfter(`#${name}`)
                       
                return;
            })
        }   

        function resetForm(form){
            $('#modal-category').modal('hide');
            $('.form-control').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            form.reset();
        }
    </script>
@endpush