<?php

namespace App\Http\Controllers;

use App\Models\Dondatphong;
use App\Models\Hotel;
use App\Models\Paymnet_Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagePaymentInfoController
{
    public function addPaymentInfo(Request $request)
    {
        $namepm = $request->input('namepm');
        $allowpayathotel = $request->input('allowpayathotel') ? 1 : 0;
        $momo = $request->input('momonumber');
        $bank = $request->input('banknumber');
        $mota = $request->input('mota');
        $momoQR = $request->file('momoQR');
        $bankQR = $request->file('bankQR');
        // dd($namepm,$allowpayathotel, $momo, $bank, $momoQR, $bankQR);

        if ($momoQR && $bankQR) {
            $nameQRmomo = "momo" . time() . "." . $momoQR->getClientOriginalExtension();
            $nameQRbank = "bank" . time() . "." . $bankQR->getClientOriginalExtension();
            Paymnet_Info::create([
                'pm_name' => $namepm,
                'pm_athotel' => $allowpayathotel,
                'pm_momo' => $momo,
                'pm_bank' => $bank,
                'pm_QRmomo' => $nameQRmomo,
                'pm_QRbank' => $nameQRbank,
                'pm_mota' => $mota,
                'o_id' => Auth::guard('owner')->user()->o_id
            ]);

            // Tạo thư mục lưu ảnh
            $directorymomo = "images/QRmomo/";
            $directorybank = "images/QRbank/";
            // 1. Lưu hình ảnh
            $imagePaths = [];
            $momoimagename = $nameQRmomo; // Đặt tên file
            $momoQR->move(public_path($directorymomo), $momoimagename); // Lưu vào thư mục
            $bankimagename = $nameQRbank; // Đặt tên file
            $bankQR->move(public_path($directorybank), $bankimagename); // Lưu vào thư mục
            $imagePaths[] = $directorymomo . $momoimagename; // Lưu đường dẫn
            $imagePaths[] = $directorybank . $bankimagename; // Lưu đường dẫn
            return back()->with('success', 'tạo thông tin thanh toán thành công');
        } else {
            return back()->with('error', 'bạn phải thêm ảnh QR momo và ngân hàng');
        }
    }

    public function updatePaymentInfo(Request $request)
    {
        $pmid = $request->input('pmid');
        $namepm = $request->input('namepm');
        $allowpayathotel = $request->input('allowpayathotel') ? 1 : 0;
        $momo = $request->input('momonumber');
        $bank = $request->input('banknumber');
        $mota = $request->input('mota');
        $momoQR = $request->file('momoQR');
        $bankQR = $request->file('bankQR');

        $pm_info = Paymnet_Info::firstWhere('pm_id', $pmid);

        $momoQRname =  ($momoQR) ? "momo" . time() . "." . $momoQR->getClientOriginalExtension() : null;
        $bankQRname = ($bankQR) ? "bank" . time() . "." . $bankQR->getClientOriginalExtension() : null;

        Paymnet_Info::where('pm_id', $pmid)->update([
            'pm_name' => $namepm,
            'pm_athotel' => $allowpayathotel,
            'pm_momo' => $momo,
            'pm_bank' => $bank,
            'pm_QRmomo' => $momoQRname ?? $pm_info->pm_QRmomo,
            'pm_QRbank' => $bankQRname ?? $pm_info->pm_QRbank,
            'pm_mota' => $mota,
        ]);

        // Tạo thư mục lưu ảnh
        $directorymomo = "images/QRmomo/";
        $directorybank = "images/QRbank/";
        $imagePaths = [];

        //xóa QRmomo cũ
        if ($momoQR) {
            $momoPath = public_path($directorymomo . $pm_info->pm_QRmomo);
            if (file_exists($momoPath)) {
                unlink($momoPath); // Xóa file vật lý
            }
            $momoimagename = $momoQRname; // Đặt tên file
            $momoQR->move(public_path($directorymomo), $momoimagename); // Lưu vào thư mục
            $imagePaths[] = $directorymomo . $momoimagename; // Lưu đường dẫn
        }
        //xóa QRbank cũ
        if ($bankQR) {
            $bankPath = public_path($directorybank . $pm_info->pm_QRbank);
            if (file_exists($bankPath)) {
                unlink($bankPath); // Xóa file vật lý
            }
            $bankimagename = $bankQRname; // Đặt tên file
            $bankQR->move(public_path($directorybank), $bankimagename); // Lưu vào thư mục
            $imagePaths[] = $directorybank . $bankimagename; // Lưu đường dẫn
        }
        return redirect()->route('paymentinfo')->with('success', 'cập nhật thông tin thanh toán thành công');
    }

    public function deletePaymentInfo($pmid)
    {
        $exists = Hotel::where('pm_id', $pmid)->exists();
        if (!$exists) {
            $pm_info = Paymnet_Info::firstWhere('pm_id', $pmid);
            // Tạo thư mục lưu ảnh
            $directorymomo = "images/QRmomo/";
            $directorybank = "images/QRbank/";
            $momoPath = public_path($directorymomo . $pm_info->pm_QRmomo);
            if (file_exists($momoPath)) {
                unlink($momoPath); // Xóa file vật lý
            }
            $bankPath = public_path($directorybank . $pm_info->pm_QRbank);
            if (file_exists($bankPath)) {
                unlink($bankPath); // Xóa file vật lý
            }
            Paymnet_Info::where('pm_id', $pmid)->delete();
            return redirect()->back()->with('success', 'xóa thông tin thanh toán thành công');
        } else {
            return back()->with('error', 'không thể xóa vì có khách sạn đang dùng thông tin thanh toán này');
        }
    }
}
