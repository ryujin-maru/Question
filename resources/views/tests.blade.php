<form method="post" action="{{route('tests')}}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <input type="file" name="cor">
    <input type="file" name="cor2">
    <input type="submit" value="送信">
</form>