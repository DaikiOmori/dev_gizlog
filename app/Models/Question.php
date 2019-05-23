<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\TagCategory;
use App\Models\Comment;

class Question extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'tag_category_id',
        'title',
        'content',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(TagCategory::class, 'tag_category_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'question_id');
    }

    public function searchAll($searchInfo)
    {     

        return $this->where('title', 'LIKE', '%'.$searchInfo['search_word'].'%')
                    ->where('tag_category_id', $searchInfo['tag_category_id'])
                    ->orderby('created_at', 'desc');
    }

    public function searchWord($searchInfo)
    {     
        return $this->where('title', 'LIKE', '%'.$searchInfo['search_word'].'%')
                    ->orderby('created_at', 'desc');
    }

    public function searchCategory($searchInfo)
    {     
        return $this->where('tag_category_id', $searchInfo['tag_category_id'])
                    ->orderby('created_at', 'desc');
    }

    public function getMyPage($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderby('created_at', 'desc');
    }

}

