<?php
session_start();
require('dbconnect.php');



if (!empty($_POST)) {
    if ($_POST['message'] !== '') {

        $members = $db->prepare('SELECT * FROM members WHERE id=?');
        $members->execute(array($_SESSION['id']));
        $member = $members->fetch();

        $message = $db->prepare('INSERT INTO posts SET member_id=?, message=?, created=NOW()');
        $message->execute(array($member['id'], $_POST['message']));

        header('Location: racket_1.php');
        exit();
    }
}

//ページネーション
$page = $_REQUEST['page'];
if ($page == '') {
    $page = 1;
}
$page = max($page, 1);

$counts = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $counts->fetch();
$max_page = ceil($cnt['cnt'] / 3);
$page = min($page, $max_page);

$start = ($page - 1) * 3;

//LIMIT句、1の場合2件目から数える
$posts = $db->prepare('SELECT m.name, p.* FROM members m, posts p WHERE m.id=p.member_id ORDER BY p.created DESC LIMIT ?,3');
//1は?の位置を指定、$startはバインドする変数を指定
$posts->bindParam(1, $start, PDO::PARAM_INT);
$posts->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <title>林昀儒 SUPER ZLC｜卓球製品情報｜バタフライ卓球用品</title>
</head>

<body>
    <header>
        <div class="container-fluid header">
            <div class="row">
                <div class="head col-md-6">
                    <p><i class="fas fa-table-tennis fa-lg tt"></i><a href="index.php">卓プロ</a></p>
                </div>
                <div class="head_1 col-md-6">
                    <ul>
                        <li><a href="create.php">会員登録</a>|</li>
                        <li><a href="login.php">ログイン</a>|</li>
                        <li><a href="logout.php">ログアウト</a>|</li>
                        <li>
                            <a href="">
                                <?php if ($login['name'] = 'success') {
                                    print($member['name'] + 'さん、こんにちは！');
                                } ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="head_image_1">
            <p>林昀儒 SUPER ZLC</p>
        </div>
    </header>
    <div class="main_bar">
        <ul class="slick01">
            <li><img alt="画像1" src="images/37131_01.jpg" /></li>
            <li><img alt="画像2" src="images/37131_02.jpg" /></li>
            <li><img alt="画像3" src="images/37131_03.jpg" /></li>
            <li><img alt="画像3" src="images/37131_03.jpg" /></li>
            <li><img alt="画像3" src="images/37131_03.jpg" /></li>
        </ul>
    </div>
    <!-- <div class="side_bar">
    </div> -->

    <div id="center">
        <div class="version">
            <h3>林昀儒選手の使用モデル</h3>
            <p>
                カーボンとZLファイバーを高密度に編み込んだスーパーZLカーボン搭載ラケットは、打球の威力を引き出す弾みの良さと、広い高反発エリアによる安定性が特徴です。
                類いまれな打球感覚を持つ中華台北の新星・林昀儒選手は、高めの振動特性を持つ威力重視のこのラケットを駆使し、鋭いチキータや質の高いカウンターを生み出しています。グリップに採用された彼の好みのカラーと、名前の頭文字で構成されたウイングマークは、若さと将来の成功を感じさせます。
            </p>
        </div>
        <ul class="tabs-menu">
            <li class="tab"><a href=".tabs-1">性能</a></li>
            <li class="tab"><a href=".tabs-2">口コミ</a></li>
            <li class="tab"><a href=".tabs-3">お勧め組み合わせラバー</a></li>
        </ul>
        <div class="tabs-content">

            <!-- 性能 -->
            <div class="tabs-1 container">
                <div class="row tabs-1-1">
                    <table class="col-md-5">
                        <tr class="tables">
                            <th>商品名</th>
                            <td>林昀儒 SUPER ZLC</td>
                        </tr>
                        <tr class="tables">
                            <th>価格</th>
                            <td>41,800円</td>
                        </tr>
                        <tr class="tables">
                            <th>発売日</th>
                            <td>2021年3月1日</td>
                        </tr>
                        <tr class="tables">
                            <th>タイプ</th>
                            <td>攻撃用シェーク</td>
                        </tr>
                        <tr class="tables">
                            <th>反発特性</th>
                            <td>12.3</td>
                        </tr>
                        <tr class="tables">
                            <th>振動特性</th>
                            <td>11.1</td>
                        </tr>
                    </table>
                    <table class="offset-md-2 col-md-5">
                        <tr class="tables">
                            <th>商品名</th>
                            <td>林昀儒 SUPER ZLC</td>
                        </tr>
                        <tr class="tables">
                            <th>aaa</th>
                            <td>bbb</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- 性能ここまで -->
            <!-- お勧め組み合わせ -->
            <div class="tabs-2">
                <table class="comment">
                    <tr class="line">
                        <th>投稿者</th>
                        <th>採点</th>
                        <th>投稿された日付</th>
                        <th></th>
                    </tr>

                    <?php foreach ($posts as $post) : ?>
                        <tr class="line-1">
                            <td width="270px"><?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?></td>
                            <td width="370px"></td>
                            <td width="370px"><?php print(htmlspecialchars($post['created'], ENT_QUOTES)); ?></td>
                            <?php if ($_SESSION['id'] == $post['member_id']) : ?>
                                <td width="100px"><a href="delete.php?id=<?php print(htmlspecialchars($post['id'])); ?>">削除</a></td>
                            <?php endif; ?>
                        </tr>
                        <tr class="comment_2">
                            <td></td>
                            <td><?php print(htmlspecialchars($post['message'], ENT_QUOTES)); ?></td>
                        </tr>
                    <?php endforeach; ?>

                </table>
                <?php
                if ($page > 1) {
                    print('<a class="figure" href="racket_1.php?page=' . ($page - 1) . '">前へ</a>');
                } else {
                    print('<span class="figure">前へ</span>');
                }

                for ($i = 1; $i <= $max_page; $i++) {
                    if ($i == $page) {
                        print('<span class="figure">' . $page . '</span>');
                    } else {
                        print('<a class="figure" href="racket_1.php?page=' . $i . '">' . $i . '</a>');
                    }
                }

                if ($page < $max_page) {
                    print('<a class="figure" href="racket_1.php?page=' . ($page + 1) . '">次へ</a>');
                } else {
                    print('<span class="figure">次へ</span>');
                }
                ?>
                <p>
                    <a href="racket_1_post.php">投稿する</a>
                </p>
            </div>
            <!-- お勧め組み合わせここまで -->
            <!-- 使用選手 -->
            <div class="tabs-3">
                <div class="tabs-3-2">
                    <div class="tabs-3-1">
                        <img src="images/37131.jpg" alt="林昀儒 SUPER ZLC" height="200" width="200">
                        <div>林昀儒 SUPER ZLC<br>41,800円(税込)</div>
                    </div>
                    <div class="tabs-3-1">
                        <img src="images/06090.jpg" alt="テナジー19" height="200" width="200">
                        <div>テナジー19<br>円(税込)</div>
                    </div>
                    <div class="tabs-3-1">
                        <img src="images/05810.jpg" alt="テナジー25" height="200" width="200">
                        <div>テナジー25<br>円(税込)</div>
                    </div>
                    <div class="chart">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
                <div>
                    <div class="tabs-3-1">
                        <img src="images/37131.jpg" alt="林昀儒 SUPER ZLC" height="200" width="200">
                        <div>林昀儒 SUPER ZLC<br>41,800円(税込)</div>
                    </div>
                    <div class="tabs-3-1">
                        <img src="images/06090.jpg" alt="テナジー19" height="200" width="200">
                        <div>テナジー19<br>円(税込)</div>
                    </div>
                    <div class="tabs-3-1">
                        <img src="images/05810.jpg" alt="テナジー25" height="200" width="200">
                        <div>テナジー25<br>円(税込)</div>
                    </div>
                    <div class="chart">
                        <canvas id="myChart-1"></canvas>
                    </div>
                </div>
            </div>
            <!-- 使用選手ここまで -->
        </div>
    </div>
    <footer>
        <p class="page_top"><a href="">PAGE TOP</a></p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="jquery.raty.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.0/chart.min.js" integrity="sha512-RGbSeD/jDcZBWNsI1VCvdjcDULuSfWTtIva2ek5FtteXeSjLfXac4kqkDRHVGf1TwsXCAqPTF7/EYITD0/CTqw==" crossorigin="anonymous"></script>
    <script src="main.js"></script>
</body>

</html>