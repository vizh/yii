<section class="main">
  <h2>Зарегистрировались сегодня (<?=$this->Count;?>)</h2>
  <table class="persons">
    <?php echo $this->Today;?>
  </table>
</section>

<section class="main">
  <h2>Зарегистрировались вчера (<?=$this->CountYesterday;?>)</h2>
  <table class="persons">
    <?php echo $this->Yesterday;?>
  </table>
</section>