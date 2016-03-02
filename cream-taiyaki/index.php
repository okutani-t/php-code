<?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $slackApiKey = 'ここにslackのAPI KEY';
    $text = 'すまん...... 食っちまった......';
    $text = urlencode($text);
    $channel = '%23cream-taiyaki';
    $url = "https://slack.com/api/chat.postMessage?token=${slackApiKey}&channel=${channel}&text=${text}&as_user=false";
    file_get_contents($url);

echo <<<EOM
<script type="text/javascript">
  alert("slackに送信したよー");
</script>
EOM;
  }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"  content="クリームたいやきを食べたか監視してslackに送信するアプリ。" />
    <title>CREAM TAIYAKI</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.4.0/animate.min.css">
    <style>
     h1,
     p {
       text-align: center;
     }
     p {
       font-size: 1.4em;
     }
     .mb30 {
       margin-bottom: 30px;
     }
     #cream_taiyaki {
       box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
       cursor: pointer;
       transition: ease .3s;
     }
     #cream_taiyaki:hover {
       opacity: .8;
     }
    </style>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <form id="my_form" method="post" action="">
      <div class="container">
        <h1>クリームたいやきチェッカー！</h1>
        <p>click me!</p>
        <p class="mb30">↓</p>
        <img id="cream_taiyaki" class="wow bounce mb30 img-responsive center-block img-circle infinite" data-wow-duration="2.0s" src="cream-taiyaki.jpg" alt="クリームたいやき">
      </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
     $(function(){
       // wow.js
       new WOW({
         mobile: false
       }).init();
       // cream taiyaki click
       $("#cream_taiyaki").on("click", function(){
         if (confirm("本当に食べた？slackに送信するよ？")) {
           $("#my_form").submit();
         }
       });
     });
    </script>

  </body>
</html>
