<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumStars extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','creator_id','stars'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
