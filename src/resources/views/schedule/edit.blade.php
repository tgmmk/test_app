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
				<form class="w-full mb-10" action="/schedule/update" method="post" id="edit" class="form-horizontal" enctype="multipart/form-data">
				@csrf
				<!-- <form class="w-full mb-10"> -->
					<input type="hidden" name="sche_id" id="sche_id" value="{{ $sche_data->id }}">
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
							<textarea maxlength="500" class="appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="remark" name="remark">{{ $sche_data->remark }}</textarea>
						</div>
					</div>
					<div class="flex justify-center md:items-center py-6">
						<div class="w-1/2 md:w-1/6 text-center">
							<button class="shadow bg-amber-400 hover:bg-amber-300 focus:shadow-outline focus:outline-none font-bold w-11/12 py-1 rounded" type="submit">更新</button>
						</div>
						<div class="w-1/2 md:w-1/6 text-center">
							<button class="delete_btn shadow bg-red-400 hover:bg-red-300 focus:shadow-outline focus:outline-none font-bold w-11/12 py-1 rounded" type="button"  data-hs-overlay="#hs-delete-modal">削除</button>
						</div>
					</div>
				</form>
	
				<div class="flex flex-col ">
					<div class="-m-1.5 overflow-x-auto ">
						<div class="p-1.5 min-w-full inline-block align-middle">
							<div class="overflow-hidden">
								<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 ">
									<thead class="bg-gray-400 text-white dark:bg-gray-700 dark:text-gray-400">
										<tr class="text-center">
										<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">お子さま氏名</th>
										<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">登所予定時間</th>
										<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">退所予定時間</th>
										<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">送迎（行き）</th>
										<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">送迎（帰り）</th>
										<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">送迎場所</th>
										<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">備考</th>
										<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">編集</th>
										</tr>
									</thead>
									<tbody>
										@foreach($stu_data as $k)
											<tr class="odd:bg-white even:bg-gray-100 text-center dark:odd:bg-slate-900 dark:even:bg-slate-800">
												<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{$k->name}}</td>
												<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{$k->start_time}}</td>
												<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{$k->end_time}}</td>
												<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">@if($k->pickup_div == 1 || $k->pickup_div == 3)〇@endif</td>
												<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">@if($k->pickup_div == 2 || $k->pickup_div == 3)〇@endif</td>
												<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{$k->pickup_place_id}}</td>
												<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{$k->remark}}</td>
												<td class="px-4 py-2 whitespace-nowrap text-end text-sm font-medium">
													<button type="button" data-hs-overlay="#hs-basic-modal" data-id="{{$k->id}}" class="editBtn py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-500 text-white hover:bg-gray-600 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">編集</button>
													<!-- <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">詳細</button> -->
												</td>
											</tr>
										@endforeach

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<!-- 編集モーダル start-->
					<div id="hs-basic-modal" class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none">
						<div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all lg:max-w-4xl lg:w-full m-3 lg:mx-auto"><!-- largeサイズ -->
							<div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
								<div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
									<h3 class="font-bold text-gray-800 dark:text-white">
										タイトル
									</h3>
									<button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-basic-modal">
									<span class="sr-only">Close</span>
									<svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
									</button>
								</div>
								<form id="stu_edit" action="/schedule/sche_stu_update" method="post" enctype="multipart/form-data" class="p-6" >
									@csrf
									<input type="hidden" name="sche_stu_id" id="sche_stu_id">
									<input type="hidden" name="sche_id" id="sche_id" value="{{ $sche_data->id }}">
									<div class="grid gap-4 sm:grid-cols-2">
										<div>
											<label for="stu_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">開始時間</label>
											<input type="time" name="stu_start_time" id="stu_start_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
										</div>
										<div>
											<label for="stu_end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">終了時間</label>
											<input type="time" name="stu_end_time" id="stu_end_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
										</div>
										<div>
											<label for="pickup_div" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">送迎</label>
											<select id="pickup_div" name="pickup_div" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
												<option value="0">なし</option>
												<option value="1">行きのみ</option>
												<option value="2">帰りのみ</option>
												<option value="3">往復</option>
											</select>
										</div>
										<div class="sm:col-span-2">
											<label for="stu_remark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">備考</label>
											<textarea id="stu_remark" name="stu_remark" rows="4" maxlength="500" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>                    
										</div>
									</div>
									<div class="flex justify-center items-center gap-x-2 pt-5 px-4 dark:border-gray-700">
										<button type="button" class="py-2 px-10 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-300 hover:bg-gray-400 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-basic-modal">
											閉じる
										</button>
										<button type="submit" class="py-2 px-10 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-amber-300 hover:bg-amber-400 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
											更新
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				<!-- modal end-->
				<!-- 削除モーダル start-->
					<div id="hs-delete-modal" class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none">
						<div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all lg:max-w-4xl lg:w-full m-3 lg:mx-auto"><!-- largeサイズ -->
							<div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
								<form action="/schedule/delete" method="post" enctype="multipart/form-data" class="p-6" >
								この教室を削除します。よろしいですか。
									@csrf
									<input type="hidden" name="delete_id" value="{{ $sche_data->id }}">
									<div class="flex justify-center items-center gap-x-2 pt-5 px-4 dark:border-gray-700">
										<button type="button" class="py-2 px-10 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-400 hover:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-delete-modal">
											閉じる
										</button>
										<button type="submit" class="py-2 px-10 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-400 hover:bg-red-300 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
											OK
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				<!-- modal end-->

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
	$(function(){
		$('.editBtn').click(function() {
			// 教室idを取得
			var sche_stu_id = $(this).data('id');

			// モーダルの内容を初期化する
			var edit_form = document.getElementById('stu_edit');
			edit_form.reset();

			// ajax起動
			if(sche_stu_id != ""){
				$.ajax({
					type: "Get",
					url: "/schedule/get_sche_stu_data",
					data: { 
						'id':sche_stu_id,
					},
					dataType : "json"
				}).done(function(data){
					data = data[0];
					// フォームに値をセットする
					$('#stu_start_time').val(data.start_time);
					$('#stu_end_time').val(data.end_time);
					$('#pickup_div').val(data.pickup_div);
					$('#stu_remark').val(data.remark);
					$('#sche_stu_id').val(sche_stu_id);
					// $('#commission').val(data);
				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log("通信に失敗しました。");
					console.log(jqXHR.status);
					console.log(textStatus);
					console.log(errorThrown);
				});
			}else{
				//処理を抜ける
				return;
			}
		});
	});

</script>