<?php
session_start();
include('functions.php');
check_session_id();

//DB接続の設定
$pdo = connect_to_db();

$user_name = $_SESSION["name"];
$status = $_SESSION["status"];

//statusによる振り分け
if ($status == 1) {
    $timer = 1;
} else {
    $timer = 0;
}
// var_dump($timer);
// exit();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <title>ホーム画面</title>
</head>

<body>
    <header>
        <p><?= $user_name ?>様</p>
        <img src="image/setting.png">

    </header>
    <div id="timer"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="pietimer/jquery.pietimer.js"></script>
    <script type="text/javascript">
        if (<?= $timer ?> == 1) {
            $(function() {
                $('#timer').pietimer({
                    timerSeconds: 20, //時間の設定（2時間）
                    color: '#00bfff',
                    fill: false, //円周をなぞる
                    showPercentage: true, //パーセンテージの表示
                    callback: function() {
                        alert("2時間経過しました、退出してください。10分以内に延長料金が発生します"); //時間経過したらアラート
                        $('#timer').pietimer('reset');
                    }
                });
            });
        } else {}
    </script>
</body>

</html>