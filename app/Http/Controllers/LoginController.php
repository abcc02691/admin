<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use DB;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // login
    public function index(Request $input){
        $account        = $input->account;
        $password       = $input->password;

        $account_data = DB::connection('test')
                    ->table('users')
                    ->where('account','=',$account)
                    ->where('password','=',$password)
                    ->get();
        if(isset($account_data[0])){
            $status= $account_data[0]->status;
            if($status==0){
                return json_encode("帳號審核中");
            }else{
                return json_encode("帳號登入成功");
            }
        }else{
            return json_encode("帳號不存在或密碼錯誤") ;
        }
    }
    //create page
    public function create_index(){
        $orgs = DB::connection('test')->table('orgs')->get();
        return view('create_account',['create' => '', 'org'=>json_encode($orgs)]);
    }
    //create account
    public function create(Request $input){
        $account    =isset($input->account)  ? $input->account  : "_";
        $password   =isset($input->password) ? $input->password : "_";
        $username   =isset($input->username) ? $input->username : "_";
        $email      =isset($input->email)    ? $input->email    : "_";
        $birthday   =isset($input->birthday) ? $input->birthday : "";

        $org_name   = $input->org_no;
        $image      = $input->file('file');
        $file_path  = Storage::putFile('public', $image);

        if($account != '_' && $password != '_' && $username != '_' && $email != '_' ){
            $account_data=DB::connection('test')
                    ->table('users')
                    ->where('account', '=', $account)
                    ->get();

            if(isset($account_data[0])){
                $orgs = DB::connection('test')->table('orgs')->get();
                return view('create_account', ['create' => 'exist', 'org' => json_encode($orgs)]);
            }

            $org_no = DB::connection('test')
                    ->table('orgs')
                    ->select('id')
                    ->where('title', '=', $org_name)
                    ->get();

            $user_id = DB::connection('test')->table('users')->insertGetId([
                'name'      => $username,
                'birthday'  => $birthday,
                'email'     => $email,
                'account'   => $account,
                'password'  => $password,
                'org_id'    =>$org_no[0]->id
            ]);

            DB::connection('test')->table('apply_file')->insertGetId([
                'user_id'    => $user_id,
                'file_path'  => $file_path,
            ]);
        }else{
            $orgs = DB::connection('test')->table('orgs')->get();
            return view('create_account', ['create' => 'error', 'org' => json_encode($orgs)]);
        }

        return view('login', ['create'=>'success']);
    }
    //create org
    public function create_org(Request $input){
        $title  = $input->title;
        $org_no = $input->org_no;

        $exsit = DB::connection('test')
                ->table('orgs')
                ->where('org_no', '=', $org_no)
                ->get();

        if(isset($exsit[0])){
            return json_encode("該組織已存在");
        }else{
            DB::connection('test')->table('orgs')->insert([
                "title"  => $title,
                "org_no" => $org_no
            ]);
            return json_encode("建立成功");
        }
    }
}
