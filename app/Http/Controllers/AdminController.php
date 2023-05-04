<?php

namespace App\Http\Controllers;

use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

session_start();


class AdminController extends Controller
{
    //
    public function login()
    {
        return view('admin.login');
    }

    public function admin_index()
    {
        $this->is_login();
        return view('admin.main');
    }

    public function check_login(Request $request)
    {
        $email = $request->admin_email;
        $password = md5($request->admin_password);
        $admin = Admin::where('admin_email', $email)->where('admin_password', $password)->first();

        if ($admin) {
            Session::put('admin_name', $admin->admin_name);
            Session::put('admin_id', $admin->id);
            redirect('admin_index')->send();
        } else {
            Session::flash('message', 'Email hoặc mật khẩu không đúng');

            return view('admin.login');
        }
    }

    public function logout_admin()
    {
        $this->is_login();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return view('admin.login');
    }
}