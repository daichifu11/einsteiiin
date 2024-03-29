<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    protected $guarded = array('id');

    public static $rules = array(
        'content' => 'required'
    );
}
