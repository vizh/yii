<?php
use partner\components\Controller;
use user\models\User;

/**
 * @var Controller $this
 * @var User $user
 * @var \user\models\Document $document
 */
?>
<div class="panel panel-info panel-dark">
    <div class="panel-heading">
        <span class="panel-title">&nbsp;</span>
        <ul class="nav nav-tabs nav-tabs-xs">
            <?php foreach ($user->Documents as $i => $document):?>
                <li <?php if ($i === 0):?>class="active"<?php endif;?>>
                    <a href="#document<?=$document->Type->Id;?>" data-toggle="tab"><?=$document->Type->Title;?></a>
                </li>
            <?php endforeach;?>
        </ul> <!-- / .nav -->
    </div> <!-- / .panel-heading -->
    <div class="tab-content">
    <?php foreach ($user->Documents as $i => $document):?>
        <div class="tab-pane fade <?php if ($i === 0):?>active in<?php endif;?>" id="document<?=$document->Type->Id;?>">
            <table class="table">
                <tbody>
                    <?php
                    $form = $document->getForm($user);
                    foreach ($form->attributeLabels() as $attribute => $label):?>
                        <tr>
                            <td class="text-right" style="width: 200px;"><?=\CHtml::tag('strong', [], $label);?>:</td>
                            <td class="text-left"><?=$form->$attribute;?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    <?php endforeach;?>
    </div>
</div>
