<?php
/**
 * @var \widget\components\Controller $this
 * @var \application\widgets\ActiveForm $activeForm
 */
use event\models\UserData;
use application\components\attribute\BooleanDefinition;

$userData = new UserData();
$userData->EventId = $this->getEvent()->Id;

$manager = $userData->getManager();
if (!$manager->hasDefinitions(true)) {
    return;
}
?>
<div class="user-data" userdata ng-if="participant.userdata" data-user="{{participant}}" data-product="{{product}}" data-index="{{$index}}">
    <?$activeForm = $this->beginWidget('\application\widgets\ActiveForm')?>
    <h4 class="text-center">{{participant.FullName}}, RUNET-ID {{participant.RunetId}}</h4>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="alert alert-danger hide">
                <ul></ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <?foreach($manager->getGroups() as $group):?>
                <?php
                $groupTitleShow = false;
                foreach ($group->getDefinitions() as $definition):?>
                    <?if(!$definition->public) continue?>
                    <?if(!$groupTitleShow && !empty($group->title)):?>
                        <h4 class="group-title"><?=$group->title?></h4>
                        <?$groupTitleShow = true?>
                    <?endif?>
                    <?if($definition instanceof BooleanDefinition):?>
                        <div class="checkbox">
                            <?=$definition->activeEdit($manager, ['ng-model' => 'participant.' . $definition->name])?>
                        </div>
                    <?php else:?>
                        <div class="form-group">
                            <?=$activeForm->label($manager, $definition->title)?>
                            <?=$definition->activeEdit($manager, ['class' => 'form-control', 'ng-model' => 'participant.' . $definition->name])?>
                        </div>
                    <?endif?>
                <?endforeach?>
            <?endforeach?>
            <div class="text-center">
                <?=\CHtml::submitButton(\Yii::t('app', 'Загеристрировать'), ['class' => 'btn btn-primary', 'ngClick' => 'submit'])?>
                <?=\CHtml::button(\Yii::t('app', 'Отмена'), ['class' => 'btn btn-warning', 'ng-click' => 'hideUserDataForm(product, $index)'])?>
            </div>
        </div>
    </div>
    <?$this->endWidget()?>
</div>

