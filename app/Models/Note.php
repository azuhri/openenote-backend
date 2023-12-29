<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    public $incrementing = \false;
    public $keyType = "string";
    protected $fillable = [
        "id",
        "user_id",
        "title",
        "content",
        "public_can_edit_link",
        "public_show_link",
    ];
}
