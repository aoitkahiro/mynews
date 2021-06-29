<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = array('id');

    // 以下を追記
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    
     // 以下を追記 PHP/Laravel17
     
    // News Modelに関連付けを行う
    public function histories() // このhistories関数の意味は…
    {
      return $this->hasMany('App\History'); // newsテーブルが更新されるたびにhistoriesテーブルを作成する関数

    }
    //
}
