@extends('layouts.admin')
@section('title', '登録済みニュースの一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>ニュース一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\NewsController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\NewsController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
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
                                <th width="20%">タイトル</th>
                                <th width="50%">本文</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $news) {{-- bladeのforeach構文で、一つ一つ処理するよ --}}
                                <tr>  {{-- $postsはどこから？-NControllerのindexAction 'posts' => $postsの'posts'の方 --}}
                                    <th>{{ $news->id }}</th> {{-- 代入された順にIDカラムを表示しますよ --}} 
                                    <td>{{ \Str::limit($news->title, 100) }}</td> {{-- 代入された順にtitleカラムを表示しますよ --}} 
                                    <td>{{ \Str::limit($news->body, 250) }}</td>
                                      {{-- \Str::limit(x,Y)はxとY字数で打ち切るというメソッド --}}
                                    <td> {{-- この<td>内は、を編集リンクを表示する機能 --}}
                                        <div>
                                            <a href="{{ action('Admin\NewsController@edit', ['id' => $news->id]) }}">編集</a>
                                                     {{-- 編集ボタンも表示しますよ。editActionですよ。 --}} 
                                        </div>
                                         <div>
                                            <a href="{{ action('Admin\NewsController@delete', ['id' => $news->id]) }}">削除</a>
                                        </div>      {{-- 削除ボタンも表示しますよ。deleteActionですよ。 --}} 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection