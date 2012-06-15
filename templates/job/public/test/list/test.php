<li>
  <span class="time"><?=$this->Date;?> г.</span>
  <div class="job_title">
    <a href="<?=RouteRegistry::GetUrl('job', 'test', 'show', array('id'=>$this->TestId));?>"><?=$this->Title;?></a>
  </div>
  <div class="description">
    <p>
      <?=$this->DescriptionShort;?>
    </p>
  </div>
</li>
 
