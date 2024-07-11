<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'image',
        'category_id',
        'author_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function authors(){
        return $this->belongsToMany(Author::class, 'authors_articles');
    }

    public function favourites(){
        return $this->hasMany(User::class,'favourites');
    }

    public function Article_comments(){
        return $this->hasMany(Comment::class);
    }
}
