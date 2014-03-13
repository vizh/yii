<div class="row">
  <div class="span12">
    <h2 class="m-bottom_30"><?=\Yii::t('app', 'Список залов');?></h2>
    <?if (!empty($forms)):?>
      <?if (\Yii::app()->getUser()->hasFlash('success')):?>
        <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
      <?endif;?>
      <div class="btn-group text-center m-bottom_20">
        <?foreach (\Yii::app()->params['Languages'] as $l):?>
          <a href="<?=$this->createUrl('/partner/program/hall', ['locale' => $l]);?>" class="btn <?if ($l == $locale):?>active<?endif;?>"><?=$l;?></a>
        <?endforeach;?>
      </div>
      <table class="table">
        <thead>
          <th><?=\Yii::t('app', 'Название');?></th>
          <th><?=\Yii::t('app', 'Сортировка');?></th>
        </thead>
        <tbody>
          <?/** @var \CFormModel $form */?>
          <?foreach ($forms as $form):?>
            <?=\CHtml::form();?>
            <?=\CHtml::errorSummary($form, '<tr><td colspan="3"><div class="alert alert-error m-bottom_0">', '</div></td></tr>');?>
            <tr>
              <td><?=\CHtml::activeTextField($form, 'Title', ['class' => 'input-block-level m-bottom_0']);?></td>
              <td><?=\CHtml::activeTextField($form, 'Order', ['class' => 'input-mini m-bottom_0']);?></td>
              <td class="text-right">
                <button type="submit" class="btn btn-success" name=""><?=\Yii::t('app', 'Сохранить');?></button>
                <?if (\event\models\section\LinkHall::model()->byHallId($form->Id)->exists() == false):?>
                  <button type="submit" class="btn btn-danger" name="<?=\CHtml::activeName($form, 'Delete');?>" value="1"><?=\Yii::t('app', 'Удалить');?></button>
                <?endif;?>
              </td>
              <?=\CHtml::activeHiddenField($form, 'Id');?>
            </tr>
            <?=\CHtml::endForm();?>
          <?endforeach;?>
        </tbody>
      </table>
    <?else:?>
      <div class="alert-error alert"><?=\Yii::t('app', 'В программу мероприятия не добавлено ни одного зала.');?></div>
    <?endif;?>
  </div>
</div>