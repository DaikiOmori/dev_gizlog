<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Services\SearchingScope;

class DailyReport extends Model
{

    use SoftDeletes, SearchingScope;

    protected $fillable = [
        'user_id', 
        'title',
        'contents',
        'reporting_time'
    ];

    protected $dates = ['reporting_time'];

    protected $deletes = [ 'deleted_at' ];


    public function fetchSearchingReport($conditions)
    {
        return $this->filterLike('reporting_time', $conditions['search_word'])
                    //->filterEqual('reporting_time', $conditions['reporting_time'])
                    ->orderby('reporting_time', 'desc');
    }

}
