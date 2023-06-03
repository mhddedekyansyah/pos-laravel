@extends('layouts.app', ['title' => 'POS | Stock'])
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
                                            <li class="breadcrumb-item active">Stock</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Stock</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form id='form'>
                                            <table id="table" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Product Name</th>
                                                    <th>Product Stock</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        </form>
                                
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->


                    </div> <!-- container -->

                </div>
                @include('pages.stock.form')
@endsection

@push('scripts')
    <script>
      $(document).ready(function(){
        
        // Reload DataTables
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('stock.data') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',  orderable: false, searchable: false,},
                {data: 'product.product_name', name: 'product.product_name'},
                {data: 'stock', name: 'stock', orderable: false, searchable: false,},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                },
            ]
        })
      })

    //   Add Modal stock
    function addForm(url){
        $('#modal-stock').modal('show');
        $('#modal-stock .modal-title').text('Create stock');
        $('#modal-stock form').attr('action', url);
        $('#modal-stock [name=_method]').val('POST');
        let form = $('#form-stock')[0];
        resetForm(form);
    }

    //   Delete stock
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


 // Edit stock
 function editForm(urlEdit, urlUpdate){
        $.ajax({
            url: urlEdit,
            success: function(res){
                console.log(res.data)
                $('#modal-stock').modal('show');
                $('#modal-stock .modal-title').text('Edit stock');
                $('#modal-stock form').attr('action', urlUpdate);
                $('#modal-stock [name=_method]').val('put');

                let form = $('#form-stock')[0];
                resetForm(form);
                $.each(res.data, function(name, value){
                    if($(`[name=${name}`).hasClass('form-select')){
                        $(`[name=${name}`).addClass('d-none')
                        $(` <input type="hidden" name="product_id" value="${res.data.product_id}" class="form-control">`).insertAfter('[name="stock"]')
                    }
                    $(`[name=${name}`).val(value);
                })
              
            },
            error: function(err){
                showAlert(err.message, 'error')
                console.log(err)
            }
        })
}
    

    //   Save stock
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
                $('#modal-stock').modal('hide');
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
            $('#modal-stock').modal('hide');
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

        $('#select_all').on('click', function() {
            if($(this).is(':checked', true)){
               
                $(".checkbox").prop('checked', true);  
            } else {  
                $(".checkbox").prop('checked', false);  
               
            } 
        });

        $('body').on('click', '.checkbox', function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked', true);
            }else{
                $('#select_all').prop('checked', false);
            }
        });

        
    </script>
@endpush