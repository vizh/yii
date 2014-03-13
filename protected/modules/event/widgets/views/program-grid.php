<?php
/**
 * @var $this \event\widgets\ProgramGrid
 */
?>

<div id="<?=$this->getNameId();?>" class="tab">
  <?foreach ($grid as $date => $data):?>
    <h4><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $date);?></h4>
    <table class="table m-bottom_50">
      <thead>
        <th></th>
        <?/** @var \event\models\section\Hall $hall */?>
        <?foreach ($data->Halls as $hall):?>
          <th><?=$hall->Title;?></th>
        <?endforeach;?>
      </thead>
      <tbody>
        <?foreach($data->Intervals as $time => $label):?>
          <?$colspan = 0;?>
          <?$flag = true;?>
          <?foreach ($data->Halls as $hallId => $hall):?>
            <?/** @var \event\models\section\Section $section */?>
            <?$section = isset($data->Sections[$hallId][$time]) ? $data->Sections[$hallId][$time]->Section : null;?>
            <?if ($flag):?>
              <tr <?if ($data->Sections[$hallId][$time]->ColSpan == sizeof($data->Halls)):?>class="info"<?endif;?>>
                <td class="time"><?=$label;?></td>
                <?$flag = false;?>
            <?endif;?>
            <?if ($section !== null):?>
              <?$colspan = $data->Sections[$hallId][$time]->ColSpan;?>
              <td colspan="<?=$colspan;?>">
                <?$section = $data->Sections[$hallId][$time]->Section;?>
                <h4><?=$section->Title;?></h4>
                <?/** @var \event\models\section\Role $role */?>
                <?foreach ($data->Sections[$hallId][$time]->Roles as $role):?>
                  <div class="m-bottom_10">
                  <?if ($role->Role->Type != \event\models\RoleType::Speaker):?>
                    <b><?=\Yii::t('app', sizeof($role->Users) > 1 ? 'Ведущие' : 'Ведущий');?>:</b><br/>
                    <?foreach ($role->Users as $user):?>
                      <a href="<?=$user->getUrl();?>"><?=$user->getFullName();?></a>
                      <?if ($user->getEmploymentPrimary() !== null):?>(<?=$user->getEmploymentPrimary()->Company->Name;?>)<?endif;?><br/>
                    <?endforeach;?>
                  <?else:?>
                    <?=\Yii::t('app', 'Докладчики');?>:
                    <?/** @var \user\models\User $user */;?>
                    <ul>
                    <?foreach ($role->Users as $user):?>
                      <li><a href="<?=$user->getUrl();?>"><?=$user->getFullName();?></a>
                      <?if ($user->getEmploymentPrimary() !== null):?>(<?=$user->getEmploymentPrimary()->Company->Name;?>)<?endif;?></li>
                    <?endforeach;?>
                    </ul>
                  <?endif;?>
                  </div>
                <?endforeach;?>
              </td>
            <?elseif ($colspan <= 0):?>
              <td></td>
            <?endif;?>
            <?$colspan--;?>
          <?endforeach;?>
          </tr>
        <?endforeach;?>
      </tbody>
    </table>
  <?endforeach;?>
</div>