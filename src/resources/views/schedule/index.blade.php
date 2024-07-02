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

					<form class="w-full" action="/schedule" method="get" id="search" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="sche_id" id="sche_id" value="">
					@csrf
					<!-- <form class="w-full mb-10"> -->
						<div class="flex md:items-center mb-3">
							<div class="w-1/6 md:w-1/12">
								<span>
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="from_date">日付</label>
							</div>
							<div class="w-2/6 md:w-3/12">
								<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="from_date" name="from_date" type="date" value="{{ $from_date }}">
							</div>
							<div class="w-1/6 md:w-1/12">
								<label class="block text-gray-500 font-bold md:text-center mb-1 md:mb-0 p-4" for="to_date">～</label>
							</div>
							<div class="w-2/6 md:w-3/12">
								<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="to_date" name="to_date" type="date" value="{{ $to_date }}">
							</div>
							<div class="w-1/4 md:w-1/12">
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="week">曜日</label>
							</div>
							<div class="w-3/4 md:w-3/12">
								<select class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="week" name="week">
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
								<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="student_name" name="student_name" type="text" value="{{ $student_name }}">
							</div>
							<div class="w-1/6 md:w-2/12">
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="student_kana">お子さま氏名かな</label>
							</div>
							<div class="w-2/6 md:w-4/12">
								<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="student_kana" name="student_kana" type="text" value="{{ $student_kana }}">
							</div>
						</div>
						<div class="flex md:items-center mb-3">
							<div class="w-2/6 md:w-2/12">
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="free_word">フリーワード</label>
							</div>
							<div class="w-4/6 md:w-6/12">
								<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="free_word" name="free_word" type="text" value="{{ $free_word }}">
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
					<div class="text-right">
						<button data-hs-overlay="#hs-create-modal" data-type="bulk" class="createBtn shadow bg-lime-500 hover:bg-lime-400 focus:shadow-outline focus:outline-none text-white font-bold rounded px-2 my-2" type="button">一括<i class="i-bxs-plus-circle align-middle py-2" style="margin-bottom:3px !important"></i></button>
						<button data-hs-overlay="#hs-create-modal" data-type="single" class="createBtn shadow bg-lime-500 hover:bg-lime-400 focus:shadow-outline focus:outline-none text-white font-bold rounded px-2 my-2" type="button">個別<i class="i-bxs-plus-circle align-middle py-2" style="margin-bottom:3px !important"></i></button>
					</div>
                    <div class="flex flex-col ">
                        <div class="-m-1.5 overflow-x-auto ">
                            <div class="p-1.5 min-w-full inline-block align-middle">
								<div class="overflow-hidden">
									<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
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
	<!-- modal start-->
	<div id="hs-create-modal" class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none">
		<div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all lg:max-w-4xl lg:w-full m-3 lg:mx-auto"><!-- largeサイズ -->
		<!-- <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto"> basicサイズ-->
			<div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
				<div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
					<h3 id="create_title" class="font-bold text-gray-800 dark:text-white">
					</h3>
					<button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-create-modal">
					<span class="sr-only">Close</span>
					<svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
					</button>
				</div>
				<form id="create_form" action="/schedule/create" method="post" enctype="multipart/form-data" class="p-6" >
					<input type="hidden" name="from_date2" id="from_date2" value="">
					<input type="hidden" name="to_date2" id="to_date2" value="">
					<input type="hidden" name="week2" id="week2" value="">
					<input type="hidden" name="student_name2" id="student_name2" value="">
					<input type="hidden" name="student_kana2" id="student_kana2" value="">
					<input type="hidden" name="free_word2" id="free_word2" value="">
					@csrf
					<div id="append_area">
						<!-- <input type="hidden" name="type" id="type" value="single">
						<div class="grid gap-4 sm:grid-cols-2">
							<div>
								<label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">日付</label>
								<input type="date" name="date" id="date" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
							</div>
							<div>
								<label for="event" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">予定</label>
								<input type="text" name="event" id="event" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
							</div>
							<div>
								<label for="create_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">開始時間</label>
								<input type="time" name="create_start_time" id="create_start_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
							</div>
							<div>
								<label for="create_end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">終了時間</label>
								<input type="time" name="create_end_time" id="create_end_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">
							</div>
							<div class="sm:col-span-2">
								<label for="remark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">備考</label>
								<textarea id="remark" name="remark" rows="4" maxlength="500" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>                    
							</div>
						</div> -->
					</div>
					<div class="flex justify-center items-center gap-x-2 pt-5 px-4 dark:border-gray-700">
						<button type="submit" class="createConfirmBtn py-2 px-10 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-lime-400 hover:bg-lime-300 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
							作成
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- modal end-->
</x-app-layout>

<script>
	$(function(){
		$('.editBtn').click(function() {
			//選択したデータ
			var schedule_id = $(this).data('id');
			$('#sche_id').val(schedule_id);
			//検索フォームの行き先を変更
			$('#search').attr('action', '/schedule/edit/'+schedule_id);

			$('#search').submit();

		});

		$('.createBtn').click(function() {
			// 教室idを取得
			var type = $(this).data('type');

			// モーダルの内容を初期化する
			var create_form = document.getElementById('create_form');
			create_form.reset();

			// 検索値を取得しフォームにセットする（セッション保持のため）
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var week = $('#week').val();
			var student_name = $('#student_name').val();
			var student_kana = $('#student_kana').val();
			var free_word = $('#free_word').val();

			$('#from_date2').val(from_date);
			$('#to_date2').val(to_date);
			$('#week2').val(week);
			$('#student_name2').val(student_name);
			$('#student_kana2').val(student_kana);
			$('#free_word2').val(free_word);
			// console.log(pickup_students_id);

			// 要素の中を初期化する
			$('#create_title').empty();
			$('#append_area').empty();

			var html = "";
			// モーダルの表示内容をセットする
			if(type == 'single'){
				$('#create_title').html('個別教室作成');
				html += '<input type="hidden" name="type" id="type" value="single">';
				html += '<div class="grid gap-4 sm:grid-cols-2">';
				html += '	<div>';
				html += '		<label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">日付</label>';
				html += '		<input type="date" name="date" id="date" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="" required>';
				html += '	</div>';
				html += '	<div>';
				html += '		<label for="event" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">予定</label>';
				html += '		<input type="text" name="event" id="event" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="">';
				html += '	</div>';
				html += '	<div>';
				html += '		<label for="create_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">開始時間</label>';
				html += '		<input type="time" name="create_start_time" id="create_start_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="" required>';
				html += '	</div>';
				html += '	<div>';
				html += '		<label for="create_end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">終了時間</label>';
				html += '		<input type="time" name="create_end_time" id="create_end_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="" required>';
				html += '	</div>';
				html += '	<div class="sm:col-span-2">';
				html += '		<label for="remark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">備考</label>';
				html += '		<textarea id="remark" name="remark" rows="4" maxlength="500" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>';
				html += '	</div>';
				html += '</div>';
				$('#append_area').html(html);
			}
			if(type == 'bulk'){
				$('#create_title').html('一括教室作成');
				html += '<input type="hidden" name="type" id="type" value="bulk">';
				html += '<div class="grid gap-4 sm:grid-cols-2">';
				html += '	<div>';
				html += '		<label for="target_month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">作成月</label>';
				html += '		<select id="target_month" name="target_month" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">';
				html += '			@foreach($selectMonthList as $k => $v)';
				html += '				<option value="{{$k}}">{{$v}}</option>';
				html += '			@endforeach';
				html += '		</select>';
				html += '	</div>';
				html += '	<div></div>';
				html += '	<div>';
				html += '		<label for="create_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">開始時間</label>';
				html += '		<input type="time" name="create_start_time" id="create_start_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="" required>';
				html += '	</div>';
				html += '	<div>';
				html += '		<label for="create_end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">終了時間</label>';
				html += '		<input type="time" name="create_end_time" id="create_end_time" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="" required>';
				html += '	</div>';
				html += '	<div class="sm:col-span-2">';
				html += '		<label for="stu_remark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">備考</label>';
				html += '		<textarea id="remark" name="remark" rows="4" maxlength="500" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>';
				html += '	</div>';
				html += '</div>';
				$('#append_area').html(html);
			}
		});

	});

</script>