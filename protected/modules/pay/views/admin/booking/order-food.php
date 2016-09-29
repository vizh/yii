<?/**
 * @var PartnerFoodOrder $form
 */

use application\helpers\Flash;
use \pay\models\forms\admin\PartnerFoodOrder;
$this->setPageTitle('Счет на питание');
?>
<?if($order !== null && $order->Paid):?>
    <script type="text/javascript">
        $(function () {
            $('form.form-horizontal').find('input').prop('disabled', true);
        });
    </script>
<?endif?>

<div class="btn-toolbar">
    <?if($form->getOwner() === null):?>
        <?=\CHtml::link('← Назад', ['partners'], ['class' => 'btn'])?>
    <?else:?>
        <?=\CHtml::link('← Назад', ['partner', 'owner' => $form->getOwner()], ['class' => 'btn'])?>
    <?endif?>
</div>
<div class="well">
    <?if($form->getOwner() !== null):?>
        <h2 class="m-bottom_10"><?=\Yii::t('app', 'Партнер:')?> <?=$form->getOwner()?></h2>
    <?endif?>
    <?if($order !== null && !$order->getIsNewRecord()):?>
        <div class="m-bottom_30">
            <?=\CHtml::link('Счет для печати', ['orderfood', 'owner' => $form->getOwner(), 'id' => $order->Id, 'print' => 1])?>
        </div>
    <?endif?>
    <?=Flash::html()?>
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
    <?=\CHtml::form('','POST',['class' => 'form-horizontal'])?>

    <?if($form->getOwner() === null):?>
        <div class="control-group">
            <?=\CHtml::activeLabel($form, 'Owner', ['class' => 'control-label'])?>
            <div class="controls">
                <?=\CHTml::activeTextField($form, 'Owner', ['class' => 'input-xxlarge'])?>
            </div>
        </div>
    <?endif?>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Name', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'Name', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Address', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'Address', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'RealAddress', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'RealAddress', ['class' => 'input-xxlarge'])?>
        </div>
    </div>

    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'INN', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'INN', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'KPP', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'KPP', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'BankName', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'BankName', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Account', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'Account', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'CorrespondentAccount', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'CorrespondentAccount', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'BIK', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'BIK', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'ChiefPosition', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'ChiefPosition', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'ChiefName', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'ChiefName', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'ChiefPositionP', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'ChiefPositionP', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'ChiefNameP', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'ChiefNameP', ['class' => 'input-xxlarge'])?>
        </div>
    </div>
    <div class="control-group">
        <?=\CHtml::activeLabel($form, 'StatuteTitle', ['class' => 'control-label'])?>
        <div class="controls">
            <?=\CHTml::activeTextField($form, 'StatuteTitle', ['class' => 'input-xxlarge'])?>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <?foreach(PartnerFoodOrder::getFoodProductData() as $date => $list):?>
                    <td colspan="<?=sizeof($list)?>" class="text-center"><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $date)?></td>
                <?endforeach?>
            </tr>
            <tr>
                <?foreach(PartnerFoodOrder::getFoodProductData() as $date => $list):?>
                    <?foreach($list as $id => $label):?>
                        <td class="text-center">
                            <p><?=$label?></p>
                            <?=\CHtml::activeDropDownList($form, 'ProductIdList[' . $id . ']', range(0,30), ['class' => 'input-mini'])?>
                        </td>
                    <?endforeach?>
                <?endforeach?>
            </tr>
        </thead>
    </table>

    <div class="control-group">
        <div class="controls">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
        </div>
    </div>
    <?=\CHtml::endForm()?>
</div>