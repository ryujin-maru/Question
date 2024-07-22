<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ユーザー情報詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg font-main">
                <div class="p-6 text-gray-900">
                    <div class=" mb-6">
                        <a href="#" onclick="history.back()" class="hover:opacity-60 text-blue-500">＜＜戻る</a>

                        </div>
                        <div class="flex justify-center">
                            <div class="w-[80%]">
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">id</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">{{$user->id}}</p>
                                </div>
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">会員番号</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">{{$user->idno}}</p>
                                </div>
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">名前</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">{{$user->name}}</p>
                                </div>
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">名前(カナ)</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">{{$user->name_kana}}</p>
                                </div>
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">ポジション</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">{{$user->position}}</p>
                                </div>
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">メールアドレス</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">{{$user->email}}</p>
                                </div>
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">現在回答問題</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">{{$user->counter}}</p>
                                </div>
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">回答数</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">{{$user->already}}</p>
                                </div>
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">合否</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">@if($user->pass_fail == 0)試験中@elseif($user->pass_fail == 1)不合格@else合格@endif</p>
                                </div>
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">作成日</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">{{$user->created_at}}</p>
                                </div>
                                <div class="flex mb-1">
                                    <p class="flex-[1] text-center bg-gray-100 p-3 rounded-md mr-1 text-gray-500">修正日</p>
                                    <p class="flex-[3] text-center bg-gray-100 p-3 rounded-md text-gray-500">{{$user->updated_at}}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>