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
        return route('questions.show', $this->slug);
    }
    // アクセサの定義はキャメルケースで、使用時の呼び出しはスネークケースで
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    // answerカウンターの装飾用にアクセサ定義
    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }
    // showで使用するbodyのアクセサ
    public function getBodyHtmlAttribute()
    {
        // markdownパーサー使用
        return \Parsedown::instance()->text($this->body);
    }

    // answersカラムがモデルにある時
    // ex. $question->answers()->count()
    // リレーションでアクセスするときは問題ない
    // が、動的プロパティでアクセスする時
    // ex. $question->answers->count(), foreach($question->answers as $answer)
    // データベースから直接値を取得することになるのでエラーとなる
    // よって、リレーションと同名のカラム名がある時は、カラム名かリレーションの名前、どちらかを変える必要がある
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    //ベストアンサーidを格納
    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    // ユーザーがお気に入り登録しているかどうか
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }
    // isFavoritedのアクセサ
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
    // お気に入り数を返すアクセサ
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
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
