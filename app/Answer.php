<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['body', 'user_id'];
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
        // answer削除時にanswers_countをデクリメント
        static::deleted(function ($answer) {
            $answer->question->decrement('answers_count');
        });
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // ベストアンサーの時、スタイリング用vote-acceptedクラスを返す
    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    // isBestのアクセサ
    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    // ベストアンサーがどうか判定
    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
    }

    //
    public function votes()
    {
        return $this->morphToMany(User::class, 'votable');
    }

    //
    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }
    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }
}
