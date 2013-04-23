<?php
/**
 * @var $roles \event\models\Role[]
 * @var $users \user\models\User[]
 * @var $paginator \application\components\utility\Paginator
 * @var $form \partner\models\forms\ParticipantSearch
 */

$roleList = array(
  '' => 'Все зарегистрированные'
);
foreach ($roles as $role)
{
  $roleList[$role->Id] = $role->Title;
}
?>

  <div class="row">
    <div class="span12">
      <?=CHtml::beginForm(Yii::app()->createUrl('/partner/user/index/'), 'get');?>
      <div class="row">
        <div class="span4">
          <?=CHtml::activeLabel($form, 'User');?>
          <?=CHtml::activeTextField($form, 'User', array('placeholder' => 'ФИО, RUNET-ID или E-mail'));?>
        </div>
        <div class="span4">
          <?=CHtml::activeLabel($form, 'Role');?>
          <?=CHtml::activeDropDownList($form, 'Role', $roleList);?>
        </div>
        <div class="span4">
          <?=CHtml::activeLabel($form, 'Sort');?>
          <?=CHtml::activeDropDownList($form, 'Sort', $form->getSortValues(), array('encode' => false));?>
        </div>
      </div>

      <div class="row indent-top2">
        <div class="span2">
          <button class="btn btn-large" type="submit"><i class="icon-search"></i> Искать</button>
        </div>
        <div class="span3">
          <button class="btn btn-large" type="submit" name="reset" value="reset">Сбросить</button>
        </div>
      </div>
      <?=CHtml::endForm();?>
    </div>
  </div>

  <h3>Всего по запросу <?=\Yii::t('', '{n} участник|{n} участника|{n} участников|{n} участника', $paginator->getCount());?></h3>


<?if (sizeof($users) > 0):?>
  <table class="table table-striped">
    <thead>
    <tr>
      <th>RUNET-ID</th>
      <th>Ф.И.О.</th>
      <th>Работа</th>
      <th>Статус</th>
      <!--<th>Управление</th>-->
    </tr>
    </thead>
    <tbody>
    <?foreach ($users as $user):?>
      <tr>
        <td><h3><a target="_blank" href="<?=$user->getProfileUrl();?>"><?=$user->RunetId;?></a></h3></td>
        <td>
          <strong><?=$user->getFullName();?></strong>
          <p>
            <em><?=$user->Email;?></em>
          </p>
          <?if (sizeof($user->LinkPhones)):?>
            <p><em><?=$user->LinkPhones[0]->Phone;?></em></p>
          <?php endif;?>
        </td>
        <td width="30%">
          <?if ($user->getEmploymentPrimary() !== null):?>
              <strong><?=$user->getEmploymentPrimary()->Company->Name;?></strong>
            <p class="position"><?=$user->getEmploymentPrimary()->Position;?></p>
          <?else:?>
            Место работы не указано
          <?endif;?>
        </td>
        <td>
          <?if (sizeof($user->Participants) == 1):?>
            <?=$user->Participants[0]->Role->Title;?><br/>
            <em><?=Yii::app()->dateFormatter->formatDateTime($user->Participants[0]->CreationTime, 'long');?></em>
          <?else:?>
              <?foreach ($user->Participants as $participant):?>
                <?if (!empty($participant->Part)):?>
                <p>
                  <strong><?=$participant->Part->Title;?></strong> - <?=$participant->Role->Title;?><br/>
                  <em><?php echo Yii::app()->dateFormatter->formatDateTime($participant->CreationTime, 'long');?></em>
                </p>
                <?endif;?>
              <?endforeach;?>
          <?endif;?>
        </td>
        <!--<td><a href="<?=Yii::app()->createUrl('/partner/user/edit', array('runetId' => $user->RunetId));?>" class="btn btn-info">Редактировать</a></td>-->
      </tr>
    <?php endforeach;?>
    </tbody>
  </table>
<?php else:?>
  <div class="alert">По Вашему запросу нет ни одного участника.</div>
<?php endif;?>

<?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>