<form method="POST" id="form_visible">
    <?php if ($this->Step == 1):?>
        <h3></h3>
        <div class="clearfix">
            <label>rocID:</label>
            <div class="input">
                <input class="span3" type="text" name="Visible[RocId]"/> 
            </div>
        </div>
        <div class="clearfix">
            <a class="button big" onclick="$('#form_visible')[0].submit(); return false;" href="#">Продолжить</a>
        </div>
    <?php else:?>
        <script type="text/javascript">
            $(function () {
                var form = $('form#form_visible');
                
                $('a.button', form).click ( function (e) {
                    form.trigger('submit');
                    return false;
                });
                
                form.submit( function (e) {
                    var message = 'Вы точно хотите '+ ($('input[name="Visible[Visible]"]', $(e.currentTarget)).val() == 0 ? 'удалить' : 'востановить') + ' пользователя';
                    if ( !confirm(message))
                        return false;
                });
            });
        </script>
        
        <h3>Пользователь: <?php echo $this->User->GetFullName();?>, статус: <?php if ($this->User->Settings->Visible):?>активен<?php else:?>удален<?php endif;?></h3>
        <div class="clearfix">
            <a class="button big" href="#">
                <?php echo ($this->User->Settings->Visible ? 'Удалить' : 'Востановить');?>
            </a>
        </div>
        <input type="hidden" name="Visible[Visible]" value="<?php echo ($this->User->Settings->Visible ? 0 : 1);?>" />
        <input type="hidden" name="Visible[RocId]" value="<?php echo $this->User->RocId;?>" />
    <?php endif;?>
</form>