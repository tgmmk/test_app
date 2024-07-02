<?php

namespace App\Component;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
use Log;
use Auth;
use DateTime;

// use App\Setting;

class Util {

	//リストデータ取得
	public static function setListValue($list_name,$args=[]){

		$response = [];

		switch ($list_name){

			//曜日リスト
			case "weekList":
				$response = [ 'ALL' => '', '0' => '日', '1' => '月' ,'2' => '火' ,'3' => '水' ,'4' => '木' ,'5' => '金' ,'6' => '土' ];
				break;

                // //操作ログ用　本部操作画面リスト
			// case "operationAllViewList":
			// 	//1~21　予約関係　
			// 	$response = [
			// 		//保護者画面
			// 		'1' => '保護者情報',
			// 		'2' => 'お子さま情報',
			// 		'3' => 'パターン管理',
			// 		'4' => '送迎場所管理',
			// 		'5' => '送迎予約作成・申請',
			// 		'6' => '送迎予約申請一覧',
			// 		'7' => '本日の予定',
			// 		//送迎講師画面
			// 		'8' => '送迎講師基本情報',
			// 		'9' => '勤務日管理',
			// 		'10' => '送迎予約依頼一覧',
			// 		'11' => '送迎予定一覧',
			// 		'12' => '本日のお仕事',
			// 		'13' => '交通費',
			// 		'14' => '立替金',
			// 		//本部のみ
			// 		'15' => '送迎予約検索',
			// 		'16' => '手数料',
			// 		'17' => '小学校管理',
			// 		'18' => '校舎管理',
			// 		'19' => '設定',
			// 		'20' => '管理者管理',
			// 		'21' => '休日設定',
			// 		'22' => 'よくある質問管理',
			// 		'23' => '予約お子さま情報',
			// 		'24' => '予約送迎講師情報',
			// 		'25' => '予約基本情報',
			// 		'26' => '業務ミーティング',//送迎講師
			// 		'27' => 'パターン一覧',//本部のみ
			// 		'28' => '送迎予約詳細',//本部のみ
			// 		'29' => '延長手当一覧',//本部のみ
			// 	];
			// 	break;
        }
        return $response;
	}

	// //Api接続に使用するドメインを取得する
	// public static function getBaseUrl(){
	// 	Log::debug ( '***  start Util/getBaseUrl  *************************' );
		
	// 	$base_url = Setting::where('id', 1)->value('base_url');
	
	// 	Log::debug ( '***  end   Util/getBaseUrl  *************************' );
	// 	return $base_url;
	// }

	// //API実行（GET）
	// public static function callApiGet($url){
	// 	Log::debug ( '***  start callApiGet  *************************' );

	// 	$curl = curl_init();

	// 	curl_setopt ( $curl, CURLOPT_URL, $url );
	// 	curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );
	// 	curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false );
	// 	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );// curl_exec()の結果を文字列にする
	// 	curl_setopt ( $curl, CURLOPT_CONNECTTIMEOUT, 30 ); // timeout in seconds
	// 	curl_setopt ( $curl, CURLOPT_TIMEOUT, 30 ); // timeout in seconds
	// 	Log::debug ($url);

	// 	$response_json = curl_exec($curl);

	// 	//タイムアウトのとき3回までやり直す
	// 	$retry = 0;
	// 	for ($retry = 0; $retry < 3; $retry++){
	// 		if (curl_error($curl)){
	// 			Log::debug("APIエラー発生");
	// 			Log::debug(mb_substr(curl_error($curl),0,100));
	// 			if(curl_errno($curl) == 28){
	// 				//タイムアウト
	// 				Log::debug("タイムアウト retry：".$retry);
	// 				$response_json = curl_exec($curl);
	// 			}else{
	// 				//タイムアウト以外のエラー
	// 				//APIエラーログ書き込み
	// 				$param_json = json_encode([]);
	// 				self::writeApiErrorLog($url, $param_json, $response_json, curl_errno($curl), curl_error($curl));
	// 				throw new \Exception(curl_error($curl));
	// 			}
	// 		}else{
	// 			//エラーなし
	// 			break;
	// 		}
	// 	}
	// 	//3回繰り返してもタイムアウトになる場合、予期せぬエラーとする
	// 	if (curl_error($curl)){
	// 		Log::debug("APIエラー発生2");
	// 		Log::debug(mb_substr(curl_error($curl),0,100));
	// 		if(curl_errno($curl) == 28){
	// 			//タイムアウト
	// 			//APIエラーログ書き込み
	// 			$param_json = json_encode([]);
	// 			self::writeApiErrorLog($url, $param_json, $response_json, curl_errno($curl), curl_error($curl));
	// 			throw new \Exception(curl_error($curl));
	// 		}
	// 	}

	// 	curl_close($curl);

	// 	// //debugログ処理
	// 	// //画像以外のparam情報を表示する
	// 	//JSON 文字列をデコードで配列にする
	// 	$response = json_decode($response_json, true);

	// 	// $debug_log = [];
	// 	// $key_debug_log = [];
	// 	if(isset($response)){
	// 	// 	//正しくレスポンスが返っている
	// 	// 	//Log::debug ("正しくレスポンスが返っている");
	// 	// 	foreach($response as $key => $value){
	// 	// 		//データ量の多いリスト以外の情報をログ表示する
	// 	// 		//一文字目は認識しない
	// 	// 		if(false !== mb_strpos($key, 'ile_path')){
	// 	// 			//file_pathを含む場合
	// 	// 		}elseif(false !== mb_strpos($key, 'tudentNameList')){
	// 	// 			//studentNameListを含む場合
	// 	// 		}elseif(false !== mb_strpos($key, 'choolList')){
	// 	// 			//schoolListを含む場合
	// 	// 		}elseif(false !== mb_strpos($key, 'refectureList')){
	// 	// 			//prefectureListを含む場合
	// 	// 		}elseif(false !== mb_strpos($key, 'alendar')){
	// 	// 			//calendarを含む場合
	// 	// 		}else{
	// 	// 			//Log::debug($key);
	// 	// 			//配列の中にファイルパスがある場合
	// 	// 			if(is_array($value) === true) {
	// 	// 				//Log::debug("配列");
	// 	// 				$key_debug_log = [];
	// 	// 				foreach($value as $k => $v){
	// 	// 					//$vが配列の場合
	// 	// 					if(is_array($v) === true){
	// 	// 						//Log::debug("配列2");
	// 	// 						$key_debug_log2 = [];
	// 	// 						foreach($v as $k2 => $v2){
	// 	// 							//Log::debug($k2);
	// 	// 							if(false !== mb_strpos($k2, 'ile_path')){
	// 	// 								//file_pathを含む場合
	// 	// 							}elseif(false !== mb_strpos($k2, 'tudentNameList')){
	// 	// 								//studentNameListを含む場合
	// 	// 							}elseif(false !== mb_strpos($k2, 'choolList')){
	// 	// 								//schoolListを含む場合
	// 	// 							}elseif(false !== mb_strpos($k2, 'refectureList')){
	// 	// 								//prefectureListを含む場合
	// 	// 							}elseif(false !== mb_strpos($v2, 'base64')){
	// 	// 								//base64
	// 	// 							}else{
	// 	// 								$key_debug_log2 = $key_debug_log2 + [$k2 => $v2];
	// 	// 							}
	// 	// 						}
	// 	// 						$key_debug_log = $key_debug_log + [$k => $key_debug_log2];
	// 	// 					}else{
	// 	// 						//Log::debug("配列でない2 ".$v);
	// 	// 						//Log::debug("配列でない2 ".$k);
	// 	// 						//配列でない場合
	// 	// 						if(false !== mb_strpos($k, 'ile_path')){
	// 	// 							//file_pathを含む場合
	// 	// 						}elseif(false !== mb_strpos($k, 'tudentNameList')){
	// 	// 							//studentNameListを含む場合
	// 	// 						}elseif(false !== mb_strpos($k, 'choolList')){
	// 	// 							//schoolListを含む場合
	// 	// 						}elseif(false !== mb_strpos($k, 'refectureList')){
	// 	// 							//prefectureListを含む場合
	// 	// 						}elseif(false !== mb_strpos($v, 'base64')){
	// 	// 							//base64
	// 	// 						}else{
	// 	// 							$key_debug_log = $key_debug_log + [$k => $v];
	// 	// 						}
	// 	// 					}
	// 	// 				}
	// 	// 				$debug_log = $debug_log + [$key => $key_debug_log];
	// 	// 			}else{
	// 	// 				//Log::debug("配列でない ".$value);
	// 	// 				//Log::debug("配列でない ".$key);
	// 	// 				if(false !== mb_strpos($value, 'base64')){
	// 	// 					//base64
	// 	// 				}else{
	// 	// 					$debug_log = $debug_log + [$key => $value];
	// 	// 				}
	// 	// 			}
	// 	// 		}

	// 		// }
	// 	// 	Log::debug ("debug_log");
	// 	// 	Log::debug($debug_log);
	// 	}else{
	// 		Log::debug ("正しくレスポンスが返っていない（callApiGet）");
	// 		//Log::debug($response_json);
	// 		//APIエラーログ書き込み
	// 		$param_json = json_encode([]);
	// 		self::writeApiErrorLog($url, $param_json, $response_json, null, null);
	// 	}

	// 	Log::debug ( '***  end   callApiGet  *************************' );

	// 	return $response_json;
	// }

	// //Apiの共通処理
	// public static function callApiPost($url, $data){
	// 	Log::debug ( '***  start callApiPost  *************************' );

	// 	//Log::debug($data);
	// 	$data = json_encode($data);
	
	// 	$curl = curl_init();

	// 	curl_setopt($curl, CURLOPT_URL, $url);
	// 	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
	// 	//curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'X-CSRF-TOKEN: '.csrf_token()]);
	// 	curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	// 	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	// 	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	// 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	// 	curl_setopt($curl, CURLOPT_HEADER, false);
	// 	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30); //timeout in seconds
	// 	curl_setopt($curl, CURLOPT_TIMEOUT, 30); //timeout in seconds
	// 	Log::debug ($url);

	// 	$response_json = curl_exec($curl);

	// 	//タイムアウトのとき3回までやり直す
	// 	$retry = 0;
	// 	for ($retry = 0; $retry < 3; $retry++){
	// 		if (curl_error($curl)){
	// 			Log::debug("APIエラー発生");
	// 			Log::debug(mb_substr(curl_error($curl),0,100));
	// 			if(curl_errno($curl) == 28){
	// 				//タイムアウト
	// 				Log::debug("タイムアウト retry：".$retry);
	// 				$response_json = curl_exec($curl);
	// 			}else{
	// 				//タイムアウト以外のエラー
	// 				//APIエラーログ書き込み
	// 				self::writeApiErrorLog($url, $data, $response_json, curl_errno($curl), curl_error($curl));
	// 				throw new \Exception(curl_error($curl));
	// 			}
	// 		}else{
	// 			//エラーなし
	// 			break;
	// 		}
	// 	}
	// 	//3回繰り返してもタイムアウトになる場合、予期せぬエラーとする
	// 	if (curl_error($curl)){
	// 		Log::debug("APIエラー発生2");
	// 		Log::debug(mb_substr(curl_error($curl),0,100));
	// 		if(curl_errno($curl) == 28){
	// 			//タイムアウト
	// 			//APIエラーログ書き込み
	// 			self::writeApiErrorLog($url, $data, $response_json, curl_errno($curl), curl_error($curl));
	// 			throw new \Exception(curl_error($curl));
	// 		}
	// 	}

	// 	curl_close($curl);

	// 	//debugログ処理
	// 	//JSON 文字列をデコードで配列にする
	// 	$response = json_decode($response_json, true);

	// 	if(isset($response)){
	// 		//正しくレスポンスが返っている
	// 	}else{
	// 		Log::debug ("正しくレスポンスが返っていない（callApiPost）");
	// 		//Log::debug($response_json);
	// 		//$response_json = mb_substr($response_json,0,30000);
	// 		//APIエラーログ書き込み
	// 		self::writeApiErrorLog($url, $data, $response_json, null, null);
	// 	}

	// 	Log::debug ( '***  end   callApiPost  *************************' );

	// 	return $response_json;
	// }

	// //APIエラーログの書き込み
	// public static function writeApiErrorLog($url, $param_json, $response_json, $curl_errno, $curl_error){

	// 	if (Auth::check()) {
	// 		// ログイン済みのときの処理
	// 		$user_id = Auth::user()->id;
	// 	} else {
	// 		// ログインしていないときの処理
	// 		$user_id = null;
	// 	}

	// 	//ログ登録
	// 	$param = [
	// 		'url' => $url, //参照ページURL
	// 		'param_json' => $param_json, //送信したデータjson
	// 		'response_json' => $response_json, //APIレスポンスjson
	// 		'curl_errno' => $curl_errno,
	// 		'curl_error' => $curl_error,
	// 		'user_id' => $user_id, //操作したユーザ情報
	// 		'created_at' => date('Y-m-d H:i:s')
	// 	];

	// 	//$str = '/usr/local/bin/php artisan command:WriteLogs tag '.$url.' '.$request_id.' '.$invoice_id.' '.$param_json.' '.$response_json.' '.$error_cd.' '.$error_msg.' '.Auth::user()->id.' '.$started_at;
	// 	//exec($str);

	// 	DB::table('api_error_logs')->insert($param);
	// }

	// //SendMail
	// public static function sendMail($to, $subject, $template, $content){
	// 	Log::debug ( '***  start Util/sendMail  *************************' );

	// 	////////////////////////////////
	// 	//SendMail
	// 	////////////////////////////////
	// 	Mail::send(['text' => $template], [
	// 		"content" => $content
	// 	], function($message) use ($to, $subject){

	// 	$message
	// 		->to($to)
	// 		//->bcc(Consts::BCC_ADDR)
	// 		->from("sougei-master@shinga-s-club.jp", "伸芽'Ｓクラブ　Ver2")
	// 		->subject($subject);
	// 	});

	// 	Log::debug ( '***  end   Util/sendMail  *************************' );
	// }

	// //共通エラーハンドリング
	// public static function commonErrorHandling($e, $user_id, $redirect_path=null){

	// 	if(empty($redirect_path)){
	// 		$redirect_path = Consts::HOME;
	// 	}

	// 	Util::sendErrorNoticeMail($e, $user_id); //メール通知
	// 	session()->flash('flash_message_error', '予期せぬエラーが発生しました。');

	// }

	// public static function sendErrorNoticeMail($e, $user_id){
	// 	Log::debug ( '***  start Util/sendErrorNoticeMail  *************************' );
	// 	Log::debug($e->getMessage());

	// 	//ユーザーの情報を取得
	// 	$users = DB::table('users')->where('id', $user_id)->first();
	// 	if(!empty($users)){
	// 		$user_name = $users->name;
	// 		$authority = $users->authority;
	// 		$classroom = $users->classroom;
	// 	}else{
	// 		$user_name = null;
	// 		$authority = null;
	// 		$classroom = null;
	// 	}

	// 	////////////
	// 	//SendMail//
	// 	////////////
	// 	$content = [];
	// 	$content["user_id"] = $user_id;
	// 	$content["user_name"] = $user_name;
	// 	$content["authority"] = $authority;
	// 	$content["classroom"] = $classroom;
	// 	$content["route"] = \Route::currentRouteAction();
	// 	$content["message"] = $e->getMessage();
	// 	$content["code"] = $e->getCode();
	// 	$content["file"] = $e->getFile();
	// 	$content["line"] = $e->getLine();
	// 	$email = Consts::to_address(); //送信先
	// 	$class = get_class($e);
	// 	$title = "【伸芽会-送迎システムVer2】予期せぬエラー発生！";

	// 	Mail::send(['text' => "vendor.email.error_notice"], [
	// 	  "content" => $content

	// 	], function($message) use ($email, $title, $class){
	// 	$message
	// 	 	->to($email)
	// 	 	->from(Consts::from_mailadress(), "伸芽'Ｓクラブ　Ver2")
	// 	 	->subject(Consts::prefix().$title."（".$class."）");
	// 	});
	// 	Log::debug ( '***  end  Util/sendErrorNoticeMail  *************************' );
	// }

	// //リストデータ取得
	// public static function setListValue($list_name,$args=[]){

	// 	$response = [];

	// 	switch ($list_name){

	// 		//有効・無効リスト
	// 		case "enabledList":
	// 			$response = ['0' => '有効', '1' => '無効'];
	// 			break;

	// 		//権限リスト
	// 		case "authorityList":
	// 			$response = ['3' => '校舎', '9' => '本部'];
	// 			break;

	// 		//ステータスリスト(検索)
	// 		case "status_searchList":
	// 			$response = ['0' => '未確定', '1' => '確定', '8' => '辞退（送迎講師）', '9' => 'キャンセル（保護者）', '4' => '終了'];
	// 			break;

	// 		//送迎講師ステータス
	// 		case "staffStatusList":
	// 			$response = ['0' => '承諾待ち', '1' => '承諾' ,'2' => '辞退' ,'5' => '終了' ,'90' => '通常キャンセル','91' => '前日キャンセル','92' => '当日キャンセル','93' => '現地キャンセル'];
	// 			break;

	// 		//お子さまステータス
	// 		case "studentStatusList":
	// 			$response = ['1' => '申請中' ,'3' => '確定','5' => '終了' ,'90' => '通常キャンセル','91' => '前日キャンセル','92' => '当日キャンセル','93' => '現地キャンセル'];
	// 			break;
	// 		//お子さまステータス 現在は予約一覧のみで使用（キャンセルの表示を短くしたもの）
	// 		case "studentStatusList2":
	// 			$response = ['1' => '申請中' ,'3' => '確定','5' => '終了' ,'90' => '通常CN','91' => '前日CN','92' => '当日CN','93' => '現地CN'];
	// 			break;
	// 		//予約ステータスリスト
	// 		case "pickupStatusList":
	// 			$response = ['0' => '未確定','1' => '確定', '5' => '終了', '90' => '通常キャンセル','91' => '前日キャンセル','92' => '当日キャンセル','93' => '現地キャンセル'];
	// 			break;

	// 		//キャンセル選択リスト
	// 		case "cancelList":
	// 			$response = ['90' => '通常キャンセル', '91' => '前日キャンセル', '92' => '当日キャンセル', '93' => '現地キャンセル'];
	// 			break;

	// 		//エリアリスト
	// 		case "areaList":
	// 			$response = ['1' => '東京エリア', '2' => '神奈川エリア', '3' => '千葉エリア', '4' => '埼玉エリア', '5' => '関西エリア'];
	// 			break;

	// 		//園・学校区分リスト
	// 		case "school_divList":
	// 			$response = ['1' => '幼稚園', '2' => '保育園', '3' => '小学校', '4' => '中学校'];
	// 			break;

	// 		//教室区分リスト
	// 		case "classroom_divList":
	// 			$response = ['1' => '学童', '2' => '保育'];
	// 			break;

	// 		//契約区分リスト
	// 		case "contractDivList":
	// 			$response = ['1' => '直契約', '2' => 'Bスタイル'];
	// 			break;

	// 		//希望無希望リスト
	// 		case "hopeList":
	// 			$response = ['1' => '受信する', '2' => '受信しない'];
	// 			break;

	// 		//送迎区分リスト
	// 		case "pickupDivList":
	// 			$response = ['1' => '小学校お迎え', '2' => '個別送迎（学童）', '3' => '個別送迎（託児）', '4' => 'コンシェルジュ'];
	// 			break;
	// 		//利用状況リスト
	// 		case "usageStatusList":
	// 			$response = ['1' => '利用中', '2' => '休会中', '3' => '終了'];
	// 			break;

	// 		//自動割当種類リスト
	// 		case "assignTypeList":
	// 			$response = ['1' => '託児個別', '2' => '学童個別', '3' => '小学校お迎え1対1', '4' => '小学校お迎え多対多'];
	// 			break;
	
	// 		//希望無希望リスト
	// 		case "weekNumberList":
	// 			$response = ['1' => 'first', '2' => 'second', '3' => 'third', '4' => 'fourth', '5' => 'fifth', '5' => 'sixth'];
	// 			break;

	// 		//都道府県リスト
	// 		case "prefectureList":
	// 			$response = [ '1' => '北海道', '2' => '青森県', '3' => '岩手県', '4' => '宮城県', '5' => '秋田県', '6' => '山形県', '7' => '福島県', '8' => '茨城県', '9' => '栃木県', '10' => '群馬県',
	// 						'11' => '埼玉県', '12' => '千葉県', '13' => '東京都', '14' => '神奈川県', '15' => '新潟県', '16' => '富山県', '17' => '石川県', '18' => '福井県', '19' => '山梨県', '20' => '長野県',
	// 						'21' => '岐阜県', '22' => '静岡県', '23' => '愛知県', '24' => '三重県', '25' => '滋賀県', '26' => '京都府', '27' => '大阪府', '28' => '兵庫県', '29' => '奈良県', '30' => '和歌山県',
	// 						'31' => '鳥取県', '32' => '島根県', '33' => '岡山県', '34' => '広島県', '35' => '山口県', '36' => '徳島県', '37' => '香川県', '38' => '愛媛県', '39' => '高知県', '40' => '福岡県',
	// 						'41' => '佐賀県', '42' => '長崎県', '43' => '熊本県', '44' => '大分県', '45' => '宮崎県', '46' => '鹿児島県', '47' => '沖縄県'];
	// 			break;

	// 		//検索用、存在する校舎の都道府県
	// 		case "SearchPrefectureList":
	// 			$response = ['13' => '東京都', '14' => '神奈川県', '12' => '千葉県', '11' => '埼玉県', '24' => '三重県', '25' => '滋賀県', '26' => '京都府', '27' => '大阪府', '28' => '兵庫県', '29' => '奈良県', '30' => '和歌山県'];
	// 			break;

	// 		//表示非表示リスト
	// 		case "showHideList":
	// 			$response = ['1' => '表示', '2' => '非表示'];
	// 			break;

	// 		//FAQ区分リスト
	// 		case "classificationList":
	// 			$response = ['1' => '送迎講師直雇用', '2' => '送迎講師Bスタイル', '3' => '保護者', '5' => '本部'];
	// 			break;

	// 		//月リスト
	// 		case "monthList":
	// 			$response = [ '1' => '1月', '2' => '2月', '3' => '3月', '4' => '4月', '5' => '5月', '6' => '6月', '7' => '7月', '8' => '8月', '9' => '9月', '10' => '10月',
	// 						'11' => '11月', '12' => '12月'];
	// 			break;

	// 		//日にちリスト
	// 		case "dayList":
	// 			$response = [ '1' => '1日', '2' => '2日', '3' => '3日', '4' => '4日', '5' => '5日', '6' => '6日', '7' => '7日', '8' => '8日', '9' => '9日', '10' => '10日',
	// 			'11' => '11日', '12' => '12日', '13' => '13日', '14' => '14日', '15' => '15日', '16' => '16日', '17' => '17日', '18' => '18日', '19' => '19日', '20' => '20日',
	// 			'21' => '21日', '22' => '22日', '23' => '23日', '24' => '24日', '25' => '25日', '26' => '26日', '27' => '27日', '28' => '28日', '29' => '29日', '30' => '30日', '31' => '31日'];
	// 			break;

	// 		//曜日リスト
	// 		case "weekList":
	// 			$response = ['0' => '日', '1' => '月' ,'2' => '火' ,'3' => '水' ,'4' => '木' ,'5' => '金' ,'6' => '土' ];
	// 			break;

	// 		//時間帯
	// 		case "timeZoneList":
	// 			$response = ['1' => '午前', '2' => '午後', '3' => '終日'];
	// 			break;

	// 		//曜日コピーリスト
	// 		case "copyWeekList":
	// 			$response = ['1' => '毎週月曜日' ,'2' => '毎週火曜日' ,'3' => '毎週水曜日' ,'4' => '毎週木曜日' ,'5' => '毎週金曜日' ,'6' => '毎週土曜日' ];
	// 			break;

	// 		//勤務時間午前リスト
	// 		case "amTimeList":
	// 			$response = ['1' => '07:00', '2' => '07:30', '3' => '08:00', '4' => '08:30', '5' => '09:00', '6' => '09:30', '7' => '10:00', '8' => '10:30', '9' => '11:00',
	// 			'10' => '11:30', '11' => '12:00'];
	// 			break;

	// 		//勤務時間午後リスト
	// 		case "pmTimeList":
	// 			$response = ['1' => '12:00','2' => '12:30','3' => '13:00','4' => '13:30','5' => '14:00','6' => '14:30','7' => '15:00','8' => '15:30','9' => '16:00',
	// 			'10' => '16:30','11' => '17:00','12' => '17:30','13' => '18:00','14' => '18:30','15' => '19:00','16' => '19:30','17' => '20:00','18' => '20:30',
	// 			'19' => '21:00'];
	// 			break;

	// 		//保護者入力交通手段リスト（保護者入力、予約内容の表示用）
	// 		case "transportationList":
	// 			$response = [ '1' => '電車', '2' => 'バス', '3' => 'タクシー', '4' => '徒歩'];
	// 			break;

	// 		//送迎講師交通手段リスト（スタッフ交通費登録で使用）
	// 		case "staffTransportationList":
	// 			$response = [ '1' => '電車・バス', '2' => 'タクシー', '3' => '徒歩'];
	// 			break;

	// 		//立替区分リスト
	// 		case "paymentDivList":
	// 			$response = [ '1' => 'お子さま交通費', '2' => 'その他立替', '3' => 'タクシー'];
	// 			break;

	// 		//学年リスト
	// 		case "gradeList":
	// 			$response = [ '-1' => '0歳児', '0' => '0歳児', '1' => '1歳児', '2' => '2歳児', '3' => '年少', '4' => '年中', '5' => '年長', '6' => '小1', '7' => '小2', '8' => '小3', '9' => '小4', '10' => '小5',
	// 						'11' => '小6'];
	// 			break;

	// 		//拡張子リスト
	// 		//$extension !='jpg' && $extension !='JPG' && $extension !='png' && $extension !='PNG' && $extension !='gif' && $extension !='GIF' && $extension !='jpeg' && $extension !='JPEG'
	// 		case "extensionList":
	// 			$response = [ '1' => 'jpg', '2' => 'JPG', '3' => 'png', '4' => 'PNG', '5' => 'gif', '6' => 'GIF', '7' => 'jpeg', '8' => 'JPEG', '9' => 'jfif'];
	// 			break;

	// 		//有無リスト
	// 		case "yesNoList":
	// 			$response = ['1' => '有', '2' => '無'];
	// 			break;

	// 		//有無リスト(未到着用)
	// 		case "yesNoList2":
	// 			$response = ['0' => '無', '1' => '有', '2' => 'すべて'];
	// 			break;

	// 		//完了、未リスト
	// 		case "doneList":
	// 			$response = ['1' => '完了', '2' => '未完了'];
	// 			break;

	// 		//完了、未リスト(検索用)
	// 		case "verificationList":
	// 			$response = ['0' => '','1' => '済', '2' => '未'];
	// 			break;

	// 		//完了、未リスト（データ編集画面用）
	// 		case "verificationList2":
	// 			$response = ['1' => '済', '2' => '未'];
	// 			break;

	// 		//送迎可不可リスト
	// 		case "possibleList":
	// 			$response = ['0' => '送迎可能', '1' => '送迎不可'];
	// 			break;

	// 		//OnOffリスト
	// 		case "onoffList":
	// 			$response = ['0' => 'ON', '1' => 'OFF'];
	// 			break;

	// 		//操作ログ用　本部操作画面リスト
	// 		case "operationAllViewList":
	// 			//1~21　予約関係　
	// 			$response = [
	// 				//保護者画面
	// 				'1' => '保護者情報',
	// 				'2' => 'お子さま情報',
	// 				'3' => 'パターン管理',
	// 				'4' => '送迎場所管理',
	// 				'5' => '送迎予約作成・申請',
	// 				'6' => '送迎予約申請一覧',
	// 				'7' => '本日の予定',
	// 				//送迎講師画面
	// 				'8' => '送迎講師基本情報',
	// 				'9' => '勤務日管理',
	// 				'10' => '送迎予約依頼一覧',
	// 				'11' => '送迎予定一覧',
	// 				'12' => '本日のお仕事',
	// 				'13' => '交通費',
	// 				'14' => '立替金',
	// 				//本部のみ
	// 				'15' => '送迎予約検索',
	// 				'16' => '手数料',
	// 				'17' => '小学校管理',
	// 				'18' => '校舎管理',
	// 				'19' => '設定',
	// 				'20' => '管理者管理',
	// 				'21' => '休日設定',
	// 				'22' => 'よくある質問管理',
	// 				'23' => '予約お子さま情報',
	// 				'24' => '予約送迎講師情報',
	// 				'25' => '予約基本情報',
	// 				'26' => '業務ミーティング',//送迎講師
	// 				'27' => 'パターン一覧',//本部のみ
	// 				'28' => '送迎予約詳細',//本部のみ
	// 				'29' => '延長手当一覧',//本部のみ
	// 			];
	// 			break;
	// 		//操作ログ用　保護者操作画面リスト
	// 		case "operationCustomerViewList":
	// 			$response = [
	// 				//保護者画面
	// 				'1' => '保護者登録者情報',
	// 				'2' => 'お子さま情報',
	// 				'3' => 'パターン管理',
	// 				'4' => '送迎場所管理',
	// 				'5' => '送迎予約作成・申請',
	// 				'6' => '送迎予約申請一覧',
	// 				'7' => '本日の予定',
	// 			];
	// 			break;

	// 		//操作ログ用　送迎講師操作画面リスト
	// 		case "operationStaffViewList":
	// 			$response = [
	// 				//送迎講師画面
	// 				'8' => '送迎講師基本情報',
	// 				'9' => '勤務日管理',
	// 				'10' => '送迎予約依頼一覧',
	// 				'11' => '送迎予定一覧',
	// 				'12' => '本日のお仕事',
	// 				'13' => '交通費',
	// 				'14' => '立替金',
	// 				'26' => '業務ミーティング',//送迎講師
	// 			];
	// 			break;

	// 		//操作ログ用　本部操作リスト
	// 		case "operationAllLogList":
	// 			//1~21　予約関係　
	// 			$response = [
	// 				'1' => '予約作成・申請',
	// 				'2' => '予約削除',
	// 				'3' => '予約キャンセル',
	// 				'4' => '予約変更',
	// 				'5' => '振替申請',
	// 				'6' => '割当',
	// 				'7' => '承諾',
	// 				'8' => '辞退',
	// 				'9' => '前日確認',
	// 				'10' => '到着（お迎え）',
	// 				'11' => '到着（終了）',
	// 				'12' => '10分経過',
	// 				'13' => '未到着',
	// 				//'13' => 'TELボタン',
	// 				//'14' => '交通費完了',
	// 				//'15' => '立替金完了',
	// 				'16' => '登録',
	// 				'17' => '更新',
	// 				'18' => '削除',
	// 				'19' => '当日確認',
	// 				'20' => '予約複製',//本部のみ
	// 				'21' => '交通費承諾',//本部のみ
	// 			];
	// 			break;
	// 		//操作ログ用　保護者操作リスト
	// 		case "operationCustomerLogList":
	// 			//1~21　予約関係　
	// 			$response = [
	// 				'1' => '予約作成・申請',
	// 				'2' => '予約削除',
	// 				'3' => '予約キャンセル',
	// 				'4' => '予約変更',
	// 				'5' => '振替申請',
	// 				'16' => '登録',
	// 				'17' => '更新',
	// 				'18' => '削除',
	// 			];
	// 			break;
	// 		//操作ログ用　操作リスト
	// 		case "operationStaffLogList":
	// 			//1~21　予約関係　
	// 			$response = [
	// 				'7' => '承諾',
	// 				'8' => '辞退',
	// 				'9' => '前日確認',
	// 				'10' => '到着（お迎え）',
	// 				'11' => '到着（終了）',
	// 				'12' => '10分経過',
	// 				'13' => '未到着',
	// 				//'13' => 'TELボタン',
	// 				//'14' => '交通費完了',
	// 				//'15' => '立替金完了',
	// 				'16' => '登録',
	// 				'17' => '更新',
	// 				'18' => '削除',
	// 				'19' => '当日確認',
					
	// 			];
	// 			break;
	// 		//メール送信履歴一覧用　操作リスト
	// 		case "operationMailLogList":
	// 			$response = [
	// 				'3' => '予約キャンセル',
	// 				'4' => '予約変更',
	// 				'5' => '振替申請',
	// 				'17' => '予約変更(場所・時間以外)',
	// 				'13' => 'お子さま未到着',
	// 			];
	// 			break;
	// 	}
	// 	return $response;
	// }

	// //正常メッセージ取得
	// public static function getSuccessMsg($name,$method){

	// 	switch ($method){
	// 		case "store":
	// 			$response = $name."が正常に登録されました。";
	// 			break;
	// 		case "update":
	// 			$response = $name."が正常に更新されました。";
	// 			break;
	// 		case "delete":
	// 			$response = $name."が正常に削除されました。";
	// 			break;
	// 	}

	// 	return $response;
	// }

	// //予約作成時用　誕生日から現在の学年(小学校)を求める 小学生ではない場合:歳
	// public static function getPickupGrade($date,$birthday){
	// 	Log::debug( '***  start Util/getPickupGrade  *************************' );
	// 	Log::debug("date（予約日）".$date);
	// 	Log::debug("birthday ".$birthday);

	// 	//ハイフン、スラッシュ、スペースを除去
	// 	$birthday = str_replace("-","",$birthday);
	// 	$birthday = str_replace("/","",$birthday);
	// 	$birthday = str_replace(" ","",$birthday);

	// 	//$now = date('Ymd');
	// 	$now = date('Ymd',strtotime($date));

	// 	$b_y = substr($birthday, 0, 4);
	// 	$b_m = substr($birthday, 4, 4);
	// 	$n_y = substr($now, 0, 4);
	// 	$n_m = substr($now, 4, 4);

	// 	if ($n_m < 400) { //前学期
	// 		$m = 1;
	// 	} else { //新学期
	// 		$m = 0;
	// 	}

	// 	if($b_m < 402) { //早生まれ
	// 		$n_y++;
	// 	}
		
	// 	$grade = $n_y - $b_y - $m;
	// 	Log::debug($n_y."-".$b_y."-".$m." = ".$grade);

	// 	//-----年齢の計算
	// 	$age = floor(($now-$birthday)/10000);
	// 	Log::debug("age".$age);

	// 	//0: うめ組    2021-04-02 - 2022-04-01
	// 	//1: うめ組    2020-04-02 - 2021-04-01
	// 	//2: もも組    2019-04-02 - 2020-04-01
	// 	//3: さくら組  2018-04-02 - 2019-04-01
	// 	//4: 年少      2017-04-02 - 2018-04-01
	// 	//5: 年中      2016-04-02 - 2017-04-01
	// 	//6: 年長      2015-04-02 - 2016-04-01
	// 	//7: 小1       2014-04-02 - 2015-04-01
	// 	//8: 小2       2013-04-02 - 2014-04-01
	// 	//9: 小3       2012-04-02 - 2013-04-01
	// 	//10: 小4      2011-04-02 - 2012-04-01
	// 	//11: 小5      2010-04-02 - 2011-04-01
	// 	//12: 小6      2009-04-02 - 2010-04-01

	// 	//学年の計算

	// 	//結果を返す
	// 	switch ($grade){
	// 		case 0:
	// 		case 1:
	// 			$data = "うめ組";
	// 				break;
	// 		case 2:
	// 			$data = "もも組";
	// 				break;
	// 		case 3:
	// 			$data = "さくら組";
	// 				break;
	// 		case 4:
	// 			$data = "年少";
	// 			break;
	// 		case 5:
	// 			$data = "年中";
	// 			break;
	// 		case 6:
	// 			$data = "年長";
	// 			break;
	// 		case 7:
	// 		case 8:
	// 		case 9:
	// 		case 10:
	// 		case 11:
	// 		case 12:
	// 			$data = "小".($grade - 6);
	// 			break;
	// 		default:
	// 			$data = $age."歳";
	// 	}
	// 	Log::debug("grade ".$data);

	// 	Log::debug ( '***  end Util/getPickupGrade  *************************' );

	// 	return $data;
	// }

	// //誕生日から現在の学年(小学校)を求める 小学生ではない場合:歳
	// public static function getGrade($birthday){
	// 	Log::debug ( '***  start Util/getGrade  *************************' );
	// 	Log::debug("birthday ".$birthday);

	// 	//ハイフン、スラッシュ、スペースを除去
	// 	$birthday = str_replace("-","",$birthday);
	// 	$birthday = str_replace("/","",$birthday);
	// 	$birthday = str_replace(" ","",$birthday);

	// 	$now = date('Ymd');
	// 	Log::debug("now ".$now);

	// 	$b_y = substr($birthday, 0, 4);
	// 	$b_m = substr($birthday, 4, 4);
	// 	$n_y = substr($now, 0, 4);
	// 	$n_m = substr($now, 4, 4);

	// 	if ($n_m < 400) { //前学期
	// 		$m = 1;
	// 	} else { //新学期
	// 		$m = 0;
	// 	}

	// 	if($b_m < 402) { //早生まれ
	// 		$n_y++;
	// 	}
		
	// 	$grade =  $n_y - $b_y - $m;

	// 	Log::debug($n_y."-".$b_y."-".$m." = ".$grade);

	// 	//-----年齢の計算
	// 	$age = floor(($now-$birthday)/10000);
	// 	Log::debug("age".$age);

	// 	//0: うめ組    2021-04-02 - 2022-04-01
	// 	//1: うめ組    2020-04-02 - 2021-04-01
	// 	//2: もも組    2019-04-02 - 2020-04-01
	// 	//3: さくら組  2018-04-02 - 2019-04-01
	// 	//4: 年少      2017-04-02 - 2018-04-01
	// 	//5: 年中      2016-04-02 - 2017-04-01
	// 	//6: 年長      2015-04-02 - 2016-04-01
	// 	//7: 小1       2014-04-02 - 2015-04-01
	// 	//8: 小2       2013-04-02 - 2014-04-01
	// 	//9: 小3       2012-04-02 - 2013-04-01
	// 	//10: 小4      2011-04-02 - 2012-04-01
	// 	//11: 小5      2010-04-02 - 2011-04-01
	// 	//12: 小6      2009-04-02 - 2010-04-01

	// 	//学年の計算

	// 	//結果を返す
	// 	switch ($grade){
	// 		case 0:
	// 		case 1:
	// 			$data = "うめ組";
	// 		  	break;
	// 		case 2:
	// 			$data = "もも組";
	// 		  	break;
	// 		case 3:
	// 			$data = "さくら組";
	// 		  	break;
	// 		case 4:
	// 			$data = "年少";
	// 			break;
	// 		case 5:
	// 			$data = "年中";
	// 			break;
	// 		case 6:
	// 			$data = "年長";
	// 			break;
	// 		case 7:
	// 		case 8:
	// 		case 9:
	// 		case 10:
	// 		case 11:
	// 		case 12:
	// 			$data = "小".($grade - 6);
	// 			break;
	// 		default:
	// 			$data = $age."歳";
	// 	}
	// 	Log::debug("grade ".$data);

	// 	Log::debug ( '***  start Util/getGrade  *************************' );

	// 	return $data;
	// }

	// // //新一年生かどうかを判定する
	// // public static function getGradeFlg($birthday){
	// // 	Log::debug ( '***  start Util/getGradeFlg  *************************' );
	// // 	Log::debug("birthday ".$birthday);

	// // 	////新一年生かどうかを判定する
	// // 	//0:新一年生ではない、1:新一年生

	// // 	$grade_flg = 0;

	// // 	//ハイフン、スラッシュ、スペースを除去
	// // 	$birthday = str_replace("-","",$birthday);
	// // 	$birthday = str_replace("/","",$birthday);
	// // 	$birthday = str_replace(" ","",$birthday);

	// // 	$now = date('Ymd');
	// // 	Log::debug("now ".$now);

	// // 	$b_y = substr($birthday, 0, 4);
	// // 	$b_m = substr($birthday, 4, 4);
	// // 	$n_y = substr($now, 0, 4);
	// // 	$n_m = substr($now, 4, 4);

	// // 	if ($n_m < 400) { //前学期
	// // 		$m = 1;
	// // 	} else { //新学期
	// // 		$m = 0;
	// // 	}

	// // 	if($b_m < 402) { //早生まれ
	// // 		$n_y++;
	// // 	}

	// // 	$grade =  $n_y - $b_y - $m;
	// // 	Log::debug($n_y."-".$b_y."-".$m." = ".$grade);

	// // 	//0: うめ組    2021-04-02 - 2022-04-01
	// // 	//1: うめ組    2020-04-02 - 2021-04-01
	// // 	//2: もも組    2019-04-02 - 2020-04-01
	// // 	//3: さくら組  2018-04-02 - 2019-04-01
	// // 	//4: 年少      2017-04-02 - 2018-04-01
	// // 	//5: 年中      2016-04-02 - 2017-04-01
	// // 	//6: 年長      2015-04-02 - 2016-04-01
	// // 	//7: 小1       2014-04-02 - 2015-04-01
	// // 	//8: 小2       2013-04-02 - 2014-04-01
	// // 	//9: 小3       2012-04-02 - 2013-04-01
	// // 	//10: 小4      2011-04-02 - 2012-04-01
	// // 	//11: 小5      2010-04-02 - 2011-04-01
	// // 	//12: 小6      2009-04-02 - 2010-04-01

	// // 	if($grade == 6){
	// // 		//年長
	// // 		//２月の場合
	// // 		if( date('m') == '02' ){
	// // 			Log::debug("操作日が2月");
	// // 			//2月1~2月5日(託児の予約が作成できる)
	// // 			if( ( date('j') >= '1' ) && ( date('j') <= '5' ) ){
	// // 				Log::debug("操作日が2月1~2月5日(託児の予約が作成できる)");
	// // 				//何もしない
	// // 			}else{
	// // 				Log::debug("操作日が2月1~2月5日以外(託児の予約作成不可)");
	// // 				//新一年生とする
	// // 				$grade_flg = 1;
	// // 			}
	// // 		}
	// // 		//3月の場合は新一年生とする
	// // 		if(date('m') == '03'){
	// // 			Log::debug("操作日が3月(託児の予約作成不可)");
	// // 			$grade_flg = 1;
	// // 		}
	// // 	}

	// // 	Log::debug("grade_flg ".$grade_flg);
	// // 	Log::debug ( '***  end Util/getGradeFlg  *************************' );

	// // 	return $grade_flg;
	// // }

	// // //学童、託児、全ての校舎のリストを取得
	// // public static function getClassroomList(){
	// // 	//校舎用リスト
	// // 	$classroomList = DB::select("
	// // 		select 
	// // 			id,
	// // 			place_div,
	// // 			class_div,
	// // 			place_name
	// // 		from 
	// // 			mst_places 
	// // 		where deleted_at is NULL 
	// // 			and place_div = 2
	// // 			and is_enable = 0
	// // 		order by data_id asc
	// // 	");

	// // 	return $classroomList ;
	// // }

	// //小学校の時間プルダウン作成用
	// public static function getSchoolTime($school_info) {
	// 	Log::debug ( '***  start Util/getSchoolTime  *************************' );
	// 	//小学校の基本時間
	// 	$school_default_time = $school_info->school_default_time;
	// 	//選択する時間
	// 	$school_select_time = $school_info->school_select_time;
	// 	if(isset($school_select_time )){
	// 		//選択時間を配列に変換（プルダウンにするため）
	// 		$select_time = explode("-", $school_select_time);
	// 		//配列にしたschool_select_timeの先頭にschool_default_timeを追加する
	// 		array_unshift( $select_time, $school_default_time);
	// 	}else{
	// 		$select_time = [$school_default_time];
	// 	}
	// 	Log::debug ( '***  end   Util/getSchoolTime  *************************' );
	// 	return $select_time;
	// }

	// //本部の送迎講師画面のメニューボタンを作成
	// public static function getStaffMenu($staff_id){
	// 	$menuHtml = "";
	// 	//送迎講師画面のメニューボタン
	// 	$menuHtml .= '<a href="/staff/show/'.$staff_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-3 col-xl-2c col-12 btn-success" type="button" style="margin-left:1px;margin-bottom:3px;">送迎講師詳細</button></a>';
	// 	$menuHtml .= '<a href="/today_works/index/'.$staff_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-3 col-xl-2c col-12 btn-success" type="button" style="margin-left:1px;margin-bottom:3px;">本日のお仕事</button></a>';
	// 	$menuHtml .= '<a href="/staff_schedule/index/'.$staff_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-3 col-xl-2c col-12 btn-success" type="button" style="margin-left:1px;margin-bottom:3px;">送迎予定一覧</button></a>';
	// 	$menuHtml .= '<a href="/staff_request/index/'.$staff_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-3 col-xl-2c col-12 btn-success" type="button" style="margin-left:1px;margin-bottom:3px;">送迎予約依頼一覧</button></a>';
	// 	$menuHtml .= '<a href="/staff_holidays/index/'.$staff_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-3 col-xl-2c col-12 btn-success" type="button" style="margin-left:1px;margin-bottom:3px;">勤務日管理</button></a>';
	// 	//$menuHtml .= '<a href="/expense_info/index/'.$staff_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-3 col-xl-2c col-12 btn-success" type="button" style="margin-left:1px;margin-bottom:3px;">交通費検索</button></a>';
	// 	$menuHtml .= '<a href="/staff_log/index/'.$staff_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-3 col-xl-2c col-12 btn-success" type="button" style="margin-left:1px;margin-bottom:3px;">操作ログ</button></a>';
	// 	return $menuHtml;
	// }

	// //本部の保護者画面のメニューボタンを作成
	// public static function getCustomerMenu($customer_id){
	// 	$menuHtml = "";
	// 	//保護者画面のメニューボタン
	// 	$menuHtml .= '<a href="/customer/show/'.$customer_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-4 col-xl-2c col-12 btn-success menu_btn" type="button" style="margin-left:1px;margin-bottom:3px;">保護者情報詳細</button></a>';
	// 	$menuHtml .= '<a href="/today_schedule/index/'.$customer_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-4 col-xl-2c col-12 btn-success menu_btn" type="button" style="margin-left:1px;margin-bottom:3px;">本日の予定</button></a>';
	// 	$menuHtml .= '<a href="/application/index/'.$customer_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-4 col-xl-2c col-12 btn-success menu_btn" type="button" style="margin-left:1px;margin-bottom:3px;">送迎予約申請一覧</button></a>';
	// 	$menuHtml .= '<a href="/reserve/index/'.$customer_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-4 col-xl-2c col-12 btn-success menu_btn" type="button" style="margin-left:1px;margin-bottom:3px;">送迎予約作成・申請</button></a>';
	// 	$menuHtml .= '<a href="/customer_log/index/'.$customer_id.'"><button class="btn btn-sm col-sm-4 col-md-3 col-lg-4 col-xl-2c col-12 btn-success menu_btn" type="button" style="margin-left:1px;margin-bottom:3px;">操作ログ</button></a>';
	// 	return $menuHtml;
	// }

	// //現在から予約日までの営業日数を計算する
	// public static function getDays($pickup_date){
	// 	Log::debug ( '***  start Util/getDays  *************************' );

	// 	//★営業日数を求める

	// 	//今日の日付
	// 	$today = new DateTime();
	// 	// // 【テスト用】現在日時を取得
	// 	// $today = new DateTime('2023-07-28 22:53:50');
	// 	Log::debug($today->format('Y-m-d'));

	// 	$pickup_date_diff = new DateTime($pickup_date);
	// 	//Log::debug($pickup_date_diff->format('Y-m-d'));

	// 	$diff = $today->diff($pickup_date_diff);

	// 	$days = $diff->days;
	// 	//今日の日付と、予約日が一致しない場合のみの処理
	// 	if($today->format('Y-m-d') != $pickup_date_diff->format('Y-m-d')){
	// 		//差は、前後の日付が加算されないので、1日追加
	// 		$days = $diff->days + 1;
	// 		//Log::debug($days);
    //     }

	// 	$ignore_days = 0;
	// 	for($i=1;$i<=$days;$i++ ){

	// 		if($i != 1){
	// 			//1週目はプラスしない
	// 			$today->modify("+1 day");
	// 			//Log::debug($today->format('Y-m-d') ." ". $today->format('w') ." ".$i );
	// 		}

	// 		//土曜日または日曜日だったらカウント
	// 		if($today->format('w') == 0 || $today->format('w') == 6){
	// 			$ignore_days++;
	// 		}else{

	// 			//祝日マスタに存在する？
	// 			$chk = MstHoliday::where('holiday', $today->format('Y-m-d'))->where('is_enable', 0)->whereNull('deleted_at')->exists();
	// 			//存在したら
	// 			if($chk == true){
	// 				//Log::debug($today->format('Y-m-d') ." ". $today->format('w') ." ".$i );
	// 				$ignore_days++;
	// 			}
	// 		}
	// 	}

	// 	//営業日数を返す
	// 	//Log::debug($days - $ignore_days);
	// 	Log::debug ( '***  end   Util/getDays  *************************' );
	// 	return $days - $ignore_days;
	// }

	// //現在から予約日までの日数を計算する
	// public static function getDays2($pickup_date){
	// 	Log::debug ( '***  start Util/getDays2  *************************' );

	// 	//★日数を求める（営業日を考慮しない）

	// 	//今日の日付
	// 	$today = new DateTime();
	// 	//Log::debug($today->format('Y-m-d'));

	// 	$pickup_date_diff = new DateTime($pickup_date);
	// 	//Log::debug($pickup_date_diff->format('Y-m-d'));

	// 	$diff = $today->diff($pickup_date_diff);

	// 	$days = $diff->days;
	// 	//今日の日付と、予約日が一致しない場合のみの処理
	// 	if($today->format('Y-m-d') != $pickup_date_diff->format('Y-m-d')){
	// 		//差は、前後の日付が加算されないので、1日追加
	// 		$days = $diff->days + 1;
	// 		//Log::debug($days);
	// 	}
	// 	//日数を返す
	// 	//Log::debug($days);
	// 	Log::debug ( '***  end   Util/getDays2  *************************' );
	// 	return $days;
	// }

	// //指定日からの指定営業日後の日付を計算する(スポット送迎判定に使用)
	// public static function getAfterDay($date,$after_cnt){
	// 	Log::debug ( '***  start Util/getAfterDay  *************************' );
	// 	Log::debug ( '$date:'.$date );
	// 	Log::debug ( '$after_cnt'.$after_cnt );

	// 	//第1引数をDatetimeで変換
	// 	$target_date = new DateTime($date);

	// 	if($after_cnt == 0){
	// 		$result_date = $target_date->format('Y-m-d');
	// 		return $result_date;
	// 	}

	// 	$cnt = 0;
	// 	//営業日数カウント初期値
	// 	$business_days = 0;

	// 	while(true){ //無限に繰り返す
	// 		Log::debug ( '$cnt：'.$cnt );

	// 		if($cnt == 0){
	// 			// 1週目は何もしない
	// 			$cnt++;
	// 			continue;
	// 		}
	// 		// 日付を加算
	// 		$target_date->modify("+1 day");
	// 		//土日以外はカウント
	// 		if($target_date->format('w') != 0 && $target_date->format('w') != 6){
	// 			Log::debug ( '平日' );
	// 			//祝日マスタに存在する？
	// 			$chk = MstHoliday::where('holiday', $target_date->format('Y-m-d'))->where('is_enable', 0)->whereNull('deleted_at')->exists();
	// 			//存在しなければ
	// 			if($chk == false){
	// 				$business_days++;
	// 			}else{
	// 				Log::debug ( '祝日マスタに存在するので営業日加算しない' );
	// 			}
	// 		}else{
	// 			Log::debug ( '土日なので営業日に営業日加算しない' );
	// 		}
	// 		Log::debug ( '$business_days:'.$business_days );
	// 		Log::debug ( '$target_date->format(Y-m-d):'.$target_date->format('Y-m-d') );

	// 		// 営業日カウントと第２引数の営業日数が等しくなれば終了
	// 		if($business_days == $after_cnt){
	// 			Log::debug ( '$business_days:'.$business_days.'とafter_cnt:'.$after_cnt.'が等しい' );
	// 			$result_date = $target_date->format('Y-m-d');
	// 			break; //繰返しの強制終了
	// 		}
	// 		$cnt++;
	// 	}

	// 	//指定営業日後の日付を返す
	// 	Log::debug ( '***  end   Util/getAfterDay  *************************' );
	// 	return $result_date;
	// }
	
	// //fromからtoまでの営業日数を計算する
	// public static function getHolidayFlg($date){
	// 	Log::debug ( '***  start Util/getHolidayFlg  *************************' );
	// 	// 初期値を設定 0=休日ではない 1=休日である
	// 	$holiday_flg = 0;
	// 	// 対象の日付
	// 	$judge_date = new DateTime($date);

	// 	//土曜日または日曜日であるか
	// 	if($judge_date->format('w') == 0 || $judge_date->format('w') == 6){
	// 		$holiday_flg = 1;
	// 	}
	// 	//祝日マスタに存在する？
	// 	$chk = MstHoliday::where('holiday', $judge_date->format('Y-m-d'))->where('is_enable',0)->whereNull('deleted_at')->exists();
	// 	if($chk == true){
	// 		$holiday_flg = 1;
	// 	}

	// 	//フラグを返す
	// 	Log::debug ( '***  end   Util/getHolidayFlg  *************************' );
	// 	return $holiday_flg;
	// }

	// //like検索エスケープ処理
	// public static function escapeProcessing($keyword){
	// 	//バックスラッシュが含まれていたら除去
	// 	$keyword = str_replace(array('\\'), array(''), $keyword);
	// 	//%が含まれていたら除去
	// 	$keyword = str_replace(array('%'), array(''), $keyword);
	// 	// "
	// 	$keyword = str_replace(array('"'), array('\"'), $keyword);
	// 	// '
	// 	$keyword = str_replace(array('\''), array('\\\''), $keyword);

	// 	return $keyword;
	// }
}
?>
