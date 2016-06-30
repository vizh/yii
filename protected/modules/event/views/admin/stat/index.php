<?/**
 * @var \event\models\Event[] $events
 */
use application\components\utility\Texts;
use event\models\Approved;

?>


<div class="row-fluid">
    <div class="btn-toolbar clearfix">
        <?=\CHtml::form($this->createUrl('/event/admin/list/index'), 'GET', array('class' => 'form-inline pull-left'));?>
        <?=\CHtml::textField('Query', \Yii::app()->request->getParam('Query', ''), array('placeholder' => \Yii::t('app', 'ID или навзание мероприятия'), 'style' => 'margin-right:5px'));?>
        <?=\CHtml::submitButton(\Yii::t('app', 'Искать'), array('class' => 'btn'));?>
        <?=\CHtml::endForm();?>

        <a href="<?=$this->createUrl('/event/admin/edit/index');?>" class="btn btn-success pull-right"><?=\Yii::t('app', 'Добавить мероприятие');?></a>
    </div>
    <div class="well">
        <table class="table events table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Даты проведения</th>
                <th>Финансовые</th>
                <th>Участники</th>
                <th style="width: 26px;"></th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($events as $row):?>
                <?php
                /** @var \event\models\Event $event; */
                $event = $row['event'];
                ?>
                <tr>
                    <td><strong><?=$event->Id;?></strong></td>
                    <td>
                        <a href="<?=$this->createUrl('/event/admin/edit/index', array('eventId' => $event->Id));?>"><?=$event->Title;?></a><br/>
                        <small><?=Texts::cropText($event->IdName,50);?></small>
                    </td>
                    <td><?$this->widget('event\widgets\Date', array('event' => $event));?></td>
                    <td>
                        <div><?= $row['fin']['bank']; ?> оплаты по счету</div>
                        <div><?= $row['fin']['receipt']; ?> оплаты по картам</div>
                        <div><?= $row['fin']['online']; ?> электронные деньги</div>
                        <hr>
                        <div><?= $row['fin']['total']; ?> общие сборы</div>
                    </td>
                    <td>
                        <div><?= $row['part']['paid']; ?> оплативших</div>
                        <div><?= $row['part']['promo']; ?> промо-код</div>
                        <div><?= $row['part']['receipt']; ?> выставили счет</div>
                        <hr>
                        <div><?= $row['part']['total']; ?> участников всего</div>
                    </td>
                    <td class="buttons">
                        <div class="btn-group">
                            <?if (!$event->Deleted):?>
                                <a href="<?=$this->createUrl('/event/view/index', ['idName' => $event->IdName]);?>" class="btn" target="_blank"><i class="icon-share"></i></a>
                            <?endif;?>
                            <a href="<?=$this->createUrl('/event/admin/edit/index', ['eventId' => $event->Id]);?>" class="btn"><i class="icon-edit"></i></a>
                            <form action="<?= $this->createUrl('/partner/main/index'); ?>" method="post">
                                <input name="event_id" type="hidden" value="<?= $event->Id; ?>">
                                <button type="submit" class="btn" title="Партнерский интерфейс"><i class="icon-th-list"></i></button>
                            </form>

                        </div>
                    </td>
                </tr>
            <?endforeach;?>
            </tbody>
        </table>
    </div>
    <?$this->widget('application\widgets\Paginator', array(
        'paginator' => $paginator
    ));?>
</div>