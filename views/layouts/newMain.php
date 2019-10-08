<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
       <link href="/css/copiedfromyoursite.css" rel="stylesheet">
       <link href="/css/justification.css" rel="stylesheet">
</head>
<body>
<div id="page-header" class="contain-to-grid hide-for-print show-for-medium-up">
    <div class="top-bar">
    <section class="top-bar-section">
            <ul class="customer-service show-for-medium-up">
                <li>Klienditeenindus</li>
                <li class="customerservice-icon"><img src="/images/ico-customerservice.jpg">1715</li>
                <li class="openingtimes-icon"><img src="/images/ico-openingtimes.jpg">Monday-Friday 9AM-5PM                </li>
                <li class="openingtimes-icon"></li>
            </ul>

        </section><section class="top-bar-section client-area">
            <ul class="right">
                  <?php if (!Yii::$app->user->isGuest) {?>
                  <li>
                     Tere <?=Yii::$app->user->identity->username ?>
                   <li>
                <?php echo Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout',
                        ['class' => 'button-orange']
                    )
                    . Html::endForm()
                    ?>
                   <?php }  else {?>
                        <li>
                            <a class="button-orange" href="index.php?r=site/login">
                                <div class="icon login"></div>Log in </a>
                        </li>
                        <li>
                            <a class="button-orange btn-disabled">
                               Register  </a>
                        </li>
                        <?php } ?>
                        </ul>
        </section></div>

</div>

<section class="midnav-class-wrapper">
    <section class="top-bar-section client-area midnav-class">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w2-collapse">
            </button>
            <a class="navbar-brand mid-navbar-brand" href="/index.php"><img src="/images/cs_logo.jpg"></a>
        </div>
        <div class="midnavcontainer">
            <ul class="right">
                <li><a href="index.php">Link-11</a></li>
                <li><a href="index.php">Link-2</a></li>
                <li><a href="index.php">Link-3</a></li>
                <li><a href="index.php">Link-4</a></li>
                <li><a href="index.php">Link-5</a></li>
            </ul>
        <div>
    </section>
</section>

<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-default',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => 'My Actions', 'url' => ['/site/index']],
            ['label' => 'Loan', 'url' => ['/loan/index']],
            ['label' => 'User', 'url' => ['/user/index']],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
