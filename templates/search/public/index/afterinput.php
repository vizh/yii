<ul class="result_types">
  <li class="was_found">Найдено:</li>
  <?$flag = false;
  foreach ($this->Counts as $key => $value):?>
    <? if ($value == 0) continue;?>
    <?if ($flag):?>
      <li>/</li>
    <?else:
      $flag = true;
    endif;?>
    <?if ($key == SearchIndex::ResultUser):?>
      <li <?=$key == $this->Active ? 'class="selected"' : '';?>>
        <a href="/search/?<?=http_build_query(array('q'=>$this->Query, 'a' => SearchIndex::ResultUser));?>">
          <?=$value;?> <?=Texts::GetRightFormByCount($value, 'пользователь', 'пользователя', 'пользователей');?>
        </a>
      </li>
    <?elseif ($key == SearchIndex::ResultCompany):?>
      <li <?=$key == $this->Active ? 'class="selected"' : '';?>>
        <a href="/search/?<?=http_build_query(array('q'=>$this->Query, 'a' => SearchIndex::ResultCompany));?>">
          <?=$value;?> <?=Texts::GetRightFormByCount($value, 'компания', 'компании', 'компаний');?>
        </a>
      </li>
    <?elseif ($key == SearchIndex::ResultNews): ?>
      <li <?=$key == $this->Active ? 'class="selected"' : '';?>>
        <a href="/search/?<?=http_build_query(array('q'=>$this->Query, 'a' => SearchIndex::ResultNews));?>">
          <?=$value;?> <?=Texts::GetRightFormByCount($value, 'новость', 'новости', 'новостей');?>
        </a>
      </li>
    <?endif;?>
  <?endforeach;?>
</ul>