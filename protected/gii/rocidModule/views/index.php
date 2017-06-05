<h1>Module Generator</h1>

<p>This generator helps you to generate the skeleton code needed by a Yii module.</p>

<? $form = $this->beginWidget('CCodeForm', ['model' => $model]) ?>

<div class="row">
    <?=$form->labelEx($model, 'moduleID')?>
    <?=$form->textField($model, 'moduleID', ['size' => 65])?>
	<div class="tooltip">
		Module ID is case-sensitive. It should only contain word characters.
		The generated module class will be named after the module ID.
		For example, a module ID <code>forum</code> will generate the module class
		<code>ForumModule</code>.
	</div>
    <?=$form->error($model, 'moduleID')?>
</div>

<? $this->endWidget() ?>
