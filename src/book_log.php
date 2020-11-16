<?php

function createReview($link)
{

     $review = [];

     echo '読書ログを登録してください' . PHP_EOL;

          echo '書籍名：';
          $review['title'] = trim(fgets(STDIN));

          echo '著者名：';
          $review['author'] = trim(fgets(STDIN));

          echo '読書状況(未読,読んでいる,読了)：';
          $review['status'] = trim(fgets(STDIN));

          echo '評価(5点満点の整数)：';
          $review['score'] = trim(fgets(STDIN));

          echo '感想：';
          $review['summary'] = trim(fgets(STDIN));

          $validated = validate($review);
          if (count($validated)) {
               foreach($validated as $error) {
                    echo $error . PHP_EOL;
               }
          }


          $sql =<<< EOT
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
               )
          EOT;
          $result = mysqli_query($link, $sql);
          if ($result) {
               echo '登録が完了しました' . PHP_EOL . PHP_EOL;
          } else {
               echo 'Error: 登録に失敗しました' . PHP_EOL;
               echo 'Debugging Error: ' . mysqli_error($link) . PHP_EOL . PHP_EOL;
          }
}

function showReviews($link)
{
     echo '登録されている読書ログを表示します' . PHP_EOL;

     $sql = 'SELECT title, author, status, score, summary FROM reviews';
     $results = mysqli_query($link, $sql);
     while ($review = mysqli_fetch_assoc($results)) {
               echo '読書ログを表示します' . PHP_EOL;
               echo '書籍名：' . $review['title'] . PHP_EOL;
               echo '著者名：' . $review['author'] . PHP_EOL;
               echo '読書状況(未読,読んでいる,読了)：' . $review['status'] . PHP_EOL;
               echo '評価(5点満点の整数)：' . $review['score'] . PHP_EOL;
               echo '感想：' . $review['summary'] . PHP_EOL . PHP_EOL;
               echo '-------------' . PHP_EOL;
     }
     mysqli_free_result($results);
}


function dbConnect() {
     $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
     if (!$link) {
          echo 'Error: データベースに接続できません' . PHP_EOL;
          echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
          exit;
     }

     return $link;
}


function validate($review) {

     $errors = [];

     if (!strlen($review['title'])) {
          $errors['title'] = '書籍名を入力してください';
     } elseif (strlen($review['title']) > 255) {
          $errors['title'] = '255文字以内で入力してください';
     }

     if (!strlen($review['author'])) {
          $errors['author'] = '著者名を入力してください';
     } elseif (strlen($review['author']) > 100) {
          $errors['author'] = '100文字以内で入力してください';
     }

     if (!in_array($review['status'], ['読了', '読んでいる', '未読'], true)) {
          $errors['status'] = '読書状況を読了、未読、読んでいるから入力してください';
     }

     if ($review['score'] < 1 || $review['score'] > 5) {
          $errors['score'] = '1~5の値から入力してください';
     }

     if (!strlen($review['summary'])) {
          $errors['summary'] = '感想を入力してください';
     } elseif (strlen($review['summary']) > 1000) {
          $errors['summary'] = '1000文字以内で入力してください';
     }

     return $errors;
}


$link = dbConnect();

while (true) {
     echo '1. 読書ログを登録する' . PHP_EOL;
     echo '2. 読書ログを表示する' . PHP_EOL;
     echo '9. 終了する' . PHP_EOL;
     echo '番号を選択してください(1,2,9)：';
     $num = trim(fgets(STDIN));

     if ($num === '1') {
          $reviews[] = createReview($link);
     } elseif ($num === '2') {
          showReviews($link);
     } elseif ($num === '9') {
          mysqli_close($link);
     break;
     }
}
