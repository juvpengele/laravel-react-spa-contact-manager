<?php

namespace App\Models;

use App\VO\ImageUploader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ["image_name", "name", "description", "user_id"];

    public function image()
    {
        return new ImageUploader($this);
    }
}
