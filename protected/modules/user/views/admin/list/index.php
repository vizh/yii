<?
/**
 * @var  AdminMainController $this
 */

use application\components\controllers\AdminMainController;
$this->setPageTitle('Список пользователей');
?>


<div class="btn-toolbar clearfix">
    <?=\CHtml::form($this->createUrl('/user/admin/list/index'), 'get', ['class' => 'form-inline'])?>
    <div class="pull-left">
        <?=\CHtml::activeTextField($filter, 'Query', ['placeholder' => \Yii::t('app', 'RUNET-ID, E-mail, фамилия или название компании'), 'class' => 'input-xxlarge'])?>
        <?=\CHtml::submitButton(\Yii::t('app', 'Искать'), ['class' => 'btn'])?>
    </div>
    <div class="pull-right">
        <?=\CHtml::activeDropDownList($filter, 'Sort', $filter->getSortData())?>
        <?=\CHtml::activeDropDownList($filter, 'PerPage', $filter->getPerPageData(), ['class' => 'input-mini', 'style' => 'margin-left: 5px;'])?>
    </div>
    <?=\CHtml::endForm()?>
</div>
<div class="well">
    <div class="clearfix">
        <?=\CHtml::link('<i class="icon icon-plus icon-white"></i> Создать пользователя', ['/user/admin/edit/index'], ['class' => 'btn btn-success pull-right'])?>
    </div>
    <table class="table">
        <thead>
        <th colspan="3"><?=\Yii::t('app', 'Список пользователей')?></th>
        </thead>
        <tbody>
        <?foreach($results as $result):?>
            <tr>
                <?if(get_class($result) == 'user\models\User'):?>
                    <?=$this->renderPartial('user-row', ['user' => $result])?>
                <?elseif (get_class($result) == 'company\models\Company'):?>
                    <td></td>
                    <td colspan="2">
                        <h2><?=$result->Name?></h2>
                        <table class="table">
                            <?foreach($result->Employments as $employment):?>
                                <tr>
                                    <?=$this->renderPartial('user-row', ['user' => $employment->User])?>
                                </tr>
                            <?endforeach?>
                        </table>
                    </td>
                <?endif?>
            </tr>
        <?endforeach?>
        </tbody>
    </table>
    <?$this->widget('\application\widgets\Paginator', ['paginator' => $paginator])?>
</div>