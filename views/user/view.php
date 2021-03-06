<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PublicUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Public Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="public-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'button-orange']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'button-orange',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name:ntext',
            'last_name:ntext',
            'email:ntext',
            'personal_code',
            'phone',
            'active:boolean',
            'dead:boolean',
            'lang:ntext',
            'age:ntext',
        ],
    ]) ?>

</div>
