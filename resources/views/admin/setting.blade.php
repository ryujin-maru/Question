<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            設定
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg font-main">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                    <p class="text-green-400">{{session('success')}}</p>
                    @endif
                    {{-- @php
                        dd($year);
                    @endphp --}}
                    <form method="post" action="{{route('admin.year_up')}}">
                        @csrf
                        表示年度
                        <select name="year">
                            @foreach ($displays as $display)
                            <option value="{{$display->year}}" @if($year->year === $display->year) selected @endif>{{$display->year}}年度</option>
                            @endforeach
                            {{-- <option value="2023" @if($year->year == '2023') selected @endif>2023年度</option>
                            <option value="2024"  @if($year->year == '2024') selected @endif>2024年度</option>
                            <option value="2025"  @if($year->year == '2025') selected @endif>2025年度</option>
                            <option value="2026"  @if($year->year == '2026') selected @endif>2026年度</option> --}}
                        </select>
                        <br><br>
                        <p>表示問題数(5の倍数のみ有効)</p>
                        <input type="number" name="number" value="{{$year->number}}"><br><br>
                        <p>間違い数{{$year->correct}}以下で合格</p>
                        <input type="number" name="correct" value="{{$year->correct}}"><br><br>

                        <input type="submit" name="submit" value="変更" class="bg-yellow-200 px-8 py-2 hover:cursor-pointer">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>