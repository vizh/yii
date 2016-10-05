<?php
/**
 * @var \event\widgets\registration\Program $this
 * @var array $grid
 */

$formatter = \Yii::app()->getDateFormatter();

$modals = '';
?>
<div class="tabs">
    <ul class="nav">
        <?foreach($grid as $date => $data):?>
            <li><a href="#<?=$this->getNameId()?>-<?=$date?>" class="pseudo-link"><?=$formatter->format('dd MMMM yyyy', $date)?></a></li>
        <?endforeach?>
    </ul>
    <?foreach($grid as $date => $data):?>
        <div class="tab" id="<?=$this->getNameId()?>-<?=$date?>">
            <table class="table m-bottom_50">
                <thead>
                <th></th>
                <?/** @var \event\models\section\Hall $hall */?>
                <?foreach($data->Halls as $hall):?>
                    <th><?=$hall->Title?></th>
                <?endforeach?>
                </thead>
                <tbody>
                <?php foreach($data->Intervals as $time => $label):?>
                    <?$colspan = 0?>
                    <?$flag = true?>
                    <?foreach($data->Halls as $hallId => $hall):?>
                        <?/** @var \event\models\section\Section $section */?>
                        <?$section = isset($data->Sections[$hallId][$time]) ? $data->Sections[$hallId][$time]->Section : null?>
                        <?if($flag):?>
                            <tr <?if(isset($data->Sections[$hallId][$time]) && $data->Sections[$hallId][$time]->ColSpan == sizeof($data->Halls) && $data->Sections[$hallId][$time]->Section->TypeId == 4):?>class="info"<?endif?>>
                            <td class="time">
                                <?if($this->getEvent()->IdName == 'next2015' && trim($label) == '12:25 &mdash; 12:30'): //TODO: Костыль для next2015?>
                                <?else:?>
                                    <?=$label?>
                                <?endif?>
                            </td>
                            <?$flag = false?>
                        <?endif?>
                        <?if($section !== null):?>
                            <?php
                                $colspan = $data->Sections[$hallId][$time]->ColSpan;
                                $this->render('program/grid-item', ['section' => $section, 'colspan' => $colspan, 'data' => $data->Sections[$hallId][$time]]);
                                $modals .= $this->render('program/grid-item-modal', ['section' => $section, 'data' => $data->Sections[$hallId][$time]], true);
                           ?>
                        <?php elseif ($colspan <= 0):?>
                            <td></td>
                        <?endif?>
                        <?$colspan--?>
                    <?endforeach?>
                    </tr>
                <?endforeach?>
                </tbody>
            </table>
            <?=$modals?>
        </div>
    <?endforeach?>
</div>