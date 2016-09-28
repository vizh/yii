<?/**
 * @var \pay\models\Product $product
 * @var \user\models\User $payer
 * @var \pay\models\Coupon[] $coupons
 */
?>

  <h4>
    <?if(!empty($payer->LastName)):?>
      Здравствуйте, <?=$payer->getFullName()?>.
    <?else:?>
      Уважаемый пользователь.
    <?endif?>
  </h4>

  <p>Вы купили следующие билеты категории "<?=$product->Title?>":</p>

<p>
  <font face="Courier New, sans-serif" size="3" style="font-family: Courier New, sans-serif; font-size: 16px; color: #00a651;">
    <strong>
      <?foreach($coupons as $coupon):?>
        <?=$coupon->Code?><br/>
      <?endforeach?>
    </strong>
  </font>
</p>

<p><strong>Внимание!</strong> Для прохода на мероприятие, необходимо активировать билеты.</p>

<ol>
  <li>Перейдите на страницу <a href="<?=Yii::app()->createAbsoluteUrl('/pay/cabinet/register', ['eventIdName' => $product->Event->IdName])?>">регистрации на мероприятие</a>.</li>
  <li>Выберите вариант "Я знаю кто пойдет на мероприятие, и хочу указать участников сразу".</li>
  <li>Найдите существующего в RUNET-ID пользователя или зарегистрируйте нового пользователя.</li>
  <li>В поле промо-код введите полученный код билета и нажмите на зеленую кнопку активации.</li>
</ol>

<p>Спасибо, ждем вас на мероприятии.</p>

<p>---<br>
  <em>Сервис регистраций RUNET-ID<br/>
    <a href="mailto:users@runet-id.com">users@runet-id.com</a></em></p>

