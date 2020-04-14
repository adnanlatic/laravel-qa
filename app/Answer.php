<?php

namespace App;

use Parsedown;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
  protected $fillable = ['body','user_id'];
  public function question(){
    return $this->belongsTo('App\Question');
  }

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function getBodyHtmlAttribute(){
    return Parsedown::instance()->text($this->body);
  }

  public static function boot(){
    parent::boot();

    static::created(function($answer){
      $answer->question->increment('answers_count');
    });

    static::deleted(function($answer){
      $answer->question->decrement('answers_count');
    });
  }
}
