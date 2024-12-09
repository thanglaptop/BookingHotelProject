<div class="modal fade" id="add-hotel-modal" tabindex="-1" aria-labelledby="add-hotel-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Khách Sạn Mới</h1>
            </div>
            <div class="modal-body">
                <form id="formAddHotel" class="row g-3 needs-validation" action="{{ route('addhotel') }}"
                method="POST" novalidate enctype="multipart/form-data">
                @csrf
                    <div style="font-weight: 600;">Ảnh khách sạn</div>
                    <div class="col-12" id="add-hotel-image">
                        <div class="zone-display-image scroll-1 border border-secondary" id="displayImage">
                            <div class="m-1" id="btnAddImage">
                                <label for="nutThemAnh"><i class="bi bi-plus-square icon-add-room"></i></label>
                            </div>
                        </div>
                        <input type="file" name="hinh[]" class="form-control d-none" id="nutThemAnh"
                            onchange="displayAnh(event, 'displayImage', 'btnAddImage')" required multiple/>
                        <div class="invalid-feedback">
                            hãy thêm ảnh cho khách sạn
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="add-hotel-type" class="form-label">Loại Hình</label>
                        <select class="form-select border-secondary" name="loaihinh" id="add-hotel-type" required>
                            @foreach ($loaihinhs as $lh)
                                <option value="{{ $lh->lh_id }}">
                                    {{ $lh->lh_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            hãy chọn loại hình
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="add-hotel-city" class="form-label">Thành Phố</label>
                        <select class="form-select border-secondary" name="city" id="add-hotel-city" required>
                            @foreach ($cities as $city)
                                <option value="{{ $city->ct_id }}">
                                    {{ $city->ct_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            hãy chọn thành phố
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="add-hotel-phone" class="form-label">Số Điện Thoại</label>
                        <input type="text" name="sdt" class="form-control border-secondary hotel-phone-input" id="add-hotel-phone" required>
                        <div class="invalid-feedback hotel-phone-feedback">
                            hãy nhập số điện thoại
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="add-hotel-name" class="form-label">Tên Khách Sạn</label>
                        <input type="text" name="hname" class="form-control border-secondary hotel-name-input" id="add-hotel-name" required>
                        <div class="invalid-feedback hotel-name-feedback">
                            hãy nhập tên khách sạn
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="add-hotel-address" class="form-label">Địa Chỉ</label>
                        <input type="text" name="hdchi" class="form-control border-secondary hotel-dchi-input" id="add-hotel-address" required>
                        <div class="invalid-feedback hotel-dchi-feedback">
                            hãy nhập địa chỉ
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="add-hotel-describe" class="form-label">Mô tả khách sạn</label>
                        <textarea name="hmota" class="form-control border-secondary hotel-mota-input" id="add-hotel-describe" style="height: 120px;" required></textarea>
                        <div class="invalid-feedback hotel-mota-feedback">
                            hãy nhập mô tả khách sạn
                        </div>
                    </div>
                    <div class="col-5">
                        <label for="edit-hotel-pm" class="form-label">Thông tin thanh toán</label>
                        <select class="form-select border-secondary" name="tttt" id="edit-hotel-pm" required>
                            @foreach ($hotelpminfo as $pm)
                                <option value="{{ $pm->pm_id }}">
                                    {{ $pm->pm_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            hãy chọn thông tin thanh toán
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-label">Tiện ích phòng</div>
                        <div class="row g-2 mt-1">
                            @foreach($tiennghihotel as $tn)
                            <div class="form-check col-3 col-md-2">
                                <input class="form-check-input border-secondary" type="checkbox" value="{{$tn->tn_id}}" name="tiennghi[]" id="add-room-utilities">
                                <label class="form-check-label" for="add-room-utilities">
                                    {{$tn->tn_name}}
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
