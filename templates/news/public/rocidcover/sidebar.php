<div class="sidebar sidebarrapple" id="sidebar">
  <?if (! empty($this->CurrentCover)):?>
  <a href="/news/rocid-cover/" class="back_to_profile">Сгенерировать обложку</a>
  <?endif;?>

  <?if (! empty($this->LastCovers)):?>
  <h2>Последние созданные обложки</h2>
  <ul>
    <?php echo $this->LastCovers;?>
  </ul>
  <?endif;?>
  <div class="all-rapple-people"></div>
  <?if (! empty($this->UserCovers)):?>
  <h2>Ваши обложки</h2>
  <ul style="padding-bottom: 20px;">
    <?php echo $this->UserCovers;?>
  </ul>
  <?endif;?>

  <?php echo $this->Banner;?>
</div>
