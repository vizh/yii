<?php
/**
 * @var \event\widgets\registration\Program $this
 * @var \event\models\section\Section $section,
 * @var int $colspan
 */

$content = $section->Title;

$product = $this->getProduct($section);
$orderItem = $this->getOrderItem($section);

$htmlOptions = ['colspan' => $colspan];
if ($product !== null) {
    $htmlOptions['data-product'] = $product->Id;
    $manager = $product->getManager();

    if (!$manager->checkLimit()) {
        $htmlOptions['data-notforsale'] = 1;
    }

    if ($manager->getLimit() !== null && $orderItem == null) {
        if ($manager->checkLimit()) {
            $content .= \CHtml::tag('p', ['class' => 'text-success limit'], 'Осталось мест: ' . ($manager->getLimit() - $manager->getSoldCount()));
        } else {
            $content .= \CHtml::tag('p', ['class' => 'text-warning limit'], 'Места закончились');
        }
    }
}
if ($orderItem !== null) {
    $htmlOptions['data-orderitem'] = $orderItem->Id;
    $htmlOptions['data-price'] = $orderItem->getPriceDiscount();
    if ($orderItem->Paid) {
        $htmlOptions['data-paid'] = 1;
    }
}

?>
<?=\CHtml::tag('td', $htmlOptions, $content);?>
