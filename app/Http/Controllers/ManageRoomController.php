<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Room_Img;
use Illuminate\Http\Request;
use App\Traits\myHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManageRoomController
{
    use myHelper;

    public function addRoom(Request $request)
    {
        $validated = $request->validate([
            'hid' => 'required|integer',
            'hinh' => 'required|array', // Dạng mảng vì có nhiều ảnh
            'hinh.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096', // Validation ảnh
            'newhinh' => 'nullable|array',
            'rname' => 'required|string|max:50',
            'rprice' => 'required|numeric|min:50000',
            'rsoluong' => 'required|integer|min:1',
            'rmota' => 'required|string|max:400',
            'rdientich' => 'required|integer|min:10',
            'rmaxadult' => 'required|integer|min:0',
            'rmaxkid' => 'required|integer|min:0',
            'rmaxperson' => 'required|integer|min:0',
            'tiennghi' => 'nullable|array', // Tiện nghi là mảng
            'tiennghi.*' => 'integer', // Đảm bảo tiện nghi tồn tại
        ]);


        $hotelId = $validated['hid'];
        // Insert data into the database
        $room = Room::create([
            'r_name' => $validated['rname'],
            'r_price' => $validated['rprice'],
            'r_soluong' => $validated['rsoluong'],
            'r_mota' => $validated['rmota'],
            'r_dientich' => $validated['rdientich'],
            'r_maxadult' => $validated['rmaxadult'],
            'r_maxkid' => $validated['rmaxkid'],
            'r_maxperson' => $validated['rmaxperson'],
            'h_id' => $hotelId
        ]);
        // Tạo thư mục lưu ảnh
        $directory = "images/hotels/h{$hotelId}/room/r{$room->r_id}/";


        // 1. Lưu hình ảnh
        $imagePaths = [];
        if ($request->hasFile('hinh')) {
            for ($i = 0; $i < count($validated['hinh']); $i++) {
                for ($j = 0; $j < count($validated['newhinh']); $j++) {
                    if ($validated['hinh'][$i]->getClientOriginalName() == $validated['newhinh'][$j]) {
                        $filename = uniqid() . '.' . $validated['hinh'][$i]->getClientOriginalExtension(); // Đặt tên file
                        $validated['hinh'][$i]->move(public_path($directory), $filename); // Lưu vào thư mục
                        $imagePaths[] = $directory . $filename; // Lưu đường dẫn
                        Room_Img::create([
                            'r_id' => $room->r_id,  // Mã phòng
                            'ri_name' => $filename,  // Tên ảnh đã lưu
                            'ri_vitri' => $j + 1
                        ]);
                    }
                }
            }
        }

        // Lưu các tiện nghi vào bảng room_tiennghi
        if (!empty($validated['tiennghi'])) {
            $room->dsTienNghi()->attach($validated['tiennghi']);
        }

        return redirect(route('owner.managehotel', ['id' => $hotelId, 'tab' => 'manage-phong']))
            ->with('success', 'Tạo phòng thành công!');
    }



    public function updateRoom(Request $request, $roomId)
    {
        $validated = $request->validate([
            'hinh' => 'nullable|array', // Hình ảnh là tùy chọn
            'hinh.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096', // Validation ảnh
            'newhinh' => 'nullable|array',
            'rname' => 'required|string|max:50',
            'rprice' => 'required|numeric',
            'rsoluong' => 'required|integer|min:1',
            'rmota' => 'required|string|max:400',
            'rdientich' => 'required|integer|min:10',
            'rmaxadult' => 'required|integer|min:0',
            'rmaxkid' => 'required|integer|min:0',
            'rmaxperson' => 'required|integer|min:0',
            'tiennghi' => 'nullable|array', // Tiện nghi là mảng
            'tiennghi.*' => 'integer', // Đảm bảo tiện nghi tồn tại
        ]);

        // Lấy thông tin phòng hiện tại
        $room = Room::findOrFail($roomId);

        $hotelId = $room->h_id;

        if ($room->r_id <= 135) {
            $phandu = $room->r_id % 5;
            if ($phandu != 0) {
                $roomnumber = $phandu;
            } else {
                $roomnumber = 5;
            }
        } else {
            $roomnumber = $room->r_id;
        }
        // Thư mục chứa ảnh
        $directory = "images/hotels/h{$hotelId}/room/r{$roomnumber}/";

        foreach ($room->room_imgs as $img) {
            //xóa ảnh cũ trước
            if (!in_array($img->ri_name, $validated['newhinh'])) {
                $imagePath = public_path($directory . $img->ri_name);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Xóa file vật lý
                }
                Room_Img::where('ri_name', $img->ri_name)->delete();
                // $image->delete(); // Xóa khỏi database
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

                $vitri = count($room->room_imgs) + 1; // Mặc định là vị trí mới là count + 1
                $existingImage = $room->room_imgs->firstWhere('ri_vitri', 0); // Kiểm tra nếu có ảnh nào có ri_vitri = 0
                if ($existingImage) {
                    $vitri = 1; // Nếu có, vị trí sẽ là 1
                }
                Room_Img::create([
                    'r_id' => $room->r_id,  // Mã phòng
                    'ri_name' => $filename,  // Tên ảnh đã lưu
                    'ri_vitri' => $vitri
                ]);
            }
        }
        $room->load('room_imgs');
        // //cập nhật vị trí
        for ($i = 0; $i < count($room->room_imgs); $i++) {
            for ($j = 0; $j < count($validated['newhinh']); $j++) {
                if ($room->room_imgs[$i]['ri_name'] == $validated['newhinh'][$j]) {
                    $name = $room->room_imgs[$i]['ri_name'];
                    Room_Img::where('r_id', $room->r_id)->where('ri_name', $name)->update(['ri_vitri' => $j + 1]);
                }
            }
        }


        // Cập nhật thông tin phòng
        $room->update([
            'r_name' => $validated['rname'],
            'r_price' => $validated['rprice'],
            'r_soluong' => $validated['rsoluong'],
            'r_mota' => $validated['rmota'],
            'r_dientich' => $validated['rdientich'],
            'r_maxadult' => $validated['rmaxadult'],
            'r_maxkid' => $validated['rmaxkid'],
            'r_maxperson' => $validated['rmaxperson']
        ]);


        // 2. Cập nhật tiện nghi
        if (!empty($validated['tiennghi'])) {
            // Xóa các tiện nghi hiện tại
            $room->dsTienNghi()->detach();
            // Gắn lại tiện nghi mới
            $room->dsTienNghi()->attach($validated['tiennghi']);
        }

        // 3. Chuyển hướng về trang quản lý khách sạn
        return redirect(route('owner.managehotel', ['id' => $hotelId, 'tab' => 'manage-phong']))
            ->with('success', 'cập nhật phòng thành công!');
    }

    public function showCloseRoom($rid, $hid)
    {
        $room = Room::where('r_id', $rid)->where('h_id', $this->hotelOfOwner($hid))->first();
        return view('owner/managehotelcontent/closeroom', ['room' => $room]);
    }

    public function closeRoom($rid, Request $request)
    {
        $owner = Auth::guard('owner')->user();
        $ngaydong = $request->input('dayclose');
        $ngaymo = $request->input('dayopen');
        $pass = $request->input('pw');
        if (!$ngaymo || !$ngaydong) {
            return back()->with('error', 'không được bỏ trống ngày đóng và ngày mở');
        }
        if (!Hash::check($pass, $owner->o_pass)) {
            return redirect()->back()->with('error', 'mật khẩu không chính xác');
        }

        $closeAvailable = $this->returnResultAvailableRoomClose($rid, $ngaydong, $ngaymo);
        if (!$closeAvailable) {
            return redirect()->back()->with('error', 'không thể đóng phòng trong khoảng thời gian có đơn đặt phòng');
        } else {
            Room::where('r_id', $rid)->update([
                'r_isclose' => 1,
                'r_dateclose' => $ngaydong,
                'r_dateopen' => $ngaymo
            ]);

            $hotelId = Room::firstWhere('r_id', $rid)->hotel->h_id;
            return redirect(route('owner.managehotel', ['id' => $hotelId, 'tab' => 'manage-phong']))
                ->with('success', 'đóng phòng thành công');
        }
    }

    public function openRoom($rid, Request $request)
    {
        $owner = Auth::guard('owner')->user();
        $pass = $request->input('pw');
        if (!Hash::check($pass, $owner->o_pass)) {
            return redirect()->back()->with('error', 'mật khẩu không chính xác');
        }
        Room::where('r_id', $rid)->update([
            'r_isclose' => 0,
            'r_dateclose' => null,
            'r_dateopen' => null
        ]);
        $hotelId = Room::firstWhere('r_id', $rid)->hotel->h_id;
        return redirect(route('owner.managehotel', ['id' => $hotelId, 'tab' => 'manage-phong']))
            ->with('success', 'mở phòng thành công');
    }
}