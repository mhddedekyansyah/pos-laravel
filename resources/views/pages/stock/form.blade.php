 <div id="modal-stock" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">stock</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <form id="form-stock" method="{{ $method ?? 'post' }}">
                                                            @method('post')
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                    <label for="stock" class="form-label">Product Stock</label>
                                                                    <input type="number" name="stock" class="form-control" id="stock" placeholder="Enter stock">
                                                                    </div>
                                                                
                                                                </div>
                                                                
                                                            </div>
                                                           
                                                   
                                                        
                                                    </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" onclick="submitForm(this.form)" class="btn btn-info waves-effect waves-light save-stock">Save</button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div><!-- /.modal -->