<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    protected $appends = ['url','avatar'];

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

    public function questions(){
      return $this->hasMany('App\Question');
    }

    public function answers(){
      return $this->hasMany('App\Answer');
    }

    public function getUrlAttribute(){
      return '#';
    }

    public function getAvatarAttribute(){
      $email = $this->email;
      $size = 32;

      return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    }

    public function favourites(){
        return $this->belongsToMany(Question::class, 'favourites')->withTimestamps(); //, 'author_id', 'question_id');
    }

    public function voteQuestions(){
      return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers(){
      return $this->morphedByMany(Answer::class, 'votable');
    }

    public function voteQuestion(Question $question, $vote){
      $voteQuestions = $this->voteQuestions();
      if ($voteQuestions->where('votable_id',$question->id)->exists()) {
         $voteQuestions->updateExistingPivot($question, ['vote'=>$vote]);
      }else {
        $voteQuestions->attach($question, ['vote'=>$vote]);
      }

      $question->load('votes');

      $downVotes = (int) $question->downVotes()->sum('vote');
      $upVotes = (int) $question->upVotes()->sum('vote');

      $question->votes_count = $upVotes + $downVotes;

      $question->save();
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();
        if ($voteAnswers->where('votable_id', $answer->id)->exists()) {
            $voteAnswers->updateExistingPivot($answer, ['vote' => $vote]);
        }
        else {
            $voteAnswers->attach($answer, ['vote' => $vote]);
        }

        $answer->load('votes');
        $downVotes = (int) $answer->downVotes()->sum('vote');
        $upVotes = (int) $answer->upVotes()->sum('vote');

        $answer->votes_count = $upVotes + $downVotes;
        $answer->save();
    }








}
