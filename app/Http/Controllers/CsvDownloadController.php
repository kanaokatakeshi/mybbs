<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CsvDownloadController extends Controller
{
    public function downloadCsv()
    {
        $posts = Post::all();
        $stream = fopen('php://temp', 'w');   //ストリームを書き込みモードで開く
        fwrite($stream, pack('C*', 0xEF, 0xBB, 0xBF)); //BOM付きutf-8にする

        $arr = array('name', 'title', 'content');   //CSVファイルのカラム（列）名の指定

        fputcsv($stream, $arr);               //1行目にカラム（列）名のみを書き込む（繰り返し処理には入れない）
        foreach ($posts as $post) {
            $arrInfo = array(
                'name' => $post->user->name,
                'title' => $post->title,
                'content' => $post->content
            );
            fputcsv($stream, $arrInfo);       //DBの値を繰り返し書き込む
        }
        // dd($stream);

        rewind($stream);                      //ファイルポインタを先頭に戻す
        $csv = stream_get_contents($stream);  //ストリームを変数に格納
        // $csv = mb_convert_encoding($csv, 'sjis-win', 'UTF-8');   //文字コードを変換

        fclose($stream);                      //ストリームを閉じる

        $headers = array(                     //ヘッダー情報を指定する
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=posts.csv'
        );

        return Response::make($csv, 200, $headers);   //ファイルをダウンロードする

    }
}
