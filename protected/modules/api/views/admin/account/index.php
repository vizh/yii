<?php

    use api\models\Account;

    /** @var Account[] $accounts */

?>
<div class="btn-toolbar">
  <a href="<?=$this->createUrl('/api/admin/account/edit')?>" class="btn"><?=Yii::t('app', 'Создать')?></a>
</div>
<div class="well">
  <table class="table">
    <thead>
      <tr>
        <th><?=Yii::t('app', 'ID')?></th>
        <th><?=Yii::t('app', 'Мероприятие')?></th>
        <th>Key</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <?foreach($accounts as $account):?>
      <tr>
        <?if (!empty($account->Event)):?>
          <td><?=$account->Event->Id?></td>
          <td><?=$account->Event->Title?></td>
        <?else:?>
          <td colspan="2">&mdash;</td>
        <?endif?>
        <td><?=$account->Key?></td>
        <td>
          <div class="btn-group">
            <?$domainsContent = '';
            foreach ($account->Domains as $domain)
              $domainsContent .= $domain->Domain.'<br/>';

            $IpContent = '';
            foreach ($account->Ips as $ip)
              $IpContent .= $ip->Ip.'<br/>';
            ?>

            <?if(!empty($domainsContent)):?>
               <button class="btn btn-mini btn-info" data-toggle="popover" data-original-title="<?=Yii::t('app', 'Домены')?>" data-content="<div class='word-break_keep-all'><?=$domainsContent?></div>" data-placement="top"><?=Yii::t('app', 'Домены')?></button>
            <?else:?>
               <button class="btn btn-mini disabled"><?=Yii::t('app', 'Домены')?></button>
            <?endif?>

            <?if(!empty($IpContent)):?>
              <button class="btn btn-mini btn-info" data-toggle="popover" data-original-title="<?=Yii::t('app', 'IP адреса')?>" data-content="<div class='word-break_keep-all'><?=$IpContent?></div>" data-placement="top"><?=Yii::t('app', 'IP')?></button>
            <?else:?>
               <button class="btn btn-mini disabled"><?=Yii::t('app', 'IP')?></button>
            <?endif?>

            <button
                class="btn btn-mini btn-info"
                data-toggle="popover"
                data-original-title="<?=Yii::t('app', 'Hash')?>"
                data-content="<div class='word-break_keep-all'><?=substr(md5($account->Key.time().$account->Secret), 0, 16)?></div>"
                data-placement="top"><?=Yii::t('app', 'Hash')?></button>
          </div>
        </td>
        <td><a href="<?=$this->createUrl('/api/admin/account/edit', ['accountId' => $account->Id])?>" class="btn btn-mini"><?=Yii::t('app', 'Редактировать')?></a></td>
      </tr>
    <?endforeach?>
  </table>
</div>