<?php
/**
 * @var $dataEvents array
 */
?>

<script type="text/javascript">
  $(function(){
    var dataEvents = <?=json_encode($dataEvents, JSON_UNESCAPED_UNICODE)?>;
    $( "#EventSearch" ).autocomplete({
      source: dataEvents,
      select: function( event, ui ) {
        $('input[name="eventId"]').val(ui.item.id);
      }
    });
  });
</script>

<div class="row indent-top3">
  <div class="span8 offset2">
    <form action="" method="post">
      <div class="control-group">
        <label for="EventSearch"><strong>Поиск мероприятия</strong></label>
        <div class="controls">
          <input id="EventSearch" type="text" name="EventSearch" class="span6">
          <input type="hidden" name="eventId">
        </div>
      </div>

      <div class="control-group indent-top2">
        <button type="submit" class="btn btn-info btn-large">Установить!</button>
        <button type="reset" class="btn">Очистить</button>
      </div>
    </form>
  </div>
</div>