<?php

session_start();

function h($s){
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$quizList = array(
    array(
        'q' => 'HTMLのHは何の略？',
        'a' => array('Hyper', 'Hot', 'Hi', 'Hury')
    ),
    array(
        'q' => 'HTMLのTは何の略？',
        'a' => array('Text', 'Ted', 'Terminal', 'Tix')
    ),
    array(
        'q' => 'HTMLのMは何の略？',
        'a' => array('Markup', 'Mers', 'Merry', 'Man')
    ),
    array(
        'q' => 'HTMLのLは何の略？',
        'a' => array('Language', 'Lel', 'Low', 'Large')
    ),
    array(
        'q' => '作者の名前は誰？',
        'a' => array('okutani', 'akuma', 'higuma', 'sakuma')
    ),
    array(
        'q' => 'ポケモンの主人公は誰？',
        'a' => array('さとし', 'ひとし', 'たけし', 'たかくら')
    ),
    array(
        'q' => '土曜日の次の日は？',
        'a' => array('sunday', 'monday', 'everyday', 'hunnyday')
    )
);

function resetSession() {
    $_SESSION['correct_count'] = 0;
    $_SESSION['num'] = 0;
    $_SESSION['token'] = sha1(uniqid(mt_rand(), true));
}

function redirect() {
    header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF対策
    if ($_POST['token'] !== $_SESSION['token']) {
        echo '不正な投稿です！';
        exit;
    }
    if (isset($_POST['reset']) && $_POST['reset'] === '1') {
        resetSession();
        redirect();
    }
    if ($_POST['answer'] === $quizList[$_POST['qnum']]['a'][0]) {
        $_SESSION['correct_count']++;
    }
    $_SESSION['num']++;
    redirect();
}

if (empty($_SESSION)) {
    resetSession();
}

$qnum = mt_rand(0, count($quizList) - 1);
$quiz = $quizList[$qnum];

$_SESSION['qnum'] = (string)$qnum;

shuffle($quiz['a']);

?>
<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset='utf-8'>
    <title>かんたんクイズ</title>
    <style>
    input {
        width: 300px;
        box-shadow: 1px 1px 3px #ccc;
        margin-bottom: 10px;
    }
    </style>
</head>
<body>
    <h1>かんたんクイズ</h1>
    <div style="padding:7px;background:#eee;border:#ccc;">
        <?php echo h($_SESSION['num']); ?> 問中
        <?php echo h($_SESSION['correct_count']); ?> 問正解！
        <?php if ($_SESSION['num'] > 0) : ?>
            正解率は <?php echo h(sprintf('%.2f', $_SESSION['correct_count'] / $_SESSION['num'] * 100)) ?> %です！
        <?php endif; ?>
    </div>
    <p>Q. <?php echo h($quiz['q']); ?></p>
    <?php foreach ($quiz['a'] as $answer) : ?>
        <form method="post" action="">
            <input type="submit" name="answer" value="<?php echo h($answer); ?>" >
            <input type="hidden" name="qnum" value="<?php echo h($_SESSION["qnum"]); ?>" >
            <input type="hidden" name="token" value="<?php echo h($_SESSION["token"]); ?>">
        </form>
    <?php endforeach; ?>
    <hr>
    <form action="" method="post">
        <input type="submit" value="リセット">
        <input type="hidden" name="reset" value="1">
        <input type="hidden" name="token" value="<?php echo h($_SESSION["token"]); ?>">
    </form>
</body>
</html>
