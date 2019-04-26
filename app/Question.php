<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ミューテータ作成
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    // アクセサ作成
    public function getUrlAttribute()
    {
        return route('questions.show', $this->id);
    }
    // アクセサの定義はキャメルケースで、使用時の呼び出しはスネークケースで
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    // answerカウンターの装飾用にアクセサ定義
    public function getStatusAttribute()
    {
        if ($this->answers > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }
}
