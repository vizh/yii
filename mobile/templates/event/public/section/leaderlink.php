<li>
  <!--<p class="event-time"><strong><?=$this->Role?></strong></p>-->
  <h3>
    <?=$this->LastName . ' ' . $this->FirstName?>
  </h3>
  <p><?=$this->CompanyName;?>
    <?if (!empty($this->CompanyName) && !empty($this->CompanyPosition)):?>, <?endif;?>
    <?=$this->CompanyPosition;?></p>
</li>