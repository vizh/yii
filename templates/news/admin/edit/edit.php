<section class="main edit newsedit">
  <?if ($this->NewsMainCategoryId == NewsPost::ExpertsCategoryId):?>
    <h2>Редактировать статью</h2>
  <?else:?>
    <h2>Редактировать новость</h2>
  <?endif;?>

  <form id="form_editnews" enctype="multipart/form-data" action="" method="post">
    <input type="hidden" value="<?=$this->NewsPostId;?>" name="news_post_id">

    <aside class="col-l">
      <input type="text" data-empty="<?=$this->words['news']['entertitle'];?>"
             class="title bordered" maxlength="250" name="data[title]"
             value="<?=htmlspecialchars($this->Title);?>">
      <div class="edit-slug">
        <strong>Постоянная ссылка:</strong>
        <?
        $url = RouteRegistry::GetUrl('news', '', 'show', array('newslink' => $this->NewsPostId . '-'));
        echo substr($url, 0, strlen($url) - 1);
        ?>
        <input class="bordered" type="text" maxlength="250" name="data[name]" value="<?=$this->Name;?>">/
      </div>
      <!-- <a id="addimage" class="button addimage">Вставить изображение</a> -->
      <div class="main-block text bordered">
        <h4>Текст новости</h4>
        <div class="textarea-container">
          <textarea name="data[content]"><?=$this->NewsContent;?></textarea>
        </div>
      </div>

      <div class="main-block text bordered">
        <h4>Цитата</h4>
        <div class="textarea-container">
          <textarea class="quote" name="data[quote]"><?=$this->Quote;?></textarea>
        </div>
      </div>

      <div class="main-block bordered">
        <h4>Тип материала</h4>
        <div class="general-container">
          <input class="span7" name="data[MaterialType]" type="text" value="<?=CHtml::encode($this->MaterialType);?>" placeholder="не более 30 символов" maxlength="30">
        </div>
      </div>

      <div class="main-block edit-news-company bordered">
        <h4>Компании</h4>
        <div class="general-container">
          <input id="addcompany" type="text" class="add-company-to-news bordered"
                 placeholder="Введите название и выберите компанию"                 
                 value="">
          <ul class="company_list">
            <?php echo $this->Companies;?>
            <li id="company_prototype" style="display:none;">
              <a target="_blank" href="">Название компании</a>
              <div title="Удалить компанию из новости" class="delete" data-company="123" onclick="return confirm('Вы уверены, что хотите удалить компанию из этой новости?');"></div>
            </li>
          </ul>
          <div class="cl"></div>
        </div>
      </div>

      <div class="main-block bordered">
        <h4>Автор статьи</h4>
        <div class="general-container">
          <input type="text" class="add-user-to-news bordered" name="data[rocid]" value="<?=$this->RocId;?>" placeholder="введите rocID">
        </div>
      </div>

      <div class="main-block edit-news-image bordered">
        <h4>Настройки новости</h4>
        <div class="general-container">
          <ul class="inputs-list">
            <li>
              <label>
                <input type="checkbox" value="1" name="data[in_main_tape]" <?=$this->InMainTape == 1 ? 'checked="checked"' : '';?> >
                &nbsp;<strong>Отображать в Главной ленте новостей</strong>
              </label>
            </li>
          </ul>

          <h5>Изображение для ленты:</h5>
          <input type="file" name="tape_image">
          <div class="image-desc">
            Автоматически создаются два изображения:<br>
            1. Ширина: 200px Высота: 130px
            <span class="mainimage">
              <?if(! empty($this->TapeImage)):?>
              <a target="_blank" href="<?=$this->TapeImage?>">просмотреть</a>
              <?else:?>
              (отсутствует)
              <?endif;?>
            </span><br>
            2. Ширина: 440px Высота: 285px
            <span class="mainimage">
              <?if(! empty($this->TapeImageBig)):?>
              <a target="_blank" href="<?=$this->TapeImageBig?>">просмотреть</a>
              <?else:?>
              (отсутствует)
              <?endif;?>
            </span>
          </div>

        </div>

        <div class="general-container">
          <h5>Копирайт изображения</h5>

          <input type="text" class="bordered span8" name="data[Copyright]" value="<?=$this->Copyright;?>" placeholder="укажите копирайт изображения, если необходимо">
        </div>
      </div>
    </aside>

    <aside class="col-r">
      <div class="pub bordered sidebar">
        <h4>Опубликовать</h4>
        <a id="button_save" class="button positive save big"><span class="icon check"></span>Сохранить</a>
        <a target="_blank"
           href="<?=RouteRegistry::GetUrl('news', '', 'show', array('newslink' => $this->NewsPostId . '-preview'));?>"
           class="button preview big">Просмотреть</a>
        <div class="cl"></div>
        <div class="pub-status sub-element">
          <h5>Статус</h5>
          <select name="data[status]" class="bordered">
            <?foreach(NewsPost::$Statuses as $key):?>
            <option value="<?=$key?>" <?=$key == $this->Status ? 'selected="selected"' : '';?> ><?=$this->words['status'][$key]?></option>
            <?endforeach;?>
          </select>
        </div>
        <div class="cl"></div>
        <div class="pub-date bordered-input sub-element">
          <h5>Дата публикации</h5>
          <input type="text" value="<?=$this->Date['mday'];?>" maxlength="2" size="2" name="data[day]" placeholder="ДД" class="span1">
          <select name="data[month]" class="bordered span2">
            <?foreach ($this->words['calendar']['months'][1] as $key => $value ):?>
            <option value="<?=$key?>" <?=$this->Date['mon'] == $key ? 'selected="selected"' : '';?>  ><?=$value?></option>
            <?endforeach;?>
          </select>
          <input type="text" value="<?=$this->Date['year'];?>" maxlength="4" size="4" name="data[year]" placeholder="ГГГГ" class="span1">&nbsp;в&nbsp;
          <input type="text" value="<?=$this->Date['hours'];?>" maxlength="2" size="2" name="data[h]" placeholder="ЧЧ" class="span1">
          <input type="text" value="<?=intval($this->Date['minutes']) < 10 ? '0' . $this->Date['minutes'] : $this->Date['minutes'];?>" maxlength="2" size="2" name="data[min]" placeholder="ММ" class="span1">
        </div>
        <div class="cl"></div>
        <?if ($this->Status != NewsPost::StatusPublish):?>
        <a id="button_publish" class="button publish big">Опубликовать</a>
        <div class="cl"></div>
        <?endif;?>
      </div>

      <div class="category bordered sidebar"
          <?=$this->NewsMainCategoryId == NewsPost::ExpertsCategoryId? 'style="display:none;"' : '';?> >
        <h4>Категории</h4>
        <div class="sub-category sub-element">
          <h5>Основная категория</h5>
          <select id="main_category" name="data[category]" class="bordered" >
            <option value="0">(Без категории)</option>
            <?foreach($this->Categories as $cat):
                if ($this->NewsMainCategoryId != NewsPost::ExpertsCategoryId &&
                    $cat->NewsCategoryId == NewsPost::ExpertsCategoryId)
                {
                  continue;
                }
            ?>
            <option value="<?=$cat->NewsCategoryId;?>" <?=$cat->NewsCategoryId == $this->NewsMainCategoryId ? 'selected="selected"' : '';?> >
              <?=$cat->Title;?>
            </option>
            <?endforeach;?>
          </select>
        </div>
        <div class="sub-category sub-element">
          <h5>Второстепенные категории</h5>
          <ul class="second_category_list inputs-list">
            <?foreach($this->Categories as $cat):
              if ($this->NewsMainCategoryId != NewsPost::ExpertsCategoryId &&
                    $cat->NewsCategoryId == NewsPost::ExpertsCategoryId)
                {
                  continue;
                }
            ?>
            <li>
              <label>
                <input type="checkbox" name="data[second_category][]"
                       value="<?=$cat->NewsCategoryId;?>"
                  <?=$cat->NewsCategoryId == $this->NewsMainCategoryId ||
                     in_array($cat->NewsCategoryId, $this->NewsCategories) ? 'checked="checked"' : '';?> >
                <?=$cat->Title;?>
              </label>
            </li>
            <?endforeach;?>
          </ul>
        </div>
      </div>
    </aside>
  </form>
</section>