<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            問題情報
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg font-main">
                <div class="p-6 text-gray-900">
                    <form method="post" id="form1" action="{{route('admin.delete')}}">
                        @csrf
                        <div class="text-right mb-4">
                            <input type="hidden" name="year" value="{{$select}}">
                            <input type="submit" id="delete" class="bg-yellow-300 px-5 py-2 text-red-600 font-bold hover:cursor-pointer text-sm" value="{{$select}}年問題全削除">
                        </div>
                    </form>
                    <div class="flex items-center justify-between mb-6">
                        
                        <h1 class="text-lg">問題</h1>
                        <button id="btn" class="bg-red-300 px-8 py-2 text-white">更新</button>
                        @if(session('success'))
                        <p class="text-green-400">{{session('success')}}</p>
                        @endif

                        <form method="get" action="{{route('admin.question')}}">
                            <select class="cursor-pointer" name="sort" id="year">
                            @foreach ($displays as $display)
                            <option value="{{$display->year}}" @if(\Request::get('sort') == $display->year || $select == $display->year) selected @endif>{{$display->year}}年度</option>
                            @endforeach
                            </select>
                            {{-- <select class="cursor-pointer" name="sort" id="year">
                                <option value="all" @if(\Request::get('sort') === 'all') selected @endif>全て</option>
                                <option value="2023" @if(\Request::get('sort') === '2023') selected @endif>2023年</option>
                                <option value="2024" @if(\Request::get('sort') === '2024') selected @endif>2024年</option>
                                <option value="2025" @if(\Request::get('sort') === '2025') selected @endif>2025年</option>
                            </select> --}}
                        </form>
                    </div>
                    <form method="post" action="{{route('admin.sort')}}">
                        <div id="taskList">
                            @csrf
                            <input type="hidden" name="year" id="form" value="{{$select}}"/>
                            @foreach ($questions as $question)
                                <div class="bg-gray-100 mb-4 rounded-md p-4" data-id="{{$question->id}}">
                                    <div class="flex">
                                        <p class="text-gray-400">{{$question->year}}年</p>
                                        <p class="text-gray-500 ml-4">問{{$question->num}}</p>
                                    </div>
                                    <p>{{$question->question}}</p>
                                    <div class="text-right mr-8">
                                        <a href="{{route('admin.edit',['id' => $question->id])}}" class="cursor-pointer hover:opacity-60 text-blue-500 font-bold">詳細</a>
                                    </div>
                                    <input type="hidden" name="id[][name]" value="" class="inputs">
                                </div>
                            @endforeach
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

<script>
    const year = document.getElementById('year');
    year.addEventListener('change',() => {
        year.form.submit();
    });

    var taskList = document.getElementById('taskList');
    Sortable.create(taskList, {
    animation: 150,
    onEnd: function (/**Event*/ evt) {
        var itemEl = evt.item;
        // console.log(itemEl.dataset.id);
    },
    });

    var btn = document.getElementById('btn');
        
    var inputs = document.querySelectorAll('.inputs');
    btn.addEventListener('click',() => {
        inputs.forEach((input,index) => {
            input.value = index + 1;
        });
        document.getElementById('form').form.submit();
    });

    const del = document.getElementById('form1');

    del.addEventListener('submit',(e) => {
        var result = confirm('本当に削除しますか？');

        if(!result) {
            e.preventDefault();
        }
    })


</script>
</x-app-layout>