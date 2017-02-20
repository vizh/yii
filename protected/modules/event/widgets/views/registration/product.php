<?php
/**
 * @var \event\widgets\Registration $this
 * @var \pay\models\Product $product
 * @var bool $groupProduct
 */
$groupProduct = isset($groupProduct) ? $groupProduct : false;
$full = sizeof($product->PricesActive) > 1 || !empty($product->Description);
?>
<?if($full && !$groupProduct):?>
    <tr>
        <td colspan="4">
            <article>
                <h4 class="article-title"><?=$product->Title?></h4>
                <?if(!empty($product->Description)):?>
                    <p><?=$product->Description?></p>
                <?endif?>
            </article>
        </td>
    </tr>
<?endif?>

<?foreach($product->PricesActive as $price):?>
    <?
    $curTime = date('Y-m-d H:i:s');
    $isMuted = $curTime < $price->StartTime;
    $mutedClass = $isMuted ? 'muted' : '';

   ?>
    <tr data-price="<?=$price->Price?>">
        <?if($full || $groupProduct):?>
            <td class="<?=$mutedClass?>">
                <?
                $title = $price->Title;
                if (empty($title))
                {
                    if ($price->EndTime !== null)
                        $title = \Yii::t('app', 'При регистрации онлайн до').' '.\Yii::app()->dateFormatter->format('d MMMM', $price->EndTime);
                    else
                        $title = \Yii::t('app', 'При регистрации онлайн с').' '.\Yii::app()->dateFormatter->format('d MMMM', $price->StartTime).' '.\Yii::t('app', 'или на входе').' ('.$this->getEvent()->getFormattedStartDate('d MMMM').')';
                }
               ?>
                <?=$title?>
            </td>
        <?else:?>
            <td style="padding-top: 20px; padding-bottom: 20px;" class="<?=$mutedClass?>">
                <strong style="margin-bottom: 15px;"><?=$product->Title?></strong>
            </td>
        <?endif?>

        <td class="t-right <?=$mutedClass?>">
            <?if($price->Price != 0):?>
                <span class="number"><?=$price->Price?></span> <?=Yii::t('app', 'руб.')?>
                <?if(Yii::app()->getLanguage() == 'en'):?>
                    <br><span class="muted" style="font-size: 85%;">approx. <?=round($price->Price/60)?> eur</span>
                <?endif?>
            <?else:?>
                <?=Yii::t('app', 'бесплатно')?>
            <?endif?>
        </td>
        <td class="t-center <?=$mutedClass?>">
            <?=CHtml::dropDownList('count['.$product->Id.']', 0, range(0, 9), ['class' => 'input-mini form-element_select', 'disabled' => $isMuted])?>
        </td>
        <td class="t-right <?=$mutedClass?>"><b class="number mediate-price">0</b> <?=Yii::t('app', 'руб.')?></td>
    </tr>
<?endforeach?>