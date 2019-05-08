<?php

namespace App\Services;

trait SearchingScope
{
    /**
     * 同一テーブルのカラムのwhere一致検索
     *
     * @param string $columnName カラム名(検索条件名)
     *        string $conditionValue 検索条件の値
     */
    public function scopeFilterEqual($query, $columnName, $conditionValue)
    {
        if (!empty($conditionValue)) {
            $query->where($columnName, $conditionValue);
        }
    }

    /**
     * 同一テーブルのカラムのwhereLike検索
     *
     * @param string $columnName カラム名(検索条件名)
     *        string $conditionValue 検索条件の値
     */
    public function scopeFilterLike($query, $columnName, $conditionValue)
    {
        if (!empty($conditionValue)) {
            $query->where($columnName, 'LIKE', '%'.$conditionValue.'%');
        }
    }

    /**
     * 同一テーブルのカラムのwhere比較検索
     * 日時の範囲を検索するときに使用
     *
     * @param string $columnName カラム名(検索条件名)
     *        string $date 検索条件の日時の値
     *        string $inequality 不等号
     */
    public function scopeFilterDateRange($query, $columnName, $date, $inequality)
    {
        if (!empty($date)) {
            $query->where($columnName, $inequality, date($date));  
        }
    }

    public function scopeFilterRelatedEqual($query, $table, $conditionName, $conditionValue)
    {
        if (!empty($conditionValue)) {
            $query->whereHas($table, function($query) use ($conditionName, $conditionValue) {
                return $query->where($conditionName, $conditionValue);
            });
        }
    }

    public function scopeFilterRelatedDateRange($query, $table, $date, $inequality)
    {
        if (!empty($date)) {
            $query->whereHas($table, function($query) use ($date, $inequality) {
                return $query->where('hire_date', $inequality, date($date));  
            });
        }
    }
}