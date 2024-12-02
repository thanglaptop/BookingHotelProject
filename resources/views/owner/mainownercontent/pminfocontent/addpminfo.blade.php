<div class="modal fade" id="add-detail-ddp" tabindex="-1" aria-labelledby="add-detail-ddp" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm thông tin thanh toán</h1>
            </div>
            <div class="modal-body">
                <form id="formDatPhong" class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                        <label for="add-pm_name" class="form-label">Tên thông tin thanh toán</label>
                        <input type="text" class="form-control border-secondary" id="add-pm_name" value="{{-- $hotel->paymentinfo->pm_momo --}}"
                            required>
                        <div class="invalid-feedback">
                            hãy nhập tên thông tin thanh toán
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- <label for="add-hotel-pm1" class="form-label">Phương thức thanh toán</label> --}}
                        <div class="form-check form-switch">
                            <input class="form-check-input border-secondary" type="checkbox" role="switch" id="add-pm-athotel"
                                {{-- @if ($hotel->paymentinfo->pm_athotel == 1) checked @endif --}}>
                            <label class="form-check-label" for="add-pm-athotel">Cho phép thanh toán
                                tại khách sạn</label>
                        </div>
                    </div>
                    <div class="col-6 p-2">
                        <div style="font-weight: 600;">Momo</div>
                        <div class="row d-flex align-items-center">

                            <div class="col-md-7 col-12">
                                <label for="add-pm-momo" class="form-label">Số momo</label>
                                <input type="text" class="form-control border-secondary" id="add-pm-momo"
                                    value="{{-- $hotel->paymentinfo->pm_momo --}}" required>
                                <div class="invalid-feedback">
                                    hãy nhập số momo
                                </div>
                            </div>

                            <div class="col-md-5 col-12 mt-2">
                                <div class="d-flex justify-content-center mb-2">
                                    <img id="selectedMomo" src="/images/other/placeholder-image.png" class="rounded"
                                        style="width: 100px; height: 100px; object-fit: cover;" />
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div data-mdb-ripple-init class="btn btn-info btn-sm">
                                        <label class="form-label text-white m-1" for="QRMomo">QR Momo</label>
                                        <input type="file" class="form-control d-none" id="QRMomo"
                                            onchange="displaySelectedImage(event, 'selectedMomo')" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 p-2">
                        <div style="font-weight: 600;">Ngân hàng</div>
                        <div class="row d-flex align-items-center">
                            <div class="col-md-7 col-12">
                                <label for="add-pm-bank" class="form-label">Số ngân hàng</label>
                                <input type="text" class="form-control border-secondary" id="add-pm-bank"
                                    value="{{-- $hotel->paymentinfo->pm_bank --}}" required>
                                <div class="invalid-feedback">
                                    hãy nhập số momo
                                </div>
                            </div>

                            <div class="col-md-5 col-12 mt-2">
                                <div class="d-flex justify-content-center mb-2">
                                    <img id="selectedBank" src="/images/other/placeholder-image.png" class="rounded"
                                        style="width: 100px; height: 100px; object-fit: cover;" />
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div data-mdb-ripple-init class="btn btn-info btn-sm">
                                        <label class="form-label text-white m-1" for="QRBank">QR Bank</label>
                                        <input type="file" class="form-control d-none" id="QRBank"
                                            onchange="displaySelectedImage(event, 'selectedBank')" />
                                    </div>
                                </div>
                            </div>
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
