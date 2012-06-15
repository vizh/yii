<li>
  <span>
    <?=$this->Date;?>
    <?if (!empty($this->MaterialType)):?>
    <span class="material-type"><?=$this->MaterialType?></span>
    <?endif;?>
  </span>
  <div><a title="<?=CHtml::encode($this->Title);?>" href="/news/<?=$this->Link;?>/"><img width="285" src="<?=$this->Image;?>" alt="<?=CHtml::encode($this->Title);?>"></a></div>
  <a href="/news/<?=$this->Link;?>/"><?=$this->Title;?></a>
  <p><?=$this->Quote;?></p>
</li>
 
