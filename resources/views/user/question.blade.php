<x-layout title="サプリメント検定">
    <div class="px-4 mt-8">
        <h1 class="mb-10 text-center">問題です。</h1>
        <form action="{{route('user.deal')}}" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="year" value="{{$set->year}}">
            @foreach ($data as $user)
                <div>
                    <div class="mb-10">
                        <p class="mb-2">問{{$user->num}}</p>
                        <h1 class="mb-4 font-bold">{{$user->question}}</h1>

                        @php
                        // 入力済みであれば初期値を設定
                        if(!is_null($user->answer->stock)) {
                            $answer = $user->answer->stock->select;
                        }else{
                            $answer = $user->answer->correct;
                        }
                        @endphp

                        <div>
                            <label class="block mb-2 hover:cursor-pointer"><input type="radio" name="{{$user->num}}"  value="answer_1" class="mr-1" required @if($user_detail->counter < $user_detail->already && $answer == 'answer_1') checked @endif>{{$user->answer->answer_1}}</label>

                            <label class="block mb-2 hover:cursor-pointer"><input type="radio" name="{{$user->num}}" value="answer_2" class="mr-1" required @if($user_detail->counter < $user_detail->already &&
                            $answer == 'answer_2') checked @endif>{{$user->answer->answer_2}}</label>

                            <label class="block mb-2 hover:cursor-pointer"><input type="radio" name="{{$user->num}}" value="answer_3" class="mr-1" required @if($user_detail->counter < $user_detail->already && $answer == 'answer_3') checked @endif>{{$user->answer->answer_3}}</label>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="text-center my-10 mt-20">
                {{-- 本番環境では16を96に変更 --}}
                @if($user_detail->counter >= $set->number - 4)
                <x-elements.button class="bg-blue-400 next w-2/4" val="採点する"/>
                @else
                <x-elements.button class="bg-green-400 next w-2/4" />
                @endif
            </div>
        </form>

        @if($user_detail->counter !== 1)
        <form action="{{route('user.back')}}" method="POST">
            @csrf
            @method('POST')
            <div class="text-center mb-10">
                <x-elements.button val="戻る" class="bg-red-400 back w-2/4" />
            </div>
        </form>
        @endif
    </div>
</x-layout>