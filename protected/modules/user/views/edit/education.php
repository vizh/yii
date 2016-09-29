<?php
/**
 * @var Educations $form
 */

use user\models\forms\edit\Educations;
?>

<?=$this->renderPartial('parts/title')?>

<div class="user-account-settings">
    <div class="clearfix">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <?=$this->renderPartial('parts/nav', ['current' => $this->getAction()->getId()])?>
                </div>
                <div class="span9">
                    <?=\CHtml::form('', 'POST', array('class' => 'b-form'))?>
                    <div class="form-header">
                        <h4><?=\Yii::t('app', 'Образование')?></h4>
                    </div>

                    <?=$this->renderPartial('parts/form-alert', ['form' => $form])?>

                    <div class="user-career-items"></div>

                    <div class="form-row form-row-add">
                        <a href="#" class="pseudo-link iconed-link" data-action="career_add"><i class="icon-plus-sign"></i> <span>Добавить образование</span></a>
                    </div>

                    <div class="form-footer">
                        <?=\CHtml::submitButton(\Yii::t('app','Сохранить'), array('class' => 'btn btn-info'))?>
                    </div>
                    <?=\CHtml::endForm()?>
                </div>
            </div>
        </div>
    </div>
</div>

<?=$this->renderPartial('education/data', ['form' => $form])?>
<?=$this->renderPartial('education/item-with-data', ['form' => $form])?>
<?=$this->renderPartial('education/item', ['form' => $form])?>