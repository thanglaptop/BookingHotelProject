<button type="button" class=" btn btn-success" style="white-space: nowrap;" data-bs-toggle="modal"
        data-bs-target="#add-detail-ddp"><i class="bi bi-plus-circle"></i> Tạo</button>
        @include('owner/mainownercontent/pminfocontent/addpminfo')
<div class="row">
    <div class="col-12 text-center">
        <h3>Danh sách thông tin thanh toán</h3>
    </div>
    @foreach ($hotelpminfo as $pm)
        <div class="p-4 pb-0">
            <div class="card h-100">
                <div class="row p-3">
                    <h4 class="card-title text-center">{{ $pm->pm_name }}</h4>
                    <div class="col-12 d-flex justify-content-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="add-pm-athotel"
                                @if ($pm->pm_athotel == 1) checked @endif disabled>
                            <label class="form-check-label" for="add-pm-athotel" style="font-weight: 600;">Cho phép
                                thanh toán
                                tại khách sạn</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 p-2 gap-2 d-flex align-items-center justify-content-center flex-column">
                        <div style="font-weight: 600;">Momo</div>
                        <img src="/images/other/placeholder-image.png" class="rounded"
                            style="width: 120px; height: 120px; object-fit: cover;" />
                        <div>{{ $pm->pm_momo }}</div>
                    </div>

                    <div class="col-6 col-md-3 p-2 gap-2 d-flex align-items-center justify-content-center flex-column">
                        <div style="font-weight: 600;">Ngân hàng</div>
                        <img src="/images/other/placeholder-image.png" class="rounded"
                            style="width: 120px; height: 120px; object-fit: cover;" />
                        <div>{{ $pm->pm_bank }}</div>
                    </div>
                    <div class="col-12 col-md-5 p-2">{{$pm->pm_mota}}</div>
                    <div class="nhom-button col-12">
                        <a href="/owner/editRoom.html"><button type="button" class="btn btn-primary">Sửa</button></a>
                        <button type="button" class="btn btn-danger">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


</div>
