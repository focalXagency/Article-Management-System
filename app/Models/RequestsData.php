<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsData extends Model
{
    use HasFactory;
    protected $fillable = [
        'country',
        'address',
        'files_path',
        'be_author_request_id',
    ];

    public function be_author_request(){
        return $this->belongsTo(BeAuthorRequest::class);
    }

    public function author(){
        return $this->hasOne(Author::class);
    }
}
