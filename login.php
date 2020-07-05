<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>ログイン画面</title>
</head>

<body>
    <div class="box">
        <img src="image/logo.png" class="logo">
        <h1>ログイン</h1>
        <form class="" action="login_read.php" method="POST">
            <p>Felica-ID</p>
            <input type="text" name="id" placeholder="あなたのFelica-IDを入力">
            <p>パスワード</p>
            <input type="password" name="pass" placeholder="パスワードを入力してください">
            <input type="submit" value="ログイン">
            <a href="register.php">新規会員登録</a>
        </form>
    </div>

</body>

</html>