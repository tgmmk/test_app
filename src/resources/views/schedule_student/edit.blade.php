<x-app-layout>
    <x-slot name="header">
		<div class="flex justify-between items-center justify-center">
			<h2 class="midashi_title font-semibold text-xl text-gray-800 leading-tight ">
				{{ __('m9') }}
			</h2>
			<div class="modoru">
				<a href="/schedule"><button type="button" class="py-1 px-5 inline-flex items-center gap-x-2 text-sm font-semibold rounded-md border border-transparent bg-gray-400 text-white hover:bg-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-500">戻る</button></a>
			</div>
		</div>
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
							<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="date">日付</label>
						</div>
						<div class="w-2/6 md:w-3/12">
							<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="date" name="date" type="date" value="{{ $sche_data->date }}" disabled>
						</div>
						<div class="w-1/6 md:w-1/12">
							<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="start_time">時間</label>
						</div>
						<div class="w-2/6 md:w-3/12">
							<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="start_time" name="start_time" type="time" value="{{ $sche_data->start_time }}">
						</div>
						<div class="w-1/6 md:w-1/12">
							<label class="block text-gray-500 font-bold md:text-center mb-1 md:mb-0 p-4" for="end_time">～</label>
						</div>
						<div class="w-2/6 md:w-3/12">
							<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="end_time" name="end_time" type="time" value="{{ $sche_data->end_time }}">
						</div>
					</div>
					<div class="flex md:items-center mb-3">
						<div class="w-1/6 md:w-2/12">
							<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="event">予定</label>
						</div>
						<div class="w-5/6 md:w-10/12">
							<input class="appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="event" name="event" type="text" value="{{ $sche_data->event }}">
						</div>
					</div>
					<div class="flex md:items-center mb-3">
						<div class="w-1/6 md:w-2/12">
							<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="remark">備考</label>
						</div>
						<div class="w-5/6 md:w-10/12">
							<textarea class="appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="remark" name="remark">{{ $sche_data->remark }}</textarea>
						</div>
					</div>
					<div class="flex justify-center md:items-center py-6">
						<div class="w-1/2 md:w-1/6 text-center">
							<button class="shadow bg-cyan-500 hover:bg-cyan-400 focus:shadow-outline focus:outline-none text-white font-bold w-11/12 py-1 rounded" type="submit">更新</button>
						</div>
					</div>
				</form>
	















                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
	$(function(){
		// $('.editBtn').click(function() {
		// 	// 教室idを取得
		// 	var schedule_id = 19;
		// 	//検索フォームの行き先を変更
		// 	$('#search').attr('action', '/schedule/edit/'+schedule_id);

		// 	$('#search').submit();

		// });
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
		// $(document).on("change", ".select_start_time", function () {

		// 	//所要時間
		// 	var time_required = $('#time_required').val();
			
		// 	var time_required = parseInt(time_required);

		// 	var select_start_time = $(".select_start_time").val();
		// 	var hour = select_start_time.slice(0, 2);
		// 	var minutes = select_start_time.slice(3, 5);
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
		// 		$('.select_end_time').val(hour+":"+minutes);
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
		// 		$('.select_end_time').val(hour+":"+minutes);
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
		// 		var start_time = $("#school_start_time").val();
		// 		var to_place_id = $("#to_place_id").val();
		// 		var end_time = $("#school_end_time").val();
		// 	}else{
		// 		var from_place_id = $("#from_place_id").val();
		// 		var start_time = $("#start_time").val();
		// 		var to_place_id = $("#to_place_id").val();
		// 		var end_time = $("#end_time").val();
		// 		//var end_time = $("#end_time_head").val();//管理者の場合
		// 	}

		// 	console.log('start_time='+start_time);
		// 	console.log('end_time='+end_time);
		// 	//最初の2文字を取得
		// 	//お迎え時間
		// 	var hourStr1 = start_time.slice(0, 2);
		// 	//最後から2文字を取得
		// 	var minutes1 = start_time.slice(3, 5);
		// 	var startTime = new Date( 2000, 0, 01, hourStr1, minutes1);
		// 	//お送り時間
		// 	var hourStr2 = end_time.slice(0, 2);
		// 	var minutes2 = end_time.slice(3, 5);
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
		// 			'start_time':start_time,
		// 			'to_place_id':to_place_id, 
		// 			'end_time':end_time, 
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