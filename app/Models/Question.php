<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\TagCategory;
use App\Models\Comment;
use App\Services\SearchingScope;

class Question extends Model
{
    use SoftDeletes, SearchingScope;

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

    public function keywordSearch($titleColumn, $selectedWord)
    {
        if (!empty($selectedWord))
            $this->where($titleColumn, $selectedWord)->get();
    }

    public function categorySearch($categoryColumn, $selectedCategory)
    {
        if(!empty($selectedCategory))
            $this->where($categoryColumn, 'LIKE', '%'.$selectedCategory.'%')->get();
    }

    public function search($searchInfo)
    {
        return $this->keywordSearch('title', $searchInfo['search_word'])
                    ->categorySearch('tag_category_id', $searchInfo['tag_category_id'])
                    ->orderby('created_at','desc');
    }

    public function searchWord($searchInfo)
    {
        return $this->filterLike('title', $searchInfo['search_word'])
                    ->filterEqual('tag_category_id', $searchInfo['tag_category_id'])
                    ->orderby('created_at', 'desc');
    }
}
