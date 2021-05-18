<?php
session_start();
require('../dbconnect.php');

$id = $_REQUEST['id'];


if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    //時間の上書き、最後のログインから1時間
    $_SESSION['time'] = time();

    $login['name'] = 'success';

    //ログインしているユーザーの情報を引き出す
    $members = $db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();
}

$rubbers = $db->prepare('SELECT * FROM rubbers WHERE id=?');
$rubbers->execute(array($id));
$rubber = $rubbers->fetch();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <title><?php print($rubber['name']); ?></title>
</head>

<body>
    <header>
        <?php require('../header_1.php') ?>
        <div class="head_image_1">
            <p><?php print($rubber['name']); ?></p>
        </div>
    </header>
    <div class="main_bar">
        <ul class="slick01">
            <li><img alt="画像1" src="../images/rubber-<?php print($id); ?>/rubber1.jpg" /></li>
            <li><img alt="画像2" src="../images/rubber-<?php print($id); ?>/rubber2.jpg" /></li>
            <li><img alt="画像3" src="../images/rubber-<?php print($id); ?>/rubber3.jpg" /></li>
        </ul>
    </div>


    <!-- 同じページにする -->
    <!-- 性能など、すべてPHPに登録 -->

    <div id="center">
        <a href="../favorite.php?racket_rubber=2&id=<?php print($id); ?>">
            <div class="favorite btn btn-warning"><i class="far fa-star"></i><span>お気に入りに追加</span></div>
        </a>
        <?php if ($_REQUEST['record'] == 'duplicate') : ?>
            <div class="favorites">
                <p>すでにお気に入り登録済です！</p>
            </div>
        <?php elseif ($_REQUEST['record'] == 'success') : ?>
            <div class="favorites">
                <p>お気に入りに登録しました！</p>
                <?php ini_set('display_errors', "On"); ?>
            </div>
        <?php endif; ?>
        <ul class="tabs-menu">
            <li class="tab tab-1"><a href="rubber_detail.php?id=<?php print($id); ?>">性能</a></li>
            <li class="tab tab-2"><a href="rubber_word.php?id=<?php print($id); ?>">口コミ</a></li>
            <li class="tab tab-2"><a href="rubber_comb.php?id=<?php print($id); ?>">お勧め組み合わせラバー</a></li>
        </ul>
        <div class="tabs-content">

            <!-- 性能 -->
            <div class="tabs-1 container">
                <div class="row tabs-1-1">
                    <table class="col-md-6">
                        <tr class="tables">
                            <th>商品名</th>
                            <td><?php print($rubber['name']); ?></td>
                        </tr>
                        <tr class="tables">
                            <th>価格</th>
                            <td><?php print($rubber['price']); ?>円（税込）</td>
                        </tr>
                        <tr class="tables">
                            <th>発売日</th>
                            <td><?php print($rubber['release_day']); ?></td>
                        </tr>
                        <tr class="tables">
                            <th>タイプ</th>
                            <td><?php print($rubber['type']); ?></td>
                        </tr>
                        <tr class="tables">
                            <th>テクノロジー</th>
                            <td><?php print($rubber['technology']); ?></td>
                        </tr>
                    </table>
                    <table class="col-md-6">
                        <tr class="tables">
                            <th>スピード</th>
                            <td><?php print($rubber['speed']); ?></td>
                        </tr>
                        <tr class="tables">
                            <th>スピン</th>
                            <td><?php print($rubber['spin']); ?></td>
                        </tr>
                        <tr class="tables">
                            <th>スポンジ硬度</th>
                            <td><?php print($rubber['sponge_hardness']); ?></td>
                        </tr>
                        <tr class="tables">
                            <th>シートカラー</th>
                            <td><?php print($rubber['seat_color']); ?></td>
                        </tr>
                        <tr class="tables">
                            <th>スポンジ厚</th>
                            <td><?php print($rubber['sponge_thickness']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p class="page_top"><a href="">PAGE TOP</a></p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="../jquery.raty.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.0/chart.min.js" integrity="sha512-RGbSeD/jDcZBWNsI1VCvdjcDULuSfWTtIva2ek5FtteXeSjLfXac4kqkDRHVGf1TwsXCAqPTF7/EYITD0/CTqw==" crossorigin="anonymous"></script>
    <script src="../main.js"></script>
</body>

</html>