<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Schedule;

class ShuttleCarController extends Controller
{
    //
    public function index(Request $request) {
		// Log::debug ( '***  start faq/index  *************************' );
		
		try{
            // $data = Schedule::where('id', 1)->first();
            $sql = "
                select * from schedules limit 2
            ";

            $data = DB::select($sql);
            dd($data);

			// //権限チェック
			// $user = Auth::user();
			// //権限が一般、管理者以外の場合ログイン画面に移動させる
			// //1=スタッフ 2=保護者 3=一般 9=管理者
			// if($user->authority == Consts::AUTH_STAFF || $user->authority == Consts::AUTH_PARENT) {
			// 	//ログイン権限がない
			// 	//ログイン画面にリダイレクト
			// 	Auth::logout();
			// 	Log::debug ( '権限がないのでログアウト' );
			// 	return redirect()->route('logout');
			// }
			// //初回ログインフラグ 0=編集済み 1=初回ログイン
			// //0以外は初回ログインとみなす
			// if ($user->first_login_flg != 0) {
			// 	//ユーザ編集画面にリダイレクト
			// 	//ログインユーザのIDを渡す
			// 	session()->flash ( 'flash_message_error', '基本情報を更新してください' );
			// 	return redirect('user/edit/'.$user->id)->with('first_login', $user->id);
			// }

			// /////////////////////////////////////
			// //API接続時にパラメータで渡す値を取得する//
			// /////////////////////////////////////
			
			// //検索項目初期値
			// $classification_div = "ALL"; //FAQ区分
			// $is_enable = "ALL"; //表示 非表示
			// $direction = "desc";
			// $column = "sort_no";
			// $order = " order by sort_no desc ";
			
			// //セッションに値があるとき：戻るボタン押下
			// //その値で検索・表示する
			// if ($request->session()->exists('faq_search_param')) {
			// 	// 存在する
			// 	// 指定したデータをセッションから取得、削除
			// 	$faq_search_param = $request->session()->pull('faq_search_param');
			// 	$request->session()->forget('faq_search_param');
			// 	foreach($faq_search_param as $key => $value){
			// 		//検索条件の作成
			// 		${$key} = $value;
			// 	}
			// }
		
			// //リクエストがあるときその値で検索
			// //FAQ区分
			// if (isset($request->classification_div)){
			// 	$classification_div = $request->classification_div;
			// }
			// //表示/非表示
			// if (isset($request->is_enable)){
			// 	$is_enable = $request->is_enable;
			// }
			// //ソート処理
			// if (isset($request->sort)){
			// 	$column = $request->sort;
			// 	$direction = "desc";
			// 	if (isset($request->direction)){
			// 		$direction = $request->direction;
			// 	}
			// }
			// if (isset($column)){
			// 	$order = " order by ".$column." ".$direction;
			// }

			// //////////
			// //API接続//
			// //////////
			// //データベースで持っているurlを取得する。
			// $base_url = Util::getBaseUrl();//url('/', null, true)
			// //接続先　画面表示情報の取得するために必要な値をパラメータで渡す
			// $url = $base_url."/api/faq_index?classification_div=".$classification_div."&is_enable=".$is_enable."&user_id=".Auth::user()->id;

			// //実行(値はjson型で返ってくる)
			// $response_json = Util::callApiGet($url);
			// //JSON 文字列をデコードで配列にする
			// $response = json_decode($response_json, true);

			// //api接続でエラーが返ってきた場合の処理
			// if(!empty($response['error_message'])){
			// 	session()->flash('flash_message_error', $response['error_message']);
			// 	return redirect('/home');
			// }

			// $sql = $response['sql'];
	
			// $faq_info = DB::table(DB::raw("({$sql}) as t ".$order))->paginate(10);

			// foreach($faq_info as $key => $value){
			// 	//ファイルが存在したら
			// 	if(file_exists($value->file_path1)){
			// 		$value->file_path1 = "有";
			// 	}else{
			// 		$value->file_path1 = "無";
			// 	}
			// }

			// Log::debug ( '***  end   faq/index  *************************' );
			return view('schedule.index',
				[
					// 'classificationList' => $response['classificationList'],
					// 'showHideList' => $response['showHideList'],
					// 'faq_info' => $faq_info,
					// 'classification_div' => $classification_div,
					// 'is_enable' => $is_enable,
				]
			);

		} catch (\Exception $e){
            dd($e);
            session()->flash('flash_message_error', '予期せぬエラーが発生しました。');
			// Util::commonErrorHandling($e, Auth::user()->id );
			return redirect('/dashboard');
		}
	}

}
