<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="type";
    protected $primaryKey="id";
    protected $fillable=["id","typeName"];
}
