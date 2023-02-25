<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'question', 'closing_at', 'archived_at'];

    public function options(){
        return $this->hasMany(PollOption::class);
    }

    public function votes(){
        return $this->hasMany(PollVote::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
