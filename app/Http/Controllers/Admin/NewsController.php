<?php //PHP starts

namespace App\Http\Controllers\Admin; //There is "admin.news.create"

use Illuminate\Http\Request; //These 2 rows are decided forms of Controller 
use App\Http\Controllers\Controller;

// 以下(use App\News;)を追記することでNews Modelが扱えるようになる
use App\News; // ???
// History Modelの使用を宣言するために追記
use App\History;
// PHP/Laravel17 で日付取得を追加したため、以下も追記
use Carbon\Carbon;
 // PHP/Laravel Heroku画像upの際に以下も追記
use Storage;

class NewsController extends Controller
{
    
 public function add() // Some routings are supposed to assign this Action 
 {
      return view('admin.news.create'); //This Action will return the view
 }
     // 以下を追記
  public function create(Request $request) // Requestクラスが何かというと、上の5行目 Illuminate\Http\Request; つまりLaravelの説明書参照
  {                     // $requestが すべてのフォームを受け取る（代入されている）Requestクラスのインスタンスなので何も設定しなくても、そういうことになる。
      
      // 以下を追記
      // Varidationを行う
      $this->validate($request, News::$rules);
    //   newは 「こういうインスタンス（＝テーブルではない）を作成する」というメソッド。それを$newsに代入する
      $news = new News;
      $form = $request->all(); //$request の正体は上の(Request $request) つまり、Requestクラスのインスタンスとなっている
       //$formという入力データのかたまりを定義した。 Requestクラスとは…Laravelが最初から用意しているクラス
       // ↓のif文の解説：フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = Storage::disk('s3')->putFile('/',$form['image'],'public'); // Heroku用
         // ↑に変更済 $path = $request->file('image')->store('public/image');//Laravelのメソッド　storageのappまで自動的に見に行く
        //メソッドチェーン　fileメソッドがなんらかのインスタンスを返す　returnで値じゃなくてインスタンスを返す
        //storeメソッドは保存して返り値で画像のパスの文字列を返す（xx/xx/xxx.jpg）
        $news->image_path = Storage::disk('s3')->url($path); // Heroku用
         // ↑に変更済 $news->image_path = basename($path); // (↑のxxx.jpg　だけを返すのがbasename)
      } else {
          $news->image_path = null;
      }
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);
      // データベースに保存する（saveメソッドがないと保存されない）
      $news->fill($form); /* このコードの意味は：フォームで入力した値をまとめてNewsインスタンスに代入する
                             $formの中にはタイトルと本文が入っている。fillが */
       // $news->title = $form['title']　（$formは連想配列）
       // $news->body = $form['body'] fillを使わないと、左記のようにしないといけなくなる。
       // 2行ならまだ良いものの、たくさんあると大変なのでfillメソッドを使う
      $news->save(); /* このコードの意味は：Modelクラスのメソッド（$newsがModelクラスのインスタンス）
      ModelクラスをNewsクラスがextendsしている  */
      
      // admin/news/createにリダイレクトする
      return redirect('admin/news/create');
  }  
  
    // 以下を追記
  public function index(Request $request)  // これがwhereメソッドでModelを検索するController(Action)だ！
  {
      $cond_title = $request->cond_title;  // まずは $requestのcond_titleに、$cond_titleという名前を付ける
      if ($cond_title != '') {  // 「$cond_titleが空欄じゃない」がtrueな時
          // 検索されたら検索結果を取得する
          $posts = News::where('title', $cond_title)->get();  /* whereメソッド…newsテーブルの中のtitleカラムで
          $cond_title（ユーザーが入力した文字）に一致するレコードをすべて取得する */
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = News::all(); /* News Modelを使って、データベースに保存されている
          newsテーブルのレコードをすべて取得し、変数$postsに代入している */
      }
      return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]); // bladeファイルに$postsの値を'posts'として渡している（$postsという名前になる）
  }
  
   // 以下を追記　PHP/Laravel16 投稿したニュースを更新/削除しよう

  public function edit(Request $request) //edit Action は投稿編集画面のアクション
  {
      // News Modelからデータを取得する
      $news = News::find($request->id); // ここでニュース情報を取得　$newsに代入して、正しくニュースが取得できたかif文で判定する
      if (empty($news)) {  // もしempty($news)がtrueなら、abort(404)を実行
        abort(404);     // emptyは引数がNULLかそうでないかを判定するメソッド NULLか空ならtrue
      }  // falseならなにもしない
      return view('admin.news.edit', ['news_form' => $news, 'hoge'=> 'konnichiwa']); /*  ['news_form' => $news]の意味はタイトルと本文の連想配列。
      $newsのままだとbladeファイルで使えないので、キーの値'news_form'に$newsの値を渡している。Viewで表示するためにControllerから取ってきている？ */
  }


  public function update(Request $request)  // Requestで取得したデータを$requestへ代入
        //update Action は投稿編集画面から送信されたフォームデータを処理する部分
  {
      // Validationをかける
      $this->validate($request, News::$rules);
      // News Modelからニュースデータを取得する（ここ以下何をしているのか、わからない！）
      $news = News::find($request->id);
      // 送信されてきたフォームデータを格納する e.g.) ユーザーの入力全部:$request->all()
      $news_form = $request->all();
            if ($request->remove == 'true') { // もし$request->removeが'true' なら$news_form['image_path'] = null;を実行
          $news_form['image_path'] = null;
      } elseif ($request->file('image')) { 
          $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
          //$path = $request->file('image')->store('public/image');
          $news->image_path = Storage::disk('s3')->url($path);
          //$news_form['image_path'] = basename($path);
      } else {
          $news_form['image_path'] = $news->image_path;
      }

      unset($news_form['image']);
      unset($news_form['remove']);
      unset($news_form['_token']);

      // 該当するデータを上書きして保存する
      $news->fill($news_form)->save(); 
      // ユーザーの入力したデータを$newsに渡して（fill）保存（save）
      
      // 以下を追記 PHP/Laravel17
      /* News Modelを保存するタイミングで、
        同時に History Modelにも編集履歴を追加するようにしている */ 
        $history = new History;
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now(); // 日付操作ﾗｲﾌﾞﾗﾘで日付取得
        $history->save();
      

      return redirect('admin/news');
      
  }
  
  // 以下を追記
  public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $news = News::find($request->id);
      // 削除する
      $news->delete();
      return redirect('admin/news/');
  }
  
  
}
