<?php

namespace App\Http\Controllers;

use App\Models\Detail_Ddp;
use App\Models\Dondatphong;
use App\Models\Giohang;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Traits\myHelper;
use Illuminate\Support\Facades\Auth;

class CreateDDPController
{
    use myHelper;
    public function taoDDP(Request $request)
    {
        // dd($request->input('room'), $request->input('soluong'));
        $validated = $request->validate([
            'name' => 'required|string||min:3|max:30',
            'sdt' => 'required|string|regex:/^0[0-9]{9}$/',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
            'thanhtoan' => 'required|string',
            'room' => 'required|array',
            'soluong' => 'required|array',
            'thanhtien' => 'required|array',
            'total' => 'required|integer',
            'cid' => 'nullable|integer',
            'hid' => 'nullable|integer'
        ]);
        $customerid = $validated['cid'] ?? null;
        $hotelid = $validated['hid'] ?? null;

        if ($validated['room']) {
            if ($customerid) {
                $ddp = Dondatphong::create([
                    'ddp_ngaydat' => date('Y-m-d'),
                    'ddp_customername' => $validated['name'],
                    'ddp_sdt' => $validated['sdt'],
                    'ddp_total' => $validated['total'],
                    'ddp_pttt' => $validated['thanhtoan'],
                    'ddp_status' => "confirmed",
                    'c_id' => $customerid
                ]);
            } else if ($hotelid) {
                $ddp = Dondatphong::create([
                    'ddp_ngaydat' => date('Y-m-d'),
                    'ddp_customername' => $validated['name'],
                    'ddp_sdt' => $validated['sdt'],
                    'ddp_total' => $validated['total'],
                    'ddp_pttt' => $validated['thanhtoan'],
                    'ddp_status' => "confirmed",
                    'h_id' => $hotelid
                ]);
            } else {
                return redirect()->back()
                    ->with('error', 'Tạo đơn đặt phòng thất bại');
            }

            for ($i = 0; $i < count($validated['room']); $i++) {
                Detail_Ddp::create([
                    'detail_checkin' => $validated['checkin'],
                    'detail_checkout' => $validated['checkout'],
                    'detail_soluong' => $validated['soluong'][$i],
                    'detail_thanhtien' => $validated['thanhtien'][$i],
                    'r_id' => $validated['room'][$i],
                    'ddp_id' => $ddp->ddp_id
                ]);
            }
            // Trả về URL lưu trong session hoặc fallback về `managehotel`
            return redirect(session('previous_url', route('owner.managehotel', ['id' => $ddp->h_id, 'tab' => 'don-dat-phong'])))
                ->with('success', 'Tạo đơn đặt phòng thành công!');
        }
    }

    public function showDetailDDP($ddpid, $hid)
    {
        $ddp = Dondatphong::where('ddp_id', $ddpid)->where('h_id', $this->hotelOfOwner($hid))->first();
        if (!$ddp) {
            return redirect()->back();
        }
        $listroom = Room::all();
        return view('owner/managehotelcontent/detailddp', ['ddp' => $ddp, 'listroom' => $listroom]);
    }

    public function updateStatusDDP(Request $request)
    {
        $validated = $request->validate([
            'ddpid' => 'required|integer',
            'status' => 'required|string',
        ]);

        $ddp = Dondatphong::where('ddp_id', $validated['ddpid'])->firstOrFail();
        $ddp->update(['ddp_status' => $validated['status']]);
        // Trả về URL lưu trong session hoặc fallback về `managehotel`
        return redirect(session('previous_url', route('owner.managehotel', ['id' => $ddp->h_id, 'tab' => 'don-dat-phong'])))
            ->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function customerTaoDDP(Request $request)
    {
        $name = $request->input('name');
        $sdt = $request->input('sdt');
        $listhotel = $request->input('listhotel');
        $listcheckin = $request->input('listcheckin');
        $listcheckout = $request->input('listcheckout');
        $listtongcong = $request->input('listtongcong');

        $listroom = $request->input('listroom');
        $listhotelId = $request->input('listhotelId');
        $listcheckinofroom = $request->input('listcheckinofroom');
        $listcheckoutofroom = $request->input('listcheckoutofroom');
        $listsoluong = $request->input('listsoluong');
        $listthanhtien = $request->input('listthanhtien');

        $customerID = Auth::guard('customer')->user()->c_id;
        $booknow = $request->input('booknow');
        for ($hotel = 0; $hotel < count($listhotel); $hotel++) {
            $radioname = $listhotel[$hotel] . 'rdb' . $listcheckin[$hotel] . 'rdb' . $listcheckout[$hotel];
            $ddp = Dondatphong::create([
                'ddp_ngaydat' => date('Y-m-d'),
                'ddp_customername' => $name,
                'ddp_sdt' => $sdt,
                'ddp_total' => $listtongcong[$hotel],
                'ddp_pttt' => $request->input($radioname),
                'c_id' => $customerID,
                'h_id' => $listhotel[$hotel],
            ]);

            for ($room = 0; $room < count($listroom); $room++) {
                if ($listhotelId[$room] == $listhotel[$hotel] && $listcheckinofroom[$room] == $listcheckin[$hotel] && $listcheckoutofroom[$room] == $listcheckout[$hotel]) {
                    Detail_Ddp::create([
                        'detail_checkin' => $listcheckin[$hotel],
                        'detail_checkout' => $listcheckout[$hotel],
                        'detail_soluong' => $listsoluong[$room],
                        'detail_thanhtien' => $listthanhtien[$room],
                        'r_id' => $listroom[$room],
                        'ddp_id' => $ddp->ddp_id
                    ]);
                    if (!isset($booknow)) {
                        $cart = Giohang::where('C_ID', $customerID)->where('R_ID', $listroom[$room])
                            ->where('g_checkin', $listcheckin[$hotel])->where('g_checkout', $listcheckout[$hotel])->first();
                        if ($cart) {
                            Giohang::where('C_ID', $customerID)->where('R_ID', $listroom[$room])
                                ->where('g_checkin', $listcheckin[$hotel])->where('g_checkout', $listcheckout[$hotel])->delete();
                        }
                    }
                }
            }
        }
        return redirect()->route('showddp')->with('success', 'tạo đơn đặt phòng thành công');
    }
}
