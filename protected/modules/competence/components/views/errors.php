<?php
/**
 * @var $this \competence\components\ErrorsWidget
 */
$errors = $this->form->getErrors();
?>

<? if (!empty($errors)): ?>
	<div class="alert alert-error">
		<a class="close" data-dismiss="alert" href="#">×</a>
        <? foreach ($errors as $error): ?>
            <?=implode('<br>', $error)?><br>
        <? endforeach ?>
	</div>
<? endif ?>