<?php foreach ($products as $product):?>
  <?php if (isset($orderForm->Count[$product->ProductId]) && $orderForm->Count[$product->ProductId] > 0):?>
    <p><?php echo $product->Title;?></p>
    <table>
    <?php for($i = 0; $i < $orderForm->Count[$product->ProductId]; $i++):?>
      <tr>
        <td>
          <?php echo CHtml::activeTextField($orderForm, 'Owners['.$product->ProductId.']['.$i.'][FullName]');?>
          
          <p>-----</p>  
          <script>
            $(function () {
              $('form').submit(function () {
                var self = $(this);
                $('.alert', self).hide();
                $.post(
                  "<?php echo $this->createUrl('/register/main/ajaxregister/');?>", 
                  self.serializeArray(),
                  function (response) {
                    if (response.Success == true) {
                      
                    }
                    else {
                      $('.alert',self).html('').show();
                      $.each(response.ErrorMsg, function (i, msg) {
                        $('.alert', self).append(msg+'<br/>');
                      });
                    }
                  }, 'json');
                return false;
              });
            });
          </script>
          <?php echo CHtml::beginForm('POST');?>
            <div class="alert alert-error hide"></div>
            <p><?php echo CHtml::activeTextField($registerForm, 'FirstName');?></p>
            <p><?php echo CHtml::activeTextField($registerForm, 'LastName');?></p>
            <p><?php echo CHtml::activeTextField($registerForm, 'SecondName');?></p>
            <p><?php echo CHtml::activeTextField($registerForm, 'Company');?></p>
            <p><?php echo CHtml::activeTextField($registerForm, 'Position');?></p>
            <p><?php echo CHtml::activeTextField($registerForm, 'Email');?></p>
            <p><?php echo CHtml::activeTextField($registerForm, 'Phone');?></p>
            <p><?php echo CHtml::submitButton();?></p>
            <input type="hidden" name="eventId" value="<?php echo $event->EventId;?>" />
          <?php echo CHtml::endForm();?>
        </td>
        <td><a href="">Новый пользователь</a></td>
      </tr>
    <?php endfor;?>
    </table>
  <?php endif;?>
<?php endforeach; ?>

