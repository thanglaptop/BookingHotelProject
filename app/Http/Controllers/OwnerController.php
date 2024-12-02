<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\Detail_Ddp;
use App\Models\Employee;
use App\Models\Hotel;
use App\Models\Loaihinh;
use App\Models\Owner;
use App\Models\Paymnet_Info;
use App\Models\Room;
use App\Models\Room_Img;
use App\Models\Tiennghi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Traits\myHelper;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OwnerController
{
    use myHelper;

    public function dangKy(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string||min:3|max:30',
            'sdt' => 'required|string|regex:/^0[0-9]{9}$/',
            'email' => 'required|email',
            'birthday' => 'required|date',
            'username' => 'required|string|min:15|max:30',
            'password' => 'required|string|min:8|max:20',
        ]);


        // Kiểm tra xem username đã tồn tại hay chưa
        $existingCus = Customer::where('c_username', $validated['username'])->first();
        if ($existingCus) {
            return redirect()->back()
                ->with('error', 'Tên đăng nhập đã tồn tại trong hệ thống!');
        }

        $existingEmail = Customer::where('c_email', $validated['email'])->first();
        if ($existingEmail) {
            return redirect()->back()
                ->with('error', 'Email đã tồn tại trong hệ thống!');
        }

        // Lưu người dùng vào cơ sở dữ liệu
        $customer = Customer::create([
            'c_name' => $validated['fullname'],
            'c_sdt' => $validated['sdt'],
            'c_email' => $validated['email'],
            'c_nsinh' => $validated['birthday'],
            'c_username' => $validated['username'],
            'c_pass' => Hash::make($validated['password']),
        ]);

        Auth::guard('customer')->login($customer);
        return redirect()->route('index')->with('successlogin', 'Đăng ký thành công!');
    }

    public function ForgetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
        ]);
        // Kiểm tra email có tồn tại không
        $customer = Customer::where('c_username', $request->username)->where('c_email', $request->email)->first();
        $owner = Owner::where('o_username', $request->username)->where('o_email', $request->email)->first();
        if ($customer) {
            $newPassword = Str::random(10);

            Customer::where('c_id', $customer->c_id)->update([
                'c_pass' => Hash::make($newPassword)
            ]);
            $name = $customer->c_name;
            // Gửi email
            Mail::send('tablogin/reset_password', ['name' => $name, 'newPassword' => $newPassword], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Khôi phục mật khẩu khách hàng');
            });

            return back()->with('success', 'Mật khẩu mới đã được gửi đến email của bạn!');
        } else if ($owner) {
            $newPassword = Str::random(10);
            Owner::where('o_id', $owner->o_id)->update([
                'o_pass' => Hash::make($newPassword)
            ]);
            $name = $owner->o_name;
            // Gửi email
            Mail::send('tablogin/reset_password', ['name' => $name, 'newPassword' => $newPassword], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Khôi phục mật khẩu chủ khách sạn');
            });

            return back()->with('success', 'Mật khẩu mới đã được gửi đến email của bạn!');
        }
        return back()->with('error', 'Tên đăng nhập hoặc email không tồn tại trong hệ thống');
    }



    public function checkOwnerLogin(Request $req)
    {
        $logininfo = $req->only('txtOUsername', 'txtOPass');
        $owner = Owner::where('o_username',  $logininfo['txtOUsername'])->first();
        $employee = Employee::where('e_username',  $logininfo['txtOUsername'])->first();
        if ($owner && Hash::check($logininfo['txtOPass'], $owner->o_pass)) {

            // Đăng nhập thành công, chuyển hướng tới trang chủ
            Auth::guard('owner')->login($owner);
            return redirect()->route('mainowner');
        } else if ($employee && Hash::check($logininfo['txtOPass'], $employee->e_pass)) {
            Auth::guard('employee')->login($employee);
            return redirect()->route('employee.managehotel', ['id' => $employee->h_id]);
        }
        return back()->withErrors(['message' => 'Đăng nhập thất bại!']);
    }

    public function ownerLogout()
    {
        Auth::guard('owner')->logout();
        session()->flush();  // Clear the session
        return redirect()->route('index');
    }

    public function employeeLogout()
    {
        Auth::guard('employee')->logout();
        session()->flush();  // Clear the session
        return redirect()->route('index');
    }

    public function showMainOwner()
    {
        $cities = City::all();
        $loaihinhs = Loaihinh::all();
        $tiennghihotel = Tiennghi::all()->where('tn_ofhotel', 1);
        $hotelpminfo = Paymnet_Info::all()->where('o_id', $this->ownerId());

        return view('owner/mainowner', [
            'tiennghihotel' => $tiennghihotel,
            'cities' => $cities,
            'loaihinhs' => $loaihinhs,
            'hotelpminfo' => $hotelpminfo
        ]);
    }

    public function showManageHotel($id, $daystart, $dayend)
    {
        $ownerId = $this->ownerId(); // Lấy ID của chủ sở hữu
        $employee = $this->Employee(); // Lấy ID của nhân viên
        if ($ownerId) {
            $hotel = Hotel::where('h_id', $id)->where('o_id', $ownerId)->first();
        }

        if ($employee) {
            $hotel = Hotel::join('employee', 'hotel.h_id', '=', 'employee.h_id')
                ->where('hotel.h_id', $id)
                ->where('employee.e_id', $employee->e_id)
                ->select('hotel.*') // Chỉ chọn cột từ bảng hotels (nếu cần)
                ->first();
        }
        if(!$hotel){
            return redirect()->back();
        }
        $listddp = $hotel->dondatphongs()->whereBetween('ddp_ngaydat', [$daystart, $dayend])->get();
        $listtiennghi = Tiennghi::all()->where('tn_ofhotel', 0);
        return view('owner/managehotel', ['hotel' => $hotel, 'listtiennghi' => $listtiennghi, 'listddp' => $listddp]);
    }



    public function showEditHotel($id)
    {
        //owner chỉ có thể truy cập ks của mình không truy cập ks của người khác thông qua url 
        $hotel = Hotel::where('h_id', $id)->where('o_id', $this->ownerId())->first();
        if(!$hotel){
            return redirect()->back();
        }
        $cities = City::all();
        $loaihinhs = Loaihinh::all();
        $tiennghihotel = Tiennghi::all()->where('tn_ofhotel', 1);
        $hotelpminfo = Paymnet_Info::all()->where('o_id', $hotel->o_id);
        $listTnOfHotel = $hotel->dsTienNghi->pluck('tn_id')->toArray();
        // Truyền dữ liệu owner sang view 'welcome'
        return view('owner/edithotel', [
            'hotel' => $hotel,
            'cities' => $cities,
            'loaihinhs' => $loaihinhs,
            'tiennghihotel' => $tiennghihotel,
            'hotelpminfo' => $hotelpminfo,
            'listTnOfHotel' => $listTnOfHotel
        ]);
    }

    public function showEditRoom($rid, $hid)
    {
        //trả về phòng thuộc khách sạn thuộc owner đang đăng nhập
        $room = Room::where('r_id', $rid)->where('h_id', $this->hotelOfOwner($hid))->first();
        if(!$room){
            return redirect()->back();
        }
        $tiennghiroom = Tiennghi::all()->where('tn_ofhotel', 0);
        $listTnOfRoom = $room->dsTienNghi->pluck('tn_id')->toArray();
        // Truyền dữ liệu owner sang view 'welcome'
        return view('owner/managehotelcontent/editroom', ['room' => $room, 'tiennghiroom' => $tiennghiroom, 'listTnOfRoom' => $listTnOfRoom]);
    }


    public function showPageCreateDDP($hid, Request $request)
    {
        // Lấy thông tin khách sạn
        $hotel = null;
        if ($this->ownerId()) {
            $hotel = Hotel::where('h_id', $this->hotelOfOwner($hid))->first();
            // dd($hotel);
        } else if ($this->Employee()) {
            $hotel = Hotel::where('h_id', $this->Employee()->h_id)->first();
        }
        // Kiểm tra nếu không tìm thấy hotel
        if ($hotel && $hotel->h_id != $hid || !$hotel) {
            return redirect()->back();
        }
        $validated = $request->validate([
            'name' => 'required|string||min:3|max:30',
            'sdt' => 'required|string|regex:/^0[0-9]{9}$/',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
        ]);
        // Lấy danh sách phòng của khách sạn
        $listroom = Room::where('h_id', $hotel->h_id)->get();
        $checkin = $validated['checkin'];
        $checkout = $validated['checkout'];

        $roomsWithRemainingQuantity = $listroom->map(function ($room) use ($checkin, $checkout) {

            $bookedQuantity = Detail_Ddp::where('r_id', $room->r_id)
                ->where(function ($query) use ($checkin, $checkout) {
                    $query->where(function ($subquery) use ($checkin, $checkout) {
                        // Điều kiện khoảng ngày đặt phòng trùng với khoảng ngày tìm kiếm
                        $subquery->where('detail_checkin', '<', $checkout)
                            ->where('detail_checkout', '>', $checkin);
                    });
                })
                ->sum('detail_soluong');
            // Tính số lượng phòng còn lại
            $remainingQuantity = max(0, $room->r_soluong - $bookedQuantity);

            // Trả về thông tin phòng và số lượng còn lại
            return [
                'r_id' => $room->r_id,
                'r_name' => $room->r_name,
                'r_price' => $room->r_price,
                'r_soluong' => $room->r_soluong,
                'remaining_quantity' => $remainingQuantity,
                'r_maxadult' => $room->r_maxadult,
                'r_maxkid' => $room->r_maxkid,
                'r_maxperson' => $room->r_maxperson,
                'r_dientich' => $room->r_dientich,
            ];
        });

        // Trả về view với dữ liệu
        return view('owner/managehotelcontent/createddp', [
            'hotel' => $hotel,
            'hoten' => $validated['name'],
            'sdt' => $validated['sdt'],
            'checkin' => $checkin,
            'checkout' => $checkout,
            'listroom' => $roomsWithRemainingQuantity,
            'checkin' => $checkin,
            'checkout' => $checkout
        ]);
    }


    public function showEditPM($pmid)
    {
        $pm = Paymnet_Info::where('pm_id', $pmid)->firstOrFail();
        return view('owner/mainownercontent/pminfocontent/editpm', ['pm' => $pm]);
    }
}
