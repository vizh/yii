<?php
/**
 * @var \event\widgets\Registration $this
 * @var \pay\models\Product[] $products
 * @var \pay\models\Account $account
 */
?>

<?if ($this->event->Id == 1498):?>
    <div id="<?=$this->getNameId()?>" class="tab">
<?endif?>

<?=CHtml::beginForm(\Yii::app()->createUrl('/pay/cabinet/register', array('eventIdName' => $this->event->IdName)), 'POST', array('class' => 'event-registration registration'))?>
<?=\CHtml::hiddenField(\Yii::app()->request->csrfTokenName, \Yii::app()->request->getCsrfToken())?>
    <header>
        <h3 class="title"><?=\Yii::t('app', 'Регистрация')?></h3>
        <?$this->widget('\event\widgets\Participant', ['event' => $this->getEvent()])?>
        <?if(isset($this->RegistrationAfterInfo)):?>
            <?=$this->RegistrationAfterInfo?>
        <?endif?>
        <?if(isset($this->RegistrationBeforeInfo)):?>
            <?=$this->RegistrationBeforeInfo?>
        <?endif?>
    </header>

<?foreach($products as $product):?>
    <article>
        <h4 class="article-title"><?=$product->Title?></h4>

        <p><?=$product->Description?></p>
    </article>

    <table class="table table-condensed">
        <thead>
        <tr>
            <th></th>
            <th class="t-right"><?=\Yii::t('app', 'Цена')?></th>
            <th class="t-center"><?=\Yii::t('app', 'Кол-во')?></th>
            <th class="t-right"><?=\Yii::t('app', 'Сумма')?></th>
        </tr>
        </thead>
        <tbody>
        <?$dateFormatter = \Yii::app()->dateFormatter?>
        <?foreach($product->PricesActive as $key => $price):
            $curTime = date('Y-m-d H:i:s');
            $isMuted = $curTime < $price->StartTime || ($price->EndTime != null && $curTime > $price->EndTime);
           ?>
            <tr data-price="<?=$price->Price?>">

                <?if (!$isMuted):?>
                <td><strong><?else:?>
                        <td class="muted"><?endif;
                           ?>

                            <?if (empty($price->Title)):?>
                                <?if ($key == 0 && $price->EndTime != null):?>
                                    <?=\Yii::t('app', 'При регистрации онлайн до')?> <?=$dateFormatter->format('d MMMM', $price->EndTime)?>
                                <?elseif ($key != 0 && $price->EndTime != null):?>
                                    <?=\Yii::t('app', 'При регистрации онлайн с')?> <?=$dateFormatter->format('d MMMM', $price->StartTime)?> <?=\Yii::t('app', 'по')?> <?=$dateFormatter->format('d MMMM', $price->EndTime)?>
                                <?else:?>
                                    <?=\Yii::t('app', 'При регистрации онлайн с')?> <?=$dateFormatter->format('d MMMM', $price->StartTime)?> <?=\Yii::t('app', 'или на входе') . ' (' . $this->getEvent()->getFormattedStartDate('dd MMMM') . ')'?>
                                <?endif?>
                            <?else:?>
                                <?=$price->Title?>
                            <?endif?>

                        <?if (!$isMuted):?></strong><?endif;
                   ?></td>
                <td class="t-right price <?=$isMuted ? 'muted' : ''?>">
                    <strong><?=$price->Price?></strong> <?=\Yii::t('app', 'руб.')?></td>
                <td class="t-center">
                    <?
                    $inpParams = array(
                        'class' => 'input-mini'
                    );
                    if ($isMuted) {
                        $inpParams['disabled'] = 'disabled';
                    }
                    echo CHtml::dropDownList('count[' . $product->Id . ']', 0, array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10), $inpParams)?>
                </td>
                <td class="t-right totalPrice <?=$isMuted ? 'muted' : ''?>"><strong
                        class="mediate-price">0</strong> <?=\Yii::t('app', 'руб.')?></td>
            </tr>
        <?endforeach?>
        </tbody>
    </table>
<?endforeach?>

    <div class="t-right total">
        <span><?=\Yii::t('app', 'Итого')?>: </span><strong id="total-price">0</strong> <?=\Yii::t('app', 'руб.')?>
    </div>

    <?if($this->event->IdName === 'phdays17'):?>
        <div class="text-center">
            <div class="control-group" style="margin:1.5em 0 1em">
                <label for="pay_email"><?=Yii::t('app', 'Для начала процесса регистрации введите Email:')?></label>
                <div class="controls">
                    <input id="pay_email" class="span4" name="email" value="" type="text">
                    <span class="help-block"><?=Yii::t('app', 'На указанный Email будет выслано письмо, с инструкциями по использованию временного аккаунта.')?></span>
                </div>
            </div>
            <hr>
        </div>
    <?else:?>
        <hr>
    <?endif?>
    <div class="text-center">
        <button class="btn btn-success" type="submit"><?=\Yii::t('app', 'Зарегистрироваться')?></button>
    </div>
<?=CHtml::endForm()?>


<?if ($this->event->Id == 1498):?>
    </div>
<?endif?>