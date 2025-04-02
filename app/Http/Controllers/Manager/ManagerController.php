<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\book;
use App\Models\Member;
use App\Models\Product;
use App\Models\sale;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    private function respond($state, $message, $data = null)
    {
        return response()->json(["state" => $state, "message" => $message, "data" => $data],200);
    }
    public function index()
    {
        $member=(new Member)->memberCount();
        $product=(new Product)->productCount();
        $book=(new book)->bookCount();
        $sum=(new book)->bookSum();
        $age=(new Member)->memberAge()->get();
        $region=(new Member)->memberRegion()->get();
        $productAmount=(new sale)->saleProduct()->get();
        return view("manager.index",compact('member','product','book','sum','age','region','productAmount'));
    }//// //
    
   
    
}
