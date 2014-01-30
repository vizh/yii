<?/**
 * @var \pay\models\Product $product
 * @var \user\models\User $payer
 * @var \pay\models\Coupon[] $coupons
 */
?>

Вы купили следующие билеты:
<?foreach ($coupons as $coupon):?>
  <?=$coupon->Code;?><br/>
<?endforeach;?>