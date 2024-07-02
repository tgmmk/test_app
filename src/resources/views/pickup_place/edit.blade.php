

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script>

// $(function () {
	/**
	 * @license
	 * Copyright 2019 Google LLC. All Rights Reserved.
	 * SPDX-License-Identifier: Apache-2.0
	 */
	let map;
	let marker;
	let geocoder;
	let responseDiv;
	let response;

	function initMap() {
		map = new google.maps.Map(document.getElementById("map"), {
			zoom: 14,
			// center: { lat: -34.397, lng: 150.644 },
			center: { "lat": 35.391028,"lng": 136.7234769 },
			mapTypeControl: false,
		});
		geocoder = new google.maps.Geocoder();

		const inputText = document.createElement("input");

		inputText.type = "text";
		inputText.id = "geo_input_txt";
		inputText.placeholder = "住所を入力してください";

		const submitButton = document.createElement("input");

		submitButton.type = "button";
		submitButton.value = "取得";
		submitButton.classList.add("button", "geo_button");
		submitButton.classList.add("button", "button-primary");

		const clearButton = document.createElement("input");
        clearButton.type = "button";
        clearButton.value = "Clear";
        clearButton.classList.add("button", "button-secondary");
        response = document.createElement("pre");
        response.id = "response";
        response.innerText = "";
        responseDiv = document.createElement("div");
        responseDiv.id = "response-container";
        responseDiv.appendChild(response);
		clearButton.type = "button";
		clearButton.value = "Clear";
		clearButton.classList.add("button", "geo_button");
		clearButton.classList.add("button", "button-secondary");
		response = document.createElement("pre");
		response.id = "response";
		response.innerText = "";
		responseDiv = document.createElement("div");
		responseDiv.id = "response-container";
		responseDiv.appendChild(response);

		// const instructionsElement = document.createElement("p");

		// instructionsElement.id = "instructions";
		// instructionsElement.innerHTML =
		// 	"↑に住所を入力してください。";
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputText);
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(submitButton);
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(clearButton);
		// map.controls[google.maps.ControlPosition.RIGHT_TOP].push(
		// 	instructionsElement
		// );
		map.controls[google.maps.ControlPosition.LEFT_TOP].push(responseDiv);
		marker = new google.maps.Marker({
			map,
		});
		map.addListener("click", (e) => {
			geocode({ location: e.latLng });
		});
		submitButton.addEventListener("click", () =>
			geocode({ address: inputText.value })
			);
			clearButton.addEventListener("click", () => {
			clear();
		});
		clear();
	}

	function clear() {
	marker.setMap(null);
	}

	function geocode(request) {
	clear();
	geocoder
		.geocode(request)
		.then((result) => {
			const { results } = result;
			// console.log('結果');
			// console.log(results[0].geometry.location.lng);
			map.setCenter(results[0].geometry.location);
			marker.setPosition(results[0].geometry.location);
			marker.setMap(map);
			response.innerText = JSON.stringify(result, null, 2);
			// 登録用エリアに住所をセット
			var result_address = document.getElementById('result_address');
			var formatted_address = results[0].formatted_address;
			result_address.value = formatted_address;
			// 登録用エリアに結果のjsonをセット
			var result_json = document.getElementById('result_json');
			result_json.value = response.innerText;
		})
		.catch((e) => {
			// ele.style.visibility = 'visible';
			var err_html = '<div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">';
            err_html +=    '<div id="dismiss-alert2" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert">';
            err_html +=        '<div class="flex">';
            err_html +=            '<div class="flex-shrink-0">';
            err_html +=            '<svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>                        </div>';
            err_html +=            '<div class="ms-2">';
            err_html +=            '<div class="text-sm font-medium">';
            err_html +=                "次の理由により、住所検索は成功しませんでした: ";
            err_html +=                e;
            err_html +=            '</div>';
            err_html +=            '</div>';
            err_html +=            '<div class="ps-3 ms-auto">';
            err_html +=            '<div class="-mx-1.5 -my-1.5">';
            err_html +=                '<button type="button" class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600 dark:bg-transparent dark:hover:bg-teal-800/50 dark:text-red-600" data-hs-remove-element="#dismiss-alert2">';
            err_html +=                '<button type="button" class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600 dark:bg-transparent dark:hover:bg-teal-800/50 dark:text-red-600" data-hs-remove-element="#dismiss-alert2">';
            err_html +=                '<button type="button" class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600 dark:bg-transparent dark:hover:bg-teal-800/50 dark:text-red-600" data-hs-remove-element="#dismiss-alert2">';
            err_html +=                '<span class="sr-only">Dismiss</span>';
            err_html +=                '<svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>';
            err_html +=                '</button>';
            err_html +=            '</div>';
            err_html +=            '</div>';
            err_html +=        '</div>';
            err_html +=    '</div>';
            err_html +='</div>';
			document.getElementById("flash_area").innerHTML = err_html;
			// document.getElementById("flash_area").appendChild(err_html);
			// document.getElementById("response-container").remove();
		// alert("次の理由により、住所検索は成功しませんでした: " + e);
		});
	}

	window.initMap = initMap;

// });
</script>

<x-app-layout>

	<div id="flash_area"></div>

    <x-slot name="header">
		<div class="flex justify-between items-center justify-center">
			<h2 class="midashi_title font-semibold text-xl text-gray-800 leading-tight ">
				{{ __('m11') }}
			</h2>
			<div class="modoru">
				<a href="/pickup_place"><button type="button" class="py-1 px-5 inline-flex items-center gap-x-2 text-sm font-semibold rounded-md border border-transparent bg-gray-400 text-white hover:bg-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-500">戻る</button></a>
			</div>
		</div>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

				<form class="w-full" action="/pickup_place/update" method="post" id="update" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="mst_place_id" id="mst_place_id" value="{{ $data->id }}">
					<input type="hidden" name="result_json" id="result_json" value="">
					@csrf
					<div class="flex md:items-center mb-3">
						<div class="w-1/6 md:w-2/12">
							<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="student_name">お子さま氏名</label>
						</div>
						<div class="w-2/6 md:w-4/12">
							<input class="disabled bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="student_name" name="student_name" type="text" value="{{ $data->name }}" disabled>
						</div>
						<div class="w-1/6 md:w-2/12">
							<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="place_name">場所名</label>
						</div>
						<div class="w-2/6 md:w-4/12">
							<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="place_name" name="place_name" type="text" value="{{ $data->place_name }}">
						</div>
					</div>
					<div class="flex md:items-center mb-3">
						<div class="w-1/6 md:w-2/12">
							<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="address">住所</label>
						</div>
						<div class="w-2/6 md:w-6/12">
							<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="address" name="address" type="text" value="{{ $data->address }}">
						</div>
					</div>
					<div class="flex md:items-center mb-3">
						<div class="w-1/6 md:w-2/12">
							<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="formatted_address">Google地点登録住所</label>
						</div>
						<div class="w-2/6 md:w-6/12">
							<input class="disabled bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="formatted_address" name="formatted_address" type="text" value="{{ $data->formatted_address }}" disabled>
						</div>
					</div>
					<div class="flex md:items-center mb-3">
						<div class="w-1/6 md:w-2/12">
							<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="result_address">検索結果</label>
						</div>
						<div class="w-2/6 md:w-6/12">
							<input class="disabled bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight" id="result_address" name="result_address" type="text" value="" disabled>
						</div>
						<div class="w-3/6 md:w-4/12 p-4">
							<label class=" block text-gray-500 font-bold">
								<input class="mr-2 leading-tight" type="checkbox" name="update_result_flg"><span class="text-sm">※経路検索用住所として保存する</span>
							</label>
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

				<div id="map" style="height: 400px;"></div>
				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjDxKLUxy3fQYmwEX61Vep-X7qFnno0KA&callback=initMap&v=weekly&solution_channel=GMP_CCS_geocodingservice_v1&language=ja" defer></script>
				<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEOVF6B4i4gTX0ueXjV_ohVqqNOqzcpXI&callback=initMap&v=weekly&solution_channel=GMP_CCS_geocodingservice_v1" defer></script> -->

                </div>
            </div>
        </div>
    </div>

</x-app-layout>