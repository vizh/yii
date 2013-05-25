<?
/**
 * @var $user \user\models\User
 * @var $userSecond \user\models\User
 */
?>

<?=\CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'));?>

  <input type="hidden" name="confirm" value="confirm">
  <input type="hidden" class="span4"  name="RunetIdMain" value="<?=$user->RunetId;?>">
  <input type="hidden" class="span4"  name="RunetIdSecond" value="<?=$userSecond->RunetId;?>">


  <div class="btn-toolbar">
    <?=\CHtml::submitButton(\Yii::t('app', 'Подтвердить объединение'), array('class' => 'btn'));?>
  </div>

  <div class="row-fluid">
    <div class="span6">
      <h2>Основной</h2>
      <h3><?=$user->getFullName();?></h3>
    </div>
    <div class="span6">
      <h2>Дубль</h2>
      <h3><?=$userSecond->getFullName();?></h3>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <h3>Адрес электронной почты</h3>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
      <label class="radio"><input type="radio" name="Email" value="<?=$user->Id;?>" checked="checked"> <?=$user->Email;?></label>
    </div>
    <div class="span6">
      <label class="radio"><input type="radio" name="Email" value="<?=$userSecond->Id;?>"> <?=$userSecond->Email;?></label>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <h3>Места работы</h3>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">

      <table class="table table-bordered">
        <?foreach ($user->Employments as $employment):?>
          <tr>
            <td>
              <?if ($employment->EndYear == null):?>
                <label class="radio"><input type="radio" name="EmploymentPrimary" value="<?=$employment->Id;?>" <?=$employment->Primary ? 'checked="checked"' : '';?>> Основное</label>
              <?endif;?>
            </td>
            <td><label class="checkbox"><input type="checkbox" name="Employment[]" value="<?=$employment->Id;?>" checked="checked"> Сохранить</label></td>
            <td>
              <strong><?=$employment->Company->Name;?></strong><br>
              <?=$employment->Position;?>
            </td>
            <td><?=$employment->StartMonth?>/<?=$employment->StartYear?> - <?=$employment->EndMonth?>/<?=$employment->EndYear?></td>
          </tr>
        <?endforeach;?>
      </table>

    </div>

    <div class="span6">
      <table class="table table-bordered">
        <?foreach ($userSecond->Employments as $employment):?>
          <tr>
            <td>
              <?if ($employment->EndYear == null):?>
                <label class="radio"><input type="radio" name="EmploymentPrimary" value="<?=$employment->Id;?>"> Основное</label>
              <?endif;?>
            </td>
            <td><label class="checkbox"><input type="checkbox" name="Employment[]" value="<?=$employment->Id;?>" checked="checked"> Добавить</label></td>
            <td>
              <strong><?=$employment->Company->Name;?></strong><br>
              <?=$employment->Position;?>
            </td>
            <td><?=$employment->StartMonth?>/<?=$employment->StartYear?> - <?=$employment->EndMonth?>/<?=$employment->EndYear?></td>
          </tr>
        <?endforeach;?>
      </table>
    </div>
  </div>

<?if ($user->getContactAddress() !== null && $userSecond->getContactAddress()!== null):?>
  <div class="row-fluid">
    <div class="span12">
      <h3>Адрес</h3>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span6">
      <label class="radio"><input type="radio" name="Address" value="<?=$user->getContactAddress()->Id;?>" checked="checked"> <?=$user->getContactAddress();?></label>
    </div>
    <div class="span6">
      <label class="radio"><input type="radio" name="Address" value="<?=$userSecond->getContactAddress()->Id;?>"> <?=$userSecond->getContactAddress();?></label>
    </div>
  </div>
<?endif;?>

  <div class="btn-toolbar">
    <?=\CHtml::submitButton(\Yii::t('app', 'Подтвердить объединение'), array('class' => 'btn'));?>
  </div>

<?=\CHtml::endForm();?>