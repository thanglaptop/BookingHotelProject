<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\Detail_Ddp;
use App\Models\Dondatphong;
use App\Models\Employee;
use App\Models\Hotel;
use App\Models\Loaihinh;
use App\Models\Owner;
use App\Models\Paymnet_Info;
use App\Models\Room;
use App\Models\Tiennghi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\myHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        return redirect()->route('index')->with('success', 'Đăng ký thành công!');
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
            return redirect()->route('employee.managehotel', ['id' => $employee->h_id, 'tab' => 'don-dat-phong']);
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

    public function showManageHotel($id, $tab, Request $request)
    {
        $hotel = $this->returnHotelBelong($id);
        if (!$hotel) {
            return redirect()->back();
        }
        $ngaybd = $request->input('daystart') ?? date('Y-m-d');
        $ngaykt = $request->input('dayend') ?? date('Y-m-d', strtotime('+1 day'));

        if($ngaykt < $ngaybd){
            return back()->with('error', 'ngày kết thúc không được nhỏ hơn ngày bắt đầu');
        }
        $sdt = $request->input('sdttim') . trim("");

        if ($ngaybd && $ngaykt && $sdt) {
            // dd($ngaybd, $ngaykt, $sdt);
            $listddp = $hotel->dondatphongs()
                ->whereBetween('ddp_ngaydat', [$ngaybd, $ngaykt])
                ->where('ddp_sdt', $sdt)->get();
        } else if ($ngaybd && $ngaykt) {
            // dd($ngaybd, $ngaykt, $sdt);
            $listddp = $hotel->dondatphongs()->whereBetween('ddp_ngaydat', [$ngaybd, $ngaykt])->get();
        } else {
            $listddp = $hotel->dondatphongs()->whereBetween('ddp_ngaydat', [date('Y-m-d'), date('Y-m-d')])->get();
        }
        $listroom = $this->returnListRoomWithRemainQuantity($hotel->h_id, date('Y-m-d'), date('Y-m-d'));
        $listtiennghi = Tiennghi::all()->where('tn_ofhotel', 0);
        // Lưu URL hiện tại vào session
        session(['previous_url' => $request->fullUrl()]);
        return view('owner/managehotel', ['hotel' => $hotel, 'listtiennghi' => $listtiennghi, 'listddp' => $listddp, 'listroom' => $listroom, 'tab' => $tab]);
    }



    public function showEditHotel($id)
    {
        //owner chỉ có thể truy cập ks của mình không truy cập ks của người khác thông qua url 
        $hotel = Hotel::where('h_id', $id)->where('o_id', $this->ownerId())->first();
        if (!$hotel) {
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
        if (!$room) {
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
        $checkin = $validated['checkin'];
        $checkout = $validated['checkout'];
        if(!$checkin || !$checkout){
            return back()->with('error', 'không được bỏ trống ngày checkin và ngày checkout');
        }
        if($checkout < $checkin){
            return back()->with('error', 'ngày checkout không được nhỏ hơn ngày checkin');
        }
        $Listroom = $this->returnListRoomWithRemainQuantity($hotel->h_id, $checkin, $checkout);


        // Trả về view với dữ liệu
        return view('owner/managehotelcontent/createddp', [
            'hotel' => $hotel,
            'hoten' => $validated['name'],
            'sdt' => $validated['sdt'],
            'checkin' => $checkin,
            'checkout' => $checkout,
            'listroom' => $Listroom,
            'checkin' => $checkin,
            'checkout' => $checkout
        ]);
    }


    public function showEditPM($pmid)
    {
        $pm = Paymnet_Info::where('pm_id', $pmid)->firstOrFail();
        return view('owner/mainownercontent/pminfocontent/editpm', ['pm' => $pm]);
    }

    public function showDanhThuPage(Request $request)
    {

        $ownerId = $this->ownerId();
        $ngaybd = $request->input('daystart') ?? date('Y-m-d');
        $ngaykt = $request->input('dayend') ?? date('Y-m-d');
        if($ngaykt < $ngaybd){
            return back();
        }
        $thang = $request->input('thang');
        $year = Carbon::now()->year;
        if ($ngaybd && $ngaykt) {
            $listhotelwithrevenue = $this->returnListHotelWithRevenue($ownerId, $ngaybd, $ngaykt);
        } else if ($thang != 0) {
            $ngaybd = Carbon::create($year, $thang, 1)->startOfMonth()->toDateString();
            $ngaykt = Carbon::create($year, $thang, 1)->endOfMonth()->toDateString();
            $listhotelwithrevenue = $this->returnListHotelWithRevenue($ownerId, $ngaybd, $ngaykt);
        } else {
            $ngaybd = date('Y-m-d');
            $ngaykt = date('Y-m-d');
            $listhotelwithrevenue = $this->returnListHotelWithRevenue($ownerId, $ngaybd, $ngaykt);
        }
        $totalrevenue = 0;
        $totalddp = 0;
        foreach ($listhotelwithrevenue as $hotel) {
            $totalrevenue += $hotel['h_doanhthu'];
            $totalddp += $hotel['h_ddp'];
        }
        return view('owner/mainownercontent/doanhthu', ['listhotelwithrevenue' => $listhotelwithrevenue, 'ngaybd' => $ngaybd, 'ngaykt' => $ngaykt, 'totalrevenue' => $totalrevenue, 'totalddp' => $totalddp]);
    }

    public function changeOwnerPassWord(Request $request)
    {
        $owner = Auth::guard('owner')->user();
        $mkcu = $request->input('oldpass');
        $mkmoi = $request->input('newpass');
        $retypepass = $request->input('retypepass');

        if (!Hash::check($mkcu, $owner->o_pass)) {
            return redirect()->back()->with('error', 'mật khẩu cũ không chính xác');
        }

        if ($retypepass != $mkmoi) {
            return redirect()->back()->with('error', 'mật khẩu nhập lại không chính xác');
        }

        Owner::where('o_id', $owner->o_id)->update([
            'o_pass' => Hash::make($mkmoi)
        ]);
        return redirect()->back()->with('success', 'đổi mật khẩu thành công');
    }

    public function showDanhGiaForOwner(Request $request)
    {
        $hotelId = $request->input('hotel');
        $star = $request->input('star');

        if(($hotelId == 0 && $star == 0) || ($hotelId == 0 && $star != 0)){
        $owner = Auth::guard('owner')->user();
        $listhotelId = $owner->hotels->pluck('h_id');
        }
        // dd($hotelId, $star);
        if ($hotelId != 0 && $star != 0) {
            $listddpId = Dondatphong::where('h_id', $hotelId)->where('ddp_status', 'rated')->pluck('ddp_id');
            $listdetail = Detail_Ddp::whereIn('ddp_id', $listddpId)->whereHas('danhgia', function ($query) use ($star) {
                $query->where('dg_star', $star);
            })->get();
        } else if($hotelId != 0 && $star == 0){
            $listddpId = Dondatphong::where('h_id', $hotelId)->where('ddp_status', 'rated')->pluck('ddp_id');
            $listdetail = Detail_Ddp::whereIn('ddp_id', $listddpId)->get();
        }else if($hotelId == 0 && $star != 0){
            $listddpId = Dondatphong::whereIn('h_id', $listhotelId)->where('ddp_status', 'rated')->pluck('ddp_id');
            $listdetail = Detail_Ddp::whereIn('ddp_id', $listddpId)->whereHas('danhgia', function ($query) use ($star) {
                $query->where('dg_star', $star);
            })->get();
        }else{
            $listddpId = Dondatphong::whereIn('h_id', $listhotelId)->where('ddp_status', 'rated')->pluck('ddp_id');
            $listdetail = Detail_Ddp::whereIn('ddp_id', $listddpId)->get();
        }
       
        return view('owner/mainownercontent/danhgia', ['listdetail' => $listdetail]);
    }
}
