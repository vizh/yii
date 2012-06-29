<form method="GET">
    <div class="row">
        <div class="span4">
            <label>Плательщик:</label>
            <input name="filter[Payer]" value="<?php if ( isset ($this->Filter['Payer'])) echo $this->Filter['Payer'];?>" placeholder="ROCID плательщика" />
        </div>
        <div class="span4">
            <label>Получатель:</label>
            <input name="filter[Owner]" value="<?php if ( isset ($this->Filter['Owner'])) echo $this->Filter['Owner'];?>" placeholder="ROCID получателя" />
        </div>
        <div class="span4">
            <label>Товар:</label>
            <select name="filter[ProductId]">
                <option value="">Все</option>
                <?php foreach ($this->Products as $product):?>
                    <option value="<?php echo $product->ProductId;?>" <?php if ( isset($this->Filter['ProductId']) && $this->Filter['ProductId'] == $product->ProductId):?>selected="selected"<?php endif;?>><?php echo $product->Title;?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="span4">
            <select name="filter[Paid]">
                <option value="">Оплаченные и нет</option>
                <option value="1" <?php if ( isset ($this->Filter['Paid']) && $this->Filter['Paid'] == 1):?>selected="selected"<?php endif;?>>Только оплаченные</option>
                <option value="0" <?php if ( isset ($this->Filter['Paid']) && $this->Filter['Paid'] == 0):?>selected="selected"<?php endif;?>>Только не оплаченные</option>
            </select>
        </div>
        <div class="span4">&nbsp;</div>
        <div class="span4">
            <select name="filter[Deleted]">
                <option value="">Не удаленные</option>
                <option value="1" <?php if ( isset ($this->Filter['Deleted']) && $this->Filter['Deleted'] == 1):?>selected="selected"<?php endif;?>>Только удаленные</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <input type="submit" name="" value="Искать" class="btn" />
        </div>
    </div>
</form>

<?php if ($this->OrderItems != null):?>
<div class="row">
    <div class="span12">
        <table class="table table-striped">
            <thead>
                <th>Товар</th>
                <th>Плательщик</th>
                <th>Получатель</th>
                <th>Оплата</th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach ($this->OrderItems as $orderItem):?>
                <tr>
                    <td><?php echo $orderItem->Product->Title;?></td>
                    <td>
                        <?php echo $orderItem->Payer->RocId;?>, <strong><?php echo $orderItem->Payer->GetFullName();?></strong>
                        <p><em><?php echo $orderItem->Payer->GetEmail() !== null ? $orderItem->Payer->GetEmail()->Email : $orderItem->Payer->Email; ?></em></p>
                    </td>
                    <td>
                        <?php echo $orderItem->Owner->RocId;?>, <strong><?php echo $orderItem->Owner->GetFullName();?></strong>
                        <p><em><?php echo $orderItem->Owner->GetEmail() !== null ? $orderItem->Owner->GetEmail()->Email : $orderItem->Owner->Email; ?></em></p>
                    </td>
                    <td>
                        <?php if ($orderItem->Paid == 1):?>
                            <span class="label label-success">Оплачен</span>
                        <?php else:?>
                            <span class="label">Не оплачен</span>
                        <?php endif;?>
                    </td>
                    
                    <td><?php if ($orderItem->Deleted == 1):?><span class="label label-warning">Удален</span><?php endif;?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<?php else:?>
    <div class="alert">По Вашему запросу заказов не найдено.</div>
<?php endif;?>
<?php echo $this->Paginator;?>
