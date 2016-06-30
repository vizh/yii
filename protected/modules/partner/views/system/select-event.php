<?php
/**
 * @var \partner\components\Controller $this
 * @var $events array
 */
$this->bodyClass = 'page-signin';
$this->showPageHeader = false;
$this->showSidebar = false;
$this->setPageTitle(\Yii::t('app', 'Авторизация в партнерском интерфейсе'));
?>
<div class="signin-container">
    <div class="signin-form">
        <form action="" method="post">
            <div class="text-center m-bottom_20">
                <img src="/images/partner/logo.png" alt="RUNET-ID" title="RUNET-ID" />
            </div>
            <div class="signin-text">
                <span><?=\Yii::t('app', 'Партнерский интерфейс');?></span>
            </div> <!-- / .signin-text -->

            <div class="form-group w-icon">
                <input type="text" placeholder="Выберите мероприятие" class="form-control input-lg" />
                <input type="hidden" name="event_id">
                <span class="fa fa-list signin-form-icon"></span>
            </div> <!-- / Username -->
        </form>
    </div>
    <!-- Right side -->
</div>

<script type="text/javascript">
    $(function(){
        var $form = $('div.signin-form form');
        $form.find('input[type="text"]').autocomplete({
            source: <?=json_encode($events, JSON_UNESCAPED_UNICODE);?>,
            select: function( event, ui ) {
                $form.find('input[name="event_id"]').val(ui.item.id);
                $form.submit();
                return false;
            }
        });
    });
</script>