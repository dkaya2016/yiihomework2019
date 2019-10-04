<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PublicUser */

$this->title = 'Create Public User';
$this->params['breadcrumbs'][] = ['label' => 'Public Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="public-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
