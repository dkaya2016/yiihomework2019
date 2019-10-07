<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Loan', ['create'], ['class' => 'button-orange']) ?>
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
            'user_id',
            'amount',
            'interest',
            'duration',
            'start_date',
            'end_date',
            'campaign',
            'status:boolean',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
