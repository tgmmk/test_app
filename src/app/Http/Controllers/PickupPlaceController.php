<?php

namespace App\Http\Controllers;

use Log;
use Datetime;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Models\Schedule;
use App\Models\ScheduleStudent;
use App\Models\MstServiceHour;
use App\Models\MstPlace;

use App\Component\Util;

class PickupPlaceController extends Controller
{
    //
    public function index(Request $request) {
		Log::debug ( '***  start pickup_place/index  *************************' );
		
		try{
			// 初期値を設定
			$student_name = "";
			$student_kana = "";
			$place_name = "";
			$address = "";

			// 入力値があればセット
			if(isset($request->student_name)){
				$student_name = $request->student_name;
				// 空白を除去
				$student_name = str_replace(' ', '', $student_name);
				$student_name = str_replace('　', '', $student_name);
			}
			if(isset($request->student_kana)){
				$student_kana = $request->student_kana;
				// 空白を除去
				$student_kana = str_replace(' ', '', $student_kana);
				$student_kana = str_replace('　', '', $student_kana);
			}
			if(isset($request->place_name)){
				$place_name = $request->place_name;
			}
			if(isset($request->address)){
				$address = $request->address;
			}

			//セッションに値があるとき：戻るボタン押下
			//その値で検索・表示する
			if ($request->session()->exists('place_search_param')) {
				// 存在する
				// 指定したデータをセッションから取得（pullで取得後に削除される)
				$search_param = $request->session()->pull('place_search_param');
				foreach($search_param as $key => $value){
					//検索条件の作成
					${$key} = $value;
				}
			}

			// ----------------------------------*\
			//where条件を設定
			// ----------------------------------*/
			$where = "where t1.deleted_at is null and t2.deleted_at is null ";

			if($student_name != ""){
				// データも空白を無視して検索する
				$where .="and (replace(name, ' ','') like '%".$student_name."%' or replace(name, '　','') like '%".$student_name."%') ";
				// $where .="and name like '%".$student_name."%' ";
			}
			if($student_kana != ""){
				// データも空白を無視して検索する
				$where .="and (replace(name_kana, ' ','') like '%".$student_kana."%' or replace(name_kana, '　','') like '%".$student_kana."%') ";
				// $where .="and name_kana like '%".$student_kana."%' ";
			}
			if($place_name != ""){
				$where .="and (place_name like '%".$place_name."%') ";
			}
			if($address != ""){
				$where .="and (address like '%".$address."%') ";
			}

            $sql = "
				select 
					t1.id,
					name,
					name_kana,
					place_name,
					address,
					case when t1.formatted_address is null then '<span style=\"color:red;\">未登録</span>' else '登録済み' end as locate_flg
				from
					mst_places t1
				left join
					students t2
				on t2.id = t1.student_id
				".$where."
            ";

			// dd($sql);

			$data = DB::table(DB::raw("({$sql}) as t order by id desc"))->paginate(30);


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

			Log::debug ( '***  end   pickup_place/index  *************************' );
			return view('pickup_place.index',
				[
					'data' => $data,
					'student_name' => $student_name,
					'student_kana' => $student_kana,
					'place_name' => $place_name,
					'address' => $address,
				]
			);

		} catch (\Exception $e){
            dd($e);
            session()->flash('flash_message_error', '予期せぬエラーが発生しました。');
			// Util::commonErrorHandling($e, Auth::user()->id );
			return redirect('/dashboard');
		}
	}

	//教室データ作成
	public function create(request $request) {
		Log::debug ( '***  start schedule/update  *************************' );
		
		try{
			//検索条件の保持
			self::save_place_search_param($request,1);

			// dd($request);
			//作成タイプ
			$type = $request->type;

			// 単発作成
			if($type == 'single'){

				//トランザクション処理開始
				DB::transaction(function () use ($request){
					// 日付
					$date = $request->date;
					//開始時間
					$start_time = $request->create_start_time;
					//終了時間
					$end_time = $request->create_end_time;
					// 予定
					$event = $request->event;
					// 備考
					$remark = $request->remark;

					// ------------------------------------------------*\
					// 同一日にデータが存在する場合は先に進まない
					// ------------------------------------------------*/
					$result = Schedule::where('date', $date)->whereNull('deleted_at')->exists();
					//存在しなければ
					if($result == true){
						session()->flash('flash_message_error', '同一日のデータが存在するので作成できません');
						throw new \Exception('同一日');
					}
					
					//登録する内容
					$param = [
						"date" => $date,
						"start_time" => $start_time,
						"end_time" => $end_time,
						"event" => $event,
						"remark" => $remark,
					];
					// 登録
					Schedule::insert($param);
				
				}); //トランザクション処理終了
			}
			// 一括作成

			if($type == 'bulk'){
				//トランザクション処理開始
				$res = DB::transaction(function () use ($request){
					// 日付
					$target_month = $request->target_month;
					//開始時間
					$start_time = $request->create_start_time;
					//終了時間
					$end_time = $request->create_end_time;
					// 備考
					$remark = $request->remark;

					//月初め
					$startDate = new DateTime('first day of ' . $target_month);
					// dd($startDate);
					//月終わり
					$endDate  = new DateTime('last day of ' . $target_month);

					// // 差分に初日と終日の２日分を足すと、その月の日数となる
					// $diff = $startDate->diff($endDate)+2;
					// dd($diff->days);

					// 対象の日数を取得
					$count = $endDate->format('j');
					// エラーメッセージ初期値
					$err = "";
					$params = [];
					$target_date = $startDate;

					for($i=1;$i<=$count;$i++){

						$ymd = $target_date->format('Y-m-d');

						$result = Schedule::where('date',$ymd )->whereNull('deleted_at')->exists();
						
						if($result == true){
							// 同一日にデータが存在する場合は登録しない
							$err_date = $target_date->format('Y年m月d日');
							$err .= $err_date."は同一日のデータが存在するので作成できませんでした<br>";
						}elseif($target_date->format('w') == 0 || $target_date->format('w') == 6){
							// 土日の場合は登録しない
							// // 祝日の場合は登録しない
							// if(){
							// }
						}else{
							// 登録処理
							//登録する内容
							$param = [
								"date" => $ymd,
								"start_time" => $start_time,
								"end_time" => $end_time,
								"remark" => $remark,
							];
							// 配列に追加
							$params[] = $param;
						}
						// １日進める
						$target_date->modify("+1 day");
					}
					// dd($params);

					// 登録
					$creat_cnt = count($params);
					Schedule::insert($params);
					$res['creat_cnt'] = $creat_cnt;
					$res['err'] = $err;
					return $res;
				}); //トランザクション処理終了

			}
			// エラーメッセージがあればセッションに追加（一括作成）
			if(!empty($res['err'])){
				session()->flash('flash_message_error', $res['err']);
			}
		
			//フラッシュの生成
			session ()->flash ('flash_message_success', $res['creat_cnt'].'件の教室データを作成しました');
	

		} catch (\Exception $e){
			if($e->getMessage() != '同一日'){
				dd($e->getMessage());
				session()->flash('flash_message_error', '予期せぬエラーが発生しました。');
			}
			// Util::commonErrorHandling($e, Auth::user()->id );
			return redirect('/schedule');
		}
		return redirect('/schedule');
	}

    //送迎場所編集	
    public function edit(request $request) {
		Log::debug ( '***  start pickup_place/edit  *************************' );
		
		try{
			// dd($request);
			//検索条件の保持
			self::save_place_search_param($request,null);

			$mst_place_id = $request->mst_place_id;

			// データを取得
			$data = DB::table('mst_places AS t1')
				->select('t1.id', 'name','place_name','address','formatted_address')
				->leftjoin('students AS t2','t2.id','=','t1.student_id')
				->whereNull('t1.deleted_at')
				->where('t1.id',$mst_place_id)
				->first();

			Log::debug ( '*****  end pickup_place/edit  *************************' );
			return view('pickup_place.edit',
				[
					'data' => $data,
					// 'student_name' => $student_name,
					// 'student_kana' => $student_kana,
					// 'student_kana' => $student_kana,
				]
			);

		} catch (\Exception $e){
            dd($e);
            session()->flash('flash_message_error', '予期せぬエラーが発生しました。');
			// Util::commonErrorHandling($e, Auth::user()->id );
			return redirect('/dashboard');
		}
	}

	//教室データ更新
	public function update(request $request) {
		Log::debug ( '***  start pickup_place/update  *************************' );
		
		try{
			// dd($request);
			// --------------------------------------------------------------------------------------------------*\
			// 検索用住所更新にチェックが入っていたら、住所検索結果の内容でformatted_addressと位置情報を更新する。
			// --------------------------------------------------------------------------------------------------*/
			if(isset($request->update_result_flg)){

				//場所id
				$mst_place_id = $request->mst_place_id;
				//場所名
				$place_name = $request->place_name;
				//登録住所
				$address = $request->address;

				$formatted_address = null;
				$location_lat = null;
				$location_lng = null;
				$place_id = null;

				$json = $request->result_json;
				$json = json_decode($json, true);

				if(is_array($json)){
					// dd($json['results'][0]['place_id']);
					//経路作成用住所
					$formatted_address = $json['results'][0]['formatted_address'];
					// $result_address = $request->result_address;
					//geocoording の緯度
					$location_lat = $json['results'][0]['geometry']['location']['lat'];
					//geocoording の経度
					$location_lng = $json['results'][0]['geometry']['location']['lng'];
					//geocoording のplace_id
					$place_id = $json['results'][0]['place_id'];
				}

				//登録する内容
				$param = [
					"place_name" => $place_name,
					"address" => $address,
					"formatted_address" => $formatted_address,
					"location_lat" => $location_lat,
					"location_lng" => $location_lng,
					"place_id" => $place_id,
				];
			}else{
				//場所id
				$mst_place_id = $request->mst_place_id;
				//場所名
				$place_name = $request->place_name;
				//登録住所
				$address = $request->address;

				//登録する内容
				$param = [
					"place_name" => $place_name,
					"address" => $address,
				];
			}

			//登録
			MstPlace::where('id', $mst_place_id)->update($param);
		
				//フラッシュの生成
				session ()->flash ('flash_message_success', '送迎場所データを更新しました');
	
				Log::debug ( '***  end   pickup_place/update  *************************' );

		} catch (\Exception $e){
			dd($e);
			session()->flash('flash_message_error', '予期せぬエラーが発生しました。');
			// Util::commonErrorHandling($e, Auth::user()->id );
			return redirect('/dashboard');
		}
		return redirect('pickup_place/edit/'.$mst_place_id.'?mst_place_id='.$mst_place_id);
	}

	//教室データ削除
	public function delete(request $request) {
		Log::debug ( '***  start schedule/delete  *************************' );
		
		try{
			//教室id
			$sche_id = $request->delete_id;

			
			//トランザクション処理開始
			DB::transaction(function () use ($request){

				//教室id
				$sche_id = $request->delete_id;

				// 教室を削除
				Schedule::where('id', $sche_id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

				// 紐づくお子さま利用情報を削除
				ScheduleStudent::where('schedule_id', $sche_id)->whereNull('deleted_at')->update(['deleted_at' => date('Y-m-d H:i:s')]);

			
			}); //トランザクション処理終了

			//フラッシュの生成
			session ()->flash ('flash_message_success', '教室データを削除しました');
	

		} catch (\Exception $e){
			dd($e);
			session()->flash('flash_message_error', '予期せぬエラーが発生しました。');
			// Util::commonErrorHandling($e, Auth::user()->id );
			return redirect('/schedule');
		}
		Log::debug ( '***  end   schedule/delete  *************************' );
		return redirect('/schedule');
	}

	// //教室作成モーダル
	// public function get_create_data(Request $request) {
	// 	Log::debug ( '***  start schedule/get_create_data  *************************' );

	// 	///////////////////////////////////
	// 	//作成に必要なフォームhtmlを取得//
	// 	///////////////////////////////////

	// 	$html = "";
	
	// 	//作成タイプを取得
	// 	$type = $request->type;

	// 	if($type == 'single'){
	// 		$html = '
	// 			<input type="hidden" name="type" id="type" value="single">
	// 			<div class="grid gap-4 sm:grid-cols-2">
	// 				<div>
	// 					<label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">日付</label>
	// 					<input type="date" name="date" id="date" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
	// 				</div>
	// 				<div>
	// 					<label for="event" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">予定</label>
	// 					<input type="text" name="event" id="event" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
	// 				</div>
	// 				<div>
	// 					<label for="create_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">開始時間</label>
	// 					<input type="time" name="create_start_time" id="create_start_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
	// 				</div>
	// 				<div>
	// 					<label for="create_end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">終了時間</label>
	// 					<input type="time" name="create_end_time" id="create_end_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
	// 				</div>
	// 				<div class="sm:col-span-2">
	// 					<label for="remark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">備考</label>
	// 					<textarea id="remark" name="remark" rows="4" maxlength="500" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>                    
	// 				</div>
	// 			</div>
	// 		';
	// 	}
	// 	if($type == 'bulk'){
	// 		$html = '
	// 			<input type="hidden" name="type" id="type" value="bulk">
	// 			<div class="grid gap-4 sm:grid-cols-2">
	// 				<div>
	// 					<label for="target_month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">作成月</label>
	// 					<select id="target_month" name="target_month" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
	// 						@foreach($selectMonthList as $k => $v)
	// 							<option value="{{$k}}">{{$v}}</option>
	// 						@endforeach
	// 					</select>
	// 				</div>
	// 				<div></div>
	// 				<div>
	// 					<label for="create_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">開始時間</label>
	// 					<input type="time" name="create_start_time" id="create_start_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
	// 				</div>
	// 				<div>
	// 					<label for="create_end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">終了時間</label>
	// 					<input type="time" name="create_end_time" id="create_end_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
	// 				</div>
	// 				<div class="sm:col-span-2">
	// 					<label for="stu_remark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">備考</label>
	// 					<textarea id="remark" name="remark" rows="4" maxlength="500" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>                    
	// 				</div>
	// 			</div>
	// 		';
	// 	}

	// 	Log::debug ( '***  end   schedule/get_create_data  *************************' );
	// 	return $html;
	// }

	//お子さま予約編集モーダル
	public function get_sche_stu_data(Request $request) {
		Log::debug ( '***  start schedule/get_sche_stu_data  *************************' );

		//////////////////////////
		//編集に必要な情報を取得//
		/////////////////////////
	
		//選択したID
		$sche_stu_id = $request->id;
		// IDから情報を取得
		// $data = ScheduleStudent::where('id',$id)->first();
		$sche_stu_data = DB::table('schedule_students AS t1')
		->leftjoin('students AS t2','t2.id','=','t1.student_id')
		->whereNull('t1.deleted_at')
		->where('t1.id',$sche_stu_id)
		->get();
		if(count($sche_stu_data) == 0){
			return json_encode(	'該当データがありません。', JSON_UNESCAPED_UNICODE);
		}

		Log::debug ( '***  end   schedule/get_sche_stu_data  *************************' );
		return $sche_stu_data;
	}

	//お子さま予約データ更新
	public function sche_stu_update(request $request) {
		Log::debug ( '***  start schedule/sche_stu_update  *************************' );
		
		try{
			// dd($request);
			//教室id
			$sche_id = $request->sche_id;
			//お子さま予約id
			$sche_stu_id = $request->sche_stu_id;
			//登所時間
			$stu_start_time = $request->stu_start_time;
			//退所時間
			$stu_end_time = $request->stu_end_time;
			// 送迎の有無
			$pickup_div = $request->pickup_div;
			// 備考
			$remark = $request->stu_remark;
			// // 教室データを取得
			// $sche_data = Schedule::where('id',$id)->first();

			//トランザクション処理開始
			DB::transaction(function () use ($sche_stu_id,$stu_start_time,$stu_end_time,$pickup_div,$remark){

				//登録する内容
				$param = [
					"start_time" => $stu_start_time,
					"end_time" => $stu_end_time,
					"pickup_div" => $pickup_div,
					"remark" => $remark,
				];
				//登録
				ScheduleStudent::where('id', $sche_stu_id)->update($param);
			
			}); //トランザクション処理終了
		
				//フラッシュの生成
				session ()->flash ('flash_message_success', 'お子さま予約データを更新しました');
	

		} catch (\Exception $e){
			dd($e);
			session()->flash('flash_message_error', '予期せぬエラーが発生しました。');
			// Util::commonErrorHandling($e, Auth::user()->id );
			return redirect('/dashboard');
		}
		return redirect('schedule/edit/'.$sche_id);
	}

	//検索条件の保持
	public function save_place_search_param($request,$type) {

		if ($request->session()->exists('place_search_param')) {
		}else{
			//セッションの値リセット
			$request->session()->forget('place_search_param');

			//検索条件の保持
			$search_param = [
				'student_name' => $request->student_name,
				'student_kana' => $request->student_kana,
				'place_name' => $request->place_name,
				'address' => $request->address,
			];

			//セッションに保存する（戻るボタン押下時）
			$request->session()->put('place_search_param', $search_param);
		}
	}

	// //更新　
	// public function update(Request $request) {
	// 	Log::debug ( '***  start pattern/update  *************************' );

	// 	//dd($request);
	// 	$validate_rule = [
	// 		'select_commission' => [
	// 			'required',
	// 		],
	// 		'commission' => [
	// 			'required',
	// 		],
	// 	];
	
	// 	//カスタムメッセージ
	// 	$messages = [
	// 		'select_commission.required' => "手数料内容は必須です。",
	// 		'commission.required' => "手数料は必須です。",
	// 	];

	// 	//バリデーションチェック
	// 	$this->validate ( $request, $validate_rule, $messages );

	// 	try{
	// 		///////////////////////////
	// 		//登録処理に必要な値を取得する//
	// 		///////////////////////////
	// 		//手数料データのIDを取得
	// 		$data_id = $request->commission_id;
	// 		//dd($commission_id);
	// 		//予約IDを取得
	// 		$pickup_id = $request->pickup_id;
	// 		//保護者IDを取得
	// 		$customer_id = $request->customer_id;
	// 		//お子さまIDを取得
	// 		$student_id = $request->student_id;
	// 		//予約お子さま情報のIDを取得
	// 		$pickup_student_id = $request->pickup_student_id;
	// 		//dd($pickup_student_id);
	// 		//登録時の日時
	// 		$timestamp = date('Y-m-d H:i:s');
	// 		//ログイン者のユーザーID取得
	// 		$user_id = Auth::user()->id;
	
	// 		//ログ登録用
	// 		$view_id = 16;
	// 		$operation_id = 17;

	// 		//トランザクション
	// 		DB::transaction(function () use ($request, $data_id, $pickup_id, $customer_id, $student_id, $user_id, $timestamp, $view_id, $operation_id){
	// 			//ログ用に交通費に紐づく予約の情報を取得する
	// 			$pickup_data = Pickup::where('id', $pickup_id)->first();
	// 			//更新前のデータを取得
	// 			$before_data = Commission::where('id', $data_id)->first();
	// 			//登録する内容
	// 			$param = [
	// 				//"pickup_id" => $pickup_id,
	// 				//"customer_id" => $customer_id,
	// 				//"student_id" => $student_id,
	// 				"commission_id" => $request->select_commission,
	// 				"commission" => $request->commission,
	// 				"updated_at" => $timestamp,
	// 				"updated_user_id" => $user_id,
	// 			];
	// 			//登録
	// 			Commission::where('id', $data_id)->update($param);
		
	// 			//ログ処理を追加する
	// 			$log_param = self::getUpdateLogParam($view_id, $operation_id, $pickup_id, $customer_id, $student_id, $timestamp, $user_id, $pickup_data, $before_data, $param);
	// 			//ログテーブルに登録
	// 			OperationLog::insert($log_param);
			
	// 		}); //トランザクション処理終了
	
	// 		//フラッシュの生成
	// 		session ()->flash ('flash_message_success', Util::getSuccessMsg("手数料","update"));
	
	// 		Log::debug ( '***  end   pattern/update  *************************' );
			
	// 	} catch (\Exception $e){
	// 		Util::commonErrorHandling($e, Auth::user()->id, null);
	// 	}

	// 	return redirect('schedule/pickup_student_edit/'.$student_id.'?pickup_student_id='.$pickup_student_id.'&pickup_id='.$pickup_id);

	// }
}
