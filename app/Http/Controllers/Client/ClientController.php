<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\book;
use App\Models\Member;
use App\Models\sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    private function respond($state, $message, $data = null)
    {
        return response()->json(["state" => $state, "message" => $message, "data" => $data], 200);
    }
    public function index()
    {
        return view("client.index");
    } //// //
    public function submitSale(Request $req)
    {
        if (
            !$req->has('buyData') || !$req->has('deliver') || !$req->has('levelOff') ||
            !$req->has('birthdayOff') || !$req->has('totalPrice') || !$req->has('discountPrice')
        ) {
            return $this->respond(false, "欄位缺失！", $req->all());
        }



        DB::beginTransaction();

        try {
            $book = new book();
            $book->userid = session()->get("member")->id;
            $book->totalPrice = $req->totalPrice;
            $book->address = $req->deliver;
            $book->lDiscount = filter_var($req->levelOff, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
            $book->bDiscount = filter_var($req->birthdayOff, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
            $book->discPrice = $req->discountPrice;
            $book->save();
            $bookId = $book->id;
            foreach ($req->buyData as $item) {
                $sale = new Sale();
                $sale->bookId = $bookId;
                $sale->productId = $item['id']; // 使用 [] 訪問陣列元素
                $sale->amount = $item['amount'];
                $sale->pPrice = $item['price'];
                $sale->pTotalPrice = $item['price'] * $item['amount'];
                $sale->save();
            }
            $member=Member::find(session()->get("member")->id);
            $member->sumPrice+=$book->discPrice; 
            if($member->level<100&&$member->sumPrice>1000){
                $member->level=20;
            }
            $member->save();
             unset($member->password);
             session()->put("member", $member);
           

            DB::commit();



            return $this->respond(true, "更新成功！");
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respond(false, "更新失敗：" . $e->getMessage());
        }
    } 
    public function book()
    {
        return view("client.book");
    }
    public function clientBook(){
        try{
        $book=(new book)->book(session()->get("member")->id)->get();
        return $this->respond(true, "查詢成功",$book);
    }catch(\Exception $e){
        return $this->respond(false, "查詢失敗：" . $e->getMessage());
    }
    }
    public function findBook(Request $req){
        try{
        $sale=(new sale)->findBook($req->id)->get();
        return $this->respond(true, "查詢成功",$sale);
    }catch(\Exception $e){
        return $this->respond(false, "查詢失敗：" . $e->getMessage());
    }
    }
   

}
