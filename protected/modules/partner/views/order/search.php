<form method="GET">
    <div class="row">
        <div class="span4">
            <label>Номер счета:</label>
            <input type="text" placeholder="" name="filter[OrderId]" 
                value="<?php if ( !empty ($filter['OrderId'])) echo $filter['OrderId'];?>"
            />
        </div>
        <div class="span4">
            <label>Название компании:</label>
            <input type="text" placeholder="" name="filter[CompanyName]" 
                value="<?php if ( !empty ($filter['CompanyName'])) echo $filter['CompanyName'];?>"
            />
        </div>
        <div class="span4">
            <label>Плательщик:</label>
            <input type="text" placeholder="ROCID" name="filter[PayerRocId]"
                value="<?php if ( !empty ($filter['PayerRocId'])) echo $filter['PayerRocId'];?>"
            />
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <input type="submit" value="Искать" class="btn" />
        </div>
    </div>
</form>

<div class="row">
    <div class="span12">
        <h2></h2>
    </div>
    <div class="span12">
        <?php if ( !empty ($orders)):?>
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Cчет</th>
                <th>Краткие данные</th>
                <th>Выставил</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Управление</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order):?>
                <tr>
                    <td><h3><?php echo $order->OrderId;?></h3></td>
                    <td width="35%">
                        <strong><?php echo $order->OrderJuridical->Name;?></strong><br>
                        ИНН/КПП:&nbsp;<?php echo $order->OrderJuridical->INN;?>&nbsp;/&nbsp;<?php echo $order->OrderJuridical->KPP;?>
                    </td>
                    <td>
                        <?php echo $order->Payer->RocId;?>, <strong><?php echo $order->Payer->GetFullName();?></strong>
                        <p>
                            <em><?php echo $order->Payer->GetEmail() !== null ? $order->Payer->GetEmail()->Email : $order->Payer->Email; ?></em>
                        </p>
                        <?php if (!empty($order->Payer->Phones)):?>
                            <p><em><?php echo urldecode($order->Payer->Phones[0]->Phone);?></em></p>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php echo Yii::app()->locale->getDateFormatter()->format('d MMMM y', strtotime($order->CreationTime));?><br>
                        <?php if ($order->OrderJuridical->Paid != 0):?>
                            <span class="label label-success">ОПЛАЧЕН</span>
                        <?php else:?>
                            <span class="label label-important">НЕ ОПЛАЧЕН</span>
                        <?php endif;?>
                    </td>
                    <td><?php echo $order->Price();?> руб.</td>
                    <td>
                        <a class="btn btn-info" href="<?=\Yii::app()->createUrl('/partner/order/view', array('orderId' => $order->OrderId));?>"><i class="icon-search icon-white"></i> Просмотр</a>
                    </td>
                </tr>
                <?endforeach;?>
            </tbody>
        </table>
        <?php elseif ( empty ($this->Filter)):?>
            <div class="alert">
                Критерии поиска не могут быть пустыми, уточните один из параметров
            </div>
        <?php else:?>
            <div class="alert">
                По Вашему запросу ничего не найдено.
            </div>
        <?php endif;?>
    </div>
</div>