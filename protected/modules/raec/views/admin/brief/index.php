<?
/**
 * @var Brief[] $briefs
 * @var Paginator $paginator
 */
use application\components\utility\Paginator;
use \raec\models\Brief;
?>
<div class="btn-toolbar"></div>
<div class="well">
    <table class="table">
        <thead>
        <tr>
            <th><?=\Yii::t('app', 'Пользователь');?></th>
            <th><?=\Yii::t('app', 'Дата заполнения');?></th>
            <th><?=\Yii::t('app', 'Процент заполнения');?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?foreach ($briefs as $brief):?>
            <tr>
                <td>
                    <a href="<?=$brief->User->getUrl();?>" target="_blank"><strong><?=$brief->User->getFullName()?></strong></a><br/>
                    <?if (($employment = $brief->User->getEmploymentPrimary()) !== null):?>
                        <small><?=$employment->Company->Name;?>, <?=!empty($employment->Position) ? $employment->Position : '';?></small>
                    <?endif;?>
                </td>
                <td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $brief->CreationTime);?></td>
                <td>
                    <?$percent = $brief->getCompletePercent();?>
                    <label class="label <?if ($percent > 90):?>label-success<?endif;?>"><?=$brief->getCompletePercent();?>%</label></td>
                <td class="text-right">
                    <a href="<?=$this->createUrl('/raec/admin/brief/view', ['briefId' => $brief->Id]);?>" class="btn"><i class="icon-eye-open"></i></a>
                </td>
            </tr>
        <?endforeach;?>
        </tbody>
    </table>

    <?$this->widget('\application\widgets\Paginator', ['paginator' => $paginator]);?>
</div>