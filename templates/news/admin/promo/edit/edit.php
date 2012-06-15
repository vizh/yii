<table cellspacing="0" cellpadding="0" border="0" style="width:100%;">
  <tbody><tr>
    <td>
      <h1>// Добавление промо элемента</h1>
    </td>
  </tr>
  </tbody></table>

<form enctype="multipart/form-data" action="" method="post">

  <input type="hidden" value="<?=$this->NewsPromoId;?>" name="promo_post_id">
  <script type="text/javascript">
    $(document).ready(function(){
      showOnTopChanged($('#input_ontop')[0]);
    });

    function showOnTopChanged(element)
    {
      if (element.checked)
      {
        $('tr.for_hide').hide(0);
        $('#span_info_nottop').hide(0);
        $('#span_info_top').show(0);
      }
      else
      {
        $('tr.for_hide').show(0);
        $('#span_info_nottop').show(0);
        $('#span_info_top').hide(0);
      }
    }
  </script>

  <table width="100%" cellpadding="3" border="0">
    <tbody>
    <tr>
      <td width="100%" valign="top" align="center">
        <table cellpadding="3" border="0">
          <tbody align="left">
          <tr bgcolor="#6d705d">
            <td colspan="2"><b><font color="#ffffff">[ДАННЫЕ]</font></b></td>
          </tr>
          <tr bgcolor="#e2e3dd">
            <td><b>Выводить в верхний блок:</b><div class="copy">(необходимо задать изображение)</div></td>
            <td>
              <label>
                <input id="input_ontop" onchange="showOnTopChanged(this);" type="checkbox" value="1" name="data[on_top]" <?=$this->OnTop == 1 ? 'checked="checked"' : '';?> >
                &nbsp;Отображать в верхнем блоке неавторизированных пользователей
              </label>
            </td>
          </tr>
          <tr bgcolor="#e2e3dd">
            <td><strong>Верхний заголовок:</strong>
              <div class="copy">(Пример: 17 апреля)<br>Для выделения даты используйте тег span</div>
            </td>
            <td width="500"><input type="text" style="width: 99%;" maxlength="250" name="data[title_top]" value="<?=htmlspecialchars($this->TitleTop);?>"></td>
          </tr>
          <tr bgcolor="#e2e3dd" class="for_hide">
            <td><strong>Заголовок:</strong><div class="copy">(Пример: "ВКонтакте" запустила видеорекламу)</div></td>
            <td width="500"><input type="text" style="width: 99%;" maxlength="250" name="data[title]" value="<?=htmlspecialchars($this->Title);?>"></td>
          </tr>
          <tr bgcolor="#e2e3dd" class="for_hide">
            <td><b>Описание:</b><div class="copy">(Привлекающая внимание выдержка из новости.)</div></td>
            <td><textarea name="data[description]" style="width: 99%;" rows="3"><?=$this->Description;?></textarea></td>
          </tr>
          <tr bgcolor="#e2e3dd">
            <td>
              <b>Ссылка:</b><div class="copy"></div>
            </td>
            <td>
              <input type="text" style="width: 99%;" maxlength="250" name="data[link]" value="<?=$this->Link;?>">
            </td>
          </tr>
          <tr bgcolor="#e2e3dd">
            <td>
              <b>Позиция на ленте:</b><div class="copy">0 - крайний левый, увеличиваются слева на право.</div>
            </td>
            <td>
              <input type="text" style="width: 99%;" maxlength="250" name="data[position]" value="<?=$this->Position;?>">
            </td>
          </tr>
          <tr bgcolor="#e2e3dd">
            <td><b>Статус:</b></td>
            <td>
              <select name="data[status]">
                <?foreach(NewsPromo::$Statuses as $key):?>
                <option value="<?=$key?>" <?=$key == $this->Status ? 'selected="selected"' : '';?> ><?=$this->words['status'][$key]?></option>
                <?endforeach;?>
              </select>
            </td>
          </tr>
          <!-- <tr bgcolor="#e2e3dd">
           <td><b>Опции ленты новостей</b></td>
           <td></td>
         </tr> -->

          <tr bgcolor="#e2e3dd">
            <td>
              <b>Изображение для ленты:</b>
              <div class="copy">
                <img src="<?=$this->TapeImage?>" alt=""><br>
                Автоматически масштабируется изображение<br>
                <span id="span_info_nottop">Ширина: 200px Высота: 130px</span>
                <span id="span_info_top">Ширина: 400px Высота: 285px</span>
              </div>
            </td>
            <td><input type="file" name="tape_image"></td>
          </tr>

          </tbody>
        </table>
      </td>
    </tr>
    </tbody>
  </table>
  <center>
    <p>
      <input type="submit" value="Сохранить новость">&nbsp;
      <a href="/admin/news/promo/list/">Назад</a>
    </p>
  </center>
</form>

 
