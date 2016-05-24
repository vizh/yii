<?php

/**
 * @var MainController $this
 * @var competence\models\Test $test
 * @var competence\models\Question[] $questions
 * @var competence\models\form\NewQuestion $form
 * @var array $types
 */

$this->pageTitle = 'Список вопросов теста';
?>
    <h2><?= CHtml::encode($test->Title) ?></h2>

    <div class="btn-toolbar clearfix">
        <a class="btn" href="<?=Yii::app()->createUrl('/competence/admin/main/index');?>"><i class="icon-arrow-left"></i> Список тестов</a>
    </div>

    <div class="well">
        <?= CHtml::form('', 'POST', ['class' => 'form-horizontal']) ?>
        <h4>Создать новый вопрос</h4>

        <?= CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>') ?>

        <div class="control-group">
            <?= CHtml::activeLabel($form, 'Code', ['class' => 'control-label']) ?>
            <div class="controls">
                <?= CHtml::activeTextField($form, 'Code', ['autocomplete' => 'off']) ?>
            </div>
        </div>

        <div class="control-group">
            <?= CHtml::activeLabel($form, 'Type', ['class' => 'control-label']) ?>
            <div class="controls">
                <?= CHtml::activeDropDownList($form, 'Type', CHtml::listData($types, 'Id', 'Title')) ?>
            </div>
        </div>

        <div class="control-group" style="margin-bottom: 0;">
            <div class="controls">
                <button class="btn btn-success" type="submit" name="newQuestion"
                        value="1"><?= Yii::t('app', 'Создать вопрос') ?></button>
            </div>
        </div>

        <?= CHtml::endForm() ?>
    </div>

<?= CHtml::form('', 'POST'); ?>
    <div class="btn-toolbar clearfix">
        <input type="submit" value="Сохранить изменения" name="saveChanges" class="btn btn-success pull-right">
    </div>

    <div class="well">


        <table class="table">
            <thead>
            <tr>
                <th><?= Yii::t('app', 'Код'); ?></th>
                <th>Тип</th>
                <th>Вопрос</th>
                <th>Предыдущий</th>
                <th>Следующий</th>
                <th>Первый/последний</th>
                <th>Сортировка</th>
                <th></th>
            </tr>
            </thead>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?= $question->Code ?></td>
                    <td><?= $question->Type->Title ?></td>
                    <td><?= $question->Title ?></td>
                    <td>
                        <select class="span1" name="question[<?= $question->Id ?>][PrevId]" id="">
                            <option value="0">&nbsp;-&nbsp;</option>
                            <?php foreach ($questions as $q2): ?>
                                <?php if ($question->Id == $q2->Id) continue; ?>
                                <option
                                    value="<?= $q2->Id; ?>" <?= $question->PrevQuestionId == $q2->Id ? 'selected="selected"' : ''; ?> ><?= $q2->Code ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                    <td>
                        <select class="span1" name="question[<?= $question->Id ?>][NextId]" id="">
                            <option value="0">&nbsp;-&nbsp;</option>
                            <?php foreach ($questions as $q2): ?>
                                <?php if ($question->Id == $q2->Id) continue; ?>
                                <option
                                    value="<?= $q2->Id; ?>" <?= $question->NextQuestionId == $q2->Id ? 'selected' : ''; ?> ><?= $q2->Code ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                    <td>
                        <label class="checkbox">
                            <input type="checkbox" name="question[<?= $question->Id ?>][First]"
                                   value="1" <?= $question->First ? 'checked' : '' ?> /> Первый
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="question[<?= $question->Id ?>][Last]"
                                   value="1" <?= $question->Last ? 'checked' : '' ?> /> Последний
                        </label>
                    </td>
                    <td>
                        <input type="text" class="span1" name="question[<?= $question->Id ?>][Sort]"
                               value="<?= $question->Sort; ?>"/>
                    </td>
                    <td>
                        <a href="<?= $this->createUrl('/competence/admin/main/editQuestion', ['id' => $question->Id]) ?>"
                           class="btn btn-mini"><?= \Yii::t('app', 'Редактировать') ?></a></td>
                </tr>
            <?php endforeach ?>
        </table>

    </div>

    <div class="btn-toolbar clearfix">
        <input type="submit" value="Сохранить изменения" name="saveChanges" class="btn btn-success pull-right">
    </div>


<?= CHtml::endForm() ?>
