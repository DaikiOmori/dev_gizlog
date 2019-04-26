<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = ['user_id', 'title', 'contents','reporting_time'];
    protected $dates = ['reporting_time'];
}
