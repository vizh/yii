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
                    <td><?=\CHtml::image($event->getLogo()->getMini());?></td>
                    <td>
                        <a href="<?=$this->createUrl('/event/admin/edit/index', array('eventId' => $event->Id));?>"><?=$event->Title;?></a><br/>
                        <small><?=Texts::cropText($event->IdName,50);?></small>
                    </td>
                    <td><label class="label"><?=$event->Type->Title;?></label></td>
                    <td class="icons">
                        <i class="icon-eye-open <?if (!$event->ShowOnMain):?>muted<?endif;?>" title="Опубликовано на главной"></i>
                        <i class="icon-fullscreen <?if (!isset($event->Top) || $event->Top == 0):?>muted<?endif;?>" title="Используется выделение в большой блок"></i>
                        <i class="icon-list <?if (empty($event->LinkProfessionalInterests)):?>muted<?endif;?>" title="Проставлены проф. интересы"></i>

                        <?if (isset($event->Options)):?>
                            <?$options = unserialize($event->Options);?>
                            <i class="icon-calendar <?if (!in_array('размещение информации в календаре', $options)):?>muted<?endif;?>" title="Выбрана опция размещение информации в календаре"></i>
                            <i class="icon-user <?if (!in_array('регистрация участников', $options)):?>muted<?endif;?>" title="Выбрана опция регистрация участников"></i>
                            <i class="icon-shopping-cart <?if (!in_array('прием оплаты', $options)):?>muted<?endif;?>" title="Выбрана опция прием оплаты"></i>
                            <i class="icon-gift <?if (!in_array('реклама и маркетинг', $options)):?>muted<?endif;?>" title="Выбрана опция реклама и маркетинг"></i>
                            <i class="icon-briefcase <?if (!in_array('оффлайн регистрация', $options)):?>muted<?endif;?>" title="Выбрана опция оффлайн регистрация"></i>
                        <?endif;?>


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