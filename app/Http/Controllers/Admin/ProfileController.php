<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下(use App\Profile;)を追記することでProfile Modelが扱えるようになる
use App\Profile;

class ProfileController extends Controller
{
    
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        $this->validate($request, Profile::$rules); // ヴァリデーションを行う
        $profile = new Profile; // インスタンスを作成して$profileへ代入する
        $form = $request->all(); // フォームから送信されてきた名前、性別、趣味、自己紹介（all）を$formに代入する
        
        // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
        $profile->fill($form);
        $profile->save(); // 投稿されたプロフィールデータ（インスタンス）を保存する
      
        return redirect('admin/profile/create'); // admin/profile/create ブレードのページへ転送する
    }

    public function edit(Request $request)
    {
        $profile = Profile::find($request->id); // ?id=n のインスタンスをfindする(このクラスのメソッド）インスタンスを$profileへ
        return view('admin.profile.edit', ['form' => $profile]); //
    }

    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        $profile = Profile::find($request->id);
        $form = $request->all(); // 送信されてきた入力データを格納する
        $profile->fill($form)->save(); 
        return redirect()->back();
    }
}