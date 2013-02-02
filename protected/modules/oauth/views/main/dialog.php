<form>
  <legend>Здравствуйте, <a href="#">Константин Константинович</a></legend>
  <p>Сайт РИФ+КИБ 2013 запрашивает доступ к&nbsp;вашему аккаунту для использования данных профиля в&nbsp;целях авторизации:</p>
  <br>
  <div class="tx-c">
    <a href="./authorization.html" class="btn">Отмена</a>
    &nbsp;
    <button type="submit" class="btn btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;Разрешить</button>
  </div>
</form>





<?php echo CHtml::beginForm();?>
<div class="clearfix m-bottom_20">
  <div class="f-left m-right_20">
    <img src="<?php echo $user->GetMiniPhoto();?>" />
  </div>
  <h3 class="u-name"><?php echo $user->GetFullName();?></h3>
  <?php $employment = $user->GetPrimaryEmployment();?>
  <?php if ($employment !== null):?>
    <?php echo $employment->Company->Name;?><?php if (!empty($employment->Position)):?>, <?php echo $employment->Position;?><?php endif;?></p>
  <?php endif;?>
</div>
<p><strong>«<?php echo $event->Name;?>»</strong> заправшивает доступ к Вашим данным</p>
<div class="clearfix m-top_20">
  <?php echo CHtml::submitButton('Разрешить', array('class' => 'btn btn-success f-left m-right_20'));?>
  <?php echo CHtml::button('Отмена', array('class' => 'btn btn-cancel'));?>
</div>
<?php echo CHtml::endForm();?>