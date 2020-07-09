<?php
session_start();
include('functions.php');
check_session_id();

//DB接続の設定
$pdo = connect_to_db();

$user_id = $_SESSION["id"];
$user_name = $_SESSION["name"];
$user_status = $_SESSION["status"];

//statusによる振り分け
if ($user_status == 1) {
    $timer = 1;
} else {
    $timer = 0;
}
// var_dump($timer);
// exit();

//入室時間と退室時間
$sql = 'SELECT * FROM inout_table LEFT OUTER JOIN users_table ON inout_table.user_id = users_table.id WHERE user_id = :user_id ORDER BY inout_table DESC';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    $intime = $record["in_time"];
    $outtime = date("H:i:s", strtotime($intime . "+2 hour"));
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Roboto+Mono:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <title>入店している場合のホーム画面</title>
</head>

<body>
    <header>
        <p id="name"><?= $user_name ?>様</p>
        <a href="mypage.php"><img id="mypage" src="image/mypage.png"></a>
    </header>
    <div class="limit">
        <table class="table_box">
            <tr>
                <th>入室時間</th>
                <th>退室時間</th>
            </tr>
            <tr>
                <td class="time"><?= $intime ?></td>
                <td class="time"><?= $outtime ?></td>
            </tr>
        </table>
        <p>※退室時間から10分経過すると延長料金が発生します。</p>
        <!-- 残りパーセンテージ表示 -->
        <div id="timer"></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="pietimer/jquery.pietimer.js"></script>
    <script type="text/javascript">
        if (<?= $timer ?> == 1) {
            $(function() {
                $('#timer').pietimer({
                    timerSeconds: 7200, //時間の設定（2時間）
                    color: '#00bfff',
                    fill: false, //円周をなぞる
                    showPercentage: true, //パーセンテージの表示
                    callback: function() {
                        alert("2時間経過しました、退出してください。10分以内に延長料金が発生します"); //時間経過したらアラート
                        $('#timer').pietimer('reset');
                    }
                });
            });
        }

        // function getNow() {
        //     var hour = now.getHours();
        //     var min = now.getMinutes();
        //     var sec = now.getSeconds();

        //     if (hour < 10) {
        //         hour = "0" + hour;
        //     }
        //     if (min < 10) {
        //         min = "0" + min;
        //     }
        //     if (sec < 10) {
        //         sec = "0" + sec;
        //     }

        //     //出力用
        //     var s = hour + ":" + min + ":" + sec;
        //     return s
        // }

        // var diffTime = <?= $outtime ?> - getNow();
        // var diffSecond = Math.floor(diffTime / (1000));
    </script>
</body>

</html>