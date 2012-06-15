<div class="line-1">
  <a href="/<?=$this->RocId;?>" class="blue"><?=$this->FirstName;?> <?=$this->LastName;?></a> добавил новое место работы:
  <a href="/company/<?=$this->CompanyId;?>/" class="blue"><?=$this->CompanyName;?></a>
  (с <?=$this->words['calendar']['months'][2][$this->Start['mon']];?> <?=$this->Start['year']?> года
  <?if(isset($this->Finish)):?>
    по <?=$this->words['calendar']['months'][1][$this->Finish['mon']];?> <?=$this->Finish['year']?> года
  <?endif;?>
  );
</div>