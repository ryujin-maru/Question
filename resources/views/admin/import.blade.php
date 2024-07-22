<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            問題インポート
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg font-main">
                <div class="p-6 text-gray-900">
                    <div class=" mb-6">
                        @if(session('success'))
                        <p class="text-green-400">{{session('success')}}</p>
                        @endif

                        <p class="mt-4">サンプル　→　<a href="{{asset('Question.csv')}}" download="sample.csv" class="text-blue-500 border-b border-blue-400">download</a></p>

                        @error('import')
                            <p>{{$message}}</p>
                        @enderror
                        <form method="post" action="{{route('admin.handle')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="import" class="mt-8" accept=".csv" required><br>
                            <input type="submit" class="bg-yellow-400 text-white px-8 py-2 rounded-md mt-10 hover:cursor-pointer" value="送信">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>