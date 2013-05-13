<?php
/**
 * @var $error string
 */
?>
<div class="container m-top_40 m-bottom_40">
  <div class="row">
    <div class="span8 offset2">

        <div class="well">
          <h4 class="m-bottom_10"><?=Yii::t('app', 'Вы не авторизованы в системе RUNET-ID.');?></h4>
          <p>
            <?=\Yii::t('app', 'Для полного доступа к платежному кабинету <a id="PromoLogin" href="">авторизуйтесь или зарегистрируйтесь.</a>');?>
          </p>

          <form action="" method="post">
             <div class="control-group">
               <label for="pay_email">Для создания временного аккаунта введите Email:</label>
               <div class="controls">
                 <input id="pay_email" class="span4" name="email" value="" type="text">
                 <span class="help-block">На указанный Email будет выслано письмо, с инструкциями по использованию временного аккаунта.
               </div>
             </div>
            <button type="submit" class="btn btn-info">Продолжить</button>
          </form>
        </div>

    </div>
  </div>
</div>