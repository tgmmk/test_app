<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('m10') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

					<form class="w-full" action="/pickup_place" method="get" id="search" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="mst_place_id" id="mst_place_id" value="">
					@csrf
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
							<div class="w-1/6 md:w-2/12">
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="place_name">場所名</label>
							</div>
							<div class="w-2/6 md:w-4/12">
								<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="place_name" name="place_name" type="text" value="{{ $place_name }}">
							</div>
							<div class="w-1/6 md:w-2/12">
								<label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 p-4" for="address">住所</label>
							</div>
							<div class="w-2/6 md:w-4/12">
								<input class=" appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" id="address" name="address" type="text" value="{{ $address }}">
							</div>
						</div>
						<div class="flex justify-center md:items-center py-6">
							<div class="w-1/2 md:w-1/6 text-center">
								<a href="/pickup_place"><button class="shadow bg-gray-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold w-11/12 py-1 rounded" type="button">クリア</button></a>
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
												<th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase">場所名</th>
												<th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase">お子さま名</th>
											<th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase">住所</th>
											<th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase">GOOGLE地点登録</th>
											<th scope="col" class="px-6 py-3 text-end text-xs font-medium uppercase">編集</th>
											</tr>
										</thead>
										<tbody>
											@foreach($data as $k)
												<tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
													<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $k->place_name }}</td>
													<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{$k->name}}</td>
													<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{$k->address}}</td>
													<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{!! $k->locate_flg !!}</td>
													<td class="px-4 py-2 whitespace-nowrap text-end text-sm font-medium">
														<button type="button" data-id="{{$k->id}}" class="editBtn py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-500 text-white hover:bg-gray-600 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">管理</button>
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
			//選択したデータ
			var mst_place_id = $(this).data('id');
			$('#mst_place_id').val(mst_place_id);
			//検索フォームの行き先を変更
			$('#search').attr('action', '/pickup_place/edit/'+mst_place_id);

			$('#search').submit();

		});

	});

</script>