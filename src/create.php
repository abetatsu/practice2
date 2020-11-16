<?php

require_once __DIR__ . '/lib/mysqli.php';



function createReview($link, $review)
{
     $createReviewSql = <<<EOT
     INSERT INTO reviews (
          title,
          author,
          status,
          score,
          summary
     ) VALUES (
          "{$review['title']}",
          "{$review['author']}",
          "{$review['status']}",
          "{$review['score']}",
          "{$review['summary']}"
     );
EOT;
     $result = mysqli_query($link, $createReviewSql);
     if (!$result) {
          error_log('Error: fail to create review');
          error_log('Debugging Error: ' . mysqli_error($link));
     }
}

function validate($review)
{
     $errors = [];

     if (empty($review['title'] || strlen($review['title']) > 255))
     {
          $errors['title'] = '書籍名を255文字以下で入力してください';
     }

     if (empty($review['author'] || strlen($review['author']) > 100))
     {
          $errors['author'] = '著者名を100文字以下で入力してください';
     }

     if (!in_array($review['status'], ['読了', '読んでる', '未読']))
     {
          $errors['status'] = '読書状況は読了、読んでる、未読の中から選んでください';
     }

     if ($review['score'] < 1 || $review['score'] > 5)
     {
          $errors['score'] = '評価は1~5の数字の中から選択してください';
     }

     if (empty($review['summary'] || strlen($review['summary']) > 1000))
     {
          $errors['summary'] = '著者名を1000文字以下で入力してください';
     }

     return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     $status = '';
     if (array_key_exists('status', $_POST))
     {
          $status = $_POST['status'];
     }

     $review = [
          'title' => $_POST['title'],
          'author' => $_POST['author'],
          'status' => $status,
          'score' => $_POST['score'],
          'summary' => $_POST['summary'],
     ];

     $errors = validate($review);
     if (!$errors) {
          $link = dbConnect();
          createReview($link, $review);
          mysqli_close($link);
          header('Location: index.php');
     }
}

$title = '読書ログ登録';
$content = __DIR__ . "/views/new.php";
include __DIR__ . '/views/layout.php';
