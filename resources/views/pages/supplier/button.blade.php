<button type="button" onclick="editForm(`{{ route('supplier.edit', $data) }}`, `{{ route('supplier.update', $data) }}`)" class="edit btn btn-success btn-sm">Edit</button>
<button type="button" onclick="deleteData(`{{ route('supplier.destroy', $data) }}`)" class="delete btn btn-danger btn-sm">Delete</button>