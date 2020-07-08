<?php
session_start();
include('functions.php');
check_session_id();

//DB接続の設定
$pdo = connect_to_db();

$user_id = $_SESSION["id"];
$user_name = $_SESSION["name"];
$user_status = $_SESSION["status"];

//トレーニング履歴はここから
//今までの入室時間と退室時間の取り出し
$sql = 'SELECT * FROM inout_table LEFT OUTER JOIN users_table ON inout_table.user_id = users_table.id WHERE user_id = :user_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    // var_dump($result);
    // exit();
    $output = "";
    // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<th>{$record["date"]}</th>";
        $output .= "<th>{$record["in_time"]}</th>";
        $output .= "<th>{$record["out_time"]}</th>";
        $output .= "<tr>";
    }

    // var_dump($record);
    // exit();

    // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($record);
}

//戻るボタンの場合分け
if ($user_status == 1) {
    $return = "home.php";
} else {
    $return = "not_home.php";
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/mypage.css">
    <title>マイページ</title>
</head>

<body>
    <header>
        <p id="name"><?= $user_name ?>様</p>
        <a href="<?= $return ?>">
            <p id="return">戻る ▶︎</p>
        </a>
    </header>
    <p>【トレーニング履歴】</p>
    <table>
        <tr>
            <td>日にち</td>
            <td>入室時間</td>
            <td>退室時間</td>
        </tr>
        <?= $output ?>
    </table>
    <div id="logout"><a href="login.php" class="btn-circle-border-double">ログアウト</a></div>
</body>

</html>