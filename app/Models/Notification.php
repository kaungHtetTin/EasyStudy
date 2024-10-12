<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public function notification_type(){
        return $this->belongsTo(NotificationType::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
