@extends('layouts.admin')
@section('title', '登録済みプロフィールの一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>プロフィール一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\ProfileController@add') }}" role="button" class="btn btn-warning">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\ProfileController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value="???">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="20%">ユーザー名</th>
                                <th width="50%">instruction</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $news) {{-- bladeのforeach構文で、一つ一つ処理するよ --}}
                                <tr>  {{-- $postsはどこから？-NControllerのindexAction 'posts' => $postsの'posts'の方 --}}
                                    <th>{{ $news->id }}</th> {{-- 代入された順にIDカラムを表示しますよ --}} 
                                    <td>{{ \Str::limit($news->name, 100) }}</td> {{-- 代入された順にtitleカラムを表示しますよ --}} 
                                    <td>{{ \Str::limit($news->instruction, 250) }}</td>
                                      {{-- \Str::limit(x,Y)はxとY字数で打ち切るというメソッド --}}
                                    <td> {{-- この<td>内は、を編集リンクを表示する機能 --}}
                                        <div>
                                            <a href="{{ action('Admin\ProfileController@edit', ['id' => $news->id]) }}">編集</a>
                                                     {{-- 編集ボタンも表示しますよ。editActionですよ。 --}} 
                                        </div>
                                         <div>
                                            <a href="{{ action('Admin\ProfileController@delete', ['id' => $news->id]) }}">削除</a>
                                        </div>      {{-- 削除ボタンも表示しますよ。deleteActionですよ。 --}} 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        @foreach($posts as $news) {{-- bladeのforeach構文で、一つ一つ処理するよ --}}
                            @if($news->id == 2)
                                <p>更新日：{{ $profile_history->edited_at }}</p>
                            @endif
                        @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection