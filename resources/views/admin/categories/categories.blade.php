@extends('layouts.admin_home')

@section('content')
        <h1 style="text-align:center;">QUẢN LÝ THỂ LOẠI PHIM</h1>
        <div class="container">
            <div class="text-right" style="margin-bottom: 30px;">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="bi bi-plus"></i> Thêm</button>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <table id="categoriesTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Tên thể loại</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td class="text-center">{{ $category->id }}</td>
                            <td class="text-center">{{ $category->category_name }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary edit-button" data-toggle="modal"
                                    data-target="#editModal" data-id="{{ $category->id }}"
                                    data-name="{{ $category->category_name }}" style="margin-right: 10px;">
                                    Chỉnh sửa
                                </button>
                                <form action="{{ route('DeleteCategory', $category->id) }}" method="POST"
                                    style="display: inline;margin-left: 10px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Thêm Thể Loại -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm Thể Loại</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('AddCategory') }}" method="POST" id="addCategoryForm">
                                @csrf
                                <div class="form-group row">
                                    <label for="category_name" class="col-md-4 col-form-label text-md-right">Tên thể loại:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="category_name"
                                            name="category_name" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Thêm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Chỉnh Sửa Thể Loại -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Thể Loại</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="updateCategoryForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="category_id" name="id">
                            <div class="form-group">
                                <label for="category_name">Tên thể loại:</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var categoryId = button.data('id');
            var categoryName = button.data('name');

            var modal = $(this);
            modal.find('.modal-body #category_id').val(categoryId);
            modal.find('.modal-body #category_name').val(categoryName);
            modal.find('form').attr('action', '/admin/categories/' + categoryId);
        });


        $(document).ready(function() {
            // Sử dụng on() để ủy quyền sự kiện cho document
            $(document).on('click', '.edit-button', function(event) {
                var button = $(event.currentTarget); // Thay đổi 'this' thành 'event.currentTarget'
                var categoryId = button.data('id');
                var categoryName = button.data('name');

                var modal = $('#editModal');
                modal.find('.modal-body #category_id').val(categoryId);
                modal.find('.modal-body #category_name').val(categoryName);
                modal.find('form').attr('action', '/admin/categories/' + categoryId);
            });


        });
        $(document).ready(function() {
            // Ẩn phần thông báo thành công sau 5 giây
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 2000);

            // Ẩn phần thông báo lỗi sau 5 giây
            setTimeout(function() {
                $('.alert-danger').fadeOut('slow');
            }, 2000);
        });
    </script>
@endsection
