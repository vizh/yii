<?php
/**
 * @var \event\widgets\registration\Program $this
 * @var \event\models\section\Section $section,
 * @var int $colspan
 */

$product = $this->getProduct($section);
$orderItem = $this->getOrderItem($section);

$htmlOptions = ['colspan' => $colspan];
if ($product !== null) {
    $htmlOptions['data-product'] = $product->Id;
    if (!$product->getManager()->checkLimit()) {
        $htmlOptions['data-notforsale'] = 1;
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
<?=\CHtml::tag('td', $htmlOptions, $section->Title);?>
