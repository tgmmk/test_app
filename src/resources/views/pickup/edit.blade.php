
<x-app-layout>

	<div id="flash_area"></div>

    <x-slot name="header">
		<div class="flex justify-between items-center justify-center">
			<h2 class="midashi_title font-semibold text-xl text-gray-800 leading-tight ">
				{{ __('m13') }}
			</h2>
			<div class="modoru">
				<a href="/pickup"><button type="button" class="py-1 px-5 inline-flex items-center gap-x-2 text-sm font-semibold rounded-md border border-transparent bg-gray-400 text-white hover:bg-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-500">戻る</button></a>
			</div>
		</div>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
					@if($route_show_flg == 1)
						<div class="text-right">
							<button data-hs-overlay="#hs-route-modal" data-type="optimal" id="optimal" class="routeBtn shadow bg-cyan-500 hover:bg-cyan-400 focus:shadow-outline focus:outline-none text-white rounded px-2 my-2" type="button">最適化</button>
							<button data-hs-overlay="#hs-route-modal" data-type="normal" id="normal" class="routeBtn shadow bg-lime-500 hover:bg-lime-400 focus:shadow-outline focus:outline-none text-white rounded px-2 my-2" type="button">経路確認</button>
						</div>
					@endif

					<form action="/pickup/update" method="post" id="update" class="form-horizontal" enctype="multipart/form-data">
					@csrf
						<input type="hidden" name="route_id" id="route_id" value="{{ $route_id }}">
						<div class="flex flex-col ">
							<div class="-m-1.5 overflow-x-auto ">
								<div class="p-1.5 min-w-full inline-block align-middle">
									<div class="overflow-hidden">
										<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 ">
											<thead class="bg-gray-400 text-white dark:bg-gray-700 dark:text-gray-400">
												<tr class="text-center">
												<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">送迎順</th>
												<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">お子さま氏名</th>
												<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">利用時間</th>
												<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">送迎場所</th>
												<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">住所</th>
												<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">google地点登録</th>
												</tr>
											</thead>
											
											<tbody id="table_sort">
											
												@foreach($data as $k => $v)
													<tr class="odd:bg-white even:bg-gray-100 text-center dark:odd:bg-slate-900 dark:even:bg-slate-800">
														<input type="hidden" name="display_order_{{ $v->id }}" data-place_id="{{ $v->place_id }}" data-student_name="{{$v->name}}" data-formatted_address="{{ $v->formatted_address }}" data-sche_stu_id="{{ $v->id }}" id="" value="">
														<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">@if($v->pickup_order == 0)未調整@elseif($v->pickup_order > 0){{++$k}}@endif</td>
														<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 text-left">{{$v->name}}</td>
														<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 text-left">{{$v->start_time}}-{{$v->end_time}}</td>
														<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 text-left">{{$v->place_name}}</td>
														<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 text-left">{{$v->address}}</td>
														<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 text-left">@if($v->formatted_address == null)<span style="color:red;"> 未登録</span>@else登録済み@endif</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="flex justify-center md:items-center pt-6">
							<div class="w-1/2 md:w-1/6 text-center">
								<button id="updateBtn" class="shadow bg-amber-400 hover:bg-amber-300 focus:shadow-outline focus:outline-none font-bold w-11/12 py-1 rounded" type="button" data-hs-overlay="#hs-delete-modal">更新</button>
							</div>
						</div>
					</form>
                </div>
				<!-- <div id="map" style="height: 400px;" ></div>
				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjDxKLUxy3fQYmwEX61Vep-X7qFnno0KA&loading=async&callback=initMap&v=weekly&language=ja" defer></script> -->
            </div>
        </div>
    </div>


	<!-- 更新モーダル start-->
	<!-- <div id="hs-basic-modal" tabindex="-1" aria-hidden="true" class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none"> -->
	<div id="hs-delete-modal" class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none">
		<div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all lg:max-w-4xl lg:w-full m-3 lg:mx-auto"><!-- largeサイズ -->
		<!-- <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto"> basicサイズ-->
			<div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
				<form action="/schedule/delete" method="post" enctype="multipart/form-data" class="p-6" >
				送迎順を更新します。よろしいですか。
					@csrf
					<input type="hidden" name="delete_id" value="">
					<div class="flex justify-center items-center gap-x-2 pt-5 px-4 dark:border-gray-700 ">
						<button type="button" class="w-2/12 py-2 gap-x-2 text-sm text-center font-semibold rounded-lg border border-transparent bg-gray-400 hover:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-delete-modal">
							キャンセル
						</button>
						<button type="button" id="confirmBtn" class="w-2/12 py-2 gap-x-2 text-sm text-center font-semibold rounded-lg border border-transparent bg-lime-400 hover:bg-lime-300 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
							OK
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- 経路最適化モーダル start-->
	<!-- <div id="hs-basic-modal" tabindex="-1" aria-hidden="true" class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none"> -->
	<div id="hs-route-modal" class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none">
		<div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all lg:max-w-4xl lg:w-full m-3 lg:mx-auto"><!-- largeサイズ -->
		<!-- <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto"> basicサイズ-->
			<div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
				<div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
					<h3 id="route_title" class="font-bold text-gray-800 dark:text-white">
					</h3>
					<button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-route-modal">
					<span class="sr-only">Close</span>
					<svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
					</button>
				</div>

				<table class="mt-4 mx-10 divide-gray-200 dark:divide-gray-700 ">
					<thead class="bg-gray-400 text-white dark:bg-gray-700 dark:text-gray-400">
						<tr class="text-left">
						<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">送迎順</th>
						<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">マーカー</th>
						<th scope="col" class="px-6 py-3  text-xs font-medium uppercase">送迎地点</th>
						</tr>
					</thead>
					
					<tbody id="summaryPanel">
					</tbody>
				</table>

				<div id="optimal_area" class="flex justify-center md:items-center py-6">
				</div>

				<div class="p-2">
					<div id="map" style="height: 500px;" ></div>
					<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG1k-vWa78nEZRddGs5aConC7xrjbBsuI&loading=async&callback=initMap&v=weekly&language=ja" defer></script> -->
					<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjDxKLUxy3fQYmwEX61Vep-X7qFnno0KA&loading=async&callback=initMap&v=weekly&language=ja" defer></script>
				</div>

				<!-- <div id="button" class="flex justify-center items-center gap-x-2 pt-5 px-4 dark:border-gray-700">
					<button type="button" class="createConfirmBtn py-2 px-10 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-lime-400 hover:bg-lime-300 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
						作成
					</button>
				</div> -->
			</div>
		</div>
	</div>
	<!-- modal end-->

</x-app-layout>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script>
	$(function(){
		$('#table_sort').find('input').each(function(idx){
				console.log("idx:"+idx);
				$(this).val(idx + 1);
		})
		// ソート機能の実装
		$('#table_sort').sortable();
		$('#table_sort').bind('sortstop', function (e, ui) {
	
			$(this).find('input').each(function(idx){
				console.log("idx:"+idx);
				$(this).val(idx + 1);
			})
		});


		$("#confirmBtn").click(function() {
			$('#update').submit();
		});

		// $("#optimalUpdateBtn").click(function() {
		// 	// $('#update').submit();
		// 	console.log("#optimalUpdateBtn");
		// });

		$('.routeBtn').click(function() {
			// 教室idを取得
			var type = $(this).data('type');
			console.log("type:"+type);

			// // モーダルの内容を初期化する
			// var create_form = document.getElementById('create_form');
			// create_form.reset();

			// 検索値を取得しフォームにセットする（セッション保持のため）
			// var from_date = $('#from_date').val();
			// var to_date = $('#to_date').val();
			// var week = $('#week').val();
			// var student_name = $('#student_name').val();
			// var student_kana = $('#student_kana').val();
			// var free_word = $('#free_word').val();

			// $('#from_date2').val(from_date);
			// $('#to_date2').val(to_date);
			// $('#week2').val(week);
			// $('#student_name2').val(student_name);
			// $('#student_kana2').val(student_kana);
			// $('#free_word2').val(free_word);
			// console.log(pickup_students_id);

			// 要素の中を初期化する
			$('#route_title').empty();
			// $('#append_area').empty();

			var html = "";
			// モーダルの表示内容をセットする
			if(type == 'normal'){
				$('#route_title').html('経路確認');

				// $('#append_area').html(html);
			}
			if(type == 'optimal'){
				$('#route_title').html('経路最適化');

				// $('#append_area').html(html);
			}
		});

	});

	function initMap() {
		const directionsService = new google.maps.DirectionsService();
		const directionsRenderer = new google.maps.DirectionsRenderer();
		const map = new google.maps.Map(document.getElementById("map"), {
			zoom: 14,
			center: { "lat": 35.391028,"lng": 136.7234769 },
		});

		directionsRenderer.setMap(map);
		document.getElementById("normal").addEventListener("click", () => {
			calculateAndDisplayRoute1(directionsService, directionsRenderer);
		});
		document.getElementById("optimal").addEventListener("click", () => {
			calculateAndDisplayRoute2(directionsService, directionsRenderer);
		});
	}

	var abc= ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
	var school_address = "{{ $school_data->formatted_address }}"//教室の住所
	var school_name = "{{ $school_data->place_name }}"//教室の名前

	function calculateAndDisplayRoute1(directionsService, directionsRenderer) {

		const optimalArea = document.getElementById("optimal_area");
		optimalArea.innerHTML = "";

		const wayPoints = [];
		// const checkboxArray = document.getElementById("waypoints");

		// for (let i = 0; i < checkboxArray.length; i++) {
		// 	if (checkboxArray.options[i].selected) {
		// 	waypts.push({
		// 		location: checkboxArray[i].value,
		// 		stopover: true,
		// 	});
		// 	}
		// }
		var display = document.getElementById('table_sort');
		var display_data = display.getElementsByTagName('input');
		for(var m = 0; m < display_data.length; m++) {
				// const formatted_address = display_data[m].dataset.formatted_address;
				wayPoints.push({location: display_data[m].dataset.formatted_address});
		}

		// wayPoints.push({location: {
		// 				"lat": 35.4337096,
		// 				"lng": 136.7691215
		// 				}});
		// wayPoints.push({location: {
		// 				"lat": 35.3998295,
		// 				"lng": 136.7298335
		// 				}});
		// wayPoints.push({location: 'スカイツリー'});
		// wayPoints.push({location: '池袋サンシャインビル'});


		directionsService
		.route({
		// origin: document.getElementById("start").value,
			origin: school_address,
			destination:school_address,
			// origin: lat_lng_school,
			// destination: lat_lng_school,
			// destination: document.getElementById("end").value,
			waypoints: wayPoints,
			// optimizeWaypoints: true,
			travelMode: google.maps.TravelMode.DRIVING,
		})
		.then((response) => {
			directionsRenderer.setDirections(response);
			console.log(response);
			const res_waypoints = response.geocoded_waypoints;

			const optimalArea = document.getElementById("optimal_area");
			optimalArea.innerHTML = "";

			const summaryPanel = document.getElementById("summaryPanel");
			summaryPanel.innerHTML = "";

			// For each route, display summary information.
			for (let i = 0; i < res_waypoints.length; i++) {
				const display_num = i ;
				res_place_id = "";
				res_place_id = res_waypoints[i].place_id;
				// console.log(res_waypoints[i].place_id);

				if(i == 0){
					summaryPanel.innerHTML += "<tr class='text-left odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800'><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>出発地点</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + abc[res_waypoints.length-1] + "</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + school_name + "</td></tr>";
					continue;
				}
				if(i == (res_waypoints.length-1)){
					summaryPanel.innerHTML += "<tr class='text-left odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800'><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>終了地点</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + abc[res_waypoints.length-1] + "</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + school_name + "</td></tr>";
					continue;
				}

				$('#table_sort').find('input').each(function(idx){
					// place_idを取得
					var place_id = $(this).data('place_id');
					var student_name = $(this).data('student_name');
					var sche_stu_id = $(this).data('sche_stu_id');
					var formatted_address = $(this).data('formatted_address');
					// console.log("place_id:"+place_id);
					if(place_id == res_place_id){
						// summaryPanel.innerHTML += display_num + "番目：" + student_name + "<br>";
						summaryPanel.innerHTML += "<tr class='text-left odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800'><td class='optimal_res px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200' data-sche_stu_id="+sche_stu_id+" >経由" + display_num + "</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + abc[i] + "</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + student_name + "</td></tr>";
					}
				})
				// $('#table_sort').find('input').each(function(idx){
				// 	// place_idを取得
				// 	var place_id = $(this).data('place_id');
				// 	var student_name = $(this).data('student_name');
				// 	var formatted_address = $(this).data('formatted_address');
				// 	console.log("place_id:"+place_id);
				// 	if(place_id == res_place_id){
				// 		summaryPanel.innerHTML += display_num + "番目：" + student_name + "<br>";
				// 	// $(this).val(idx + 1);
				// 	}
				// })
			}
		})
		.catch((e) => window.alert("Directions request failed due to " + status));
	}

	function calculateAndDisplayRoute2(directionsService, directionsRenderer) {

		const wayPoints = [];
		const waypointsArray = @json($data);

		for (let i = 0; i < waypointsArray.length; i++) {
			wayPoints.push({location: waypointsArray[i]["formatted_address"]});
		}
		console.log(wayPoints);

		directionsService
		.route({
			origin: school_address,
			destination:school_address,
			waypoints: wayPoints,
			optimizeWaypoints: true,
			travelMode: google.maps.TravelMode.DRIVING,
		})
		.then((response) => {
			directionsRenderer.setDirections(response);
			console.log(response);
			const res_waypoints = response.geocoded_waypoints;

			const optimalArea = document.getElementById("optimal_area");
			optimalArea.innerHTML = "";
			optimalArea.innerHTML = "<div class='w-1/2 md:w-2/6 text-center'><button id='optimalUpdateBtn' class='shadow bg-amber-400 hover:bg-amber-300 focus:shadow-outline focus:outline-none w-11/12 py-1 rounded' type='button' onclick='optimal_confirm()'>この順番で更新する</button></div>";

			const summaryPanel = document.getElementById("summaryPanel");
			summaryPanel.innerHTML = "";

			// For each route, display summary information.
			for (let i = 0; i < res_waypoints.length; i++) {
				const display_num = i ;
				res_place_id = "";
				res_place_id = res_waypoints[i].place_id;
				// console.log(res_waypoints[i].place_id);

				if(i == 0){
					summaryPanel.innerHTML += "<tr class='text-left odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800'><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>出発地点</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + abc[res_waypoints.length-1] + "</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + school_name + "</td></tr>";
					continue;
				}
				if(i == (res_waypoints.length-1)){
					summaryPanel.innerHTML += "<tr class='text-left odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800'><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>終了地点</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + abc[res_waypoints.length-1] + "</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + school_name + "</td></tr>";
					continue;
				}

				$('#table_sort').find('input').each(function(idx){
					// place_idを取得
					var place_id = $(this).data('place_id');
					var student_name = $(this).data('student_name');
					var sche_stu_id = $(this).data('sche_stu_id');
					var formatted_address = $(this).data('formatted_address');
					// console.log("place_id:"+place_id);
					if(place_id == res_place_id){
						// summaryPanel.innerHTML += display_num + "番目：" + student_name + "<br>";
						summaryPanel.innerHTML += "<tr class='text-left odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800'><td class='optimal_res px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200' data-sche_stu_id="+sche_stu_id+" >経由" + display_num + "</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + abc[i] + "</td><td class='px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200'>" + student_name + "</td></tr>";
					}
				})
				// $('#table_sort').find('input').each(function(idx){
				// 	// place_idを取得
				// 	var place_id = $(this).data('place_id');
				// 	var student_name = $(this).data('student_name');
				// 	var formatted_address = $(this).data('formatted_address');
				// 	console.log("place_id:"+place_id);
				// 	if(place_id == res_place_id){
				// 		summaryPanel.innerHTML += display_num + "番目：" + student_name + "<br>";
				// 	// $(this).val(idx + 1);
				// 	}
				// })
			}
		})
		.catch((e) => window.alert("Directions request failed due to " + status));
	}

	// 経路最適化更新ボタン押下
	function optimal_confirm() {

		var display = document.getElementById('table_sort');
		var display_data = display.getElementsByTagName('input');
		var optimal_res = document.querySelectorAll(".optimal_res");
		for(var i = 0; i < optimal_res.length; i++) {
			const cnt = i + 1;
			console.log('optimalUpdateBtn:'+cnt+'番目');
			const sche_stu_id = optimal_res[i].dataset.sche_stu_id;
			console.log('sche_stu_id'+sche_stu_id);
			for(var l = 0; l < display_data.length; l++) {
				const display_sche_stu_id = display_data[l].dataset.sche_stu_id;
				if(display_sche_stu_id == sche_stu_id){
					$(display_data[l]).val(cnt);
					console.log('test');
				}
			}
		}
		$('#update').submit();
	}


		// window.initMap = initMap;

	

	// var _map;

	// // 地図の初期化
	// var initMap = function() {
	// 	_map = new google.maps.Map(document.getElementById("map"), {
	// 		zoom : 14,
	// 		center: { "lat": 35.391028,"lng": 136.7234769 },
	// 		mayTypeId: google.maps.MapTypeId.ROADMAP
	// 	});
	// };

	// var directionsService = new google.maps.DirectionsService;
	// var directionsRenderer = new google.maps.DirectionsRenderer;

	// // ルート検索を実行
	// directionsService.route({
	// 	origin: "東京駅",
	// 	destination: "新宿駅",
	// 	travelMode: google.maps.TravelMode.DRIVING
	// }, function(response, status) {
	// 	console.log(response);
	// 	if (status === google.maps.DirectionsStatus.OK) {
	// 		// ルート検索の結果を地図上に描画
	// 		directionsRenderer.setMap(map);
	// 		directionsRenderer.setDirections(response); 
	// 	}
	// });


	// --------------



	// // ルート検索実行
	// var calcRoute = function() {	
	// 	// 経由地の配列を生成
	// 	var wayPoints = new Array();
	// 	wayPoints.push({location: '東京タワー'});
	// 	wayPoints.push({location: 'スカイツリー'});
	// 	wayPoints.push({location: '池袋サンシャインビル'});
	// 	wayPoints.push({location: '東京都庁'});
	// 	wayPoints.push({location: 'お台場'});

	// 	// DirectionsService生成
	// 	var directionsService = new google.maps.DirectionsService();

	// 	// DirectionｓRenderer生成
	// 	var directionsRenderer = new google.maps.DirectionsRenderer();
	// 	directionsRenderer.setPanel(document.getElementById('route-panel'));
	// 	directionsRenderer.setMap(_map);

	// 	// ルート検索実行
	// 	directionsService.route({
	// 		origin: 'マルティスープ',  // 出発地
	// 		destination: '六本木ヒルズ',  // 到着地
	// 		avoidHighways: true, // 高速は利用しない
	// 		travelMode: google.maps.TravelMode.DRIVING, // 車モード
	// 		optimizeWaypoints: true, // 最適化を有効
	// 		waypoints: wayPoints // 経由地
	// 	}, function(response, status) {
	// 		console.log(response);
	// 		if (status === google.maps.DirectionsStatus.OK) {
	// 			directionsRenderer.setDirections(response);
	// 			var legs = response.routes[0].legs;
				
	// 			// 総距離と総時間の合計する
	// 			var dis = 0;
	// 			var sec = 0;
	// 			$.each(legs, function(i, val) {
	// 				sec += val.duration.value;
	// 				dis += val.distance.value;
	// 			});
	// 			console.log("distance=" + dis + ", secound=" + sec);
	// 		} else {
	// 			alert('Directions 失敗(' + status + ')');
	// 		}
	// 	});	
	// };

	// calcRoute();

	// --------------

	// function initMap() {
	// const directionsService = new google.maps.DirectionsService();
	// const directionsRenderer = new google.maps.DirectionsRenderer();
	// const map = new google.maps.Map(document.getElementById("map"), {
	// 	zoom: 6,
	// 	center: { "lat": 35.391028,"lng": 136.7234769 },
	// });

	// directionsRenderer.setMap(map);
	// document.getElementById("submit").addEventListener("click", () => {
	// 	calculateAndDisplayRoute(directionsService, directionsRenderer);
	// });
	// }

	// function calculateAndDisplayRoute(directionsService, directionsRenderer) {
	// const waypts = [];
	// const checkboxArray = [];
	// const checkboxArray = document.getElementById("waypoints");

	// for (let i = 0; i < checkboxArray.length; i++) {
	// 	if (checkboxArray.options[i].selected) {
	// 	waypts.push({
	// 		location: checkboxArray[i].value,
	// 		stopover: true,
	// 	});
	// 	}
	// }

	// directionsService
	// 	.route({
	// 	origin: document.getElementById("start").value,
	// 	destination: document.getElementById("end").value,
	// 	waypoints: waypts,
	// 	optimizeWaypoints: true,
	// 	travelMode: google.maps.TravelMode.DRIVING,
	// 	})
	// 	.then((response) => {
	// 	directionsRenderer.setDirections(response);

	// 	const route = response.routes[0];
	// 	const summaryPanel = document.getElementById("directions-panel");

	// 	summaryPanel.innerHTML = "";

	// 	// For each route, display summary information.
	// 	for (let i = 0; i < route.legs.length; i++) {
	// 		const routeSegment = i + 1;

	// 		summaryPanel.innerHTML +=
	// 		"<b>Route Segment: " + routeSegment + "</b><br>";
	// 		summaryPanel.innerHTML += route.legs[i].start_address + " to ";
	// 		summaryPanel.innerHTML += route.legs[i].end_address + "<br>";
	// 		summaryPanel.innerHTML += route.legs[i].distance.text + "<br><br>";
	// 	}
	// 	})
	// 	.catch((e) => window.alert("Directions request failed due to " + status));
	// }

	// window.initMap = initMap;

	// --------------


</script>

