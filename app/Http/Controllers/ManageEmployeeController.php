<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManageEmployeeController
{
    public function addEmployee(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:30',
            'hotel' => 'required|integer',
            'username' => 'required|string|max:30',
            'password' => 'required|string|max:30',
        ]);

        // Kiểm tra xem username đã tồn tại hay chưa
        $existingEmp = Employee::where('e_username', $validated['username'])->first();
        if ($existingEmp) {
            return redirect()->back()
                ->with('error', 'Tên đăng nhập đã tồn tại trong hệ thống!');
        }

        Employee::create([
            'e_username' => $validated['username'],
            'e_pass' => Hash::make($validated['password']),
            'e_name' => $validated['fullname'],
            'o_id' => Auth::guard('owner')->user()->o_id,
            'h_id' => $validated['hotel']
        ]);
        return redirect()->back()
            ->with('success', 'Tạo nhân viên mới thành công');
    }

    public function showEditEmployee($nvid)
    {
        $nv = Employee::findOrFail($nvid);

        return view('owner/mainownercontent/editnv', ['nv' => $nv]);
    }

    public function updateEmployee(Request $request)
    {
        $validated = $request->validate([
            'nvid' => 'required|integer',
            'fullname' => 'required|string|max:30',
            'hotel' => 'required|integer',
            'username' => 'required|string|max:30',
            'password' => 'required|string|max:30',
        ]);
        $nv = Employee::findOrFail($validated['nvid']);

        $existingOwner = Owner::where('o_id', $nv->o_id)->first();
        if (!Hash::check($validated['password'], $existingOwner->o_pass)) {
            return redirect()->back()
                ->with('error', 'Mật khẩu chủ khách sạn không chính xác');
        }
        if ($nv->e_username != $validated['username']) {
            // Kiểm tra xem username đã tồn tại hay chưa
            $existingEmp = Employee::where('e_username', $validated['username'])->first();
            if ($existingEmp) {
                return redirect()->back()
                    ->with('error', 'Tên đăng nhập đã tồn tại trong hệ thống!');
            }
            $nv->update([
                'e_username' => $validated['username'],
                'h_id' => $validated['hotel'],
                'e_name' => $validated['fullname'],
            ]);
            return redirect()->back()
                ->with('success', 'sửa thông tin nhân viên thành công');
        } else if ($nv->e_username == $validated['username']) {
            $nv->update([
                'h_id' => $validated['hotel'],
                'e_name' => $validated['fullname'],
            ]);
            return redirect()->back()
                ->with('success', 'sửa thông tin nhân viên thành công');
        }
    }

    public function updateEmployeePassword(Request $request)
    {
        $validated = $request->validate([
            'nvid' => 'required|integer',
            'newpassword' => 'required|string|max:30',
            'ownerpassword' => 'required|string|max:30',
        ]);
        $nv = Employee::findOrFail($validated['nvid']);
        $existingOwner = Owner::where('o_id', $nv->o_id)->first();
        if (!Hash::check($validated['ownerpassword'], $existingOwner->o_pass)) {
            return redirect()->back()
                ->with('errorpw', 'Mật khẩu chủ khách sạn không chính xác');
        }
        $nv->update([
            'e_pass' => Hash::make($validated['newpassword'])
        ]);
        return redirect()->back()
            ->with('successpw', 'Đổi mật khẩu nhân viên thành công');
    }

    public function deleteEmployee($eid){
        Employee::where('e_id', $eid)->delete();
        return back()->with('success', 'xóa nhân viên thành công');
    }
}
