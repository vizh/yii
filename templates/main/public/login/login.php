<script type="text/javascript">
  $(function(){
    $('#userbar .loginButton').trigger('click');
    $('#overlay').unbind('click');
    $('.auth_me').after($('<a href="/" style="display: inline-block; padding-top: 20px; margin-left: 5px; color: #5a5a5a;">Отмена</a>'));
  });
</script>

<div class="content">
    <div id="sidebar" class="sidebar sidebarcomp">
      <?php echo $this->Banner;?>
    </div>
</div>