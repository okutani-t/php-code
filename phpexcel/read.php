<?php

require __DIR__ . '/vendor/autoload.php';

$filename = 'test.xlsx';
$filepath = __DIR__ . '/' . $filename;
try {
    $book = PHPExcel_IOFactory::load($filepath);
} catch (Exception $e) {
    die('Error loading file "' . pathinfo($filepath, PATHINFO_BASENAME) . '": ' . $e->getMessage());
}

echo 'シートの数: '. $book->getSheetCount() . PHP_EOL;
echo 'Sheet name1: ' . $book->getSheetNames()[0] . PHP_EOL;
echo 'Sheet name2: ' . $book->getSheetNames()[1] . PHP_EOL;

$book->setActiveSheetIndex(0);
$sheet1 = $book->getActiveSheet()->toArray(null, true, true, true);
$book->setActiveSheetIndex(1);
$sheet2 = $book->getActiveSheet()->toArray(null, true, true, true);

echo 'name1: '  . $sheet1[3]['A'] . PHP_EOL;
echo 'name2: '  . $sheet2[3]['A'] . PHP_EOL;
echo 'score1: ' . $sheet1[1]['D'] . PHP_EOL;
echo 'score2: ' . $sheet2[1]['D'] . PHP_EOL;
