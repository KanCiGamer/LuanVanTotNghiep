<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;

class UserController extends Controller
{
    public function index()
    {
        $users = Users::paginate(10);
        //$users = Users::all();
        //dd ($users);
        return view('admin.user.user', compact('users'));
    }
    public function updateStatus(Request $request, $id)
    {
        $user =  Users::findOrFail($id);
        $user->update(['block' => $request->input('block')]);
        return redirect()->back()->with('success', 'Cập nhật trạng thái người dùng thành công!');
    }
    public function UserInfor($id)
    {
        $user =  Users::findOrFail($id);
        return view('admin.user.user_infor', compact('user'));
    }
}
