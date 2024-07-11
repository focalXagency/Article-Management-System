<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'request_data_id',
    ];

    public function articles(){
        return $this->belongsToMany(Article::class);
    }

    public function userData(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function blocks(){
        return $this->belongsToMany(User::class, 'blocks');
    }

    public function requestData(){
        return $this->belongsTo(RequestsData::class, 'request_data_id');
    }
}
