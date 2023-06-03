@extends('layouts.app', ['title' => 'POS | Supplier'])
@section('content')
    <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Supplier</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Supplier</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-end mb-3">
                                      
                                                <button onclick="addForm(`{{ route('supplier.store') }}`)" class="btn btn-primary btn-sm add-category" >Add Supplier </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <form id='form'>
                                                    <table id="table" class="table dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Image</th>
                                                            <th>Name</th>
                                                            <th>Address</th>
                                                            <th>Phone</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->


                    </div> <!-- container -->

                </div>
                @include('pages.supplier.form')
@endsection

@push('scripts')
    <script>
      $(document).ready(function(){
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
        // Reload DataTables
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('supplier.data') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',  orderable: false, searchable: false,},
                {data: 'image.image', name: 'image.image', orderable: false, searchable: false,},
                {data: 'supplier_name', name: 'supplier_name'},
                {data: 'address', name: 'address'},
                {data: 'phone', name: 'phone'},
                
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                },
            ]
        })
      })

    //   Add Modal Category
    function addForm(url){
        $('#modal-supplier').modal('show');
        $('#modal-supplier .modal-title').text('Create Supplier');
        $('#modal-supplier form').attr('action', url);
        $('#modal-supplier [name=_method]').val('POST');
        let form = $('#form-supplier')[0];
        resetForm(form);
    }

    //   Delete Category
    function deleteData(url){
         Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
                url,
                type: 'delete',
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(res){
                    showAlert(res.message, res.type);
                    $('#table').DataTable().ajax.reload();
                    console.log(res)
                },
                error: function(err){
                    console.log(err)
                }
            })
        }
    })
    }


 // Edit Category
 function editForm(urlEdit, urlUpdate){
        $.ajax({
            url: urlEdit,
            success: function(res){
                console.log(res.data)
                $('#modal-supplier').modal('show');
                $('#modal-supplier .modal-title').text('Edit Supllier');
                $('#modal-supplier form').attr('action', urlUpdate);
                $('#modal-supplier [name=_method]').val('put');

                let form = $('#form-supplier')[0];
                resetForm(form);
                $.each(res.data, function(name, value){
                    console.log(name)
                    console.log(value)
                    if($(`[name=${name}`).attr('type') != 'file'){
                        $(`[name=${name}`).val(value);
                    }else{
                        $(`#${name}-preview`).attr('src', `{{ Storage::url('${value[name]}') }}`)
                    }
                })
              
            },
            error: function(err){
                showAlert(err.message, 'error')
                console.log(err)
            }
        })
}
    

    //   Save Category
    function submitForm(form){

        $.ajax({
            url: $(form).attr('action'),
            data:  new FormData(form),
            type: 'POST',
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(res){
                $('#modal-supplier').modal('hide');
                showAlert(res.message, res.type);
                $('#table').DataTable().ajax.reload();
                console.log(res)
            },
            error: function(err){
                console.log(err)
                if(err.status == 422){
                    loopErrors(err.responseJSON.errors)
                    return;
                }
            }
        })
    }
  
      
        function resetForm(form){
            $('#modal-supplier').modal('hide');
            $('.form-control').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            $(`#image-preview`).attr('src', `{{ asset('assets/images/no_image.jpg') }}`)
            form.reset();
        }

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

        
    </script>
@endpush