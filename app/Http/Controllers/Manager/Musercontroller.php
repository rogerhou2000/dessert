<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;

class Musercontroller extends Controller
{
    //
    private function respond($state, $message, $data = null)
    {
        return response()->json(["state" => $state, "message" => $message, "data" => $data], 200);
    }
    public function user()
    {
        return view("manager.user");
    } //// //

    public function userList()
    {
        $list = (new Member())->getUser();
        if ($list) {
            return $this->respond(true, "", $list);
        } else {
            return $this->respond(false, "介接資料庫錯誤");
        }
    }
    public function updateUserLevel(Request $req)
    {
        $data = json_decode($req->getContent(), true);

        // 檢查 JSON 格式
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->respond(false, "無效的 JSON 數據: " . json_last_error_msg());
        }

        // 檢查必要欄位
        if (!isset($data['id'], $data['level'])) {
            return $this->respond(
                false,
                "欄位錯誤!"
            );
        }


        // 提取數據
        $userId = trim($data['id']);
        $newLevel = trim($data['level']);

        // 查詢用戶
        $action = Member::find($userId);

        if (!$action) {
            return $this->respond(false, "查無此用戶");
        }

        try {
            // 設定等級邏輯
            if ($newLevel > 0) {
                $action->level = $action->sumPrice >= 2000 ? 20 : 10;
            } else {
                $action->level = 0;
            }

            // 保存到資料庫
            $action->save();

            return $this->respond(true, "更新成功");
        } catch (Exception $e) {
            // 捕捉錯誤
            return $this->respond(false, "更新失敗：" . $e->getMessage());
        }
    }
}
