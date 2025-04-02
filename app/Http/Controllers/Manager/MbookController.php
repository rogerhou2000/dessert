<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\book;
use Illuminate\Http\Request;

class MbookController extends Controller
{
    private function respond($state, $message, $data = null)
    {
        return response()->json(["state" => $state, "message" => $message, "data" => $data], 200);
    }
    public function index()
    {
        return view("manager.book");
    } //
    public function clientBook()
    {
        try {
            $book = (new book)->bookAll()->get();
            return $this->respond(true, "查詢成功", $book);
        } catch (\Exception $e) {
            return $this->respond(false, "查詢失敗：" . $e->getMessage());
        }
    }
}
