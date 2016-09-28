<?if ($event->Visible):?>
  <div class="control-group">
    <div class="controls">
      <?if (!$event->isFbPublish()):?>
        <button class="btn btn-block btn-info" type="button"
          onclick="window.open('<?=$this->createUrl('/event/admin/fb/publish', ['eventId' => $event->Id])?>', '','width=300, height=400')">
          Опубликовать на Facebook
        </button>
      <?else:?>
        <button class="btn btn-block btn-info" type="button"
                onclick="window.open('<?=$this->createUrl('/event/admin/fb/update', ['eventId' => $event->Id])?>', '','width=300, height=400')">
          Обновить на Facebook
        </button>
        <button class="btn btn-block btn-danger" type="button"
          onclick="window.open('<?=$this->createUrl('/event/admin/fb/delete', ['eventId' => $event->Id])?>', '','width=300, height=400')">
          Удалить с Facebook
        </button>
      <?endif?>
    </div>
  </div>
<?endif?>