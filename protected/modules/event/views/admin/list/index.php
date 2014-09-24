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
        <table class="table events">
            <thead>
            <tr>
                <th>ID</th>
                <th>Код</th>
                <th>Лого</th>
                <th>Название</th>
                <th>Тип</th>
                <th>Опции</th>
                <th>Даты проведения</th>
                <th style="width: 26px;"></th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($events as $event):?>
                <?/** @var \event\models\Event $event; */?>
                <?
                $class = null;
                if  ($event->Visible)
                    $class = 'success';
                elseif ($event->External && $event->Approved == Approved::None)
                    $class = 'muted';
                elseif ($event->External && $event->Approved == Approved::No)
                    $class = 'error';
                ?>

                <tr <?if (!empty($class)):?>class="<?=$class;?><?endif;?>">
                    <td><strong><?=$event->Id;?></strong></td>
                    <td><?=Texts::cropText($event->IdName,50);?></td>
                    <td><?=\CHtml::image($event->getLogo()->getMini());?></td>
                    <td><a href="<?=$this->createUrl('/event/admin/edit/index', array('eventId' => $event->Id));?>"><?=$event->Title;?></a></td>
                    <td><label class="label"><?=$event->Type->Title;?></label></td>
                    <td class="icons">
                        <i class="icon-eye-open <?if (!$event->ShowOnMain):?>muted<?endif;?>" title="Опубликовано на главной"></i>
                        <i class="icon-fullscreen <?if (!isset($event->Top) || $event->Top == 0):?>muted<?endif;?>" title="Используется выделение в большой блок"></i>
                        <i class="icon-list <?if (empty($event->LinkProfessionalInterests)):?>muted<?endif;?>" title="Проставлены проф. интересы"></i>
                    </td>
                    <td><?$this->widget('event\widgets\Date', array('event' => $event));?></td>
                    <td class="buttons">
                        <div class="btn-group">
                            <?if (!$event->Deleted):?>
                                <a href="<?=$this->createUrl('/event/admin/list/index', ['EventId' => $event->Id, 'Action' => 'Delete', 'BackUrl' => \Yii::app()->getRequest()->getRequestUri()]);?>" class="btn btn-danger"><i class="icon-remove icon-white"></i></a>
                            <?endif;?>
                            <a href="<?=$this->createUrl('/event/admin/edit/index', ['eventId' => $event->Id]);?>" class="btn"><i class="icon-edit"></i></a>
                            <?if (!$event->Deleted):?>
                                <a href="<?=$this->createUrl('/event/view/index', ['idName' => $event->IdName]);?>" class="btn" target="_blank"><i class="icon-share"></i></a>
                            <?endif;?>
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