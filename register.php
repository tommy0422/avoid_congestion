<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <style>
        .box {
            width: 320px;
            height: 500px;
        }
    </style>
    <title>新規会員登録画面</title>
</head>

<body>
    <div class="box">
        <img src="image/logo.png" class="logo">
        <h1>新規会員登録</h1>
        <form class="" action="register_read.php" method="POST">
            <p>Felica-ID</p>
            <input type="text" name="id" placeholder="発行されたFelica-IDを入力">
            <p>名前</p>
            <input type="text" name="name" placeholder="あなたの名前を入力してください">
            <p>新しいパスワード</p>
            <input type="password" name="pass" placeholder="パスワードを入力してください">
            <input type="submit" name="" value="新規登録">
            <a href="login.php">戻る</a>
        </form>
    </div>

</body>

</html>