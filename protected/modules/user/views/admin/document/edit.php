<?php
/**
 * @var BaseDocument[] $forms
 * @var User $user
 * @var \application\components\controllers\AdminMainController $this
 */

use \user\models\forms\document\BaseDocument;
use user\models\User;
use application\helpers\Flash;

$this->setPageTitle('Документы удостоверяющие личность: ' . $user->getFullName());
?>
<div class="btn-toolbar">
    <?php if (!empty($backUrl)):?>
        <?=\CHtml::link('&larr; Вернуться', $backUrl, ['class' => 'btn']);?>
    <?php endif;?>
</div>
<div class="well">
    <?=Flash::html();?>
    <div class="accordion">
        <?php foreach ($forms as $form):?>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" href="#document-<?=$form->getDocumentType()->FormName;?>">
                    <?=$form->getTitle();?>
                    <?php if ($form->isUpdateMode()):?>
                        <span class="label label-success pull-right">Задан</span>
                    <?php else:?>
                        <span class="label pull-right">Не задан</span>
                    <?php endif;?>
                </a>
            </div>
            <div id="document-<?=$form->getDocumentType()->FormName;?>" class="accordion-body collapse <?php if ($form->hasErrors()):;?>in<?php endif;?>">
                <div class="accordion-inner">
                    <?=$form->renderEditView($this);?>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>