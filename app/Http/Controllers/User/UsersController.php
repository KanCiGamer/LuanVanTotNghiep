<?php

namespace App\Http\Controllers\User;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;
use App\Http\Controllers\Controller;
use App\Mail\resetPassWord;
use App\Models\invoice;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function register(Request $rq)
    {
        
        $rq->validate([
            'user_name' => 'required',
            // 'user_phone' => 'required|unique:users',
            // 'user_email' => 'required|email|unique:users',
            'user_gender' => 'required',
            'user_date_of_birth' => 'required|date',
            'user_password' => 'required|min:8',
        ]);

        $sdt =  Users::where('user_phone', $rq->input('user_phone'))->first();
        $email =  Users::where('user_email', $rq->input('user_email'))->first();
        if ($sdt) {
            return redirect('/login')->withErrors([
                'error_phone' => 'Số điện thoại đã tồn tại',
            ]);
        } else if ($email) {
            return redirect('/login')->withErrors([
                'error_email' => 'Email đã tồn tại',
            ]);
        } else {
            $user = new Users;
            $user->user_id = 'USER' . str_pad((Users::count() + 1), 6, '0', STR_PAD_LEFT);
            $user->user_name = $rq->user_name;
            $user->user_phone = $rq->user_phone;
            $user->user_email = $rq->user_email;
            $user->user_gender = $rq->user_gender;
            $user->user_date_of_birth = $rq->user_date_of_birth;
            $user->user_password = bcrypt($rq->user_password);
            $user->role_id = 0;

            $token = Str::random(255);
            $user->verification_token = $token;

            $user->save();

            $verificationUrl = url('/verify/' . $token);

            Mail::to($user->user_email)->send(new VerifyEmail($user, $verificationUrl));

            //Auth::guard('users')->login($user);
            return redirect()->route('VerifyNotify');
        }
        
    }

    public function login(Request $rq)
    {
        $account = $rq->input('account');
        $password = $rq->input('user_password');
        // kiểm tra giá trị nhập vào là email
        if (filter_var($account, FILTER_VALIDATE_EMAIL)) {
            $user = Users::where('user_email', $account)->first();
            if (!$user) {
                return redirect('/login')->withErrors([
                    'error' => 'Tài khoản không tồn tại',
                ]);
            } else if (!$user->verification) {
                return redirect()->route('VerifyNotify');
            } else if (Auth::guard('users')->attempt(['user_email' => $account, 'password' => $password])) {
                if (Auth::guard('users')->user()->role_id == 0) {
                    if(Auth::guard('users')->user()->block == 1)
                    {
                        return redirect('/login')->withErrors([
                            'error' => 'Tài khoản bị khóa',
                        ]);
                    }
                    else
                    {
                        return redirect()->route('home');
                    }
                    
                } else if (Auth::guard('users')->user()->role_id == 5) {
                    return redirect()->route('AdminPage');
                }
            } else {
                return redirect('/login')->withErrors([
                    'error' => 'Tài khoản hoặc mật khẩu không đúng!',
                ]);
            }
        } // kiểm tra giá trị nhập vào là số điện thoại
        else if (preg_match('/^[0-9]{10}$/', $account)) {
            $user = Users::where('user_phone', $account)->first();
            if (!$user) {
                return redirect('/login')->withErrors([
                    'error' => 'Tài khoản không tồn tại',
                ]);
            } else if (!$user->verification) {
                return redirect()->route('VerifyNotify');
            } else if(!$user->block)
            {
                return redirect('/notify')->withErrors([
                    'error' => 'Tài khoản bị khóa',
                ]);
            } 
            else if (Auth::guard('users')->attempt(['user_phone' => $account, 'password' => $password])) {
                if (Auth::guard('users')->user()->role_id == 0) {
                    return redirect()->route('home');
                } else if (Auth::guard('users')->user()->role_id == 5) {
                    return redirect()->route('AdminPage');
                }
            } else {
                return redirect('/login')->withErrors([
                    'error' => 'Tài khoản hoặc mật khẩu không đúng!',
                ]);
            }
        }
    }
    private function verifyAccount($accountField, $account, $password)
    {
        $user = Users::where($accountField, $account)->first();
        if (!$user) {
            return redirect('/login')->withErrors([
                'error' => 'Tài khoản không tồn tại',
            ]);
        } else if (!$user->verification) {
            return redirect()->route('VerifyNotify');
        } else if (Auth::guard('users')->attempt([$accountField => $account, 'password' => $password])) {
            if (Auth::guard('users')->user()->role_id == 0) {
                return redirect()->route('home');
            } else if (Auth::guard('users')->user()->role_id == 5) {
                return redirect()->route('AdminPage');
            }
        } else {
            return redirect('/login')->withErrors([
                'error' => 'Tài khoản hoặc mật khẩu không đúng!',
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('users')->logout();
        return redirect()->route('home');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Users::findOrFail($id);
        $invoice = $user->invoice;
        //dd($invoice);
        return view('user.user', compact('user', 'invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $user = Users::findOrFail($id);
    }
    public function updateInfor(Request $request, $id)
    {
        $user = Users::findOrFail($id);
        $email = $request->input('user_email');
        $phone = $request->input('user_phone');
        $name = $request->input('user_name');
        $gender = $request->input('user_gender');
        if ($user->user_email != $email) { 
            $validEmail = Users::where('user_email', $email)->first();
            if ($validEmail) {
                return redirect()->back()->withErrors([
                    'error_email' => 'Email đã tồn tại',
                ]);
            } 
        }
        if ($user->user_phone != $phone) {
            $validPhone = Users::where('user_phone', $phone)->first();
            if ($validPhone) {
                return redirect()->back()->withErrors([
                    'error_phone' => 'Số điện thoại đã tồn tại',
                ]);
            }
        }
        $user->user_email = $email;
        $user->user_phone = $phone;
        $user->user_gender = $gender;
        $user->user_name = $name;
        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }
    public function updatePassword(Request $request, $id)
    {
        $user = Users::findOrFail($id);
        $password = $request->input('user_password');
        $new_password = $request->input('new_user_password');

        if(!Hash::check($password,$user->user_password))
        {
            return back()->withErrors(['error_password' => 'Mật khẩu cũ không chính xác.']);
        }
        $user->user_password = bcrypt($new_password);
        $user->save();
        return redirect()->back()->with('successp', 'Cập nhật mật khẩu thành công!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function showRSPassWord()
    {
        return view('user.rspassword');
    }
    public function SendMailRSPassWord(Request $rq)
    {
        $email = $rq->input('user_email');
        $user = Users::where('user_email', $email)->first();
        //dd($user);
        if($user)
        {
            $token = Str::random(255);
            $user->verification_token = $token;
            $user->save();
            $verificationUrl = url('/rs-password/' . $token);
            Mail::to($user->user_email)->send(new resetPassWord($verificationUrl));
            return back()->with('message', 'Chúng tôi đã gửi email đặt lại mật khẩu. Vui lòng kiểm tra hộp thư đến của bạn.');
        }
       else{
        return back()->with('message', 'Tài khoản không tồn tại');
       }
    }
    public function verifyRePass($token)
    {
        $user = Users::where('verification_token', $token)->first();

        if ($user) {
            return view('user.set_password', ['user' => $user, 'token' => $token]); 
        } else {
            return redirect()->route('VerifyNotify')->with('error', 'Có lỗi xảy ra khi đặt lại mật khẩu');
        }
    }
    public function rePass(Request $request)
    {
        $user = Users::where('user_id', $request->input('user_id'))->first();
        if($user)
        {
            $user->user_password = bcrypt($request->user_password);
            $user->save();
            return redirect()->route('UserLogin')->with('success', 'Đổi mật khẩu tài khoản thành công!');
        }else{
            return back()->with('message', 'Lỗi khi cập nhật mật khẩu.');
        }
    }
    public function verifyToken($token)
    {
        $user = Users::where('verification_token', $token)->first();

        if ($user) {
            $user->verification = true;
            $user->save();
            return redirect()->route('UserLogin')->with('success', 'Xác minh tài khoản thành công!');
        } else {
            return redirect()->route('VerifyNotify')->with('error', 'Xác minh thất bại!');
        }
    }
}
