<?php
use partner\components\Controller;
use user\models\User;

/**
 * @var User $user
 * @var Controller $this
 * @var bool $hideContacts
 * @var bool $hideEmployment
 * @var bool $hideId
 */
$hideEmployment = isset($hideEmployment) && $hideEmployment;
$hideContacts = isset($hideContacts) && $hideContacts;
$hideId = isset($hideId) && $hideId;

if (!isset($linkHtmlOptions)) {
    $linkHtmlOptions = ['class' => 'lead lead-sm'];
}
$linkHtmlOptions['onclick'] = '$(\'#modal-user\').data(\'url\', $(this).attr(\'href\')).modal(\'show\'); return false;';

\Yii::app()->getClientScript()->registerScript(__FILE__, '

    $("#modal-user").on("show.bs.modal", function (e) {
        var $loader = $(this).find(".loader").removeClass("hide");
        var $iframe = $("<iframe/>", {
            "class": "hide",
            "css": {
                 "width" : "100%",
                 "height": "100%",
                 "border": 0
            }
        });

        var url = $(this).data("url");
        $iframe.prop("src", url + "&layout=0");
        $(this).find(".modal-body")
            .css("height", $(window).height() - 150)
            .append($iframe);

        $(this).find(".modal-footer a.btn").attr("href", url);
        $iframe.load(function () {
            $iframe.removeClass("hide");
            $loader.addClass("hide");
        });
    })
    .on("hide.bs.modal", function (e) {
        $(this).find("iframe").remove();
    });
', \CClientScript::POS_LOAD);
?>

<?=\CHtml::link((!$hideId ? '<span class="text-light-gray">' . $user->RunetId . ',</span> ' : '') . $user->getFullName(), ['user/edit', 'id' => $user->RunetId], $linkHtmlOptions);?>


<?php if (!$hideEmployment && ($employment = $user->getEmploymentPrimary()) !== null):?>
    <p><?=$employment;?></p>
<?php endif;?>

<?php if (!$hideContacts):?>
    <p class="m-top_5 text-nowrap"><i class="fa fa-envelope-o"></i>&nbsp;<?=\CHtml::mailto($user->Email);?>
    <?php if (($phone = $user->getPhone()) !== null):?>
        <br/><i class="fa fa-phone"></i>&nbsp;<?=$phone;?>
    <?php endif;?>
    </p>
<?php endif;?>

<?php if (!isset($this->clips[Controller::PAGE_FOOTER_CLIP_ID])):?>
    <?php $this->beginClip(Controller::PAGE_FOOTER_CLIP_ID);?>
    <?$this->beginWidget('application\widgets\bootstrap\Modal', [
        'header' => 'Редактирование участника мероприятия',
        'htmlOptions' => ['class' => 'modal-fullscreen', 'id' => 'modal-user'],
        'footer' => \CHtml::link('<span class="btn-label fa fa-external-link"></span> ' . \Yii::t('app', 'Открыть в основном окне'), '', ['class' => 'btn btn-default btn-labeled btn-xs'])
    ]);?>
    <div class="text-center text-muted loader hide">
        <i class="fa fa-refresh fa-spin fa-5x"></i>
        <p class="lead">Загрузка...</p>
    </div>
    <?$this->endWidget();?>
    <?php $this->endClip();?>
<?php endif;?>
