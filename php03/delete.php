<?php
$id = $_GET['id'];

try {
    $db_name = 'gs_db3'; 
    $db_id   = 'root'; 
    $db_pw   = ''; 
    $db_host = 'localhost'; 
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

$stmt = $pdo->prepare('DELETE FROM gs_an_table WHERE  id = :id;');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// このSQLインジェクションがあるため、関数ではなく、文字列で処理される。

// var_dump($status); exit();
// ここで処理が終わるようになる。

$result = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    header('Location: select.php');
    exit();
}

?>