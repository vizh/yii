<?php
/**
 * @var \event\widgets\registration\Program $this
 * @var \event\models\section\Section $section,
 * @var int $colspan
 * @var array $data
 */

$content = $section->Title;
$registration = '';

$product = $this->getProduct($section);
$orderItem = $this->getOrderItem($section);

$htmlOptions = ['colspan' => $colspan];
if ($product !== null) {
    $htmlOptions['data-product'] = $product->Id;
    $manager = $product->getManager();

    if ($manager->getLimit() !== null) {
        if ($manager->checkLimit()) {
            $registration .= \CHtml::tag('p', ['class' => 'text-success limit text-center'], 'Осталось мест: ' . ($manager->getLimit() - $manager->getSoldCount()));
        } else {
            $htmlOptions['data-notforsale'] = 1;
            $registration .= \CHtml::tag('p', ['class' => 'text-warning limit text-center'], 'Места закончились');
        }
    }
    $registration .= \CHtml::button(\Yii::t('app', 'Регистрация'), ['class' => 'btn btn-info btn-mini btn-block btn-register hide']);
    $registration .= \CHtml::button(\Yii::t('app', 'Отменить'), ['class' => 'btn btn-danger btn-mini btn-block btn-unregister hide']);
}
if ($orderItem !== null) {
    $htmlOptions['data-orderitem'] = $orderItem->Id;
    $htmlOptions['data-price'] = $orderItem->getPriceDiscount();
    if ($orderItem->Paid) {
        $htmlOptions['data-paid'] = 1;
    }
}
if (!empty($section->Info)) {
    $registration .= \CHtml::button(\Yii::t('app', 'Подробнее'), ['class' => 'btn btn-mini btn-block', 'data-toggle' => 'modal', 'data-target' => '#' . $this->getId() . '_modal' . $section->Id]);
}

if (!empty($registration)) {
    $content .= \CHtml::tag('div', ['class' => 'registration-block'], $registration);
}
?>
<?=\CHtml::tag('td', $htmlOptions, $content)?>
