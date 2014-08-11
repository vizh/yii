<?
/**
 * @var User $user
 */
?>

<div class="alert primary-phone-verify">
  <div class="container">
    <strong>
      <?=\Yii::t('app', '{name}, пожалуйста {action} ваш основной контактный номер телефона.', [
        '{name}' => $user->getShortName(),
        '{action}' => !empty($user->PrimaryPhone) ? 'подтвердите' : 'укажите'
      ]);?>
    </strong>
    <a href="<?=\Yii::app()->createUrl('/user/edit/contacts');?>" class="btn btn-mini"><?=\Yii::t('app', 'Подтвердить');?></a>
  </div>
</div>