<div class="btn-toolbar">
  <form method="get" class="form-inline">
    <input type="text" name="Query" placeholder="<?=Yii::t('app', 'RUNET&mdash;ID, E-mail, фамилия или название компании');?>" class="input-xxlarge" value="<?=\Yii::app()->getRequest()->getParam('Query');?>"/>
    <input type="submit" class="btn" value="<?=\Yii::t('app', 'Искать');?>"/>
  </form>
</div>
<div class="well">
  <table class="table">
    <thead>
      <th colspan="3"><?=\Yii::t('app', 'Список пользователей');?></th>
    </thead>
    <tbody>
    <?foreach ($results as $result):?>
      <tr>
        <?if (get_class($result) == 'user\models\User'):?>
          <?=$this->renderPartial('user-row', ['user' => $result]);?>
        <?elseif (get_class($result) == 'company\models\Company'):?>
          <td></td>
          <td colspan="2">
            <h2><?=$result->Name;?></h2>
            <table class="table">
              <?foreach ($result->Employments as $employment):?>
                <tr>
                <?=$this->renderPartial('user-row', ['user' => $employment->User]);?>
                </tr>
              <?endforeach;?>
            </table>
          </td>
        <?endif;?>
      </tr>
    <?endforeach;?>
    </tbody>
  </table>
  <?$this->widget('\application\widgets\Paginator', ['paginator' => $paginator]);?>
</div>