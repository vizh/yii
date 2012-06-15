<ul id="search_result" class="advspopup">
  <?php echo $this->Companies;?>
  <?php echo $this->Users;?>
  <?php echo $this->News;?>

  <li>
    <a href="/search/?<?=http_build_query(array('q'=>$this->Query));?>" class="vall">Посмотреть все результаты<br />
      <span>
  <?$flag = false;
  foreach ($this->Counts as $key => $value):?>
    <? if ($value == 0) continue;?>
    <?if ($flag):?>
      ,
    <?else:
      $flag = true;
    endif;?>
    <?if ($key == SearchIndex::ResultCompany):?>
          <?=$value;?> <?=Texts::GetRightFormByCount($value, 'компания', 'компании', 'компаний');?>
    <?elseif ($key == SearchIndex::ResultUser):?>
          <?=$value;?> <?=Texts::GetRightFormByCount($value, 'пользователь', 'пользователя', 'пользователей');?>
    <?elseif ($key == SearchIndex::ResultNews): ?>
          <?=$value;?> <?=Texts::GetRightFormByCount($value, 'новость', 'новости', 'новостей');?>
    <?endif;?>
  <?endforeach;?>
        </span>
      </a>
</li>

</ul>