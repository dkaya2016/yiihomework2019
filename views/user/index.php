<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Public Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="public-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Public User', ['create'], ['class' => 'button-orange']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model){
         },
        'tableOptions' => [
            'id' => 'theDatatable',
            'class'=>'table table-bordered bottom-lined-table'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'first_name:ntext',
            'last_name:ntext',
            'email:ntext',
            'personal_code',
            'phone',
            'active:boolean',
            'dead:boolean',
            'lang:ntext',
            'age',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
