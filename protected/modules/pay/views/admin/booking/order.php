<? /**
 * @var \pay\models\forms\admin\PartnerOrder $form
 * @var \pay\models\RoomPartnerOrder $order
 * @var \pay\models\RoomPartnerBooking[] $bookings
 */

use application\helpers\Flash;
use application\components\utility\Texts;

?>
<? if ($order !== null && $order->Paid): ?>
    <script type="text/javascript">
        $(function () {
            $('form.form-horizontal').find('input').prop('disabled', true);
        });
    </script>
<? endif; ?>

<div class="btn-toolbar">
    <a href="<?= $this->createUrl('/pay/admin/booking/partner', ['owner' => $form->getOwner()]); ?>"
       class="btn">&larr; <?= \Yii::t('app', 'Назад'); ?></a>
</div>
<div class="well">
    <h2 class="m-bottom_10"><?= \Yii::t('app', 'Партнер:'); ?> <?= $form->getOwner(); ?></h2>
    <?php if ($order !== null && !$order->getIsNewRecord()): ?>
        <div class="m-bottom_30">
            <?= CHtml::link('Счет для печати', ['order', 'owner' => $form->getOwner(), 'id' => $order->Id, 'print' => 1]); ?>
        </div>
    <?php endif ?>

    <?= Flash::html(); ?>
    <?= CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>'); ?>

    <?= CHtml::form('', 'POST', ['class' => 'form-horizontal']); ?>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'Name', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'Name', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'Address', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'Address', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'RealAddress', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'RealAddress', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>

    <div class="control-group">
        <?= CHtml::activeLabel($form, 'INN', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'INN', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'KPP', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'KPP', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'BankName', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'BankName', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'Account', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'Account', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'CorrespondentAccount', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'CorrespondentAccount', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'BIK', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'BIK', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'ChiefPosition', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'ChiefPosition', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'ChiefName', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'ChiefName', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'ChiefPositionP', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'ChiefPositionP', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'ChiefNameP', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'ChiefNameP', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>
    <div class="control-group">
        <?= CHtml::activeLabel($form, 'StatuteTitle', ['class' => 'control-label']); ?>
        <div class="controls">
            <?= CHTml::activeTextField($form, 'StatuteTitle', ['class' => 'input-xxlarge']); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th><?= \Yii::t('app', 'Бронь'); ?></th>
                    <th><?= \Yii::t('app', 'Дата въезда'); ?></th>
                    <th><?= \Yii::t('app', 'Дата выезда'); ?></th>
                    <th>Доп. мест</th>
                    <th class="total"></th>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <?php if ($booking->OrderId == null || ($order !== null && $booking->OrderId == $order->Id)): ?>
                        <?php
                        /** @var \pay\components\managers\RoomProductManager $manager */
                        $manager = $booking->Product->getManager();
                        $price = $booking->getStayDay() * (Texts::getOnlyNumbers($manager->Price) + $booking->AdditionalCount * $manager->AdditionalPrice);
                        ?>
                        <tr>
                            <td style="width: 1px;"><?= \CHtml::activeCheckBox($form, 'BookingIdList[]', ['uncheckValue' => null, 'value' => $booking->Id, 'checked' => in_array($booking->Id, $form->BookingIdList), 'data-price' => $price]); ?></td>
                            <td><?= $manager->Hotel; ?>, <?= $manager->Housing; ?>, №<?= $manager->Number; ?></td>
                            <td><?= \Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $booking->DateIn); ?></td>
                            <td><?= \Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $booking->DateOut); ?></td>
                            <td><?= $booking->AdditionalCount; ?></td>
                            <td><span class="label"><?= $price; ?> <?= \Yii::t('app', 'руб'); ?></span></td>
                            <td class="text-center"><a
                                    href="<?= $this->createUrl('/pay/admin/booking/partnerbookinginfo', ['bookingId' => $booking->Id, 'backUrl' => \Yii::app()->getRequest()->getUrl()]); ?>"
                                    class="btn btn-info btn-mini"><i class="icon-wrench icon-white"></i></a></td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?= CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?= CHtml::endForm() ?>
</div>