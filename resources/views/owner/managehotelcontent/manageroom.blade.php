<div @if ($tab == 'manage-phong') class="tab-pane fade mt-4 active show"
    @else class="tab-pane fade mt-4" @endif
    id="manage-phong" role="tabpanel" aria-labelledby="tab-manage-phong" tabindex="0">
    <!-- ADD ROOM HOTEL -->

    @if (Auth::guard('owner')->check())
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-room-modal"> <i
                class="bi bi-plus-circle"></i> Thêm Phòng</button>
    @endif
    <div class="modal fade" id="add-room-modal" tabindex="-1" aria-labelledby="add-room-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="add-room-modal-label">Thêm Phòng Mới</h1>
                </div>
                <div class="modal-body">
                    <form id="formAddHotel" class="row g-3 needs-validation" action="{{ route('addroom') }}"
                        method="POST" novalidate enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $hotel->h_id }}" name="hid">
                        <div style="font-weight: 600;">Ảnh phòng</div>
                        <div class="col-12" id="add-room-image">
                            <div class="zone-display-image scroll-1 border border-secondary" id="displayImage">
                                <div class="m-1" id="btnAddImage">
                                    <label for="nutThemAnh"><i class="bi bi-plus-square icon-add-room"></i></label>
                                </div>
                            </div>
                            <input type="file" name="hinh[]" class="form-control d-none" id="nutThemAnh"
                                onchange="displayAnh(event, 'displayImage', 'btnAddImage')" multiple required />
                            <div class="invalid-feedback">
                                hãy thêm ảnh cho phòng
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="add-room-name" class="form-label">Tên phòng</label>
                            <input type="text" class="form-control border-secondary room-name-input" id="add-room-name"
                                name="rname" required>
                            <div class="invalid-feedback room-name-feedback">
                                hãy nhập tên phòng
                            </div>
                        </div>
                        <div class="col-8">
                            <label for="add-room-price" class="form-label">Giá phòng</label>
                            <input type="number" class="form-control border-secondary room-price-input" id="add-room-price"
                                name="rprice" required>
                            <div class="invalid-feedback room-price-feedback">
                                hãy nhập giá phòng
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="add-room-quantity" class="form-label">Số lượng phòng</label>
                            <input type="number" class="form-control border-secondary room-sl-input" id="add-room-quantity"
                                name="rsoluong" required>
                            <div class="invalid-feedback room-sl-feedback">
                                hãy nhập số lượng phòng
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="add-room-describe" class="form-label">Mô tả phòng</label>
                            <textarea class="form-control border-secondary room-mota-input" id="add-room-describe" name="rmota" style="height: 120px;" required></textarea>
                            <div class="invalid-feedback room-mota-feedback">
                                hãy nhập mô tả phòng
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="add-room-dientich" class="form-label">Diện tích</label>
                            <input type="number" class="form-control border-secondary room-dt-input" id="add-room-dientich"
                                name="rdientich" required>
                            <div class="invalid-feedback room-dt-feedback">
                                hãy nhập số diện tích phòng
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="add-room-adult" class="form-label">người lớn</label>
                            <input type="number" class="form-control border-secondary adult-input" id="add-room-adult"
                                name="rmaxadult" value="0" required>
                            <div class="invalid-feedback adult-feedback">
                                hãy nhập số người lớn tối đa
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="add-room-kid" class="form-label">trẻ em</label>
                            <input type="number" class="form-control border-secondary kid-input" id="add-room-kid"
                                name="rmaxkid" value="0" required>
                            <div class="invalid-feedback kid-feedback">
                                hãy nhập số trẻ em tối đa
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="add-room-maxperson" class="form-label">cả người lớn và trẻ em</label>
                            <input type="number" class="form-control border-secondary all-input" id="add-room-maxperson"
                                name="rmaxperson" value="0" required>
                            <div class="invalid-feedback all-feedback">
                                hãy nhập số người lớn và trẻ em tối đa
                            </div>
                        </div>
                        <div class="text-primary">Nếu đã nhập người lớn, trẻ em thì không cần phải nhập cả người lớn và
                            trẻ em</div>
                        <div class="col-12">
                            <div class="form-label">Tiện nghi phòng</div>
                            <div class="row g-2 mt-1">
                                @foreach ($listtiennghi as $tiennghi)
                                    <div class="form-check col-3">
                                        <input class="form-check-input border-secondary" type="checkbox"
                                            name="tiennghi[]" value="{{ $tiennghi->tn_id }}" id="add-room-utilities">
                                        <label class="form-check-label" for="add-room-utilities">
                                            {{ $tiennghi->tn_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
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
    </div>
    @php
        $dem = 1;
    @endphp
    @foreach ($hotel->rooms as $room)
        <div class="p-4 pb-0">
            <div class="card h-100">
                <div class="row g-0">
                    <div class="col-md-4">
                        @php
                            $img = $room->room_imgs->firstWhere('ri_vitri', 1);
                            if ($room->r_id <= 135) {
                                $roompath =
                                    '/images/hotels/h' . $room->hotel->h_id . '/room/r' . $dem . '/' . $img->ri_name;
                                if ($dem > 5) {
                                    break;
                                }
                                $dem++;
                            } else {
                                $roompath =
                                    '/images/hotels/h' .
                                    $room->hotel->h_id .
                                    '/room/r' .
                                    $room->r_id .
                                    '/' .
                                    $img->ri_name;
                            }

                            $allow = '';
                            if ($room->r_maxadult != 0 && $room->r_maxkid != 0) {
                                $allow = $room->r_maxadult . ' người lớn, ' . $room->r_maxkid . ' trẻ em';
                            } elseif ($room->r_maxadult != 0 && $room->r_maxkid == 0) {
                                $allow = $room->r_maxadult . ' người lớn';
                            } else {
                                $allow = $room->r_maxperson . ' người lớn và trẻ em';
                            }
                            $conlai = $listroom->firstWhere('r_id', $room->r_id)['r_conlai'] ?? 0;
                        @endphp
                        <img src="{{ $roompath }}" class="img-fluid rounded-start h-100" alt="ảnh không tồn tại">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $room->r_name }}</h5>
                            <div class="row">
                                <div class="col-md-8 d-flex justify-content-between">
                                    <div class="card-text">Mã phòng:
                                        R{{ $room->r_id }}{{ $hotel->h_id }}H</div>
                                    <div class="card-text">Số lượng: {{ $room->r_soluong }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 d-flex justify-content-between">
                                    <div class="card-text">Giá: {{ number_format($room->r_price, 0, ',', '.') }}đ/ngày
                                    </div>
                                    <div class="card-text">Còn lại: {{ $conlai }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 d-flex justify-content-between">
                                    <div class="card-text">Tối đa: {{ $allow }}</div>
                                    <div class="card-text">Diện tích: {{ $room->r_dientich }}m<sup>2</sup></div>
                                </div>
                            </div>
                            <div class="card-text">Mô tả: {{ $room->r_mota }}</div>
                            <div class="d-flex align-items-center">
                                <span class="card-text" style="white-space: nowrap;">cơ sở vật chất:
                                </span>
                                <div class="list-csvc scroll-1">
                                    @if ($room->dsTienNghi != null)
                                        @foreach ($room->dsTienNghi as $tn)
                                            <button type="button" class="btn btn-light btn-sm m-1"
                                                disabled>{{ $tn->tn_name }}</button>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            @if (Auth::guard('owner')->check())
                                <div class="nhom-button">
                                    <a href="{{ route('editroom', ['rid' => $room->r_id, 'hid' => $hotel->h_id]) }}">
                                        <button type="button" class="btn btn-primary">Chỉnh Sửa</button></a>
                                    <a
                                        href="{{ route('showcloseroom', ['rid' => $room->r_id, 'hid' => $hotel->h_id]) }}">
                                        @if ($room->r_isclose == 1 && date('Y-m-d') >= $room->r_dateclose && date('Y-m-d') < $room->r_dateopen)
                                            <button type="button" class="btn btn-danger">Phòng Đóng</button>
                                        @else
                                            <button type="button" class="btn btn-success">Hoạt Động</button>
                                        @endif
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
