<?php

use application\components\controllers\AdminMainController;
use pay\models\search\admin\booking\FoodNaturalSearch;

/** @var AdminMainController $this */
/** @var FoodNaturalSearch $model */
?>


<div class="row-fluid">
    <div class="btn-toolbar clearfix">
        <a href="<?=$this->createUrl('foodNaturalForm')?>" class="btn btn-success pull-right">Добавить</a>
    </div>

    <div class="well">
        <table class="table">
            <thead>
            <tr>
                <th rowspan="2">Пользователь</th>
                <th>2017-04-18</th>
                <th colspan="3">2017-04-19</th>
                <th colspan="3">2017-04-20</th>
                <th colspan="3">2017-04-21</th>
            </tr>
            <tr>
                <th>Завтрак</th>
                <th>Завтрак</th>
                <th>Обед</th>
                <th>Ужин</th>
                <th>Завтрак</th>
                <th>Обед</th>
                <th>Ужин</th>
                <th>Завтрак</th>
                <th>Обед</th>
                <th>Ужин</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model->search() as $item) {
                echo CHtml::openTag('tr');
                echo CHtml::tag('td', [], $item['user_name'].', '.$item['user_runet_id']);
                foreach (FoodNaturalSearch::$productIds as $date => $meals) {
                    foreach ($meals as $meal => $id) {
                        echo CHtml::tag('td', [], CHtml::tag('span', ['class' => 'label '.($item['poi'.$id.'paid'] ? 'label-success' : 'label-warning')], $item['poi'.$id]));
                    }
                }
                echo CHtml::closeTag('tr');
            } ?>
            </tbody>
        </table>
    </div>
</div>
