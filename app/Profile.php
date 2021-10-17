<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'name' => 'required',
        'gender' => 'required',
        'hobby' => 'required',
        'instruction' => 'required',
        
    );
    
    public function histories()
    {
      return $this->hasMany('App\ProfileHistory');//profileテーブルが更新されるたびにhistoriesテーブルを作成する関数
      // なぜ、profileテーブルが更新されるたびにhistoriesテーブルを作成するのか不明。profile_historiesテーブルと関係あるのでは？
    }
}
