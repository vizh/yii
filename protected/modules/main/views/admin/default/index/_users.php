<?php
/**
 * @var User[] $users
 */
use user\models\User;
use application\components\web\ArrayDataProvider;
?>
<div class="block-heading">
    <a href="#yw4">Пользователи (20 последних)</a>
</div>
<div class="block-body">
    <?$this->widget('\application\widgets\grid\GridView', [
        'dataProvider'=> new ArrayDataProvider($users),
        'columns' => [
            [
                'header' => 'ФИО',
                'value' => function (User $user) {
                    return $user->getFullName();
                }
            ],
            [
                'type' => 'raw',
                'value' => function (User $user) {
                    $html  = \CHtml::link('<i class="icon icon-edit"></i>', ['/user/admin/edit/index', 'runetId' => $user->RunetId], ['class' => 'btn']);
                    $html .= \CHtml::link('<i class="icon icon-eye-open"></i>', $user->getUrl(), ['target' => '_blank', 'class' => 'btn']);
                    return \CHtml::tag('div', ['class' => 'btn-group'], $html);
                },
                'htmlOptions' => ['class' => 'text-right']
            ]
        ]
    ])?>
</div>