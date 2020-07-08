<?php
session_start();
include('functions.php');
check_session_id();

//DB接続の設定
$pdo = connect_to_db();

$user_name = $_SESSION["name"];

//入店者数のカウント
$sql = "SELECT COUNT(status) FROM users_table WHERE status = 1";

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}

$in_people = $record;
// var_dump($in_people);
// exit;

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/not_home.css">
    <title>入店していない場合のホーム画面</title>
</head>

<body>
    <header>
        <p id="name"><?= $user_name ?>様</p>
        <a href="mypage.php"><img id="mypage" src="image/mypage.png"></a>
    </header>
    <fieldset>
        <legend>現在の入店者数</legend>
        <p><?= $in_people["COUNT(status)"] ?>人</p>
    </fieldset>

</body>

</html>