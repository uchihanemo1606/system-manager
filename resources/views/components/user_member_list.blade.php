@php
    $type = $type ?? 'hardware'; // Giá trị mặc định là hardware nếu chưa truyền vào
    $idParam = ($type === 'hardware') ? 'id' : 'id';
    $id = request()->query($idParam); 
@endphp

<div class="table-responsive table-user-member-list mt-3 shadow-sm" {{ $type }}>
    
    @if ($id)
        <div class="user-member-list-add mb-2">
            <button class="btn btn-success btn-sm" onclick="loadModal('type_permission_create', { type: '{{ $type }}', id: '{{ $id }}' },'xl')">
                <i class="mdi mdi-plus"></i> Thêm người dùng
            </button>
        </div>
    @endif

    <table class="table table-bordered table-hover mb-0 align-middle text-center">
        <thead class="table-light">
            <tr>
                <th style="width: 50px">#</th>
                <th>Tên người dùng</th>
                <th>Quyền hạn</th>
                <th style="width: 120px">Thao tác</th>
            </tr>
        </thead>
        <tbody id="user-list-{{ $type }}">
            <!-- Dữ liệu sẽ được JS đẩy vào đây -->
        </tbody>
    </table>
</div>
