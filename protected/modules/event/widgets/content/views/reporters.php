<?php
/**
 * @var \event\widgets\content\Reporters $this
 */

use \application\components\utility\Texts;
?>
<div id="<?=$this->getNameId()?>" <?if($this->event->FullWidth):?>class="full-width"<?endif?>>
    <ul class="media-list">
        <?php foreach($this->getUsers() as $user):?>
            <li class="media-body">
                <?=\CHtml::link(\CHtml::image($user->getPhoto()->get90px(),'', ['class' => 'media-object img-circle']), $user->getUrl(), ['class' => 'pull-left'])?>
                <div>
                    <h4 class="media-heading"><?=\CHtml::link($user->getFullName(), $user->getUrl())?></h4>
                    <?=Texts::cropText($user->getEmploymentPrimary(), 50)?>
                </div>
            </li>
        <?endforeach?>
    </ul>
</div>
