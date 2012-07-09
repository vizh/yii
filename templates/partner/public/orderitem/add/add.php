<form method="GET">
    <div class="row">
        <div class="span12 indent-bottom2">
            <div class="control-group">
                <label>Плательщик:</label>
                <input type="text" name="OrderItem[Payer]" value="" />
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
                <input type="text" name="OrderItem[Owner]" value="" />
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
                    <?php if ($this->Products != null):?>
                        <?php foreach ($this->Procucts as $product):?>
                            <option value="<?php echo $product->ProductId;?>"><?php echo $product->Title;?></option>
                        <?php endforeach;?>
                    <?php endif;?>
                </select>
            </div>
        </div>
    </div>
</form>