<button onclick="editForm(`{{ route('category.edit', $data) }}`, `{{ route('category.update', $data) }}`)" class="edit btn btn-success btn-sm">Edit</button>
<button onclick="deleteData(`{{ route('category.destroy', $data) }}`)" class="delete btn btn-danger btn-sm">Delete</button>