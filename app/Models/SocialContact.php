<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialContact extends Model
{
    use HasFactory;
    public function social_media(){
        return $this->belongsTo(SocialMedia::class);
    }
}
