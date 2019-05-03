<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    // リレーション
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    // eloquent eventsを発火させる
    public static function boot()
    {
        parent::boot();
        // answer作成時にanswers_countをインクリメント
        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
