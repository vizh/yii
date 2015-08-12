<?php
/**
 * @var \event\widgets\registration\Program $this
 * @var \event\models\section\Section $section,
 */

use event\models\RoleType;
?>
<?php $this->beginWidget('\application\widgets\bootstrap\Modal', ['header' => $section->Title, 'id' => $this->getId().'_modal'.$section->Id]);?>
    <?=$section->Info;?>
    <?php foreach ($data->Links as $links):?>
        <?php if ($links[0]->Role->Type != RoleType::Speaker):?>
            <h5><?=\Yii::t('app', sizeof($links) > 1 ? 'Ведущие' : 'Ведущий');?>:</h5>
            <?php foreach ($links as $link):?>
                <p>
                    <?php if ($link->User !== null):?>
                        <?=\CHtml::link($link->User->getFullName(), $link->User->getUrl(), ['target' => '_blank']);?>
                        <?php if ($link->User->getEmploymentPrimary() !== null):?>
                            <br/><span class="muted"><?=$link->User->getEmploymentPrimary()->Company->Name;?></span>
                        <?php endif;?>
                    <?php elseif ($link->Company !== null):?>
                        <?=\CHtml::link($link->Company->Name, $link->Company->getUrl());?>
                    <?php else:?>
                        <?=$link->CustomText;?>
                    <?php endif;?>
                </p>
            <?php endforeach;?>
        <?php else:?>
            <h5><?=\Yii::t('app', 'Докладчики');?>:</h5>
            <ul>
                <?php foreach ($links as $link):?>
                    <li>
                        <?php if ($link->User !== null):?>
                            <?=\CHtml::link($link->User->getFullName(), $link->User->getUrl(), ['target' => '_blank']);?>
                            <?php if ($link->User->getEmploymentPrimary() !== null):?>
                                <br/><span class="muted"><?=$link->User->getEmploymentPrimary()->Company->Name;?></span>
                            <?php endif;?>
                        <?php elseif ($link->Company !== null):?>
                            <?=\CHtml::link($link->Company->Name, $link->Company->getUrl());?>
                        <?php else:?>
                            <?=$link->CustomText;?>
                        <?php endif;?>
                    </li>
                <?php endforeach;?>
            </ul>
        <?php endif;?>
    <?php endforeach;?>
<?php $this->endWidget();?>
