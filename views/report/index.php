<style>
    .butt {
        justify-content: center;
        display: flex;
    }
</style>

<?php

use app\models\Report;
use app\models\Role;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ReportSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if(Yii::$app->user->identity->role_id == Role::USER_ID) {
                echo Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ;
            }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'number',
            'description:ntext',
            'status',
            [
                'attribute'=> 'change status',
                //смена статуса вмдна только админу
                'visible' => (Yii::$app->user->identity->role_id == '1')?true:false,
                'format'=> 'raw',
                'value'=> function ($data) {
                    $html = Html::beginForm(Url::to(['update', 'id' => $data->id]));
                    $html .= Html::activeDropDownList($data, 'status_id', [
                        2 => 'Подтверждено',
                        3 => 'Отклонено',
                    ],
                    [
                        'prompt' => [
                            'text'=> 'Новая',
                            'options' => [
                                'value'=> '1',
                                'style'=> 'display: none',
                            ]
                        ]
                    ]);
                    $html .= Html::submitButton('Принять', ['class' => 'btn btn-link']);
                    $html .= Html::endForm();
                    return $html;
                }
            ],
        ],
    ]); ?>


</div>
