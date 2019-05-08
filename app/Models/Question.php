<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\SearchingScope;
use App\Models\User;
use App\Models\TagCategory;
use App\Models\Comment;

class Question extends Model
{
    use SoftDeletes, SearchingScope;

    protected $fillable = [
        'user_id',
        'tag_category_id',
        'title',
        'content',
        'answer',
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

    public function fetchMyPageQuestions($user_id)
    {
        return $this->where('user_id', $user_id)->orderby('created_at', 'desc')->get();
    }

    public function fetchSearchingQuestion($conditions)
    {
        return $this->filterLike('title', $conditions['search_word'])
                    ->filterEqual('tag_category_id', $conditions['tag_category_id'])
                    ->orderby('created_at', 'desc');
    }
}
