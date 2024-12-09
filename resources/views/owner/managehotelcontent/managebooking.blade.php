<div @if ($tab != 'manage-phong') class="tab-pane fade mt-4 active show"
@else class="tab-pane fade mt-4" @endif
    id="don-dat-phong" role="tabpanel" aria-labelledby="tab-don-dat-phong" tabindex="0">
    <div class="row">
        <form
            @if (Auth::guard('owner')->check()) action="{{ route('owner.managehotel', ['id' => $hotel->h_id, 'tab' => 'don-dat-phong']) }}"
        @elseif(Auth::guard('employee')->check())
        action="{{ route('employee.managehotel', ['id' => $hotel->h_id, 'tab' => 'don-dat-phong']) }}" @endif
            method="GET" class="row">
            <div class="col-md-7 col-12 d-flex align-items-end gap-2">
                <div class="flex-fill"><label for="ngayBD">ngày bắt đầu</label>
                    <input type="date" name="daystart" class="form-control border-secondary w-100"
                        value="{{ old('daystart', request('daystart', date('Y-m-d'))) }}" id="todayDate1">
                </div>
                <div class="flex-fill"><label for="ngayKT">ngày kết thúc</label>
                    <input type="date" name="dayend" class="form-control border-secondary w-100"
                        value="{{ old('dayend', request('dayend', date('Y-m-d'))) }}" id="todayDate2">
                </div>
            </div>
            <div class="col-md-5 col-12 d-flex align-items-end gap-2">
                <div class="flex-fill">
                    <label for="SDT">số điện thoại</label>
                    <input type="tel" name="sdttim" class="form-control border-secondary w-100"
                        value="{{ old('sdttim', request('sdttim')) }}" id="SDT">
                </div>
                <div class="w-10"><button type="submit" class=" btn btn-primary">Tìm</button></div>
                <button type="button" class="btn btn-success" style="white-space: nowrap;" data-bs-toggle="modal"
                    data-bs-target="#modal-ddp">
                    <i class="bi bi-plus-circle"></i> Tạo
                </button>
            </div>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="modal-ddp" tabindex="-1" aria-labelledby="modal-ddp-label" aria-hidden="true">
            <div class="modal-dialog  modal-lg  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-ddp-label">Tạo Đơn Đặt Phòng</h1>
                    </div>
                    <div class="modal-body">
                        <form
                            @if (Auth::guard('owner')->check()) action="{{ route('owner.taoddp', ['hid' => $hotel->h_id]) }}"
                                    @elseif(Auth::guard('employee')->check())
                                    action="{{ route('employee.taoddp', ['hid' => $hotel->h_id]) }}" @endif
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
                                <input type="date" name="checkin" class="form-control daystart" id="inputCin"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-5 mt-1">
                                <label for="inputCout" class="form-label">Check-out</label>
                                <input type="date" name="checkout" class="form-control dayend" id="inputCout"
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
                                $status = '<td class="text-primary">Xác nhận</td>';
                                break;
                            case 'checkedin':
                                $status = '<td class="text-warning">Đã checkin</td>';
                                break;
                            case 'completed':
                                $status = '<td class="text-success">Hoàn thành</td>';
                                break;
                            case 'rated':
                                $status = '<td class="text-success">Đã đánh giá</td>';
                                break;
                            case 'canceled':
                                $status = '<td class="text-danger">Đã hủy</td>';
                                break;
                            default:
                                $status = '<td class="text-info">Chờ duyệt</td>';
                                break;
                        }
                        $detail = $ddp->detail_ddps->first();

                    @endphp
                    <tr>
                        <th scope="row">{{ $stt++ }}</th>
                        <td>{{ $ddp->ddp_customername }}</td>
                        <td>{{ $ddp->ddp_sdt }}</td>
                        <td>{{ date('d/m/Y', strtotime($ddp->ddp_ngaydat)) }}</td>
                        <td>{{ $pttt }}</td>
                        <td>{{ date('d/m/Y', strtotime($detail->detail_checkin)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($detail->detail_checkout)) }}</td>
                        {!! $status !!}
                        <td>{{ number_format($ddp->ddp_total, 0, ',', '.') }} VNĐ</td>
                        <td>
                            @if (Auth::guard('owner')->check())
                                <a
                                    href="{{ route('owner.detailddp', ['ddpid' => $ddp->ddp_id, 'hid' => $ddp->h_id]) }}">Xem
                                    chi tiết</a>
                            @elseif(Auth::guard('employee')->check())
                                <a
                                    href="{{ route('employee.detailddp', ['ddpid' => $ddp->ddp_id, 'hid' => $ddp->h_id]) }}">Xem
                                    chi tiết</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div style="height: 5rem;"></div>
</div>

<script>
    window.handleDateChange = function() {
        const checkinInput = document.getElementById("todayDate1");
        const checkoutInput = document.getElementById("todayDate2");

        const checkinDateStr = checkinInput.value;
        const checkoutDateStr = checkoutInput.value;

        const checkinDate = new Date(checkinDateStr);
        const checkoutDate = new Date(checkoutDateStr);

        // Kiểm tra nếu ngày check-out < ngày check-in
        if (checkoutDateStr && checkoutDate < checkinDate) {
            // alert("Ngày check-out không được nhỏ hơn hoặc bằng ngày check-in.");
            checkoutInput.value = ""; // Reset ngày check-out
            return;
        }

        // Nếu ngày check-in > ngày check-out
        if (checkinDateStr && checkoutDateStr && checkinDate > checkoutDate) {
            // alert("Ngày check-in không được lớn hơn hoặc bằng ngày check-out.");
            checkoutInput.value = ""; // Reset ngày check-out
            return;
        }
    };

    // Lắng nghe sự kiện thay đổi ngày check-in và check-out
    document.getElementById("todayDate1").addEventListener('change', handleDateChange);
    document.getElementById("todayDate2").addEventListener('change', handleDateChange);
</script>