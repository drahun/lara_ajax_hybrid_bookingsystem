<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Enjoythetrip\Presenters\CommentPresenter;
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function commentable(){
        return $this->morphTo();
    }
}