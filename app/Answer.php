<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
  public function question(){
    return $this->belongsTo('App\Answer');
  }

  public function user(){
    return $this->belongsTo('App\Answer');
  }

  public function getBodyHtmlAttribute(){
    return Parsedown::instance()->text($this->body);
  }
}
