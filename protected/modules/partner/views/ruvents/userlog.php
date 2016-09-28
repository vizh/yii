<div class="row">
  <div class="span1 m-top_5">
    <?=\CHtml::image($user->getPhoto()->get58px())?>
  </div>
  <div class="span11">
    <h2 style="margin-top: 0"><?=\Yii::t('app', 'Активность пользователя')?> <?=$user->getFullName()?></h2>
    <?$employment = $user->getEmploymentPrimary()?>
    <?if($employment !== null):?>
      <p><?=$employment->Company->Name?><?if(!empty($employment->Position)):?>, <?=$employment->Position?><?endif?></p>
    <?endif?>
    <?if(!empty($backUrl)):?>
      <a href="<?=$backUrl?>" class="btn">&larr; <?=\Yii::t('app', 'Назад')?></a>
    <?endif?>
  </div>
</div>

<hr/>

<?if(!empty($logs)):?>
  <table class="table">
    <thead>
      <th><?=\Yii::t('app', 'Время')?></th>
      <th><?=\Yii::t('app', 'Логин оператора')?></th>
      <th><?=\Yii::t('app', 'Действие')?></th>
      <th><?=\Yii::t('app', 'Параметры')?></th>
    </thead>
    <tbody>
      <?foreach($logs as $log):?>
      <tr <?if($log->Action == 'badge'):?>class="success"<?endif?>>
        <td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm:ss', $log->CreationTime)?></td>
        <td><?=$log->Operator->Login?></td>
        <td><?=$log->getActionMessage()?></td>
        <td>
          <table class="table table-bordered">
            <?foreach($log->Data as $item):?>
              <tr>
                <td style="width: 25%"><?=$item->Field?></td>
                <?if($item->To == null):?>
                  <td colspan="2"><?=$item->From?></td>
                <?else:?>
                  <td><?=$item->From?></td>
                  <td><?=$item->To?></td>
                <?endif?>
              </tr>
            <?endforeach?>
          </table>
        </td>
      </tr>
      <?endforeach?>
    </tbody>
  </table>
<?else:?>
  <div class="alert alert-error"><?=\Yii::t('app', 'Не найдена активность по данному пользователю.')?></div>
<?endif?>