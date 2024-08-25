@extends('layouts.admin_home')

@section('content')
        <h1 style="text-align:center;">QUẢN LÝ MÃ GIẢM GIÁ</h1>
        <div class="container">
            <div class="text-right" style="margin-bottom: 30px;">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                    <i class="bi bi-plus"></i> Thêm mã giảm giá
                </button>
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

            <table id="discountCodesTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Mã giảm giá</th>
                        <th class="text-center">Phần trăm giảm giá</th>
                        <th class="text-center">Ngày hết hạn</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($discountCodes as $discountCode)
                        <tr>
                            <td class="text-center">{{ $discountCode->id }}</td>
                            <td class="text-center">{{ $discountCode->code }}</td>
                            <td class="text-center">{{ $discountCode->discount_percentage }}%</td>
                            <td class="text-center">{{ $discountCode->expiry_date}}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary edit-button" data-toggle="modal"
                                    data-target="#editModal" data-id="{{ $discountCode->id }}"
                                    data-code="{{ $discountCode->code }}"
                                    data-discount="{{ $discountCode->discount_percentage }}"
                                    data-expiry="{{ $discountCode->expiry_date }}" 
                                    style="margin-right: 10px;">
                                    Chỉnh sửa
                                </button>
                                <form action="{{route('DeleteDiscount', $discountCode->id )}}" method="POST"
                                    style="display: inline; margin-left: 10px;">
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

        <!-- Modal Thêm mã giảm giá -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm mã giảm giá</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('AddDiscount')}}" method="POST" id="addDiscountCodeForm">
                                @csrf
                                <div class="form-group row">
                                    <label for="code" class="col-md-4 col-form-label text-md-right">Mã giảm giá:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="code" name="code" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="discount_percentage" class="col-md-4 col-form-label text-md-right">Phần trăm giảm giá:</label>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" min="1" max="100" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="expiry_date" class="col-md-4 col-form-label text-md-right">Ngày hết hạn:</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" id="expiry_date" name="expiry_date">
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

        <!-- Modal Chỉnh sửa mã giảm giá -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh sửa mã giảm giá</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="updateDiscountCodeForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="discount_code_id" name="id">
                            <div class="form-group">
                                <label for="code">Mã giảm giá:</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                            </div>
                            <div class="form-group">
                                <label for="discount_percentage">Phần trăm giảm giá:</label>
                                <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" min="1" max="100" required>
                            </div>
                            <div class="form-group">
                                <label for="expiry_date">Ngày hết hạn:</label>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ẩn thông báo sau 2 giây
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 2000);

            // Xử lý sự kiện khi mở modal chỉnh sửa
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var discountCodeId = button.data('id');
                var code = button.data('code');
                var discount = button.data('discount');
                var expiry = button.data('expiry');

                var modal = $(this);
                modal.find('.modal-body #discount_code_id').val(discountCodeId);
                modal.find('.modal-body #code').val(code);
                modal.find('.modal-body #discount_percentage').val(discount);
                modal.find('.modal-body #expiry_date').val(expiry);
                modal.find('form').attr('action', '/admin/discount/' + discountCodeId);
            });
        });
    </script>
@endsection