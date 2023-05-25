@extends('layouts.app', ['title' => 'POS | Product'])
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
                                            <li class="breadcrumb-item active">Product</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Product</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            
                                        <button onclick="addForm(`{{ route('category.store') }}`)" class="btn btn-primary waves-effect waves-light add-category" >Add Category </button>
                                     
                                        </div>
                                        <table id="table" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th width="5%">
                                                        <input type="checkbox" name="select_all" id="select_all">
                                                    </th>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->


                    </div> <!-- container -->

                </div>
                @include('pages.category.form')
@endsection

{{-- @push('scripts')
    <script>
      $(document).ready(function(){
        
        // Reload DataTables
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('category.data') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',  orderable: false, searchable: false,},
                {data: 'category_name', name: 'category_name'},
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
        $('#modal-category').modal('show');
        $('#modal-category .modal-title').text('Create Category');
        $('#modal-category form').attr('action', url);
        $('#modal-category [name=_method]').val('POST');
        let form = $('#form-category')[0];
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
                $('#modal-category').modal('show');
                $('#modal-category .modal-title').text('Edit Category');
                $('#modal-category form').attr('action', urlUpdate);
                $('#modal-category [name=_method]').val('put');

                let form = $('#form-category')[0];
                resetForm(form);
                $.each(res.data, function(name, value){
                    $(`[name=${name}`).val(res.data.category_name);
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
                $('#modal-category').modal('hide');
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
            $('#modal-category').modal('hide');
            $('.form-control').removeClass('is-invalid')
            $('.invalid-feedback').remove()
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
@endpush --}}