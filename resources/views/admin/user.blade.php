<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            試験者情報
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-right mt-4 mr-6">
                    <form method="get" id="form">
                        <select name="year" id="year">
                            <option value="all">ALL</option>
                            @foreach ($years as $year)
                                <option value="{{$year->year}}" @if(\Request::get('year') == $year->year) selected @endif>{{$year->year}}年度</option>
                            @endforeach
                        </select>
                    </form>
                    <form method="POST" action="{{route('user_csv')}}">
                        @csrf
                        <input type="hidden" name="year" value="{{\Request::get('year')}}">
                        <input type="submit" value="CSV出力" class="mt-4 px-7 py-2 border border-black bg-green-200 cursor-pointer">
                    </form>
                </div>

                <div class="p-6 text-gray-900">
                    @foreach ($users as $user)
                    
                    <div class="flex bg-gray-100 rounded-md mb-4 text-lg p-2 justify-between">
                        <p>{{$user->year}}年度</p>
                        <p>会員番号：{{$user->idno}}　　</p>
                        <p>名前：{{$user->name}}　</p>
                        <p>メールアドレス：{{$user->email}}　</p>
                        <div>
                            <a href="{{route('admin.confirm',['id' => $user->id])}}" class="mr-4 text-blue-400">詳細</a>
                        </div>  
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div>
        {{-- <button class="btn">クリック</button> --}}
    </div>

<script
src="https://code.jquery.com/jquery-3.7.1.min.js"
integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
crossorigin="anonymous"></script>
<script>
    var select = document.getElementById('year');
    var forms = document.getElementById('form');
    select.addEventListener('change',() => {
        select.form.submit();
    });

    $(function() {
        $.ajax({
            url:'http://127.0.0.1:8000/api/v_9/user/6',
            type:'GET',
            dataType:'json',
            // headers: {'X-CSRF-TOKEN':$("meta[name="csrf-token"]").atrr("content")}
        })
        .done(function(data){
            console.log(data)
        })
        .fail(function() {
            alert('失敗')
    })
    })

</script>
</x-app-layout>