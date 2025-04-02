<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    public static function uploadPhoto($photo, $path )
    {
        
        // 資料夾不存在時
        if (!file_exists($path))
        {
            // 建資料夾， 允許讀(4)，寫(2)，執行(1)
            mkdir($path, 0777);
        }
        
     
        $ext = $photo->extension();
        

        $times = explode(" ", microtime());

        $fileName = date("Y_m_d_H_i_s_", $times[1]).substr($times[0],2,3).".".$ext;
        

        // 將上傳檔案由暫存區移至指定資料夾
        $photo->move($path, $fileName);
        return $fileName;
}

}
