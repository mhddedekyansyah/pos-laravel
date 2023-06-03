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
                                        <div class="d-flex justify-content-between mb-3">
                                            <button onclick="deleteMultiple('{{ route('product.delete-all') }}')" class="btn btn-danger btn-sm delete-all">Delete</button>
                                            <button onclick="addForm(`{{ route('product.store') }}`)" class="btn btn-primary btn-sm add-product" >Add Product </button>
                                        </div>
                                        <form id='form'>
                                            <table id="table" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th width="5%">
                                                        <input type="checkbox" name="select_all" id="select_all">
                                                    </th>
                                                    <th>No</th>
                                                    <th>Product Code</th>
                                                    <th>Name</th>
                                                    <th>Stock</th>
                                                    <th>Buying Date</th>
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
                @include('pages.product.show')
                @include('pages.product.form')
@endsection



@push('scripts')
    <script>
      $(document).ready(function(){
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

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
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('product.data') }}",
            },
            columns: [
                 {
                    data: 'select_all', 
                    name: 'select_all', 
                    orderable: false, 
                    searchable: false,
                },
                {data: 'DT_RowIndex', name: 'DT_RowIndex',  orderable: false, searchable: false,},
                {data: 'product_code', name: 'product_code'},
                {data: 'product_name', name: 'product_name'},
                {data: 'stock.stock', name: 'stock.stock'},
                {data: 'buying_date', name: 'buying_date'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                },
            ]
        })
      })

    //   Add Modal product
    function addForm(url){
        $('#modal-product').modal('show');
        $('#modal-product .modal-title').text('Create product');
        $('#modal-product form').attr('action', url);
        $('#modal-product [name=_method]').val('POST');
        let form = $('#form-product')[0];
        resetForm(form);
    }

    //   Delete product
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


 // Edit product
 function editForm(urlEdit, urlUpdate){
        $.ajax({
            url: urlEdit,
            success: function(res){
                console.log(res.data)
                $('#modal-product').modal('show');
                $('#modal-product .modal-title').text('Edit product');
                $('#modal-product form').attr('action', urlUpdate);
                $('#modal-product [name=_method]').val('put');

                let form = $('#form-product')[0];
                resetForm(form);
                $.each(res.data, function(name, value){
                  
                    if($(`[name=${name}`).attr('type') != 'file'){
                            $(`[name=${name}`).val(value)
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
    

    //   Save product
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
                $('#modal-product').modal('hide');
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
    
    
    // Show Product
    function show(url){
        $('#show').modal('show')
        $.ajax({
            url: url,
            dataType: 'json',
            cache: false,
            processData: false,
            success: function(res){
                console.log(res.data)
                $(`#image-product`).attr('src',  `{{ Storage::url('${res.data.image.image}') }}`)
                $.each(res.data, function(name, value){
                    if(name == 'category'){
                        $(`#${name}`).text(value.category_name)
                    }else if(name == 'supplier'){
                        $(`#${name}`).text(value.supplier_name)
                    }else if(name == 'stock'){
                        $(`#${name}`).text(value.stock)
                    }else if(name == 'buying_price' || name == 'selling_price'){
                        let numberFormat = new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 3,  style: "currency", currency: "IDR" }).format(value)
                        $(`#${name}`).text(numberFormat)
                    }else{
                        $(`#${name}`).text(value)
                    }  
                })

            },
            error: function(err){
                showAlert(err.message, 'error')
                console.log(err)
            }
        })
    }
   
    function resetForm(form){
            $('#modal-product').modal('hide');
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
                 $(`[name=${name}]`).addClass('is-invalid')
                    if($(`[name=${name}]`).hasClass('.input-group')){
                        $(`<small class="text-danger invalid-feedback">${value[0]}</small>`).insertAfter('input-group-append').next()
                    }else{
                 
                        $(`<small class="text-danger invalid-feedback">${value[0]}</small>`).insertAfter(`[name=${name}]`)
                    }    
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


        function deleteMultiple(url){
            console.log($('#form')[0])
            if($('input:checked').length > 1){
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
                let form = $('#form')[0];
                $.ajax({
                        url,
                        data: new FormData(form),
                        type: 'POST',
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(res){
                            showAlert(res.message, res.type);
                            $('#table').DataTable().ajax.reload();
                            $('#select_all:checked').prop('checked', false)
                            console.log(res)
                        },
                        error: function(err){
                            console.log(err)
                        }
                    })
                }
            })
        }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No row selected!',
                    })
                      $('#select_all:checked').prop('checked', false)
                }
            
    }
    </script>
@endpush