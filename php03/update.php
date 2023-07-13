<?php

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

$name   = $_POST['name'];
$email  = $_POST['email'];
$age    = $_POST['age'];
$content = $_POST['content'];
$id = $_POST['id'];

try {
    $db_name = 'gs_db3'; 
    $db_id   = 'root'; 
    $db_pw   = ''; 
    $db_host = 'localhost'; 
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

$stmt = $pdo->prepare('UPDATE gs_an_table
                     SET name = :name,
                         email = :email,
                         age = :age,
                         content = :content,
                         indate = sysdate()
                     WHERE  id = :id;');
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':age', $age, PDO::PARAM_INT);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// このSQLインジェクションがあるため、関数ではなく、文字列で処理される。
// var_dump($status); exit();
// ここで処理が終わるようになる。

// STR=文字   INT=数字　

$result = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    header('Location: select.php');
    exit();
}

?>
