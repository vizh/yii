<?php
/**
 * @var Invite $this
 */

use application\components\attribute\BooleanDefinition;
use application\components\attribute\Definition;
use event\widgets\Invite;

$userDataManager = $this->userData->getManager();
$oneColumn = count($userDataManager->getDefinitions()) <= 5;

$printEditArea = function(Definition $definition) use ($userDataManager)
{
   ?>
    <?if($definition instanceof BooleanDefinition):?>
    <div class="control-group">
        <?=$definition->activeEdit($userDataManager)?>
    </div>
<?else:?>
    <div class="control-group">
        <label><?=$definition->title?></label>
        <?if($definition->required):?>
            <div class="required"><?=$definition->activeEdit($userDataManager)?></div>
        <?else:?>
            <?=$definition->activeEdit($userDataManager)?>
        <?endif?>
    </div>
<?endif?>
<?
}
?>

<div class="form-user-register">
    <?foreach($userDataManager->getGroups() as $group):?>
        <?if(count($group->getDefinitions()) !== 0):?>
            <div class="clearfix">
                <?if(!empty($group->title)):?>
                    <h5><?=$group->title?></h5>
                <?endif?>

                <?if($oneColumn):?>
                    <?foreach($group->getDefinitions() as $definition):?>
                        <?$printEditArea($definition)?>
                    <?endforeach?>
                <?php else:?>
                    <div class="pull-left">
                        <?
                        $i=0;
                        foreach ($group->getDefinitions() as $definition) {
                            $i++;
                            if ($i % 2 == 0) continue;
                            $printEditArea($definition);
                        }
                       ?>
                    </div>
                    <div class="pull-right">
                        <?
                        $i=0;
                        foreach ($group->getDefinitions() as $definition) {
                            $i++;
                            if ($i % 2 == 1) continue;
                            $printEditArea($definition);
                        }
                       ?>
                    </div>
                <?endif?>
            </div>
        <?endif?>
    <?endforeach?>

    <small class="muted required-notice">
        <span class="required-asterisk">*</span> &mdash; <?=\Yii::t('app', 'поля обязательны для заполнения')?>
    </small>
</div>



