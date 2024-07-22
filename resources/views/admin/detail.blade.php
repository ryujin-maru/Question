<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            問題情報詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg font-main">
                <div class="p-6 text-gray-900">
                    <div class=" mb-6">
                        <a href="#" onclick="history.back()" class="hover:opacity-60 text-blue-500">＜＜戻る</a>
                        <h1 class="font-bold text-xl mt-4">問題 {{$question->num}}</h1>
                        <div>

                        </div>
                        <div class="flex justify-center">
                            <form method="post" action="{{route('admin.update',['id' => $question->id])}}" class="w-9/12">
                                @csrf
                                <textarea class="w-full rounded-md mb-6" name="ques" rows="4">{{$question->question}}</textarea>
                                <p>解答１</p>
                                <textarea class="w-full rounded-md" name="ans1" rows="2">{{$question->answer->answer_1}}</textarea>
                                <p>解答２</p>
                                <textarea class="w-full rounded-md" name="ans2" rows="2">{{$question->answer->answer_2}}</textarea>
                                <p>解答３</p>
                                <textarea class="w-full rounded-md mb-6" name="ans3" rows="2">{{$question->answer->answer_3}}</textarea>

                                <div class="flex mb-16">
                                    <div class="mr-6">
                                        <p>正解</p>
                                        <select name="correct">
                                            <option value="answer_1" @if($question->answer->correct == 'answer_1') selected @endif>解答1</option>
                                            <option value="answer_2" @if($question->answer->correct == 'answer_2') selected @endif>解答2</option>
                                            <option value="answer_3" @if($question->answer->correct == 'answer_3') selected @endif>解答3</option>
                                        </select>
                                    </div>

                                    {{-- <div>
                                        <p>年度</p>
                                        <input type="text" name="year" value="{{$question->year}}" >
                                    </div> --}}
                                </div>

                                <div class="flex justify-center">
                                    <x-elements.button val="更新" class="bg-yellow-400 back w-2/4 hover:opacity-60" />
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>