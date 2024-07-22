@props([
    'val' => '次の問題へ',
])

<input type="submit" value="{{$val}}" onclick="hide(this)" {{$attributes->merge(['class' => "text-gray-50 rounded-md px-10 py-3 hover:cursor-pointer btn"]) }}>