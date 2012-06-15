<ul class="nav nav-pills">
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'coupon', 'index');?>">Промо-коды</a>
    </li>
    <li class="active">
        <a href="<?=RouteRegistry::GetUrl('partner', 'coupon', 'users');?>">Активированные промо-коды</a>
    </li>
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'coupon', 'activation');?>">Активация промо-кода</a>
    </li>
</ul>

<form>
    <div class="row">
        <div class="span4">
            <label>ROCID:</label>
            <input type="text" name="filter[RocId]" value="<?php if ( isset ($this->Filter['RocId'])) echo $this->Filter['RocId'];?>" />
        </div>

        <div class="span4">
            <label>Фамилия, имя:</label>
            <input type="text" name="filter[Name]" value="<?php if ( isset ($this->Filter['Name'])) echo $this->Filter['Name'];?>" />
        </div>

        <div class="span4">
            <label>Код купона:</label>
            <input type="text" name="filter[Code]" value="<?php if ( isset ($this->Filter['Code'])) echo $this->Filter['Code'];?>" />
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <input type="submit" value="Искать" name="" class="btn"/>
        </div>
    </div>
</form>

<?php if ($this->Activations != null):?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ROCID</th>
            <th>Ф.И.О.</th>
            <th>Промо-код</th>
            <th>Размер скидки</th>
            <th>Оплачен</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->Activations as $activation):?>
            <tr>
                <td><?php echo $activation->User->RocId;?></td>
                <td><?php echo $activation->User->GetFullName();?></td>
                <td><?php echo $activation->Coupon->Code;?></td>
                <td><?php echo $activation->Coupon->Discount * 100;?> %</td>
                <td>
                    <?php if ( !empty ($activation->OrderItems)):?>
                        <span class="label label-success">Оплачен</span>
                    <?php else:?>
                        <span class="label">Не оплачен</span>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php else:?>
    <div class="alert">По Вашему запросу нет ни одной активации.</div>
<?php endif;?>
<?php echo $this->Paginator;?>