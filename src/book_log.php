<?php

function createReview()
{
     echo '読書ログを登録してください' . PHP_EOL;

          echo '書籍名：';
          $title = trim(fgets(STDIN));

          echo '著者名：';
          $author = trim(fgets(STDIN));

          echo '読書状況(未読,読んでいる,読了)：';
          $status = trim(fgets(STDIN));

          echo '評価(5点満点の整数)：';
          $score = trim(fgets(STDIN));

          echo '感想：';
          $summary = trim(fgets(STDIN));

          echo '登録が完了しました' . PHP_EOL . PHP_EOL;

          return [
               'title' => $title,
               'author' => $author,
               'status' => $status,
               'score' => $score,
               'summary' => $summary,
          ];

}

function showReviews($reviews)
{
     foreach($reviews as $review) {
          echo '読書ログを表示します' . PHP_EOL;
          echo '書籍名：' . $review['title'] . PHP_EOL;
          echo '著者名：' . $review['author'] . PHP_EOL;
          echo '読書状況(未読,読んでいる,読了)：' . $review['status'] . PHP_EOL;
          echo '評価(5点満点の整数)：' . $review['score'] . PHP_EOL;
          echo '感想：' . $review['summary'] . PHP_EOL . PHP_EOL;
          echo '-------------' . PHP_EOL;
     }
}

$reviews = [];

while (true) {
     echo '1. 読書ログを登録する' . PHP_EOL;
     echo '2. 読書ログを表示する' . PHP_EOL;
     echo '9. 終了する' . PHP_EOL;
     echo '番号を選択してください(1,2,9)：';
     $num = trim(fgets(STDIN));

     if ($num === '1') {
          $reviews[] = createReview();
     } elseif ($num === '2') {
          showReviews($reviews);
     } elseif ($num === '9') {
     break;
     }
}
