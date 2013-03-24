<div class="input-append">
  <input type="text" value="<?php echo isset($user) ? $user->GetFullName() : '';?>"  <?php echo $htmlOptions;?> data-userautocompleteinput="1" />
  <span class="add-on">
    <?php if (!empty($value)):?>
      ROCID: <?php echo $value;?>
    <?php else:?>
      &mdash;
    <?php endif;?>
  </span>
  <input type="hidden" name="<?php echo $field;?>" value="<?php echo $value;?>" />
</div>
