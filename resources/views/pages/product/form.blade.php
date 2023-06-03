 
                                         <!--  Modal content for the Large example -->
                                        <div class="modal fade" id="modal-product" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="modal-product">Large modal</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <form id="form-product" method="{{ $method ?? 'post' }}" enctype="multipart/form-data">
                                                            @method('post')
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="selling_price" class="form-label">Supplier Name</label>
                                                                       <select class="form-select" name="supplier_id">
                                                                            <option selected disabled>Choose Supplier</option>
                                                                            @foreach ($suppliers as $supplier)
                                                                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="product_name" class="form-label">Product Name</label>
                                                                        <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Enter product name">
                                                                    </div>
                            
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                            <div class="row">
                                                                
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="product_name" class="form-label">Category Name</label>
                                                                       <select class="form-select" name="category_id">
                                                                            <option selected disabled>Choose Category</option>
                                                                            @foreach ($categories as $category)
                                                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="product_name" class="form-label">Buying Date</label>
                                                                        <div class="input-group date" id="datepicker">
                                                                            <input type="text" class="form-control input-group" id="date" name="buying_date"/>
                                                                            <span class="input-group-append">
                                                                            <span class="input-group-text bg-light d-block">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                            
                                                                </div>
                                                            </div>
                                                             <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="buying_price" class="form-label">Buying Price</label>
                                                                        <input type="number" name="buying_price" class="form-control" id="buying_price" placeholder="Enter buying price">
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="selling_price" class="form-label">Selling Price</label>
                                                                        <input type="number" name="selling_price" class="form-control" id="selling_price" placeholder="Enter selling price">
                                                                    </div>
                            
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="image" class="form-label">image</label>
                                                                        <input type="file" name="image" id="image" class="form-control">
                                                                        <img id="image-preview" src="{{ asset('assets/images/no_image.jpg') }}" alt="pic" class="mt-3 rounded-circle avatar-lg img-thumbnail"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" onclick="submitForm(this.form)" class="btn btn-info waves-effect waves-light save-product">Save</button>
                                                            </div>
                                                    </form>
                                                    </div>
                                                    
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->