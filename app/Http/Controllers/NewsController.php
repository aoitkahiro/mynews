<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;

use App\News;

class NewsController extends Controller
{
    //
    public function index(Request $request)
    {
        $posts = News::all()->sortByDesc('updated_at'); // sortByDescは(カッコ)の中のキーで降順に並び替える関数

        if (count($posts) > 0) {
            $headline = $posts->shift(); // shift()…配列の最初のデータを削除し、その値を返すメソッド
        } else {
            $headline = null;
        } // 以上のif文で、$headlineに最新記事を、$postsに最新以外の記事を格納している。

        // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        return view('news.index', ['headline' => $headline, 'posts' => $posts]);
    }
}
