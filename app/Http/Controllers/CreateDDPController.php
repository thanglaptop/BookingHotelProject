<?php

namespace App\Http\Controllers;

use App\Models\Detail_Ddp;
use App\Models\Dondatphong;
use Illuminate\Http\Request;

class CreateDDPController
{
    public function taoDDP(Request $request){
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

        if($validated['room']){
            if($customerid){
                $ddp=Dondatphong::create([
                    'ddp_ngaydat' => date('Y-m-d'),
                    'ddp_customername' => $validated['name'],
                    'ddp_sdt' => $validated['sdt'],
                    'ddp_total' => $validated['total'],
                    'ddp_pttt' => $validated['thanhtoan'],
                    'ddp_status' => "confirmed",
                    'c_id' => $customerid
                ]);
            }else if($hotelid){
                $ddp=Dondatphong::create([
                    'ddp_ngaydat' => date('Y-m-d'),
                    'ddp_customername' => $validated['name'],
                    'ddp_sdt' => $validated['sdt'],
                    'ddp_total' => $validated['total'],
                    'ddp_pttt' => $validated['thanhtoan'],
                    'ddp_status' => "confirmed",
                    'h_id' => $hotelid
                ]);
            }else{
                return redirect()->back()
                ->with('errorddp', 'Tạo đơn đặt phòng thất bại');
            }
            
            for($i=0; $i < count($validated['room']);$i++){
                Detail_Ddp::create([
                    'detail_checkin' => $validated['checkin'],
                    'detail_checkout' => $validated['checkout'],
                    'detail_soluong' => $validated['soluong'][$i],
                    'detail_thanhtien' => $validated['thanhtien'][$i],
                    'r_id' => $validated['room'][$i],
                    'ddp_id' => $ddp->ddp_id
                ]);
            }
            return redirect()->back()
                ->with('successddp', 'Tạo đơn đặt phòng thành công');
        }
        

    }
}
