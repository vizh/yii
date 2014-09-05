<?php
/**
 * @var \event\models\Event $event
 * @var string[] $definedAttributes
 */
$definedAttributes = isset($definedAttributes) ? $definedAttributes : [];

use application\components\attribute\ListDefinition;
use event\models\UserData;
use application\components\attribute\BooleanDefinition;
use application\components\attribute\Definition;
use event\components\UserDataManager;

$userData = new UserData();
$userData->EventId = $event->Id;

if (!$userData->getManager()->hasDefinitions()) {
    return;
}


$printEditArea = function(Definition $definition, UserDataManager $manager) use ($definedAttributes)
{
    ?>
    <?if ($definition instanceof BooleanDefinition):?>
    <div class="control-group">
        <?=$definition->activeEdit($manager);?>
    </div>
<?elseif($definition instanceof ListDefinition && $definition->required):?>
    <label <?if(in_array($definition->name, $definedAttributes)):?>class="defined-attribute required"<?else:?>class="required"<?endif;?>><?=$definition->title;?></label>
    <?=$definition->activeEdit($manager);?>
<?else:?>
    <div class="control-group">
        <label <?if(in_array($definition->name, $definedAttributes)):?>class="defined-attribute"<?endif;?>><?=$definition->title;?></label>
        <?if ($definition->required):?>
            <div class="required"><?=$definition->activeEdit($manager);?></div>
        <?else:?>
            <?=$definition->activeEdit($manager);?>
        <?endif;?>
    </div>
<?endif;?>
<?
}
?>

<?foreach ($userData->getManager()->getGroups() as $group):?>
    <?if (count($group->getDefinitions()) !== 0):?>
        <div class="clearfix">
            <?if (!empty($group->title)):?>
                <h5 class="title"><?=$group->title;?></h5>
            <?endif;?>

            <div class="pull-left">
                <?
                $i=0;
                foreach ($group->getDefinitions() as $definition) {
                    $i++;
                    if ($i % 2 == 0) continue;
                    $printEditArea($definition, $userData->getManager());
                }
                ?>
            </div>
            <div class="pull-right">
                <?
                $i=0;
                foreach ($group->getDefinitions() as $definition) {
                    $i++;
                    if ($i % 2 == 1) continue;
                    $printEditArea($definition, $userData->getManager());
                }
                ?>
            </div>
        </div>
    <?endif;?>
<?endforeach;?>

<?if (!empty($definedAttributes)):?>
<small class="muted required-notice">Поля <span class="text-success">отмеченные зеленым цветом</span> заполнялись ранее и могут быть пропущены</small>
<small class="muted required-notice"><span class="required-asterisk">*</span> &mdash; поля обязательны для заполнения</small>
<?endif;?>