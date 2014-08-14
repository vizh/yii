<?php
/**
 * @var $this \event\widgets\ProgramGrid
 */
use event\models\section\LinkUser;

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
                  <?if (!empty($section->Info)):?>
                  <p><?=$section->Info;?></p>
                  <?endif;?>
                <?/** @var LinkUser[] $links */?>
                <?foreach ($data->Sections[$hallId][$time]->Links as $links):?>
                  <div class="m-bottom_10">
                  <?if ($links[0]->Role->Type != \event\models\RoleType::Speaker):?>
                    <b><?=\Yii::t('app', sizeof($links) > 1 ? 'Ведущие' : 'Ведущий');?>:</b><br/>
                    <?foreach ($links as $link):?>
                          <?if ($link->User != null):?>
                              <a href="<?=$link->User->getUrl();?>"><?=$link->User->getFullName();?></a>
                              <?if ($link->User->getEmploymentPrimary() !== null):?>(<?=$link->User->getEmploymentPrimary()->Company->Name;?>)<?endif;?>
                          <?elseif ($link->Company != null):?>
                              <a href="<?=$link->Company->getUrl();?>"><?=$link->Company->Name;?></a>
                          <?else:?>
                              <?=$link->CustomText;?>
                          <?endif;?>
                      <br/>
                    <?endforeach;?>
                  <?else:?>
                    <?=\Yii::t('app', 'Докладчики');?>:
                    <?/** @var \user\models\User $user */;?>
                    <ul>
                    <?foreach ($links as $link):?>
                      <li>
                          <?if (!empty($link->Report->Title)):?>
                          <strong><?=$link->Report->Title;?></strong><br>
                          <?endif;?>
                          <?if ($link->User != null):?>
                              <a href="<?=$link->User->getUrl();?>"><?=$link->User->getFullName();?></a>
                              <?if ($link->User->getEmploymentPrimary() !== null):?>(<?=$link->User->getEmploymentPrimary()->Company->Name;?>)<?endif;?>
                          <?elseif ($link->Company != null):?>
                              <a href="<?=$link->Company->getUrl();?>"><?=$link->Company->Name;?></a>
                          <?else:?>
                              <?=$link->CustomText;?>
                          <?endif;?>
                      </li>
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