<x-layout title="合否">
    @if($pass_fail == 2)
    <div class="mt-[100px] max-w-2xl w-full px-2">
        <div class="text-center">
            <h1 class="text-lg border-b border-gray-400">採点の結果、<br>90点以上の回答で「<span class="text-red-500">合格</span>」となりました。</h1>
        </div>
        <div class="md:text-center mt-5">
            <p>これにより本講習受講及び問題集の解答は終了となります。<br>
                「サプリメントコーディネーター登録証」の発送手続きに入らせて頂きます。<br>
                ご到着まで１～２週間程かかる場合がございます。いましばらくお待ちくださいませ。<br>
                今後もサプリメントにおける更なる知識向上と、健全な販売活動が行われることを
                期待しております。                       
            </p>
            <p class="text-right mt-4">JBA事務局</p>
        </div>
    </div>
    @elseif($pass_fail == 1)
    <div class="mt-[100px] max-w-2xl w-full px-2">
        <div class="text-center">
            <h1 class="text-lg border-b border-gray-400">採点の結果、<br>90点未満の回答で「<span class="text-blue-500">不合格</span>」となりました。</h1>
        </div>
        <div class="md:text-center mt-5">
            <p>再度下記のボタンから不正解問題の「解答」送信をお願い致します。</p>
        </div>

        <div>
            <form method="POST" action="{{route('user.first')}}">
                @csrf
                @method('POST')
                <div class="text-center mt-10">
                    <x-elements.button val="解答する" class="bg-red-500" />
                </div>
            </form>
        </div>
    </div>
    @endif
    
</x-layout>