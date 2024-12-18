<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Hotel_Img;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\myHelper;
use Illuminate\Support\Facades\Hash;

class ManageHotelController
{
    use myHelper;

    public function addHotel(Request $request)
    {
        $validated = $request->validate([
            'hinh' => 'required|array|min:1', // Đảm bảo ít nhất có 1 ảnh
            'hinh.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Kiểm tra từng ảnh
            'newhinh' => 'nullable|array',
            'loaihinh' => 'required|integer',
            'city' => 'required|integer',
            'sdt' => 'required|string|regex:/^0[0-9]{9}$/', // Số điện thoại bắt đầu bằng 0 và có đúng 10 chữ số
            'hname' => 'required|string|max:50', // Tên khách sạn tối đa 255 ký tự
            'hdchi' => 'required|string|max:100', // Địa chỉ tối đa 255 ký tự
            'hmota' => 'required|string|max:400', // Mô tả tối đa 1000 ký tự
            'tttt' => 'required|integer',
            'tiennghi' => 'nullable|array', // Tiện ích phòng là mảng (có thể không chọn gì)
            'tiennghi.*' => 'integer',
        ]);
       


        // Insert data into the database
        $hotel = Hotel::create([
            'h_name' => $validated['hname'],
            'h_dchi' => $validated['hdchi'],
            'h_sdt' => $validated['sdt'],
            'h_mota' => $validated['hmota'],
            'lh_id' => $validated['loaihinh'],
            'ct_id' => $validated['city'],
            'pm_id' => $validated['tttt'],
            'o_id' => Auth::guard('owner')->user()->o_id,
        ]);
        // Tạo thư mục lưu ảnh
        $directory = "images/hotels/h{$hotel->h_id}/";

        
        // 1. Lưu hình ảnh
        $imagePaths = [];
        if ($request->hasFile('hinh')) {
            for($i = 0; $i < count($validated['hinh']); $i++){
                for($j = 0; $j < count($validated['newhinh']); $j++){
                    if($validated['hinh'][$i]->getClientOriginalName() == $validated['newhinh'][$j]){
                        $filename = uniqid() . '.' . $validated['hinh'][$i]->getClientOriginalExtension(); // Đặt tên file
                        $validated['hinh'][$i]->move(public_path($directory), $filename); // Lưu vào thư mục
                        $imagePaths[] = $directory . $filename; // Lưu đường dẫn
                        Hotel_Img::create([
                            'h_id' => $hotel->h_id,  // Mã phòng
                            'hi_name' => $filename,  // Tên ảnh đã lưu
                            'hi_vitri' => $j+1
                        ]);
                    }
                }
            }
        }

        // Lưu các tiện nghi vào bảng room_tiennghi
        if (!empty($validated['tiennghi'])) {
            $hotel->dsTienNghi()->attach($validated['tiennghi']);
        }

        return redirect()->route('mainowner');
    }



    public function updateHotel(Request $request, $hotelId)
    {
        $validated = $request->validate([
            'hinh' => 'nullable|array', // Đảm bảo ít nhất có 1 ảnh
            'hinh.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096', // Kiểm tra từng ảnh
            'newhinh' => 'nullable|array',
            'loaihinh' => 'required|integer',
            'city' => 'required|integer',
            'sdt' => 'required|string|regex:/^0[0-9]{9}$/', // Số điện thoại bắt đầu bằng 0 và có đúng 10 chữ số
            'hname' => 'required|string|max:50', // Tên khách sạn tối đa 255 ký tự
            'hdchi' => 'required|string|max:100', // Địa chỉ tối đa 255 ký tự
            'hmota' => 'required|string|max:400', // Mô tả tối đa 1000 ký tự
            'tttt' => 'required|integer',
            'tiennghi' => 'nullable|array', // Tiện ích phòng là mảng (có thể không chọn gì)
            'tiennghi.*' => 'integer',
        ]);

        // Lấy thông tin phòng hiện tại
        $hotel = Hotel::findOrFail($hotelId);

        // Thư mục chứa ảnh
        $directory = "images/hotels/h{$hotel->h_id}/";

        foreach ($hotel->hotel_imgs as $img) {
            //xóa ảnh cũ trước
            if (!in_array($img->hi_name, $validated['newhinh'])) {
                $imagePath = public_path($directory . $img->hi_name);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Xóa file vật lý
                }
                Hotel_Img::where('hi_name', $img->hi_name)->delete();
            }
        }

        $imagePaths = [];
        if ($request->hasFile('hinh')) {
            foreach ($validated['hinh'] as $newimg) {
                $filename = uniqid() . '.' . $newimg->getClientOriginalExtension(); // Đặt tên file
                foreach ($validated['newhinh'] as $key => $tenhinh) {
                    if ($tenhinh == $newimg->getClientOriginalName()) {
                        $validated['newhinh'][$key] = $filename; // Cập nhật giá trị trong mảng
                        break;
                    }
                }
                $newimg->move(public_path($directory), $filename); // Lưu vào thư mục
                $imagePaths[] = $directory . $filename; // Lưu đường dẫn

                $vitri = count($hotel->hotel_imgs) + 1; // Mặc định là vị trí mới là count + 1
                $existingImage = $hotel->hotel_imgs->firstWhere('hi_vitri', 0); // Kiểm tra nếu có ảnh nào có ri_vitri = 0
                if ($existingImage) {
                    $vitri = 1; // Nếu có, vị trí sẽ là 1
                }
                Hotel_Img::create([
                    'h_id' => $hotel->h_id,  // Mã phòng
                    'hi_name' => $filename,  // Tên ảnh đã lưu
                    'hi_vitri' => $vitri
                ]);
            }
        }
        $hotel->load('hotel_imgs');
        // dd($hotel->hotel_imgs, $validated['newhinh']);
        // //cập nhật vị trí
        for($i = 0; $i < count($hotel->hotel_imgs); $i++){
            for($j = 0; $j < count($validated['newhinh']); $j++){
                if($hotel->hotel_imgs[$i]['hi_name'] == $validated['newhinh'][$j]){
                    $name = $hotel->hotel_imgs[$i]['hi_name'];
                    Hotel_Img::where('h_id', $hotel->h_id)->where('hi_name', $name)->update(['hi_vitri' => $j+1]);
                }
            }
        }

        // Cập nhật thông tin phòng
        $hotel->update([
            'h_name' => $validated['hname'],
            'h_dchi' => $validated['hdchi'],
            'h_sdt' => $validated['sdt'],
            'h_mota' => $validated['hmota'],
            'lh_id' => $validated['loaihinh'],
            'ct_id' => $validated['city'],
            'pm_id' => $validated['tttt']
        ]);


        // 2. Cập nhật tiện nghi
        if (!empty($validated['tiennghi'])) {
            // Xóa các tiện nghi hiện tại
            $hotel->dsTienNghi()->detach();
            // Gắn lại tiện nghi mới
            $hotel->dsTienNghi()->attach($validated['tiennghi']);
        }

        // 3. Chuyển hướng về trang quản lý khách sạn
        return redirect()->route('mainowner');
    }

    public function showCloseHotel($hid){
        $hotel = Hotel::firstWhere('h_id', $this->hotelOfOwner($hid));
        return view('owner/closehotel', ['hotel'=> $hotel]);
    }

    public function closeHotel($hid, Request $request){
        $owner = Auth::guard('owner')->user();
        $ngaydong = $request->input('dayclose');
        $ngaymo = $request->input('dayopen');

        if(!$ngaymo || !$ngaydong){
            return back()->with('error', 'không được bỏ trống ngày đóng và ngày mở');
        }

        $pass = $request->input('pw');

        if(!Hash::check($pass, $owner->o_pass)){
            return redirect()->back()->with('error', 'mật khẩu không chính xác');
        }

        $closeAvailable = $this->returnResultAvailableClose($hid, $ngaydong, $ngaymo);
        if(!$closeAvailable){
            return redirect()->back()->with('error', 'không thể đóng cửa trong khoảng thời gian có đơn đặt phòng');
        }else{
            Hotel::where('h_id', $hid)->update([
                'h_isclose' => 1,
                'h_dateclose' => $ngaydong,
                'h_dateopen' => $ngaymo
            ]);
            return redirect()->route('mainowner')->with('success', 'đóng cửa khách sạn thành công');
        }
    }

    public function openHotel($hid, Request $request){
        $owner = Auth::guard('owner')->user();
        $pass = $request->input('pw');
        if(!Hash::check($pass, $owner->o_pass)){
            return redirect()->back()->with('error', 'mật khẩu không chính xác');
        }
        Hotel::where('h_id', $hid)->update([
            'h_isclose' => 0,
            'h_dateclose' => null,
            'h_dateopen' => null
        ]);
        return redirect()->route('mainowner')->with('success', 'mở cửa khách sạn thành công');
    }
}