<?php
/**
 * @var \pay\widgets\PayButtons $this
 * @var string $system
 */


/** @var \CClientScript $clientScript */
$clientScript = \Yii::app()->getClientScript();
$clientScript->registerScriptFile('https://widget.cloudpayments.ru/bundles/cloudpayments');
$clientScript->registerScript('cloudpayments','
    $(function () {
        $("a.cloudpayments").click(function (e) {
            e.preventDefault();
            var $target = $(e.currentTarget);
            if ($target.attr("disabled") == "disabled") {
                return false;
            }
            $target.addClass("loader");
            $.ajax({
                url : $target.attr("href"),
                xhrFields: {
                    withCredentials: true
                },
                dataType: "json",
                success : function (response) {
                    $target.removeClass("loader");
                    var cloudPaymentsPayHandler  = function () {
                        var widget = new cp.CloudPayments();
                        widget.charge(response,
                            function (options) {
                                var $modal = $("<div/>", {
                                    "class" : "modal hide",
                                    "html"  : "<div class=\"modal-header\"><h3>Заказ оплачен!</h3></div>" +
                                              "<div class=\"modal-body\">Спасибо, заказ оплачен!<br/>Подробная информация отправлена на ваш электронный адрес.</div>" +
                                              "<div class=\"modal-footer\"><a href=\"#\" class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Закрыть</a></div>"
                                });
                                $("body").append($modal);
                                $modal.modal();
                                $modal.on("hidden", function () {
                                    location.reload();
                                    $modal.remove();
                                    return false;
                                });
                            },
                            function (reason, options) {

                            }
                        );
                    }
                    cloudPaymentsPayHandler();
                }
            });
        });
    });

');
?>

<?=\CHtml::link('&nbsp;', ['/pay/cabinet/pay', 'type' => $system, 'eventIdName' => $this->account->Event->IdName], $this->getHtmlOptions($system))?>
<span class="cloudpayments"></span>
