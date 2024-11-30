<div class="tab-pane fade mt-4" id="don-dat-phong" role="tabpanel" aria-labelledby="tab-don-dat-phong" tabindex="0">
    <div class="row">
        <div class="col-md-7 col-12 d-flex align-items-end gap-2">
            <div class="flex-fill"><label for="ngayBD">ngày bắt đầu</label>
                <input type="date" class="form-control border-secondary w-100" value="{{date('Y-m-d')}}" id="todayDate">
            </div>
            <div class="flex-fill"><label for="ngayKT">ngày kết thúc</label>
                <input type="date" class="form-control border-secondary w-100" value="{{date('Y-m-d')}}" id="todayDate">
            </div>
            <div class="">
                <button type="button" class=" btn btn-primary">Tìm</button>
            </div>
        </div>

        <div class="col-md-5 col-12 d-flex align-items-end gap-2">
            <div class="flex-fill">
                <label for="maDP">mã đặt phòng</label> 
                <input type="text" class="form-control border-secondary w-100" id="maDP">
            </div>
            <div class="w-10"><button type="button" class=" btn btn-primary">Tìm</button></div>
            {{-- <div class="w-10"><button type="button" class=" btn btn-success" style="white-space: nowrap;"
                    data-bs-toggle="modal" data-bs-target="#add-detail-ddp"><i class="bi bi-plus-circle"></i>
                    Tạo</button>
            </div> --}}
            <a href="{{route('taoddp', ['hid' => $hotel->h_id])}}" class="w-10"><button type="button" class=" btn btn-success" style="white-space: nowrap;"><i class="bi bi-plus-circle"></i>
                Tạo</button>
        </a>
        </div>

        {{-- <div class="modal fade" id="add-detail-ddp" tabindex="-1" aria-labelledby="add-detail-ddp" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Đặt phòng tại chỗ</h1>
                    </div>
                    <div class="modal-body">
                        <form id="formDatPhong" class="row g-3 needs-validation" novalidate>
                            <div class="col-4">
                                <label for="dp-fullname" class="form-label">Họ Tên</label>
                                <input type="text" class="form-control" id="dp-fullname" required>
                                <div class="invalid-feedback">
                                    hãy nhập họ tên
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="dp-phone" class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control" id="dp-phone" required>
                                <div class="invalid-feedback">
                                    hãy nhập số điện thoại
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="dp-room" class="form-label">Chọn Phòng</label>
                                <select class="form-select" id="dp-room" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option>phòng tình nhân </option>
                                    <option>pphòng ban công </option>
                                </select>
                                <div class="invalid-feedback">
                                    hãy chọn phòng
                                </div>
                            </div>
                            <div class="col-2">
                                <label for="dp-sl" class="form-label">Số lượng</label>
                                <input type="number" class="form-control" id="dp-sl" required>
                                <div class="invalid-feedback">
                                    hãy nhập số lượng
                                </div>
                            </div>
                            <div class="col-5">
                                <label for="dp-checkin" class="form-label">Ngày Checkin</label>
                                <input type="date" class="form-control" id="dp-checkin" required>
                                <div class="invalid-feedback">
                                    hãy nhập ngày checkin
                                </div>
                            </div>
                            <div class="col-5">
                                <label for="dp-checkout" class="form-label">Ngày Checkout</label>
                                <input type="date" class="form-control" id="dp-checkout" required>
                                <div class="invalid-feedback">
                                    hãy nhập ngày checkout
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="dp-pm" class="form-label">Phương thức thanh
                                    toán</label>
                                <select class="form-select" id="dp-pm" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option>...</option>
                                </select>
                                <div class="invalid-feedback">
                                    hãy chọn phương thức thanh toán
                                </div>
                            </div>
                            <div class="col-8 total">
                                Tổng Tiền: 1.000.000 vnđ
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Lưu</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="resetForm('formAddHotel')" type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
    <div class="border-table scroll-1 p-2">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Mã Đơn</th>
                    <th scope="col">Ngày Đặt</th>
                    <th scope="col">Tên Khách Hàng</th>
                    <th scope="col">SĐT</th>
                    <th scope="col">Check-in</th>
                    <th scope="col">Check-out</th>
                    <th scope="col">Mã Phòng</th>
                    <th scope="col">SL</th>
                    <th scope="col">Tổng Tiền</th>
                    <th scope="col">Trạng Thái</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr>
                    <th scope="row">MDP01</th>
                    <td>23-10-2024</td>
                    <td>Hứa Vinh Thắng</td>
                    <td>0707879832</td>
                    <td>23-10-2024</td>
                    <td>25-10-2024</td>
                    <td>BCV01</td>
                    <td>1</td>
                    <td>600.000</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-danger dropdown-toggle btn-sm" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Chờ Duyệt
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#">Chờ Duyệt </a></li>
                                <li><a class="dropdown-item" href="#">Confirmed </a></li>
                                <li><a class="dropdown-item" href="#">Đã Nhận </a></li>
                                <li><a class="dropdown-item" href="#">Hoàn Thành </a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">MDP02</th>
                    <td>23-10-2024</td>
                    <td>Mô Ham Mách A Ra Pát</td>
                    <td>0775201831</td>
                    <td>22-10-2024</td>
                    <td>23-10-2024</td>
                    <td>MV02</td>
                    <td>2</td>
                    <td>600.000.000</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-danger dropdown-toggle btn-sm" type="button"
                                id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                Chờ Duyệt
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <li><a class="dropdown-item" href="#">Chờ Duyệt </a></li>
                                <li><a class="dropdown-item" href="#">Confirmed </a></li>
                                <li><a class="dropdown-item" href="#">Đã Nhận </a></li>
                                <li><a class="dropdown-item" href="#">Hoàn Thành </a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">MDP03</th>
                    <td>23-10-2024</td>
                    <td>Travis Scott</td>
                    <td>0707879832</td>
                    <td>23-10-2024</td>
                    <td>28-10-2024</td>
                    <td>SV01</td>
                    <td>1</td>
                    <td>600.000</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-danger dropdown-toggle btn-sm" type="button"
                                id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                Chờ Duyệt
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <li><a class="dropdown-item" href="#">Chờ Duyệt </a></li>
                                <li><a class="dropdown-item" href="#">Confirmed </a></li>
                                <li><a class="dropdown-item" href="#">Đã Nhận </a></li>
                                <li><a class="dropdown-item" href="#">Hoàn Thành </a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <div style="height: 5rem;"></div>
</div>
