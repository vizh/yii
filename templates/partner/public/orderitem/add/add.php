<ul class="nav nav-pills">
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'orderitem', 'index');?>">Заказы</a>
    </li>
    <li class="active">
        <a href="<?=RouteRegistry::GetUrl('partner', 'orderitem', 'add');?>">Добавить заказ</a>
    </li>
</ul>


<script type="text/javascript">
$( function () {
    $('#FieldPayer, #FieldOwner').autocomplete({
        source: "/partner/user/ajaxget/",
        minLength: 2,
        select: function(e, ui){
            $('input[name="'+ $(this).data('valuefield')+ '"]').val(ui.item.id);
        }
    });
})
</script>

<form method="POST">
    <div class="row">
        <div class="span12 indent-bottom3">
            <h2>Добавление заказа</h2>
        </div>
    </div>  
    
    <?php if ( !empty ($this->Error)):?>
    <div class="alert alert-error"><?php echo $this->Error;?></div>
    <?php endif;?>
    
    <div class="row">
        <div class="span12 indent-bottom2">
            <div class="control-group">
                <label>Плательщик:</label>
                <input type="text" id="FieldPayer" name="OrderItem[PayerName]" data-valuefield="OrderItem[PayerRocId]" value="<?php if ( isset ($this->Payer)) echo $this->Payer->GetFullName();?>"/>
                <input type="hidden" name="OrderItem[PayerRocId]" value="<?php if ( isset ($this->Payer)) echo $this->Payer->RocId;?>" />
                <p class="help-block">
                    <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска. 
                </p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="span12 indent-bottom2">
            <div class="control-group">
                <label>Получатель:</label>
                <input type="text" id="FieldOwner" name="OrderItem[OwnerName]" data-valuefield="OrderItem[OwnerRocId]" value="<?php if ( isset ($this->Owner)) echo $this->Owner->GetFullName();?>"/>
                <input type="hidden" name="OrderItem[OwnerRocId]" value="<?php if ( isset ($this->Owner)) echo $this->Owner->RocId;?>" />
                <p class="help-block">
                    <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска. 
                </p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="span12 indent-bottom1">
            <div class="control-group">
                <label>Товар:</label>
                <select name="OrderItem[ProductId]">
                    <?php if ( !empty ($this->Products)):?>
                        <?php foreach ($this->Products as $product):?>
                            <option value="<?php echo $product->ProductId;?>" <?php if ( isset ($this->Product) && $this->Product->ProductId == $product->ProductId):?>selected="selected"<?php endif;?>><?php echo $product->Title;?></option>
                        <?php endforeach;?>
                    <?php endif;?>
                </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="span12">
            <input type="submit" name="" value="Сохранить" class="btn btn-primary"/>
        </div>
    </div>
</form>