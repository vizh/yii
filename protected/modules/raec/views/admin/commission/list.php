<?php

/**
 * @var \raec\models\Commission[] $commissions
 */

$this->setPageTitle(Yii::t('app', 'Комиссии РАЭК'));

?>
<div class="btn-toolbar" style="overflow:hidden">
    <a href="<?=$this->createUrl('/raec/admin/commission/edit')?>" class="btn pull-right"><i class="icon-plus"></i> <?=Yii::t('app', 'Добавить комиссию')?></a>
</div>
<div class="well">
    <div class="row-fluid">
        <div class="span12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Название</th>
                    <th colspan="2">Участников</th>
                </tr>
                </thead>
                <tbody>
                <?foreach($commissions as $commission):?>
                    <tr>
                        <td><a href="<?=$this->createUrl('/raec/admin/commission/edit', ['id' => $commission->Id])?>"><?=$commission->Title?></a></td>
                        <td><?=count($commission->UsersActive)?> чел.</td>
                        <td class="text-right">
                            <a href="<?=$this->createUrl('/raec/admin/commission/edit', ['id' => $commission->Id])?>" class="btn"><i class="icon-edit"></i> <?=Yii::t('app', 'Редактировать')?></a>
                            <a href="<?=$this->createUrl('/raec/admin/commission/userList', ['id' => $commission->Id])?>" class="btn"><i class="icon-user"></i> <?=Yii::t('app', 'Участники')?></a>
                        </td>
                    </tr>
                <?endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</div>