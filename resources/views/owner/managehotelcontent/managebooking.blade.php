<div class="tab-pane fade mt-4 active show" id="don-dat-phong" role="tabpanel" aria-labelledby="tab-don-dat-phong"
    tabindex="0">
    <div class="row">
        <div class="col-md-7 col-12 d-flex align-items-end gap-2">
            <div class="flex-fill"><label for="ngayBD">ngày bắt đầu</label>
                <input type="date" class="form-control border-secondary w-100" value="{{ date('Y-m-d') }}"
                    id="todayDate">
            </div>
            <div class="flex-fill"><label for="ngayKT">ngày kết thúc</label>
                <input type="date" class="form-control border-secondary w-100" value="{{ date('Y-m-d') }}"
                    id="todayDate">
            </div>
        </div>
        <div class="col-md-5 col-12 d-flex align-items-end gap-2">
            <div class="flex-fill">
                <label for="maDP">mã đặt phòng</label>
                <input type="text" class="form-control border-secondary w-100" id="maDP">
            </div>
            <div class="w-10"><button type="button" class=" btn btn-primary">Tìm</button></div>
            <button type="button" class="btn btn-success" style="white-space: nowrap;" data-bs-toggle="modal"
                data-bs-target="#modal-ddp">
                <i class="bi bi-plus-circle"></i> Tạo
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modal-ddp" tabindex="-1" aria-labelledby="modal-ddp-label" aria-hidden="true">
                <div class="modal-dialog  modal-lg  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modal-ddp-label">Tạo Đơn Đặt Phòng</h1>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('owner.taoddp', ['hid' => $hotel->h_id]) }}"
                                class="needs-validation row g-3" method="GET" novalidate>
                                @csrf
                                <h5 class="col-12">Thông tin đơn đặt:</h5>

                                <div class="col-6">
                                    <label for="inputName" class="form-label">Họ và tên</label>
                                    <input type="text" name="name" class="form-control" id="inputName" required>
                                    <div class="invalid-feedback">
                                        hãy nhập họ và tên
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="inputSdt" class="form-label">Số điện thoại</label>
                                    <input type="text" name="sdt" class="form-control" id="inputSdt" required>
                                    <div class="invalid-feedback">
                                        hãy nhập số điện thoại
                                    </div>
                                </div>
                                <div class="col-5 mt-1">
                                    <label for="inputCin" class="form-label">Check-in</label>
                                    <input type="date" name="checkin" class="form-control" id="inputCin"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-5 mt-1">
                                    <label for="inputCout" class="form-label">Check-out</label>
                                    <input type="date" name="checkout" class="form-control" id="inputCout"
                                        value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>
                                <div class="col-2 d-flex align-items-end">
                                    <button class="btn btn-primary ms-3" type="submit">Tiếp tục</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>

    </div>
    <div class="border-table scroll-1 p-2">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên Khách Hàng</th>
                    <th scope="col">SĐT</th>
                    <th scope="col">Ngày Đặt</th>
                    <th scope="col">PTTT</th>
                    <th scope="col">Check-in</th>
                    <th scope="col">Check-out</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Tổng Tiền</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @php
                    $stt = 1;
                @endphp
                @foreach ($listddp as $ddp)
                    @php
                        switch ($ddp->ddp_pttt) {
                            case 'momo':
                                $pttt = 'Momo';
                                break;
                            case 'bank':
                                $pttt = 'Ngân hàng';
                                break;
                            default:
                                $pttt = 'Trực tiếp';
                                break;
                        }
                        switch ($ddp->ddp_status) {
                            case 'confirmed':
                                $status = 'Xác nhận';
                                break;
                            case 'checkedin':
                                $status = 'Checkin';
                                break;
                            case 'canceled':
                                $status = 'Đã hủy';
                                break;
                            default:
                                $status = 'Chờ duyệt';
                                break;
                        }
                        $detail = $ddp->detail_ddps->first();

                    @endphp
                    <tr>
                        <th scope="row">{{ $stt }}</th>
                        <td>{{ $ddp->ddp_customername }}</td>
                        <td>{{ $ddp->ddp_sdt }}</td>
                        <td>{{ date('d/m/Y', strtotime($ddp->ddp_ngaydat)) }}</td>
                        <td>{{ $pttt }}</td>
                        <td>{{ date('d/m/Y', strtotime($detail->detail_checkin)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($detail->detail_checkout)) }}</td>
                        <td>{{ $status }}</td>
                        <td>{{ number_format($ddp->ddp_total, 0, ',', '.') }} VNĐ</td>
                        <td><a href="#">Xem chi tiết</a></td>
                    </tr>
                    @php $stt++; @endphp
                @endforeach
                <tr>
                    <th scope="row">1</th>
                    <td>Hứa Vinh Thắng</td>
                    <td>0707879832</td>
                    <td>23/10/2024</td>
                    <td>Momo</td>
                    <td>23/10/2024</td>
                    <td>25/10/2024</td>
                    <td>Chờ duyệt</td>
                    <td>600.000 VNĐ</td>
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

            </tbody>
        </table>

    </div>
    <div style="height: 5rem;"></div>
</div>
