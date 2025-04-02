<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\book;
use App\Models\Member;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    private function respond($state, $message, $data = null)
    {
        return response()->json(["state" => $state, "message" => $message, "data" => $data],200);
    }


    public function index()
       {$member=(new Member)->memberCount();
        $product=(new Product)->productCount();
        $book=(new book)->bookCount();
        $sum=(new book)->bookSum();
        return view("front.index",compact('member','product','book','sum'));
    }
    public function product(Request $req)
    {
        $type=$req->type;
        return view("front.product",compact('type'));
    }

    public function chkUniAcc(Request $req)
    {
        if (isset($req->email)) {
            $email = trim($req->email);
            if ($email) {
                $result = (new Member)->checkMember($email);
                if ($result) {
                    return $this->respond(false, "帳號已存在");
                } else {
                    return $this->respond(true, "帳號可使用");
                }
            } else {
                return $this->respond(false, "欄位空值!");
            }
        } else {
            return $this->respond(false, "欄位錯誤!");
        }
    }

    public function register(Request $req)
    {
        
        $data = json_decode($req->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->respond(false, "無效的 JSON 數據: " . json_last_error_msg());
        }

        if (isset($data['email'], $data['password'], $data['username'], $data['city'], $data['address'], $data['birthday'])) {
            $email = trim($data['email']);
            $password = trim($data['password']);
            $name = trim($data['username']);
            $city = trim($data['city']);
            $birthday = trim($data['birthday']);
            $address = trim($data['address']);
            $result = (new Member)->checkMember($email);
                if ($result) {
                    return $this->respond(false, "帳號已存在");

                }

            if ($email && $password && $name && $city && $birthday && $address) {
                $member = new Member();
                $member->email = $email;
                $member->password = password_hash($password, PASSWORD_DEFAULT);
                $member->name = $name;
                $member->city = $city;
                $member->birthday = $birthday;
                $member->address = $address;
                $member->save();
                $member->password = $password;
                return $this->respond(true, "註冊完成!", $member);
            } else {
                return $this->respond(false, "欄位空值!");
            }
        } else {
            return $this->respond(false, "欄位錯誤!");
        }
    }



    public function login(Request $req)
    {
        $data = json_decode($req->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->respond(false, "無效的 JSON 數據: " . json_last_error_msg());
        }
        if (isset($data['email'], $data['password'])) {
            $email = trim($data['email']);
            $password = trim($data['password']);
            if ($email) {
                $result = (new Member)->checkMember($email);
                if ($result->level==0){
                    return $this->respond(false, "帳號停權");
                }

                if ($result && password_verify($password, $result->password)) {
                    unset($result->password);
                    session()->put("member", $result);
                    return $this->respond(true, "登入成功","/client/index");
                } else {
                    return $this->respond(false, "登入失敗");
                }
            } else {
                return $this->respond(false, "欄位空值!");
            }
        } else {
            return $this->respond(false, "欄位錯誤!");
        }
    }
    public function logout()
    {
        session()->flush();

        return redirect('/'); 
    }
    public function gettype()
    {
        $list = Type::get();
        if ($list) {
            return $this->respond(true, "", $list);
        } else {
            return $this->respond(false, "介接資料庫錯誤");
        }

    }
    public function getProduct()
    {
        $list = Product::get();
        if ($list) {
            return $this->respond(true, "", $list);
        } else {
            return $this->respond(false, "介接資料庫錯誤");
        }

    }
}

