<div class="table-responsive" {{ $type }}>
    <table class="table table-nowrap table-hover mb-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">tên</th>
                <th scope="col">Ngày tham gia</th>
                <th scope="col">Quyền hạng</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody id="user-list-{{ $type }}">
            <!-- Dữ liệu sẽ được JS đẩy vào đây -->
        </tbody>
    </table>
</div>
