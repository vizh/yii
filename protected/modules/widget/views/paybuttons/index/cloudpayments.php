<?php
/**
 * @var \pay\components\Controller $this
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
                                var url = "' . $this->createUrl('success', ['system' => 'cloudpayments', 'id' => 'invoiceId']) . '";
                                url = url.replace("invoiceId", response.invoiceId);
                                location.href = url;
                            },
                            function (reason, options) {}
                        );
                    }
                    cloudPaymentsPayHandler();
                }
            });
        });
    });

');
?>
<?=\CHtml::link('&nbsp;', $this->createAbsoluteUrl('/pay/cabinet/pay', ['type' => 'cloudpayments', 'eventIdName' => $this->getEvent()->IdName]), ['class' => 'btn btn-primary cloudpayments'])?>
<span class="cloudpayments"></span>
