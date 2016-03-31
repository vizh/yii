<?php
/**
 * @var User                      $user
 * @var Event                     $event
 * @var Participant|Participant[] $participant
 */

use pay\models\RoomPartnerBooking;
use user\models\User;
use event\models\Event;
use event\models\Participant;
use ruvents\components\QrCode;
use pay\models\OrderItem;
use pay\components\admin\Rif;

$role = $participant->Role;

$criteria = new \CDbCriteria();
$criteria->with = ['Product'];
$criteria->addCondition('"Product"."ManagerName" = :ManagerName');
$criteria->params['ManagerName'] = 'RoomProductManager';
$roomOrderItem = OrderItem::model()->byEventId($event->Id)->byPaid(true)->byAnyOwnerId($user->Id)->find($criteria);

$roomProductManager = $roomOrderItem !== null ? $roomOrderItem->Product->getManager() : null;
$parkingReporterRoleIdList = [3, 6];
$parking = null;
if ($roomProductManager !== null || in_array($role->Id, $parkingReporterRoleIdList)) {
    $command = Rif::getDb()->createCommand();
    $command->select('*')->from('ext_booked_parking')->where('ownerRunetId = :RunetId');
    $parking = $command->queryRow(true, ['RunetId' => $user->RunetId]);
}
$parkingReporter = !empty($parking) && in_array($role->Id,
        $parkingReporterRoleIdList) && ($roomProductManager == null || $roomProductManager->Hotel != Rif::HOTEL_P);
?>
<style type="text/css">
    html {
        font-family: sans-serif;
    }

    body {
        margin: 0
    }

    article, aside, details, figcaption, figure, footer, header, main, nav, section, summary {
        display: block
    }

    audio, canvas, progress, video {
        display: inline-block;
        vertical-align: baseline
    }

    audio:not([controls]) {
        display: none;
        height: 0
    }

    [hidden], template {
        display: none
    }

    a {
        background: transparent
    }

    a:active, a:hover {
        outline: 0
    }

    abbr[title] {
        border-bottom: 0.2mm dotted
    }

    b, strong {
        font-weight: bold
    }

    dfn {
        font-style: italic
    }

    h1 {
        font-size: 2em;
        margin: 0.67em 0
    }

    mark {
        background: #ff0;
        color: #000
    }

    small {
        font-size: 80%
    }

    sub, sup {
        font-size: 75%;
        line-height: 0;
        position: relative;
        vertical-align: baseline
    }

    sup {
        top: -0.5em
    }

    sub {
        bottom: -0.25em
    }

    img {
        border: 0
    }

    svg:not(:root) {
        overflow: hidden
    }

    figure {
        margin: 1em 10.5mm
    }

    hr {
        -moz-box-sizing: content-box;
        box-sizing: content-box;
        height: 0
    }

    pre {
        overflow: auto
    }

    code, kbd, pre, samp {
        font-family: monospace, monospace;
        font-size: 1em
    }

    button, input, optgroup, select, textarea {
        color: inherit;
        font: inherit;
        margin: 0
    }

    button {
        overflow: visible
    }

    button, select {
        text-transform: none
    }

    button, html input[type="button"], input[type="reset"], input[type="submit"] {
        -webkit-appearance: button;
        cursor: pointer
    }

    button[disabled], html input[disabled] {
        cursor: default
    }

    button::-moz-focus-inner, input::-moz-focus-inner {
        border: 0;
        padding: 0
    }

    input {
        line-height: normal
    }

    input[type="checkbox"], input[type="radio"] {
        box-sizing: border-box;
        padding: 0
    }

    input[type="number"]::-webkit-inner-spin-button, input[type="number"]::-webkit-outer-spin-button {
        height: auto
    }

    input[type="search"] {
        -webkit-appearance: textfield;
        -moz-box-sizing: content-box;
        -webkit-box-sizing: content-box;
        box-sizing: content-box
    }

    input[type="search"]::-webkit-search-cancel-button, input[type="search"]::-webkit-search-decoration {
        -webkit-appearance: none
    }

    fieldset {
        border: 0.2mm solid #c0c0c0;
        margin: 0 0.5mm;
        padding: 0.35em 0.625em 0.75em
    }

    legend {
        border: 0;
        padding: 0
    }

    textarea {
        overflow: auto
    }

    optgroup {
        font-weight: bold
    }

    table {
        border-collapse: collapse;
        border-spacing: 0
    }

    td, th {
        padding: 0
    }

    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box
    }

    *:before, *:after {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box
    }

    html {
        font-size: 62.5%;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0)
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 3.7mm;
        line-height: 1.42857143;
        color: #1a1a1a;
        background-color: #fff
    }

    input, button, select, textarea {
        font-family: inherit;
        font-size: inherit;
        line-height: inherit
    }

    a {
        color: #2eaff2;
        text-decoration: none
    }

    a:hover, a:focus {
        color: #0c87c7;
        text-decoration: underline
    }

    a:focus {
        outline: thin dotted;
        outline: 1.3mm auto -webkit-focus-ring-color;
        outline-offset: -0.5mm
    }

    figure {
        margin: 0
    }

    img {
        vertical-align: middle
    }

    .img-responsive {
        display: block;
        max-width: 100%;
        height: auto
    }

    .img-rounded {
        border-radius: 1.6mm
    }

    .img-thumbnail {
        padding: 1mm;
        line-height: 1.42857143;
        background-color: #fff;
        border: 0.2mm solid #ddd;
        border-radius: 1mm;
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
        display: inline-block;
        max-width: 100%;
        height: auto
    }

    .img-circle {
        border-radius: 50%
    }

    hr {
        margin-top: 5.3mm;
        margin-bottom: 5.3mm;
        border: 0;
        border-top: 0.2mm solid #eee
    }

    .sr-only {
        position: absolute;
        width: 0.2mm;
        height: 0.2mm;
        margin: -0.2mm;
        padding: 0;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0
    }

    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
        font-family: inherit;
        font-weight: 500;
        line-height: 1.1;
        color: inherit
    }

    h1 small, h2 small, h3 small, h4 small, h5 small, h6 small, .h1 small, .h2 small, .h3 small, .h4 small, .h5 small, .h6 small, h1 .small, h2 .small, h3 .small, h4 .small, h5 .small, h6 .small, .h1 .small, .h2 .small, .h3 .small, .h4 .small, .h5 .small, .h6 .small {
        font-weight: normal;
        line-height: 1;
        color: #999
    }

    h1, .h1, h2, .h2, h3, .h3 {
        margin-top: 1.3mm;
        margin-bottom: 2.6mm
    }

    h1 small, .h1 small, h2 small, .h2 small, h3 small, .h3 small, h1 .small, .h1 .small, h2 .small, .h2 .small, h3 .small, .h3 .small {
        font-size: 65%
    }

    h4, .h4, h5, .h5, h6, .h6 {
        margin-top: 2.6mm;
        margin-bottom: 2.6mm
    }

    h4 small, .h4 small, h5 small, .h5 small, h6 small, .h6 small, h4 .small, .h4 .small, h5 .small, .h5 .small, h6 .small, .h6 .small {
        font-size: 75%
    }

    h1, .h1 {
        font-size: 31.6mm
    }

    h2, .h2 {
        font-size: 4.8mm
    }

    h3, .h3 {
        font-size: 11.6mm
    }

    h4, .h4 {
        font-size: 3.4mm
    }

    h5, .h5 {
        font-size: 3.7mm
    }

    h6, .h6 {
        font-size: 10.5mm
    }

    p {
        margin: 0 0 2.6mm
    }

    .lead {
        margin-bottom: 5.3mm;
        font-size: 11.6mm;
        font-weight: 200;
        line-height: 1.4
    }

    small, .small {
        font-size: 85%
    }

    cite {
        font-style: normal
    }

    .text-left {
        text-align: left
    }

    .text-right {
        text-align: right
    }

    .text-center {
        text-align: center
    }

    .text-justify {
        text-align: justify
    }

    .text-muted {
        color: #999
    }

    .text-primary {
        color: #2eaff2
    }

    a.text-primary:hover {
        color: #0e98df
    }

    .text-success {
        color: #3c763d
    }

    a.text-success:hover {
        color: #2b542c
    }

    .text-info {
        color: #31708f
    }

    a.text-info:hover {
        color: #245269
    }

    .text-warning {
        color: #8a6d3b
    }

    a.text-warning:hover {
        color: #66512c
    }

    .text-danger {
        color: #a94442
    }

    a.text-danger:hover {
        color: #843534
    }

    .bg-primary {
        color: #fff;
        background-color: #2eaff2
    }

    a.bg-primary:hover {
        background-color: #0e98df
    }

    .bg-success {
        background-color: #dff0d8
    }

    a.bg-success:hover {
        background-color: #c1e2b3
    }

    .bg-info {
        background-color: #d9edf7
    }

    a.bg-info:hover {
        background-color: #afd9ee
    }

    .bg-warning {
        background-color: #fcf8e3
    }

    a.bg-warning:hover {
        background-color: #f7ecb5
    }

    .bg-danger {
        background-color: #f2dede
    }

    a.bg-danger:hover {
        background-color: #e4b9b9
    }

    .page-header {
        padding-bottom: 2.3mm;
        margin: 10.5mm 0 5.3mm;
        border-bottom: 0.2mm solid #eee
    }

    ul, ol {
        margin-top: 0;
        margin-bottom: 2.6mm
    }

    ul ul, ol ul, ul ol, ol ol {
        margin-bottom: 0
    }

    .list-unstyled {
        padding-left: 0;
        list-style: none
    }

    .list-inline {
        padding-left: 0;
        list-style: none;
        margin-left: -1.3mm
    }

    .list-inline > li {
        display: inline-block;
        padding-left: 1.3mm;
        padding-right: 1.3mm
    }

    dl {
        margin-top: 0;
        margin-bottom: 5.3mm
    }

    dt, dd {
        line-height: 1.42857143
    }

    dt {
        font-weight: bold
    }

    dd {
        margin-left: 0
    }

    abbr[title], abbr[data-original-title] {
        cursor: help;
        border-bottom: 0.2mm dotted #999
    }

    .initialism {
        font-size: 90%;
        text-transform: uppercase
    }

    blockquote {
        padding: 2.6mm 5.3mm;
        margin: 0 0 5.3mm;
        font-size: 1.3mm;
        border-left: 1.3mm solid #eee
    }

    blockquote p:last-child, blockquote ul:last-child, blockquote ol:last-child {
        margin-bottom: 0
    }

    blockquote footer, blockquote small, blockquote .small {
        display: block;
        font-size: 80%;
        line-height: 1.42857143;
        color: #999
    }

    blockquote footer:before, blockquote small:before, blockquote .small:before {
        content: '\2014 \00A0'
    }

    .blockquote-reverse, blockquote.pull-right {
        padding-right: 4mm;
        padding-left: 0;
        border-right: 1.3mm solid #eee;
        border-left: 0;
        text-align: right
    }

    .blockquote-reverse footer:before, blockquote.pull-right footer:before, .blockquote-reverse small:before, blockquote.pull-right small:before, .blockquote-reverse .small:before, blockquote.pull-right .small:before {
        content: ''
    }

    .blockquote-reverse footer:after, blockquote.pull-right footer:after, .blockquote-reverse small:after, blockquote.pull-right small:after, .blockquote-reverse .small:after, blockquote.pull-right .small:after {
        content: '\00A0 \2014'
    }

    blockquote:before, blockquote:after {
        content: ""
    }

    address {
        margin-bottom: 5.3mm;
        font-style: normal;
        line-height: 1.42857143
    }

    code, kbd, pre, samp {
        font-family: Menlo, Monaco, Consolas, "Courier New", monospace
    }

    code {
        padding: 0.5mm 1mm;
        font-size: 90%;
        color: #c7254e;
        background-color: #f9f2f4;
        white-space: nowrap;
        border-radius: 1mm
    }

    kbd {
        padding: 0.5mm 1mm;
        font-size: 90%;
        color: #fff;
        background-color: #333;
        border-radius: 0.8mm;
        box-shadow: inset 0 -0.2mm 0 rgba(0, 0, 0, 0.25)
    }

    pre {
        display: block;
        padding: 1.3mm;
        margin: 0 0 2.6mm;
        font-size: 3.4mm;
        line-height: 1.42857143;
        word-break: break-all;
        word-wrap: break-word;
        color: #333;
        background-color: #f5f5f5;
        border: 0.2mm solid #ccc;
        border-radius: 1mm
    }

    pre code {
        padding: 0;
        font-size: inherit;
        color: inherit;
        white-space: pre-wrap;
        background-color: transparent;
        border-radius: 0
    }

    .container {
        margin-right: auto;
        margin-left: auto;
        padding-left: 4mm;
        padding-right: 4mm
    }

    .container-fluid {
        margin-right: auto;
        margin-left: auto;
        padding-left: 4mm;
        padding-right: 4mm
    }

    .row {
        margin-left: -4mm;
        margin-right: -4mm;
    }

    .row:after {
        content: " ";
        visibility: hidden;
        display: block;
        height: 0;
        clear: both
    }

    .col-1, .col-sm-1, .col-md-1, .col-lg-1, .col-2, .col-sm-2, .col-md-2, .col-lg-2, .col-3, .col-sm-3, .col-md-3, .col-lg-3, .col-4, .col-sm-4, .col-md-4, .col-lg-4, .col-5, .col-sm-5, .col-md-5, .col-lg-5, .col-6, .col-sm-6, .col-md-6, .col-lg-6, .col-7, .col-sm-7, .col-md-7, .col-lg-7, .col-8, .col-sm-8, .col-md-8, .col-lg-8, .col-9, .col-sm-9, .col-md-9, .col-lg-9, .col-10, .col-sm-10, .col-md-10, .col-lg-10, .col-11, .col-sm-11, .col-md-11, .col-lg-11, .col-12, .col-sm-12, .col-md-12, .col-lg-12 {
        position: relative;
        min-height: 0.2mm;
        padding-left: 4mm;
        padding-right: 4mm
    }

    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
        float: left
    }

    .col-12 {
        width: 100%
    }

    .col-11 {
        width: 91.66666667%
    }

    .col-10 {
        width: 83.33333333%
    }

    .col-9 {
        width: 75%
    }

    .col-8 {
        width: 66.66666667%
    }

    .col-7 {
        width: 58.33333333%
    }

    .col-6 {
        width: 50%
    }

    .col-5 {
        width: 41.66666667%
    }

    .col-4 {
        width: 33.33333333%
    }

    .col-3 {
        width: 25%
    }

    .col-2 {
        width: 16.66666667%
    }

    .col-1 {
        width: 8.33333333%
    }

    .col-offset-12 {
        margin-left: 100%
    }

    .col-offset-11 {
        margin-left: 91.66666667%
    }

    .col-offset-10 {
        margin-left: 83.33333333%
    }

    .col-offset-9 {
        margin-left: 75%
    }

    .col-offset-8 {
        margin-left: 66.66666667%
    }

    .col-offset-7 {
        margin-left: 58.33333333%
    }

    .col-offset-6 {
        margin-left: 50%
    }

    .col-offset-5 {
        margin-left: 41.66666667%
    }

    .col-offset-4 {
        margin-left: 33.33333333%
    }

    .col-offset-3 {
        margin-left: 25%
    }

    .col-offset-2 {
        margin-left: 16.66666667%
    }

    .col-offset-1 {
        margin-left: 8.33333333%
    }

    .col-offset-0 {
        margin-left: 0
    }

    @import url(http://fonts.googleapis.com/css?family=Arimo:400,700&subset=latin,cyrillic);
    *, body {
        font-family: Arimo, sans-serif
    }

    header {
        border-bottom: 0.2mm solid #E7E5E6;
        padding: 2.6mm 0;
    }

    .row-userinfo .userinfo {
        font-size: 7.5mm;
        line-height: 7.4mm;
        margin: 4mm 0
    }

    .row-userinfo .userinfo.status {
        color: #2DAEF2
    }

    .row-userinfo .userinfo.company {
        color: gray
    }

    .row-userinfo .qrcode > figcaption {
        text-align: center
    }

    .row-timeline {
        border-top: 0.2mm solid #E7E5E6;
        color: #656565;
        padding: 5.3mm 0 5.3mm;
        margin: 2.6mm 0 0;
    }

    .row-datetime {
        font-size: 2.6mm;
        margin-top: 2.6mm;
        margin-bottom: 0;
    }

    .row-datetime .date {
        color: #222225;
        font-size: 6mm;
    }

    .row-datetime .date > big {
        display: block;
        font-size: 7mm
    }

    .row-datetime .time > span {
        color: #999
    }

    .row-reminder {
        color: #656565;
        padding: 2.6mm 0 0;
        font-size: 80%;
    }

    .row-reminder h2 {
        margin-bottom: 4mm;
    }

    .row-transport .title {
        color: #F1861A;
        font-size: 5.3mm;
        line-height: 5.3mm;
        margin: 5mm 0 5mm 9mm;
        padding: 0;
    }

    .row-bus_timeline {
        color: #656565;
        font-size: 80%
    }

    .row-bus_timeline .title {
        font-size: 5.3mm;
        margin: 10mm 0 5mm 0;
        padding: 0;
    }

    .row-bus_timeline h4 {
        margin-top: 3mm;
        margin-bottom: 2mm
    }

    .footer {
        color: #C8C8CB;
        font-size: 3mm;
    }

    ul > li {
        background: 0 0.8mm no-repeat url(data:image/png; base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAYAAAA71pVKAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAESSURBVHjalNO/K8RxHMfxh08GFl0334JMyEI2SUluduEyWC47f4PZrkQhKbNSMsiirpTOhhKy6LqNjeX91amju9fyqff79fz07v2jq1KpaFIPVrCASfThHTc4wQE+M3NqAkdwiS28YQ3z2MBrxK8wlgHd8Q7jAk+RfPRbB9jEMc4xjbuEXuwFMNcCzJTlH8Lf240yRjGEuv9Vj37co5ywhCM8a08v4V9MGMepznSKiYRcG+W2Kj+X0EC+QziPRkIVxQ7hIqopZreMQptgIfzHCYeoxfrl2yj3JPyHCR9YxQDO0P8H2B/5wfB/ZLtdwwy+cItdlCJWwk7EuzAb/p/dzj6Yarqq7RhjA9dYx37zVX0PAB99QGeygeZKAAAAAElFTkSuQmCC);
        list-style: none;
        margin-bottom: 0.2mm;
        padding: 0.8mm 0 0.5mm 5.3mm;
        font-size: 10.2mm
    }

    .row-transport, .row-userinfo {
        padding: 0
    }

    .row-timeline h3, .row-transport h3 {
        font-size: 3.4mm;
        font-weight: 400;
        margin: 0;
        padding: 0 0 0.8mm
    }

    .row-bus_timeline .row-fill h3, ul {
        margin: 0;
        padding: 0
    }

    .row-bus_timeline .row-fill h3 {
        font-size: 6mm;
    }

    .page-transport {
        font-size: 2.6mm
    }

    table.booking {

    }

    table.booking td {
        padding: 0 1.3mm
    }

    table.food-table {
        margin-top: 2mm;
        width: 100%
    }

    table.food-table td, table.food-table th {
        text-align: center;
        font-size: 3mm;
        padding: 2mm 0.2mm;
        border: 0.2mm solid #cccccc;
        background-color: #E7E5E6
    }

    .row-timeline.noborder {
        border-top: 0
    }
</style>
<htmlpagefooter name="main-footer">
    <div class="text-center footer">
        <p>Онлайн-регистрация участников — <u>RUNET-ID</u>, регистрация участников на площадке — <u>RUVENTS</u></p>
    </div>
</htmlpagefooter>
<div class="page-main">
    <header>
        <div class="container">
            <div class="row">
                <!-- Логотип -->
                <div class="col-7">
                    <div class="logo">
                        <img title="" alt="" height="50"
                             src="data:image/png;base64,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"/>

                    </div>
                </div>
                <!-- Информация о проживании -->
                <?php if ($roomProductManager !== null): ?>
                    <div class="col-4">
                        <table class="booking">
                            <tr>
                                <td class="text-muted">Пансионат <?= $pdf->y; ?></td>
                                <td><?= $roomProductManager->Hotel; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Корпус</td>
                                <td><?= $roomProductManager->Housing; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Комната</td>
                                <td><?= $roomProductManager->Number; ?></td>
                            </tr>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <div role="main">
        <div class="container">
            <!-- Информация об участнике -->
            <section class="row row-userinfo">
                <!-- Статус, ФИО, компания -->
                <div class="col-6 col-offset-1">
                    <div class="userinfo status"><?= $role->Title; ?></div>
                    <div class="userinfo"><?= $user->GetFullName(); ?></div>
                    <? if ($user->getEmploymentPrimary() !== null && $user->getEmploymentPrimary()->Company !== null): ?>
                        <div class="userinfo company"><?= $user->getEmploymentPrimary()->Company->Name; ?></div>
                    <? endif; ?>
                </div>

                <!-- QR-код -->

                <div class="col-4">
                    <figure class="qrcode text-center">
                        <img src="<?= QrCode::getAbsoluteUrl($user, 100); ?>"/>
                        <figcaption>RUNET-ID / <?= $user->RunetId; ?></figcaption>
                    </figure>
                </div>
            </section>
            <?php
            $rif = new Rif();
            $userHotel = $rif->getUserHotel($user->RunetId);

            $foodProductMatrix = [
                13 => [4416, 4417, 4418],
                14 => [4419, 4420, 4421],
                15 => [4422, 4423, 4424],
            ];

            $criteria = new \CDbCriteria();
            $criteria->addInCondition('"t"."ProductId"', \CArray::to_list($foodProductMatrix));
            $userFoodOrderItems = OrderItem::model()->byPaid(true)->byAnyOwnerId($user->Id)->findAll($criteria);
            $userFoodProductIdList = \CHtml::listData($userFoodOrderItems, 'Id', 'ProductId');
            $foodHotels = [];
            switch ($userHotel) {
                case Rif::HOTEL_LD:
                    $foodHotels = [
                        13 => [Rif::HOTEL_LD, Rif::HOTEL_LD, Rif::HOTEL_LD],
                        14 => [Rif::HOTEL_LD, Rif::HOTEL_LD, Rif::HOTEL_LD],
                        15 => [Rif::HOTEL_LD, Rif::HOTEL_LD, Rif::HOTEL_LD],
                    ];
                    break;

                case Rif::HOTEL_P:
                    $foodHotels = [
                        13 => [Rif::HOTEL_P, Rif::HOTEL_LD, Rif::HOTEL_LD],
                        14 => [Rif::HOTEL_P, Rif::HOTEL_LD, Rif::HOTEL_LD],
                        15 => [Rif::HOTEL_P, Rif::HOTEL_LD, Rif::HOTEL_LD],
                    ];
                    break;
            }

            $foodTimes = [
                Rif::HOTEL_LD => [
                    13 => ['8:30 до 10:00', '14:30 до 15:30', '20:30 до 22:00'],
                    14 => ['8:30 до 10:00', '15:00 до 16:00', '21:00 до 22:30'],
                    15 => ['8:00 до 10:00', '14:30 до 15:30', '19:00 до 20:30'],
                ],

                Rif::HOTEL_P => [
                    13 => ['8:30 до 10:00', '14:30 до 15:30', '20:30 до 22:00'],
                    14 => ['8:30 до 10:00', '15:00 до 16:00', '21:00 до 22:30'],
                    15 => ['8:00 до 10:00', '14:30 до 15:30', '19:00 до 20:30'],
                ],
            ];
            ?>

            <? if (!empty($userFoodProductIdList)): ?>
            <div class="row row-timeline noborder" style="padding-bottom: 4mm; padding-top: 4mm;">
                <div class="col-12">
                    <div class="title">Питание</div>
                    <table class="food-table">
                        <thead>
                        <tr>
                            <th></th>
                            <th colspan="2">Завтрак</th>
                            <th colspan="2">Обед</th>
                            <th colspan="2">Ужин</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? for ($d = 13; $d <= 15; $d++): ?>
                            <tr>
                                <td><?= $d; ?>.04</td>
                                <? for ($i = 0; $i < 3; $i++): ?><? $hotel = isset($foodHotels[$d][$i])
                                    ? $foodHotels[$d][$i] : null; ?><? if ($hotel !== null): ?>
                                    <td><?= mb_convert_case($hotel,
                                            MB_CASE_TITLE); ?>, <?= $foodTimes[$hotel][$d][$i]; ?></td>
                                    <td>
                                        <?php
                                        $has = false;
                                        if (is_array($foodProductMatrix[$d][$i])) {
                                            foreach ($foodProductMatrix[$d][$i] as $id) {
                                                $has = in_array($id, $userFoodProductIdList);
                                                if ($has) {
                                                    break;
                                                }
                                            }
                                        } else {
                                            $has = in_array($foodProductMatrix[$d][$i], $userFoodProductIdList);
                                        }
                                        ?>
                                        <?= $has ? '+' : '&nbsp;'; ?>
                                    </td>
                                <? else: ?>
                                    <td colspan="2">&mdash;</td>
                                <? endif; ?><? endfor; ?>
                            </tr>
                        <? endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row row-timeline noborder">
                <? else: ?>
                <div class="row row-timeline">
                    <? endif; ?>
                    <div class="row">
                        <!-- Расписание работы регистрации -->
                        <div class="col-1 text-right">
                            <img
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGNDM3NDFBQUI1QjExMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGNDM3NDFBQkI1QjExMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTdGQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTgwQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+RzvMSgAAAxZJREFUeNrMmT9sEnEUxx+krQnSAa1DBV1IhEEGUmxkrCM0OgixSR2aLq1/hy46uJXF2RqtQyetJiQ6KLgpGwnaMApNSAexHSgsRQaMxveOd80Bd3A/KHf3TT4J3P3uve/9+N3vfu+HbWlpCQaQHbmCzCEh5BLiRk7z+d/IL2QX+Y58Rb4h/0QTjQm29yD3kEXkQo92p5AzSAC5ycd+ItvIBlIW6Qk9Oos8R0rI4z7mtETXPOIYFGvqpAwuIAXkLjIBw2uCY/3g2AMbpJ//BfJW790Kaopjv0TGRQ06kA/IKoxeK8h7zqnL4Bjf2TwYp3nOOa7HID1l18F4Uc5n/QwucJebpZXOB0dp8Bw//mZrg6e1LoPrPLmaLTKX6DR4EVkG62iZ31rHBu/0motMEE3m92WDxG2wnuh9b5dXJR4LGiRPszQpX9NqEY1GIRgMth0rFovQaDQglUpptlEqkUiA3++HWCymej6fzx/HUtEcGZzROutwOMDr9bYdk7+TKUqu1qZTTqdTsw3dcA/NkEFfv75Op9OQTCZb/e7xwNrampQwFAqpttFSqVSSbkpAPhqD0yJXlMtlqNVqRo3DaerBSaGRiz3odrulz/V6/fh4OBwGn88nMr70aFLXkj8SiUgolcvloFAoQCAQkL67XC4JgfGluyY5Ur77tMaOMlmlUoFMJqM5Tk9QR2TwoJ9BMjeC5Hp0QAapay4PG4nGXzwe7zqezWaHCbtLBncUpeHAomlHba7b29sbJuyODQv3q3SjYE2FaR7MiRTSBop2JnJ23o54Y0GDr8mbXbHMblrIXFMuP2SD9BNvWcjgFu/ltNUkT5CqBcxV2UtX0VSVl9km66Gyozrr4nfIKxPNUe7tfjsLD5CPJpj7xLn7bn00ubr/bKA5ynVLbSbR2t1qIDeQTQPMbXKuhtrJXvuDf6C1/bY4oqe7yrFXOReIGpRFg9YPrY3Gk5jMmxzL3/lADGqQdMi7D7RceYrsD2Bsn6/1cqxDPRfZhvgbYpZr6hmuDM9Thcnn62yoyMu5L9D6G+KvaKL/AgwAZFjBTyIfWREAAAAASUVORK5CYII="
                                style="image-resolution: 120dpi;"/>
                        </div>
                        <div class="col-10" style="margin-bottom: 1.3mm;">
                            <h3>Режим работы стойки регистрации</h3>
                            <div>Регистрация участников, оплата участия. КПП «Лесные Дали»</div>
                        </div>
                    </div>
                    <!-- График по дням -->
                    <div class="row row-datetime">
                        <div class="col-2 col-offset-1">
                            <div class="date"><big>12</big> апреля</div>
                            <div class="time"><span>Начало</span> 12:00</div>
                            <div class="time"><span>Окончание</span> 02:00</div>
                        </div>
                        <div class="col-2">
                            <div class="date"><big>13</big> апреля</div>
                            <div class="time"><span>Начало</span> 07:00</div>
                            <div class="time"><span>Окончание</span> 02:00</div>
                        </div>
                        <div class="col-2">
                            <div class="date"><big>14</big> апреля</div>
                            <div class="time"><span>Начало</span> 08:00</div>
                            <div class="time"><span>Окончание</span> 19:00</div>
                        </div>
                        <div class="col-2">
                            <div class="date"><big>15</big> апреля</div>
                            <div class="time"><span>Начало</span> 8:00</div>
                            <div class="time"><span>Окончание</span> 16:00</div>
                        </div>
                    </div>
                </div>

                <!-- Расписание работы оргкомитета -->
                <div class="row row-timeline">
                    <div class="row">
                        <div class="col-1 text-right">
                            <img
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyRkFCM0E3REI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyRkFCM0E3RUI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTdCQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTdDQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+XcT0nAAAA7BJREFUeNrMWU1IG1EQHoNaNI1gaw+apIJCFGxBtIntRUxPHqQFe6hgT4I//cu1pfTWHOy5llYFT/3zkoAt1IO0Bw+FpHrx0CZQEdroQYOgTZSUls7szobddZPsRpPdDz42yc6+973Z9+a9mVSMjo5CEbAhvUg/8hLSg3Qi7Xw/hUwg48ivyM/IKPKf0Y4qDdq7kHeRw0h3HrtTyDPIi8gb/NtP5BvkFPKXEU/owVnkc+QP5MMC4nKBnnnAbVBbDSclcAj5HXkHWQ3HRzW39Y3bLlogvf4XyLd6R2sQDdz2S2SVUYG1yDByAkqPcWSI+9QlsJJHNgDlwwD3WaVHIK2ya1B+UJ/PCgkcYpebhXH1wpELPMfL32xMcVg7IvAJB1ezQeKCaoHnkSNgHYzwrpUVeDtfLDIBFMzvSQKJt8B6oP3eJp1KXBYUSJp8FJSv5rNyOp3g9/vB5RLHcHBwALFYDBYXF7M2/f390NnZqXguHo9DOp3O2mnZSAiHw0KbGvCTwO5c4qjRwcFB4fPu7i4cHh5CS0sLdHR0gNvthtnZWXFfrK0VfpdD+k6iJicnNW0k2O32XBK6SWBbLs9J4kKhUNYT9PvY2Bh4vV5IJpPCPQlkI30nu0AgIIjq6urStNGBNpqDjVp3enp6hGs0GlW8zkQiAUtLSwobLZAdef2YaCSBDs3TpVs8k5KX1FheXhau9fX1eeduU1OTeP5PpYoV6Mh55K+pqRGu29vbulujOUuUg94ALQCat8WABO7L9z75KqT509zcnPVYdmK0idOWFo0c6+vrwnMSaHDqZw1inwRuaQnc2NgQrj6fDxYWFmBvb0/hKcLa2tqRQRlYAHqwRQIpAF1Q31ldXRVeD63WYDAIkUhEiGsej0fwLHlvfn6+1ME6TgJXZKmhAhTnaJH09fVBb2+vYl6ROLlXS4SVCkzcL+OHL4Us6+rqwOFwCOGjjLhCHoxwIp13PyZvlcFjilBK2mxcjnhtwcPCK9Jmkx2zMxYSl5HSD0kgveI5Cwmc41qOIid5TDubBcQlWcuRpCkpHbNNRkDuKHVe/A45Y6K4GS7R5a0s3Ee+N0HcB+67YOkjw9n9xzKKo75uakWSXNWtNPI6croM4qa5r7SR8hvhD4jlt+ESre4ktz3BfYFRgRJo0raDWGg8iWCe4bba1QuiWIGEHa4+tCKfIjeLELbJz7ZyWzt6T9RGQDsOFdEf0VmWc+puzgwpATnNdr9ZUIyPc59A/Bvir9FR/RdgABYkE9ZZQEObAAAAAElFTkSuQmCC"
                                style="image-resolution: 120dpi;"/>
                        </div>
                        <div class="col-10">
                            <h3>Режим работы стойки орг. комитета</h3>
                            <div>Выдача отчетных документов, оплата доп. услуг, отметка командировочных удостоверений, орг. вопросы: «Лесные Дали»</div>
                        </div>
                    </div>
                    <div class="row row-datetime">
                        <div class="col-2 col-offset-1">
                            <div class="date"><big>12</big> апреля</div>
                            <div class="time"><span>Начало</span> 17:00</div>
                            <div class="time"><span>Окончание</span> 00:00</div>
                        </div>
                        <div class="col-2">
                            <div class="date"><big>13</big> апреля</div>
                            <div class="time"><span>Начало</span> 8:00</div>
                            <div class="time"><span>Окончание</span> 22:00</div>
                        </div>
                        <div class="col-2">
                            <div class="date"><big>14</big> апреля</div>
                            <div class="time"><span>Начало</span> 8:00</div>
                            <div class="time"><span>Окончание</span> 19:00</div>
                        </div>
                        <div class="col-2">
                            <div class="date"><big>15</big> апреля</div>
                            <div class="time"><span>Начало</span> 8:00</div>
                            <div class="time"><span>Окончание</span> 16:00</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-reminder">
                <div class="col-3" style="padding-left: 15mm">
                    <h2>Памятка участника</h2>
                    <ul>
                        <li>Распечатать путевой лист</li>
                        <li>Выбрать вид транспорта</li>
                        <li>Зарегистрироваться</li>
                        <li>Оплатить дополнительные услуги</li>
                        <li>Посетить выставку и конференцию РИФ+КИБ</li>
                        <li>Получить отчетные документы и оформить командировочное удостоверение</li>
                    </ul>
                </div>
                <div class="col-3">
                    <h2>Заселение</h2>
                    <ul>
                        <li>Поляны (т-образный перекресток,<br/>поворот налево, 28,5 км)</li>
                        <li>Лесные Дали (т-образный перекресток,<br/>поворот направо, 28,5 км)</li>
                    </ul>
                </div>
                <div class="col-3">
                    <h2>Оплата услуг
                        <img
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyRkFCM0E3REI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyRkFCM0E3RUI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTdCQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTdDQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+XcT0nAAAA7BJREFUeNrMWU1IG1EQHoNaNI1gaw+apIJCFGxBtIntRUxPHqQFe6hgT4I//cu1pfTWHOy5llYFT/3zkoAt1IO0Bw+FpHrx0CZQEdroQYOgTZSUls7szobddZPsRpPdDz42yc6+973Z9+a9mVSMjo5CEbAhvUg/8hLSg3Qi7Xw/hUwg48ivyM/IKPKf0Y4qDdq7kHeRw0h3HrtTyDPIi8gb/NtP5BvkFPKXEU/owVnkc+QP5MMC4nKBnnnAbVBbDSclcAj5HXkHWQ3HRzW39Y3bLlogvf4XyLd6R2sQDdz2S2SVUYG1yDByAkqPcWSI+9QlsJJHNgDlwwD3WaVHIK2ya1B+UJ/PCgkcYpebhXH1wpELPMfL32xMcVg7IvAJB1ezQeKCaoHnkSNgHYzwrpUVeDtfLDIBFMzvSQKJt8B6oP3eJp1KXBYUSJp8FJSv5rNyOp3g9/vB5RLHcHBwALFYDBYXF7M2/f390NnZqXguHo9DOp3O2mnZSAiHw0KbGvCTwO5c4qjRwcFB4fPu7i4cHh5CS0sLdHR0gNvthtnZWXFfrK0VfpdD+k6iJicnNW0k2O32XBK6SWBbLs9J4kKhUNYT9PvY2Bh4vV5IJpPCPQlkI30nu0AgIIjq6urStNGBNpqDjVp3enp6hGs0GlW8zkQiAUtLSwobLZAdef2YaCSBDs3TpVs8k5KX1FheXhau9fX1eeduU1OTeP5PpYoV6Mh55K+pqRGu29vbulujOUuUg94ALQCat8WABO7L9z75KqT509zcnPVYdmK0idOWFo0c6+vrwnMSaHDqZw1inwRuaQnc2NgQrj6fDxYWFmBvb0/hKcLa2tqRQRlYAHqwRQIpAF1Q31ldXRVeD63WYDAIkUhEiGsej0fwLHlvfn6+1ME6TgJXZKmhAhTnaJH09fVBb2+vYl6ROLlXS4SVCkzcL+OHL4Us6+rqwOFwCOGjjLhCHoxwIp13PyZvlcFjilBK2mxcjnhtwcPCK9Jmkx2zMxYSl5HSD0kgveI5Cwmc41qOIid5TDubBcQlWcuRpCkpHbNNRkDuKHVe/A45Y6K4GS7R5a0s3Ee+N0HcB+67YOkjw9n9xzKKo75uakWSXNWtNPI6croM4qa5r7SR8hvhD4jlt+ESre4ktz3BfYFRgRJo0raDWGg8iWCe4bba1QuiWIGEHa4+tCKfIjeLELbJz7ZyWzt6T9RGQDsOFdEf0VmWc+puzgwpATnNdr9ZUIyPc59A/Bvir9FR/RdgABYkE9ZZQEObAAAAAElFTkSuQmCC"
                            style="width: 5.3mm; margin: 0 0.8mm;"/>
                        <img
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGNDM3NDFBQUI1QjExMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGNDM3NDFBQkI1QjExMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTdGQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTgwQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+RzvMSgAAAxZJREFUeNrMmT9sEnEUxx+krQnSAa1DBV1IhEEGUmxkrCM0OgixSR2aLq1/hy46uJXF2RqtQyetJiQ6KLgpGwnaMApNSAexHSgsRQaMxveOd80Bd3A/KHf3TT4J3P3uve/9+N3vfu+HbWlpCQaQHbmCzCEh5BLiRk7z+d/IL2QX+Y58Rb4h/0QTjQm29yD3kEXkQo92p5AzSAC5ycd+ItvIBlIW6Qk9Oos8R0rI4z7mtETXPOIYFGvqpAwuIAXkLjIBw2uCY/3g2AMbpJ//BfJW790Kaopjv0TGRQ06kA/IKoxeK8h7zqnL4Bjf2TwYp3nOOa7HID1l18F4Uc5n/QwucJebpZXOB0dp8Bw//mZrg6e1LoPrPLmaLTKX6DR4EVkG62iZ31rHBu/0motMEE3m92WDxG2wnuh9b5dXJR4LGiRPszQpX9NqEY1GIRgMth0rFovQaDQglUpptlEqkUiA3++HWCymej6fzx/HUtEcGZzROutwOMDr9bYdk7+TKUqu1qZTTqdTsw3dcA/NkEFfv75Op9OQTCZb/e7xwNrampQwFAqpttFSqVSSbkpAPhqD0yJXlMtlqNVqRo3DaerBSaGRiz3odrulz/V6/fh4OBwGn88nMr70aFLXkj8SiUgolcvloFAoQCAQkL67XC4JgfGluyY5Ur77tMaOMlmlUoFMJqM5Tk9QR2TwoJ9BMjeC5Hp0QAapay4PG4nGXzwe7zqezWaHCbtLBncUpeHAomlHba7b29sbJuyODQv3q3SjYE2FaR7MiRTSBop2JnJ23o54Y0GDr8mbXbHMblrIXFMuP2SD9BNvWcjgFu/ltNUkT5CqBcxV2UtX0VSVl9km66Gyozrr4nfIKxPNUe7tfjsLD5CPJpj7xLn7bn00ubr/bKA5ynVLbSbR2t1qIDeQTQPMbXKuhtrJXvuDf6C1/bY4oqe7yrFXOReIGpRFg9YPrY3Gk5jMmxzL3/lADGqQdMi7D7RceYrsD2Bsn6/1cqxDPRfZhvgbYpZr6hmuDM9Thcnn62yoyMu5L9D6G+KvaKL/AgwAZFjBTyIfWREAAAAASUVORK5CYII="
                            style="width: 5.3mm;"/>
                    </h2>
                    <ul>
                        <li>Регистрационный взнос</li>
                        <li>Питание на мероприятии</li>
                        <li>Билет на банкет (при наличии мест)</li>
                        <li>Подписка на журнал «Интернет в Цифрах»</li>
                    </ul>
                </div>
            </div>
        </div>
        <sethtmlpagefooter name="main-footer" value="on" show-this-page="1"/>
    </div>
</div>
<pagebreak/>
<div class="page-transport">
    <header>
        <div class="container">
            <div class="row">
                <!-- Логотип -->
                <div class="col-7">
                    <div class="logo">
                        <img title="" alt="" height="50"
                             src="data:image/png;base64,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"/>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div role="main">
        <div class="container">
            <!-- Заголовок -->
            <div class="row row-transport">
                <div class="col-12">
                    <div class="title">Как добраться?</div>
                    <!-- Автобусы конференции -->
                    <div class="row" style="margin-bottom: 5mm;">
                        <div class="col-1 text-right">
                            <img alt=""
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAZCAYAAAAv3j5gAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA0tJREFUeNqklk1oE1EQxzebTdKGGFM/UrSWVihUbQzSYnuJFnrwpgjFc0DwJB6l0rMHD0VB6sGzgqBCb3rSgoJFD7loL1rwI0q1FFsLanezSfxN+jY8Y5Lu4sDwvmbn6/1n3oby+bwRCoWMSqViQCbzC4yn4OewDYcMf1SFIpZlja+vry/Mzc3dTCQSzuTkpBEOhw1LSXjCoxi6jtEP7E2ZphkOYojvXCifSqXODg4OLhaLxcfeoRg6ifJuFD9kvMI6zrikWHeiLYmseA7Jd8PZbHaa+VP4NDpWLDZvsBi2bXsgGo3uU8IZ9s8wbsKOz4hicATOlstlIx6Pd+VyuQwRPiDSguVJYaSTVP1megsP3jiOE2W9EolEbNbbpg/lHSjs5Y5mxXG+GcNITE+dd5Od8Bp8jeVnBQ7faZMUa2k+zN4dxo5/DHEQgWVdNf6fShgVT6PiRM0QGzOMvWyswlHJghySAt9aJRIPDEpxSZwmK6ucXWb+RbTdU/J94oGqB4O7MRqg35a4T11eDIUUkGb+Sp0YUUJuK48DkBioqAxtOaLdkeQz3O6OdGMyb2O8JIZUhoxmEQm5zRT7uacmhurwNj1YSp9iHRZLQaDdIkIxVNYjMuUSFccQLDM63uX6BYIeEUUqxSvwdtAX8xwwdeDA++EJeFeAZtpIKWCeQ/kBXYeleV3lcAB+RA2tsX4vjZWxyPgN/sH8l4ZKAU4cTsLdSvEAZXGQ+W5lpNIMDDGlRHLbJSxduB3y2gDGVvrqLcj0cghLp14kv8fgceYXifZlgJQVkL8EkCYYj8CvVfffiqhUKnnzt6RMno0eeV0x9oxxL1tj24FCHEXPPHKzyAvSjktdMl+qy2QymTpqhoaGXvD8juLVV9YbAgp5FH2iTvraCmjdKd/wvr3jhT0qSK5FNDIy4slKPhMYkUvuUZEFqaM9wto6DjDE6PeaoeXlZc8jO51OuzyAgeqnVU1hxO3v77frd5RMJuvnhH0XoUPMO7WPPjFs6H2xgQTCO/C8T2+qZOY+/LOZIalo+QOSJ/2qtneevScNpaCTi/wJLn5e1Zb8ut2mQ0zr0Lea9DV5gj+qd2kTJa+UjNsqVXSCAsM5VcAS+UJjC/sjwAAT6pRt15sXzAAAAABJRU5ErkJggg=="/>
                        </div>
                        <div class="col-4">
                            <h3>Автобусы конференции</h3>
                            Автобусы отправляются от ст. м. «Молодёжная» до пансионата «Лесные Дали» см. место посадки
                        </div>

                        <div class="col-1 text-right">
                            <img alt=""
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAVCAYAAABYHP4bAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAutJREFUeNq8ls9LVFEUx+978+aHkw0WYlimIBk62CqiGgmDMgSRatUiBUHcBUGt+gtq4y6IWrsMNxNiLoQEa6MYJNMwRbscBWPQIZvf0+drzxCbwmfggcO579xzzvfee86591mjo6MmmUya+fl5I2pubjYDAwNma2vLrlQqp0KhUHu1Wj1hWdYxZAiTkPlFOXQ5dBnkWj6f/4L8Gg6HK1NTU2ZlZWXbqKenx3R2dhrH1CCcLziOM47jeQVG2tIj/7B1dZVAICDQRcYP4IW9dnYNx9PwpG3bV5DhWjY1yJatfBi/hFv2GjilUsm0tbWZpqYmw1EZVna3XC63sLo3zM/AfrM/KsI38O3luIYKhcITgE1dXZ0RhkNABTfBYNBg5Pf5fMPSQQ/hReONXuO7UF9fP0yscWIVFUsb0LEo6Y0oWlnBHWQU3Vudtwu4L5KtmyP5Rt1YrYotDBXDfZT3kFI4rtOEkuw67xvM9ZFvjM/ncInY64A9dfx+/zUG7bsCbjKedccBL+eGXwExC9AmMuKCR8Dos6jx7mg0OhiJRIbQ69hknMKpJDuPOaoSWKdyVoskRiKbzU4kEom4s7Gxsby6urpMY/ZREFEmtYvuWj3jheRP5a0R+zEYxhoZGdGWzzHxjvkjbpmqSHwHxCirgd22+E5aLpOnD2o0w6BLIAB+hnuZvIlc94ogH8r6FvKqYikmJd4lDCeXyxk+GkiYDOe0M4wF/p7xdS9ALHCpWCy+Uk9Cc/AZvhvURw7naACxBAT1A3Yb4OOAXPS6I/wuwWME/oZ/v3bCrWABZhx97CQeeRIx+R81cBR+oatnd1Fsp8ccEh0aUK33SFeEKu5ADevGbNzrWwsoS0EMIj/CQY9AeVjlPLNzBf0GisfjpqOjIx2LxdTJKvE0nHTvK+OxvOWfpPLSuuO2c2PbaRWHTz2TyWRSPH7rXEM/MHzE/Ke/Pd3/unL0wMF5gJb4FYhw9Tybnp6eSKVS5qcAAwAj+HJyQ4fmhwAAAABJRU5ErkJggg=="/>
                        </div>
                        <div class="col-4">
                            <h3>Личный автотранспорт</h3>
                            38 км. от МКАД по Рублёво-Успенскому шоссе<br/>Московская область, Одинцовский район, поселок Горки-10, пансионат «Лесные Дали»
                        </div>
                    </div>

                    <!-- Электричка -->
                    <div class="row" style="margin-bottom: 5mm;">
                        <div class="col-1 text-right">
                            <img alt=""
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAmCAYAAADa8osYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABMdJREFUeNrsl01oXFUUgN+8efOXzGQyJE5k4k+kKUm1JEiLCxe2tabFhQ1IESFQ0KyqUqkiWdSN2CJqC/5sdNO60IULF4oFUVQ0QlHUCCXShcWYMMMU0iZNMiQzycz4nTf3jtfJm5nXjSsvHO59755zz/+55wbGx8etQCBgyQiHw1YsFnO/q9WqVSqVrK2tLfeb//dWKpXI3NzcTCqV6unt7d1dLpd/YW+N/y5uKBSyHMdxaRYXF921nCPDWV5edhfyo6+vr77WQ5jYtj3M/BOz3d/fv48DjoPzFNvvMp+wjCG0QrO6uuoCJDVGWpvGoQlESpC3+FXmu4zWReai7KNJCa086ZWA/zCyvEcKxAEgwprzKqLiK2JdDk7w/2sOWIbZD6z3GAJfB/4UoRoPbGQUguAk87PAXaKNGmUOnWa+GQwGH2G9yXodmAD/ToN+A/gWmALn8r8YaX8oM73J/LzpI2XG74GHdZDUuZfLR/DXpwZqFHgUYe7HxAfX1tZ+1/i2RIbYMZFI7I9GoycamahR8GBuKa28/HN7Op0+E4lE3EgWcIgivXkYXwRMZxoHHgDOAisinNovCY3GF2ElzK2aUy2EfnBoaEjMutDoo7TB5MbGxsaHMMmRP8IxhDnELCEDv4N/3zF/AV51ZWUlGI/Hx/jep/eBbi9G2jYV6I4Vi8WLErqdnZ1WsxA2zSg5A6PXWV9E0EPqvLq9bQ+iWaZvdB408ZlnzjAk3z7xwvHKo6IkYkdHR93efkZPT4/GLXgVAS9GgZqQgW3lqJXpdAVQ9L4YycmVZqWpmekMoTxNsM1HJG06n8/fls1mLaMy+NJqdnZWNNvhixEEUnpeJpFTrIVT2Ae4eOTOAbR7xpfpJJS5Lp5j+Tjr6wF/NqyC5gwPD98DTdSvj3T0ZBT4Hq3yzbb+o/E/o5a51CpumjGSwipXctYnn8Lm5uYVgmH1lhgRda8ySeLtBC60YZIlScfm5+d3kej7ycGFdoy03leBd2q5W5Ub9LQU2mbmoof7mJ7uktQ6tPqV7/NeNc9kdFNfWBDFpKQoSDbLN9WSJSR/BgYGrJmZGSuXyyWlPRDh2FvXvguOjIxoujg/nmBOAHeoe0larrek9Wpqe5pLphvgXKMEHc1kMqdYh6H/DThX135iYqJeT5FEbscx9b2uNI74iDgJngL0nWhni83x8xG2PvcynfRqx0D4UpX7mB8myoRyTgL/2DBa4nvSZLIt6pAsTy9+GHjBuMhu5aq4jI/uQ9gLho9rF6P5IS+Crq6uCK+Fx/xe4Q2C7qZ9e0CCoxGcxoqLnaekj1MNxxVCNsd3sJUisg/uXjE389sI/SOC5s1K4Ug3aai+F8QpQUC77NLS0qHu7u4Fn+XnNHCKM+6mMz2DgJOmVWz9tACiNITnVGMoD6mp6enpBb++4tDXYHJJMX4auqPm08U85SXgIaXZB5jwo2Qy6btfgFEBkJdIQbngDayV0b13cHR0VP7vgft5dff/BeGTdJ2FwcFB15HtWi4xkWImdU80OihvLGmJ+f+ZjroxNt5XeSO160XgGjZ2o7Bd9MnB0i1p4Kyz6o0kY1KeoMLIUQ8pUfdn4A8O/qpRg3b9ifjUGCXo34Mmrh52GSD1twADAOz0d+YcPWtKAAAAAElFTkSuQmCC"/>
                        </div>
                        <div class="col-4">
                            <h3>Электричка</h3>
                            Электричкой с Белорусского вокзала или платформ "Беговая", "Фили", "Кунцево" (около одноименных станций метро) до платформы Жаворонки, а далее местным автобусом №32 до пансионата "Лесные Дали" (ходит редко).
                        </div>
                        <div class="col-1 text-right">
                            <img alt=""
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3NJREFUeNq0lstrE2EQwHc3mzSJsXlJmlRikKonixW9iO2hUMG7hyhePYj9F7yJgvQg3kUvguJJqh7Vgz14sD2ViiW0PkBCEDUmzfvhb7bfhm0am0RxYJjd+eY9882unk6nNYFms2lRr9erZbNZedcnJiaCjUYj2G6393E0ouu6W2R4F1IHq/C2oD9rtdovwzDa9XrdssWzVq1WtUwmo5mtVstSQtiivB+JRqNXoIcR9sEzMFIDGzzrEg/oEl+gCc8DbZmmWcZwBif3eN8UWy6XS0skEpopxt1utyYRIJTk+QHGFwOBwDOi+4DCD3hNFf0OEF30XNAoBo+VSqVpn88n+hfhZdHXqIRmSlpEYSmAl9F9XalUFqRsdnZ9QDLLIZcrl8tLOAkR1CV070iVBAxVrgQHp4hmhsPn4XBYGwZURhbm8/kX2JwFT2J3TOwbGD9DNo+QfYfwUeiGrTxAFh05j8ejxWIxbXR0NIOd4+AKQT8kYK+JkxnkzoJLCH+ClmxlaZwY+JMz4Uu5JRM7I9GH/xbMoj8diURShpRKTckXaBFa6mXYNtQNEojtSGFBjbXY82InLNN1UBkpMg2tQqGwIzIZAMFux7ZRuxeO7FrIt3BeUO8RExpXlzFL6SKhUGhXpHv1R85tGUcAMvI5FUhIynSVCfBydgDGhW4F+6L2m64uGRc2X3JHnhL4pjhZUxHNqls9kOFeIOOqHLbUlli27okwpXFqTcRA6ZFH+zsYAZPgmOwx2SQCpqMsNSkXeA78LCMIW/C7TJ29ENUNN1UgYmU/GAETGB6DHgL96N+0N4bprKOiQYQnSX2yT923V8Z2FTrPapU05NUeFsMhLw51yaBYLC6rmg4DVaWXU7Y6CTidSPo5JmJudXX1NM5uD+OBK3BD9KDnef2mSrnLiQvDXynJRiqVEqWVYRYkwa0kk9JzLaN6aTpLZEMd4SlGeSEej7/ByfVBnVjNNc1b4+PjAXoyB0sWZKPjxNFMQ0U1j9K8s6GDAMFNoffEYU/vVa7/BsYg9f6X8+6eONfDXcr1nr6kwCA3V/5WvGpDyIDIhZQLUWFzb9GPPPyP8E+gd20vJ87b/wpclF8bvtvWP4AzcudGlnO/329tYoJLO5z0nK518D7o4/uwbi+7fgMg5/JHIn8mOFojoMewtwik8xn/LcAALeLg3cqH3A8AAAAASUVORK5CYII="/>
                        </div>
                        <div class="col-4">
                            <h3>Маршрутное такси</h3>
                            На маршрутном такси №121 от станции метро "Молодежная" прямо до пансионата «Лесные Дали». Маршрутка отправляется каждые 15-20 минут по наполнению.
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <img src="/img/event/rif15/ticket/map_bus.jpg" style="image-resolution: 100dpi;"/>
            </div>

            <!-- Расписание автобусов -->
            <div class="row row-bus_timeline" style="padding-left: 9mm;">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="title">Расписание автобусов</div>
                        </div>
                    </div>

                    <div class="row row-fill">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3">
                                    <h3>13 апреля</h3>
                                </div>
                                <div class="col-3">
                                    <h3>14 апреля</h3>
                                </div>
                                <div class="col-3">
                                    <h3>15 апреля</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h4>M. «Молодёжная» → П-т «Поляны» <span>(время в пути – 60 минут без учета пробок)</span>
                            </h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div
                                    class="col-3">07:30, 08:00, 08:10, 08:20, 08:30, 08:40, 08:50, 09:00, 09:15, 09:30, 10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30, 14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00
                                </div>
                                <div
                                    class="col-3">07:30, 08:00, 08:10, 08:20, 08:30, 08:40, 08:50, 09:00, 09:15, 09:30, 10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30, 14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00
                                </div>
                                <div
                                    class="col-3">07:30, 08:00, 08:15, 08:30, 08:40, 08:50, 09:00, 09:15, 09:30, 10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30, 14:00, 14:30, 15:00, 15:30, 16:00, 16:30
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h4>«Лесные дали» → «Поляны»
                                <span>(отправление по заполнению, но не реже 1 раза в 10 минут)</span></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3">№ 1м:&nbsp;&nbsp;&nbsp;с 08.00 до 24.00</div>
                                <div class="col-3">№ 1м:&nbsp;&nbsp;&nbsp;с 08.00 до 24.00</div>
                                <div class="col-3">№ 1м:&nbsp;&nbsp;&nbsp;с 08.00 до 20.20</div>
                            </div>
                            <div class="row">
                                <div class="col-3">№ 2м:&nbsp;&nbsp;&nbsp;с 08.00 до 24.00</div>
                                <div class="col-3">№ 2м:&nbsp;&nbsp;&nbsp;с 08.00 до 24.00</div>
                                <div class="col-3">№ 2м:&nbsp;&nbsp;&nbsp;с 08.00 до 19.50</div>
                            </div>
                            <div class="row">
                                <div class="col-3">№ 3м:&nbsp;&nbsp;&nbsp;с 08.00 до 21.00</div>
                                <div class="col-3">№ 3м:&nbsp;&nbsp;&nbsp;с 08.00 до 21.00</div>
                                <div class="col-3">№ 3м:&nbsp;&nbsp;&nbsp;с 08.00 до 18.50</div>
                            </div>
                        </div>
                    </div>
                </div>
                </section>
            </div>
        </div>
        <sethtmlpagefooter name="main-footer" value="on" show-this-page="1"/>
    </div>
</div>

<pagebreak/>
<div class="text-center">
    <img src="/img/event/rif16/ticket/map.jpg" class="img-responsive"/>
</div>
<sethtmlpagefooter name="main-footer" value="on" show-this-page="1"/>

<?php if (!empty($parking) && $roomProductManager !== null): ?><?php
    $showText2 = false;

    switch ($roomProductManager->Hotel) {
        case Rif::HOTEL_LD:
            $y = 580;
            $name = 'dali';
            $showText2 = true;
            break;

        case RIF::HOTEL_P:
            $y = 830;
            $name = 'polyany';
            $showText2 = false;
            break;
    }

    $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot.img.event.rif16.ticket.'.$name).'.png');
    $text1 = mb_strtoupper($parking['carNumber']);

    $path = '/img/event/rif16/ticket/car_rendered/'.$user->RunetId.'.jpg';
    $image->text($text1, 160, 0, $y);
    $image->save(\Yii::getPathOfAlias('webroot').$path);

    if ($showText2) {
        $dates = [];
        $datetime = new \DateTime($roomOrderItem->getItemAttribute('DateIn'));
        while ($datetime->format('Y-m-d') <= $roomOrderItem->getItemAttribute('DateOut')) {
            $dates[] = $datetime->format('d');
            $datetime->modify('+1 day');
        }
        $text2 = implode(',', $dates);

        $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot').$path);
        $image->text($text2, 100, 300, 820);
        $image->save(\Yii::getPathOfAlias('webroot').$path);
    }
    ?>
    <pagebreak orientation="L"/>
    <div class="text-center">
        <img src="<?= $path; ?>"/>
    </div>
    <pagebreak orientation="L"/>
    <div class="text-center">
        <img src="/img/event/rif16/ticket/map_all.png"/>
    </div>
<?php endif; ?>

<?php if ($parkingReporter): ?>
    <pagebreak orientation="L"/>
    <?php
    $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot.img.event.rif16.ticket.reporter').'.png');
    $text1 = mb_strtoupper($parking['carNumber']);
    $path = '/img/event/rif16/ticket/car_rendered/'.$user->RunetId.'-r.jpg';
    $image->text($text1, 160, 0, 530);
    $image->save(\Yii::getPathOfAlias('webroot').$path);
    $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot').$path);
    $image->text('22,23,24', 100, 300, 810);
    $image->save(\Yii::getPathOfAlias('webroot').$path)
    ?>
    <div class="text-center">
        <img src="<?= $path; ?>"/>
    </div>
    <pagebreak orientation="L"/>
    <div class="text-center">
        <img src="/img/event/rif16/ticket/map_reporter.png"/>
    </div>
<? endif; ?>


