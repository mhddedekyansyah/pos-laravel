 <div id="modal-customer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">customer</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <form id="form-customer" method="{{ $method ?? 'post' }}">
                                                            @method('post')
                                                            <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="customer_name" class="form-label">Customer Name</label>
                                                                    <input type="text" name="customer_name" class="form-control" id="customer_name" placeholder="Enter customer name">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="phone" class="form-label">Phone Number</label>
                                                                    <input type="number" name="phone" class="form-control" id="phone" placeholder="Enter phone number">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="address">Address</label>
                                                                    <textarea class="form-control" name="address" id="address" rows="3"></textarea>
                                                                </div>
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
                                                                <button type="button" onclick="submitForm(this.form)" class="btn btn-info waves-effect waves-light save-customer">Save</button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div><!-- /.modal -->