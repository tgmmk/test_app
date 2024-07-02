<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('m2') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

					<form class="w-full mb-10" action="/schedule" method="get" id="search" class="form-horizontal" enctype="multipart/form-data">
					@csrf
					<!-- <form class="w-full mb-10"> -->
						<div class="flex md:items-center mb-3">
							<div class="w-1/6 md:w-1/12">
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="from_date">日付</label>
							</div>
							<div class="w-2/6 md:w-3/12">
								<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="from_date" name="from_date" type="date" value="{{ $from_date }}">
							</div>
							<div class="w-1/6 md:w-1/12">
								<label class="block text-gray-500 font-bold md:text-center mb-1 md:mb-0 p-4" for="to_date">～</label>
							</div>
							<div class="w-2/6 md:w-3/12">
								<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="to_date" name="to_date" type="date" value="{{ $to_date }}">
							</div>
							<div class="w-1/4 md:w-1/12">
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="week">曜日</label>
							</div>
							<div class="w-3/4 md:w-3/12">
								<select class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="week" name="week">
									<option value=""></option>
									@foreach($weekList as $k => $v)
										<option value="{{ $k }}" @if($k == $week) selected @endif>{{ $v }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="flex md:items-center mb-3">
							<div class="w-1/6 md:w-2/12">
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="student_name">お子さま氏名</label>
							</div>
							<div class="w-2/6 md:w-4/12">
								<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="student_name" name="student_name" type="text" value="{{ $student_name }}">
							</div>
							<div class="w-1/6 md:w-2/12">
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="student_kana">お子さま氏名かな</label>
							</div>
							<div class="w-2/6 md:w-4/12">
								<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="student_kana" name="student_kana" type="text" value="{{ $student_kana }}">
							</div>
						</div>
						<div class="flex md:items-center mb-3">
							<div class="w-2/6 md:w-2/12">
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="free_word">フリーワード</label>
							</div>
							<div class="w-4/6 md:w-6/12">
								<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="free_word" name="free_word" type="text" value="{{ $free_word }}">
							</div>
						</div>
						<div class="flex justify-center md:items-center py-6">
							<div class="w-1/2 md:w-1/6 text-center">
								<a href="/schedule"><button class="shadow bg-gray-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold w-11/12 py-1 rounded" type="button">クリア</button></a>
							</div>
							<div class="w-1/2 md:w-1/6 text-center">
								<button class="shadow bg-cyan-500 hover:bg-cyan-400 focus:shadow-outline focus:outline-none text-white font-bold w-11/12 py-1 rounded" type="submit">検索</button>
							</div>
						</div>
					</form>
                    



                    <div class="flex flex-col ">
                        <div class="-m-1.5 overflow-x-auto ">
                            <div class="p-1.5 min-w-full inline-block align-middle">
								<div class="overflow-hidden">
									<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 ">
										<thead class="bg-gray-400 text-white dark:bg-gray-700 dark:text-gray-400">
											<tr>
											<th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase">日付</th>
											<th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase">曜日</th>
											<th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase">開始時間</th>
											<th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase">終了時間</th>
											<th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase">お子さま</th>
											<th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase">予定</th>
											<th scope="col" class="px-6 py-3 text-end text-xs font-medium uppercase">編集</th>
											</tr>
										</thead>
										<tbody>
											@foreach($data as $k)
												<tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
													<td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$k->date}}</td>
													<td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$weekList[$k->week]}}</td>
													<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{$k->start_time}}</td>
													<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{$k->end_time}}</td>
													<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{!! $k->name !!}</td>
													<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{$k->event}}</td>
													<td class="px-4 py-2 whitespace-nowrap text-end text-sm font-medium">
														<button type="button" data-id="{{$k->id}}" class="editBtn py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-500 text-white hover:bg-gray-600 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">管理</button>
														<!-- <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">詳細</button> -->
													</td>
												</tr>
											@endforeach

										</tbody>
									</table>
								</div>
                            </div>
                        </div>
						{{ $data->links('vendor.pagination.tailwind2') }}
						<!-- {{ $data->onEachSide(5)->links() }} -->
					</div>

















                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
	$(function(){
		$('.editBtn').click(function() {
			// 教室idを取得
			var schedule_id = 1;
			//検索フォームの行き先を変更
			$('#search').attr('action', '/schedule/edit/'+schedule_id);

			$('#search').submit();

		});
        // alert('test');

		// //画像押下時 画像拡大モーダル発動
		// $(document).on('click', '.imgBtn', function(){

		// 	//リセット
		// 	$('.bigimg').children().attr('src', null);
		// 	$('#file_name').text(null);

		// 	//選択した画像情報
		// 	var imgSrc = $(this).data('path');
		// 	var name = $(this).data('name');
		// 	console.log(name);

		// 	//画像拡大モーダルにセット
		// 	$('.bigimg').children().attr('src', imgSrc);
		// 	$('#file_name').text(name);

		// 	//モーダル発動
		// 	$('#modal_file').show();
		// });

		// //お迎え時間のプルダウンが選択されるたび実行
		// $(document).on("change", ".select_from_time", function () {

		// 	//所要時間
		// 	var time_required = $('#time_required').val();
			
		// 	var time_required = parseInt(time_required);

		// 	var select_from_time = $(".select_from_time").val();
		// 	var hour = select_from_time.slice(0, 2);
		// 	var minutes = select_from_time.slice(3, 5);
		// 	var hour = parseInt(hour);
		// 	var minutes = parseInt(minutes);

		// 	if(time_required > 0){
		// 		//所要時間を足す
		// 		minutes = minutes + time_required;
		// 		if(minutes >= 60){
		// 			//console.log('1時間以上の場合');
		// 			//分を時間換算する	参考サイトhttps://mebee.info/2022/07/26/post-61467/
		// 			var diff_hour = `${Math.floor(minutes / 60)}`;//時間
		// 			var diff_minutes = `${ minutes % 60 }` //分
		// 			//console.log('diff_hour:'+diff_hour);
		// 			//console.log('diff_minutes:'+diff_minutes);
		// 			diff_hour = parseInt(diff_hour);//足し算するため数値に変換
		// 			hour = hour + diff_hour;//お迎え時間+所要時間の「時」の値
		// 			console.log('hour:'+hour);
		// 			minutes = diff_minutes;;//所要時間の「分」の値
		// 		}
		// 		//hourが一桁のとき、先頭に0を足す。例(8:00)
		// 		if(hour < 10){
		// 			hour = '0'+hour.toString();
		// 			//console.log('先頭に0を足す:hour='+hour);
		// 		}
		// 		//分が一桁のとき、先頭に0を足す
		// 		if(minutes < 10){
		// 			minutes = '0'+minutes.toString();
		// 		}
		// 		$('.select_to_time').val(hour+":"+minutes);
		// 	}else{;
		// 		//１時間後の数字にする
		// 		hour = hour + 1;
		// 		//hourが一桁のとき、先頭に0を足す。例(8:00)
		// 		if(hour < 10){
		// 			hour = '0'+hour.toString();
		// 			//console.log('先頭に0を足す:hour='+hour);
		// 		}
		// 		//分が一桁のとき、先頭に0を足す
		// 		if(minutes < 10){
		// 			minutes = '0'+minutes.toString();
		// 		}
		// 		$('.select_to_time').val(hour+":"+minutes);
		// 	}

		// });

		// //更新ボタン押下時
		// $(document).on('click', '#confirmedBtn', function(){

		// 	$('div.content-header').empty();

		// 	console.log('pickup_div:'+pickup_div);
		// 	var flg = "";
		// 	var service_div = $("#service_div").val();
		// 	console.log('service_div:'+service_div);
		// 	if(pickup_div == 1){
		// 		var from_place_id = $("#from_place_id").val();
		// 		var from_time = $("#school_from_time").val();
		// 		var to_place_id = $("#to_place_id").val();
		// 		var to_time = $("#school_to_time").val();
		// 	}else{
		// 		var from_place_id = $("#from_place_id").val();
		// 		var from_time = $("#from_time").val();
		// 		var to_place_id = $("#to_place_id").val();
		// 		var to_time = $("#to_time").val();
		// 		//var to_time = $("#to_time_head").val();//管理者の場合
		// 	}

		// 	console.log('from_time='+from_time);
		// 	console.log('to_time='+to_time);
		// 	//最初の2文字を取得
		// 	//お迎え時間
		// 	var hourStr1 = from_time.slice(0, 2);
		// 	//最後から2文字を取得
		// 	var minutes1 = from_time.slice(3, 5);
		// 	var startTime = new Date( 2000, 0, 01, hourStr1, minutes1);
		// 	//お送り時間
		// 	var hourStr2 = to_time.slice(0, 2);
		// 	var minutes2 = to_time.slice(3, 5);
		// 	var endTime = new Date( 2000, 0, 01, hourStr2, minutes2);
		// 	//時間差
		// 	var elapsedTime = endTime.getTime() - startTime.getTime()
		// 	var time_diff = elapsedTime / ( 1000 * 60 ); // 分の計算
		
		// 	console.log('time_diff='+time_diff);
		// 	//場所と時間の値を送り、伸芽会の契約ごとのルールに沿った内容かを確認する
		// 	$.ajax({
		// 		type: "Get",
		// 		url: "/getRequestCheck",
		// 		data: {
		// 			'pickup_div':pickup_div,
		// 			'service_div':service_div,
		// 			'from_place_id':from_place_id, 
		// 			'from_time':from_time,
		// 			'to_place_id':to_place_id, 
		// 			'to_time':to_time, 
		// 			'time_diff':time_diff, 
		// 			'flg':flg, 
		// 		},
		// 		dataType : "json"
		// 	}).done(function(result){
		// 		console.log(result);
				
		// 		if(result[0] == true || result === undefined){
		// 			//フォームの2重送信を防止する
		// 			$("#confirmedBtn").prop('disabled', true);

		// 			$('#update').attr({
		// 				action: '/application/update',
		// 				method: 'post'
		// 			});

		// 			$('#update').submit();
		// 		}else{

		// 			$.each(result, function(index, value) {
		// 				$('div.content-header').prepend('<div class="alert alert-danger"> \
		// 													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> \
		// 													<i class="icon fas fa-exclamation-triangle"></i>'+value+'\
		// 												</div>');
		// 			})
		// 			//モーダルを閉じる
		// 			$('#commissionCheckModal').modal('hide');
		// 		}
				
		// 	}).fail(function(XMLHttpRequest, textStatus, error){
		// 		console.log("通信に失敗しました。");
		// 		console.log(jqXHR.status);
		// 		console.log(textStatus);
		// 		console.log(errorThrown.message);
		// 	});
		// });

	});

</script>