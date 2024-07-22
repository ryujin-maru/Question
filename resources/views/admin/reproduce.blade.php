<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            問題出力・問題複写
        </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="POST" action="{{route('admin.output')}}">
                    @csrf
                    <div class="flex items-center">
                        <p class="mr-5">CSV 出力年度</p>
                        <select name="year">
                            @foreach ($years as $year)
                            <option value="{{$year->year}}">{{$year->year}}年度</option>
                            @endforeach
                        </select>
                        <input type="submit" class="text-white px-8 py-2 ml-5 hover:cursor-pointer bg-red-400 hover:shadow-none" value="出力">
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-8">
            <div class="p-6 text-gray-900">
                @if(session('reproduce'))
                <p class="text-green-400">{{session('reproduce')}}</p>
                @endif
                <form method="post" action="{{route('admin.copy')}}">
                    @csrf
                    <div class="flex items-center">
                        <p class="mr-5">複写元</p>
                        <select name="output">
                            @foreach ($years as $year)
                            <option value="{{$year->year}}">{{$year->year}}年度</option>
                            @endforeach
                        </select>
                        <p class="text-xl ml-5 mr-5">→</p>
                        <p class="mr-5">複写先</p>
                        <select class="mr-5" name="copy">
                        @foreach ($years as $year)
                        <option value="{{$year->year}}">{{$year->year}}年度</option>
                        @endforeach
                        </select>
                        <input type="submit" class="text-white px-8 py-2 ml-5 hover:cursor-pointer bg-red-400 hover:shadow-none" value="複写">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>