<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
        // return route('questions.show', $this->id);
        return '#';
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // gravatar用アクセサ
    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=" . $size;
    }

    // Favorite用多対多リレーション定義
    // 第1引数では最終的な接続先モデルを指定する
    // 第2引数では中間テーブル名を指定する
    // 第3引数では接続元モデルIDを示す中間テーブル内のカラムを指定する
    // 第4引数では接続先モデルIDを示す中間テーブル内のカラムを指定する
    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); //, 'author_id', 'question_id');
    }

    //
    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable');
    }
    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable');
    }
}
