<?php
/**
 * @var \event\widgets\registration\Program $this
 * @var \event\models\section\Section $section,
 */

use event\models\RoleType;
?>
<?$this->beginWidget('\application\widgets\bootstrap\Modal', ['header' => $section->Title, 'id' => $this->getId().'_modal'.$section->Id])?>
    <?=$section->Info?>
    <?foreach($data->Links as $links):?>
        <?if($links[0]->Role->Type != RoleType::Speaker):?>
            <h5><?=\Yii::t('app', sizeof($links) > 1 ? 'Ведущие' : 'Ведущий')?>:</h5>
            <?foreach($links as $link):?>
                <p>
                    <?if($link->User !== null):?>
                        <?=\CHtml::link($link->User->getFullName(), $link->User->getUrl(), ['target' => '_blank'])?>
                        <?if($link->User->getEmploymentPrimary() !== null):?>
                            <br/><span class="muted"><?=$link->User->getEmploymentPrimary()->Company->Name?></span>
                        <?endif?>
                    <?php elseif ($link->Company !== null):?>
                        <?=\CHtml::link($link->Company->Name, $link->Company->getUrl())?>
                    <?php else:?>
                        <?=$link->CustomText?>
                    <?endif?>
                </p>
            <?endforeach?>
        <?php else:?>
            <h5><?=\Yii::t('app', 'Докладчики')?>:</h5>
            <ul>
                <?foreach($links as $link):?>
                    <li>
                        <?if($link->User !== null):?>
                            <?=\CHtml::link($link->User->getFullName(), $link->User->getUrl(), ['target' => '_blank'])?>
                            <?if($link->User->getEmploymentPrimary() !== null):?>
                                <br/><span class="muted"><?=$link->User->getEmploymentPrimary()->Company->Name?></span>
                            <?endif?>
                        <?php elseif ($link->Company !== null):?>
                            <?=\CHtml::link($link->Company->Name, $link->Company->getUrl())?>
                        <?php else:?>
                            <?=$link->CustomText?>
                        <?endif?>
                    </li>
                <?endforeach?>
            </ul>
        <?endif?>
    <?endforeach?>
<?$this->endWidget()?>
