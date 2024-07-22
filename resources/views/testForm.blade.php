<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon"  href="{{ asset('cropped-logo.ico') }}">
    <title>Document</title>
</head>
<body>
    <div style="margin-top:100px;">
        <form method="post" action="http://127.0.0.1:8000/index">
        <input class="enter val" type="number" name="idno" size="30" id="user_id" value="8888888">
        <input class="enter val" type="mail" name="email" id="e-mail" value="test@test.com">
        <input type="text" class="enter val" name="name" id="user_name" size="30" value="テストです">
        <input type="text" class="enter val" id="simeif" name="name_kana" size="30" value="テストデス">
        <div class="input-box">
                    <div class="input">
                    <select class="val" id="select" name="position">
                    <option value="posessions">--ポジションを選択してください--</option>
                    <option value="MA" selected>顧客・MA</option>
                    <option value="AD">AD</option>
                    <option value="BAD">BAD</option>
                    <option value="MG">MG・LMG</option>
                    <option value="その他">その他</option>
                    <!-- <option value="TH">TH</option>
                    <option value="GE">GE・GC</option> -->
                    </select>
                    </div>
                </div>
            <input type="submit" value="送信">
        </form>


    </div>

    <script>
        console.log(sessionStorage.getItem('hoge'));
    </script>
</body>
</html>