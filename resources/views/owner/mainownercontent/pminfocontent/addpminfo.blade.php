<div class="modal fade" id="add-detail-ddp" tabindex="-1" aria-labelledby="add-detail-ddp" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm thông tin thanh toán</h1>
            </div>
            <div class="modal-body">
                <form id="formDatPhong" action="{{ route('addpaymentinfo') }}" class="row g-3 needs-validation"
                    method="POST" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        <label for="add-pm_name" class="form-label">Tên thông tin thanh toán</label>
                        <input type="text" name="namepm" class="form-control border-secondary pm-name"
                            id="add-pm_name" required>
                        <div class="invalid-feedback pm-name-feedback">
                            hãy nhập tên thông tin thanh toán
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input border-secondary" name="allowpayathotel" type="checkbox"
                                role="switch" id="add-pm-athotel">
                            <label class="form-check-label" for="add-pm-athotel">Cho phép thanh toán
                                tại khách sạn</label>
                        </div>
                    </div>
                    <div class="col-6 p-2">
                        <div style="font-weight: 600;">Momo</div>
                        <div class="row d-flex align-items-center">

                            <div class="col-md-7 col-12">
                                <label for="add-pm-momo" class="form-label">Số momo</label>
                                <input type="text" name="momonumber"
                                    class="form-control border-secondary momo-number" id="add-pm-momo" required>
                                <div class="invalid-feedback momo-number-feedback">
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
                                        <input type="file" name="momoQR" class="form-control d-none" id="QRMomo"
                                            onchange="displaySelectedImage(event, 'selectedMomo')" required />
                                            <div class="invalid-feedback">
                                                hãy thêm ảnh QR momo
                                            </div>
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
                                <input type="text" name="banknumber"
                                    class="form-control border-secondary bank-number" id="add-pm-bank" required>
                                <div class="invalid-feedback bank-number-feedback">
                                    hãy nhập số ngân hàng
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
                                        <input type="file" name="bankQR" class="form-control d-none" id="QRBank"
                                            onchange="displaySelectedImage(event, 'selectedBank')" required />
                                            <div class="invalid-feedback">
                                                hãy thêm ảnh QR ngân hàng
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="add-pm-describe" class="form-label">Mô tả thông tin thanh toán</label>
                        <textarea name="mota" class="form-control border-secondary pm-mota-input" id="add-pm-describe" style="height: 120px;"
                            required></textarea>
                        <div class="invalid-feedback pm-mota-feedback">
                            hãy nhập mô tả thông tin thanh toán
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
