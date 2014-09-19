<h2 class="m-bottom_30"><?=\Yii::t('app', 'Статусы мероприятия');?></h2>
<table class="table table-striped">
  <thead>
    <th colspan="2"><?=\Yii::t('app', 'Статусы');?></th>
    <th><?=\Yii::t('app', 'Цвет');?></th>
  </thead>
  <tbody>

  </tbody>
  <tfoot>
    <tr style="background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAFUlEQVQImWNgQAOPHz/+T3UBBgYGAL+IEklz7bqmAAAAAElFTkSuQmCC);">
      <td colspan="3">
        <form class="form-inline" style="margin-bottom: 0;">
          <?=\CHtml::textField('Role', '', ['placeholder' => 'Добавить новый статус', 'class' => 'input-xlarge']);?>
          <button type="button" class="btn hide"><?=\Yii::t('app', 'Добавить');?></button>
        </form>
      </td>
    </tr>
  </tfoot>
</table>