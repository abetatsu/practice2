<?php

$link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

if (!$link) {
     echo 'データベースに接続できませんでした' . PHP_EOL;
     echo 'Debugging Error: ' . mysqli_connect_error() . PHP_EOL;
}
echo 'データベースに接続できました' . PHP_EOL;

$sql = 'SELECT name, founder FROM companies';
$results = mysqli_query($link, $sql);

while ($company = mysqli_fetch_assoc($results)) {
     echo '会社名：' . $company['name'] . PHP_EOL;
     echo '代表者名：' . $company['founder'] . PHP_EOL;
}

mysqli_free_result($results);

// $sql =<<<EOT
// INSERT INTO companies (
//      name,
//      establishment_date,
//      founder
// ) VALUES (
//      'SmartHR Inc',
//      '2013-01-23',
//      'Shoji Miyata'
// )
// EOT;

// $result = mysqli_query($link, $sql);
// if ($result) {
//      echo 'データが登録されました' . PHP_EOL;
// } else {
//      echo 'データの登録に失敗しました' . PHP_EOL;
// }


mysqli_close($link);
echo 'データベースと切断しました' . PHP_EOL;
