<?php
/**
 * @var User $user
 * @var Event $event
 * @var Participant|Participant[] $participant
 */

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
$parkingReporterRoleIdList = [3,6];
$parking = null;
if ($roomProductManager !== null || in_array($role->Id, $parkingReporterRoleIdList)) {
    $command = Rif::getDb()->createCommand();
    $command->select('*')->from('ext_booked_parking')->where('ownerRunetId = :RunetId');
    $parking = $command->queryRow(true, ['RunetId' => $user->RunetId]);
}
$parkingReporter = !empty($parking) && in_array($role->Id, $parkingReporterRoleIdList) && ($roomProductManager == null || $roomProductManager->Hotel != Rif::HOTEL_P);
?>
<style type="text/css">
    html {font-family:sans-serif;}
    body {margin:0}
    article,aside,details,figcaption,figure,footer,header,main,nav,section,summary {display:block}
    audio,canvas,progress,video {display:inline-block;vertical-align:baseline}
    audio:not([controls]) {display:none;height:0}
    [hidden],template {display:none}
    a {background:transparent}
    a:active,a:hover {outline:0}
    abbr[title] {border-bottom:0.2mm dotted}
    b,strong {font-weight:bold}
    dfn {font-style:italic}
    h1 {font-size:2em;margin:0.67em 0}
    mark {background:#ff0;color:#000}
    small {font-size:80%}
    sub,sup {font-size:75%;line-height:0;position:relative;vertical-align:baseline}
    sup {top:-0.5em}
    sub {bottom:-0.25em}
    img {border:0}
    svg:not(:root) {overflow:hidden}
    figure {margin:1em 10.5mm}
    hr {-moz-box-sizing:content-box;box-sizing:content-box;height:0}
    pre {overflow:auto}
    code,kbd,pre,samp {font-family:monospace, monospace;font-size:1em}
    button,input,optgroup,select,textarea {color:inherit;font:inherit;margin:0}
    button {overflow:visible}
    button,select {text-transform:none}
    button,html input[type="button"],input[type="reset"],input[type="submit"] {-webkit-appearance:button;cursor:pointer}
    button[disabled],html input[disabled] {cursor:default}
    button::-moz-focus-inner,input::-moz-focus-inner {border:0;padding:0}
    input {line-height:normal}
    input[type="checkbox"],input[type="radio"] {box-sizing:border-box;padding:0}
    input[type="number"]::-webkit-inner-spin-button,input[type="number"]::-webkit-outer-spin-button {height:auto}
    input[type="search"] {-webkit-appearance:textfield;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box}
    input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration {-webkit-appearance:none}
    fieldset {border:0.2mm solid #c0c0c0;margin:0 0.5mm;padding:0.35em 0.625em 0.75em}
    legend {border:0;padding:0}
    textarea {overflow:auto}
    optgroup {font-weight:bold}
    table {border-collapse:collapse;border-spacing:0}
    td,th {padding:0}
    * {-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}
    *:before,*:after {-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}
    html {font-size:62.5%;-webkit-tap-highlight-color:rgba(0,0,0,0)}
    body {font-family:Arial,Helvetica,sans-serif;font-size:3.7mm;line-height:1.42857143;color:#1a1a1a;background-color:#fff}
    input,button,select,textarea {font-family:inherit;font-size:inherit;line-height:inherit}
    a {color:#2eaff2;text-decoration:none}
    a:hover,a:focus {color:#0c87c7;text-decoration:underline}
    a:focus {outline:thin dotted;outline:1.3mm auto -webkit-focus-ring-color;outline-offset:-0.5mm}
    figure {margin:0}
    img {vertical-align:middle}
    .img-responsive {display:block;max-width:100%;height:auto}
    .img-rounded {border-radius:1.6mm}
    .img-thumbnail {padding:1mm;line-height:1.42857143;background-color:#fff;border:0.2mm solid #ddd;border-radius:1mm;-webkit-transition:all .2s ease-in-out;transition:all .2s ease-in-out;display:inline-block;max-width:100%;height:auto}
    .img-circle {border-radius:50%}
    hr {margin-top:5.3mm;margin-bottom:5.3mm;border:0;border-top:0.2mm solid #eee}
    .sr-only {position:absolute;width:0.2mm;height:0.2mm;margin:-0.2mm;padding:0;overflow:hidden;clip:rect(0, 0, 0, 0);border:0}
    h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6 {font-family:inherit;font-weight:500;line-height:1.1;color:inherit}
    h1 small,h2 small,h3 small,h4 small,h5 small,h6 small,.h1 small,.h2 small,.h3 small,.h4 small,.h5 small,.h6 small,h1 .small,h2 .small,h3 .small,h4 .small,h5 .small,h6 .small,.h1 .small,.h2 .small,.h3 .small,.h4 .small,.h5 .small,.h6 .small {font-weight:normal;line-height:1;color:#999}
    h1,.h1,h2,.h2,h3,.h3 {margin-top:1.3mm;margin-bottom:2.6mm}
    h1 small,.h1 small,h2 small,.h2 small,h3 small,.h3 small,h1 .small,.h1 .small,h2 .small,.h2 .small,h3 .small,.h3 .small {font-size:65%}
    h4,.h4,h5,.h5,h6,.h6 {margin-top:2.6mm;margin-bottom:2.6mm}
    h4 small,.h4 small,h5 small,.h5 small,h6 small,.h6 small,h4 .small,.h4 .small,h5 .small,.h5 .small,h6 .small,.h6 .small {font-size:75%}
    h1,.h1 {font-size:31.6mm}
    h2,.h2 {font-size:4.8mm}
    h3,.h3 {font-size:11.6mm}
    h4,.h4 {font-size:3.4mm}
    h5,.h5 {font-size:3.7mm}
    h6,.h6 {font-size:10.5mm}
    p {margin:0 0 2.6mm}
    .lead {margin-bottom:5.3mm;font-size:11.6mm;font-weight:200;line-height:1.4}
    small,.small {font-size:85%}
    cite {font-style:normal}
    .text-left {text-align:left}
    .text-right {text-align:right}
    .text-center {text-align:center}
    .text-justify {text-align:justify}
    .text-muted {color:#999}
    .text-primary {color:#2eaff2}
    a.text-primary:hover {color:#0e98df}
    .text-success {color:#3c763d}
    a.text-success:hover {color:#2b542c}
    .text-info {color:#31708f}
    a.text-info:hover {color:#245269}
    .text-warning {color:#8a6d3b}
    a.text-warning:hover {color:#66512c}
    .text-danger {color:#a94442}
    a.text-danger:hover {color:#843534}
    .bg-primary {color:#fff;background-color:#2eaff2}
    a.bg-primary:hover {background-color:#0e98df}
    .bg-success {background-color:#dff0d8}
    a.bg-success:hover {background-color:#c1e2b3}
    .bg-info {background-color:#d9edf7}
    a.bg-info:hover {background-color:#afd9ee}
    .bg-warning {background-color:#fcf8e3}
    a.bg-warning:hover {background-color:#f7ecb5}
    .bg-danger {background-color:#f2dede}
    a.bg-danger:hover {background-color:#e4b9b9}
    .page-header {padding-bottom:2.3mm;margin:10.5mm 0 5.3mm;border-bottom:0.2mm solid #eee}
    ul,ol {margin-top:0;margin-bottom:2.6mm}
    ul ul,ol ul,ul ol,ol ol {margin-bottom:0}
    .list-unstyled {padding-left:0;list-style:none}
    .list-inline {padding-left:0;list-style:none;margin-left:-1.3mm}
    .list-inline>li {display:inline-block;padding-left:1.3mm;padding-right:1.3mm}
    dl {margin-top:0;margin-bottom:5.3mm}
    dt,dd {line-height:1.42857143}
    dt {font-weight:bold}
    dd {margin-left:0}
    abbr[title],abbr[data-original-title] {cursor:help;border-bottom:0.2mm dotted #999}
    .initialism {font-size:90%;text-transform:uppercase}
    blockquote {padding:2.6mm 5.3mm;margin:0 0 5.3mm;font-size:17.1.3mm;border-left:1.3mm solid #eee}
    blockquote p:last-child,blockquote ul:last-child,blockquote ol:last-child {margin-bottom:0}
    blockquote footer,blockquote small,blockquote .small {display:block;font-size:80%;line-height:1.42857143;color:#999}
    blockquote footer:before,blockquote small:before,blockquote .small:before {content:'\2014 \00A0'}
    .blockquote-reverse,blockquote.pull-right {padding-right:4mm;padding-left:0;border-right:1.3mm solid #eee;border-left:0;text-align:right}
    .blockquote-reverse footer:before,blockquote.pull-right footer:before,.blockquote-reverse small:before,blockquote.pull-right small:before,.blockquote-reverse .small:before,blockquote.pull-right .small:before {content:''}
    .blockquote-reverse footer:after,blockquote.pull-right footer:after,.blockquote-reverse small:after,blockquote.pull-right small:after,.blockquote-reverse .small:after,blockquote.pull-right .small:after {content:'\00A0 \2014'}
    blockquote:before,blockquote:after {content:""}
    address {margin-bottom:5.3mm;font-style:normal;line-height:1.42857143}
    code,kbd,pre,samp {font-family:Menlo,Monaco,Consolas,"Courier New",monospace}
    code {padding:0.5mm 1mm;font-size:90%;color:#c7254e;background-color:#f9f2f4;white-space:nowrap;border-radius:1mm}
    kbd {padding:0.5mm 1mm;font-size:90%;color:#fff;background-color:#333;border-radius:0.8mm;box-shadow:inset 0 -0.2mm 0 rgba(0,0,0,0.25)}
    pre {display:block;padding:9.1.3mm;margin:0 0 2.6mm;font-size:3.4mm;line-height:1.42857143;word-break:break-all;word-wrap:break-word;color:#333;background-color:#f5f5f5;border:0.2mm solid #ccc;border-radius:1mm}
    pre code {padding:0;font-size:inherit;color:inherit;white-space:pre-wrap;background-color:transparent;border-radius:0}
    .container {margin-right:auto;margin-left:auto;padding-left:4mm;padding-right:4mm}
    .container-fluid {margin-right:auto;margin-left:auto;padding-left:4mm;padding-right:4mm}
    .row {margin-left:-4mm;margin-right:-4mm;}
    .row:after {
        content:" ";
        visibility:hidden;
        display:block;
        height:0;
        clear:both
    }
    .col-1, .col-sm-1, .col-md-1, .col-lg-1, .col-2, .col-sm-2, .col-md-2, .col-lg-2, .col-3, .col-sm-3, .col-md-3, .col-lg-3, .col-4, .col-sm-4, .col-md-4, .col-lg-4, .col-5, .col-sm-5, .col-md-5, .col-lg-5, .col-6, .col-sm-6, .col-md-6, .col-lg-6, .col-7, .col-sm-7, .col-md-7, .col-lg-7, .col-8, .col-sm-8, .col-md-8, .col-lg-8, .col-9, .col-sm-9, .col-md-9, .col-lg-9, .col-10, .col-sm-10, .col-md-10, .col-lg-10, .col-11, .col-sm-11, .col-md-11, .col-lg-11, .col-12, .col-sm-12, .col-md-12, .col-lg-12 {position:relative;min-height:0.2mm;padding-left:4mm;padding-right:4mm}
    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {float:left}
    .col-12 {width:100%}
    .col-11 {width:91.66666667%}
    .col-10 {width:83.33333333%}
    .col-9 {width:75%}
    .col-8 {width:66.66666667%}
    .col-7 {width:58.33333333%}
    .col-6 {width:50%}
    .col-5 {width:41.66666667%}
    .col-4 {width:33.33333333%}
    .col-3 {width:25%}
    .col-2 {width:16.66666667%}
    .col-1 {width:8.33333333%}
    .col-offset-12 {margin-left:100%}
    .col-offset-11 {margin-left:91.66666667%}
    .col-offset-10 {margin-left:83.33333333%}
    .col-offset-9 {margin-left:75%}
    .col-offset-8 {margin-left:66.66666667%}
    .col-offset-7 {margin-left:58.33333333%}
    .col-offset-6 {margin-left:50%}
    .col-offset-5 {margin-left:41.66666667%}
    .col-offset-4 {margin-left:33.33333333%}
    .col-offset-3 {margin-left:25%}
    .col-offset-2 {margin-left:16.66666667%}
    .col-offset-1 {margin-left:8.33333333%}
    .col-offset-0 {margin-left:0}
    @import url(http://fonts.googleapis.com/css?family=Arimo:400,700&subset=latin,cyrillic);
    *,body {
        font-family:Arimo, sans-serif
    }
    header {
        border-bottom:0.2mm solid #E7E5E6;
        padding:2.6mm 0;
    }
    .row-userinfo .userinfo {
        font-size:7.5mm;
        line-height:7.4mm;
        margin:4mm 0
    }
    .row-userinfo .userinfo.status {
        color:#2DAEF2
    }
    .row-userinfo .userinfo.company {
        color:gray
    }
    .row-userinfo .qrcode > figcaption {
        text-align:center
    }
    .row-timeline {
        border-top:0.2mm solid #E7E5E6;
        color:#656565;
        padding:5.3mm 0 5.3mm;
        margin: 2.6mm 0 0;
    }
    .row-datetime {
        font-size:2.6mm;
        margin-top:2.6mm;
        margin-bottom:0;
    }
    .row-datetime .date {
        color:#222225;
        font-size:6mm;
    }
    .row-datetime .date > big {
        display:block;
        font-size:7mm
    }
    .row-datetime .time > span {
        color:#999
    }
    .row-reminder {
        color:#656565;
        padding:2.6mm 0 50mm;
        font-size:80%;
        background: #F2F3F4 url('/img/event/rif15/ticket/reminder_bg.jpg') center -30mm;
        background-image-resolution: 120dpi;
    }
    .row-reminder h2 {
        margin-bottom: 4mm;
    }
    .row-transport .title {
        color:#2DAEF2;
        font-size:5.3mm;
        line-height:5.3mm;
        margin: 5mm 0 5mm 9mm;
        padding: 0;
    }
    .row-bus_timeline {
        color:#656565;
        font-size:80%
    }
    .row-bus_timeline .title {
        font-size:5.3mm;
        margin: 10mm 0 5mm 0;
        padding: 0;
    }
    .row-bus_timeline h4 {
        margin-top:3mm;
        margin-bottom: 2mm
    }
    .footer {
        color:#C8C8CB;
        font-size:3mm;
    }
    ul >li {
        background: 0 0.8mm no-repeat url(data:image/png; base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAYAAAA71pVKAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAESSURBVHjalNO/K8RxHMfxh08GFl0334JMyEI2SUluduEyWC47f4PZrkQhKbNSMsiirpTOhhKy6LqNjeX91amju9fyqff79fz07v2jq1KpaFIPVrCASfThHTc4wQE+M3NqAkdwiS28YQ3z2MBrxK8wlgHd8Q7jAk+RfPRbB9jEMc4xjbuEXuwFMNcCzJTlH8Lf240yRjGEuv9Vj37co5ywhCM8a08v4V9MGMepznSKiYRcG+W2Kj+X0EC+QziPRkIVxQ7hIqopZreMQptgIfzHCYeoxfrl2yj3JPyHCR9YxQDO0P8H2B/5wfB/ZLtdwwy+cItdlCJWwk7EuzAb/p/dzj6Yarqq7RhjA9dYx37zVX0PAB99QGeygeZKAAAAAElFTkSuQmCC);
        list-style:none;
        margin-bottom:0.2mm;
        padding:0.8mm 0 0.5mm 5.3mm;
        font-size:10.2mm
    }
    .row-transport, .row-userinfo {
        padding:0
    }
    .row-timeline h3,.row-transport h3 {
        font-size:3.4mm;
        font-weight:400;
        margin:0;
        padding:0 0 0.8mm
    }
    .row-bus_timeline .row-fill h3, ul {
        margin:0;
        padding:0
    }
    .row-bus_timeline .row-fill h3 {
        font-size:6mm;
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
    table.food-table td,table.food-table th {
        text-align: center;
        font-size: 2.3mm;
        padding: 0.5mm 0.2mm;
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
                    <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAyMDggMzQuNTI0IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAyMDggMzQuNTI0IiB4bWw6c3BhY2U9InByZXNlcnZlIj48Zz48cGF0aCBmaWxsPSIjMTdBNjY5IiBkPSJNMTkuODc3LDQuNzRjMS45NDgtMC45NjYsMy44NjYtMS43NTksNS42OTctMi4zNTljMC4wNTEtMC4wMTUsMC4wODctMC4wNjEsMC4wOTItMC4xMTFjMC4wMDUtMC4wNTQtMC4wMjItMC4xMDQtMC4wNjktMC4xM2MtMC42OTUtMC4zODQtMS40MjEtMC43Mi0yLjE2Mi0xLjAwNGMtMC4wMjQtMC4wMDktMC4wNTEtMC4wMDktMC4wNzgtMC4wMDVjLTEuNzM1LDAuNDExLTMuNTE1LDAuOTcxLTUuMjkxLDEuNjY5QzguMzk4LDYuNzgzLDIuMzI5LDExLjM0NywwLjAzMywxNi4zNmMtMC4wMDYsMC4wMTUtMC4wMTIsMC4wMzMtMC4wMTIsMC4wNDljLTAuMTA0LDIuMTAyLDAuMTc1LDQuMTgzLDAuODI1LDYuMTk0YzAuMDE4LDAuMDUzLDAuMDcsMC4wOTEsMC4xMjcsMC4wOTFjMC4wMDMsMCwwLjAwNywwLDAuMDExLDBjMC4wNjEtMC4wMDYsMC4xMS0wLjA1MiwwLjEyMS0wLjExMkMxLjk4OSwxNi42OSw4LjMwNSwxMC42ODcsMTkuODc3LDQuNzR6Ii8+PHBhdGggZmlsbD0iIzE3QTY2OSIgZD0iTTIuMjk4LDkuMDYyYzAuMDMxLDAsMC4wNjEtMC4wMTEsMC4wODctMC4wMzRjMy4xOS0yLjgzMSw4LjA1LTUuMjkxLDE0LjQ0LTcuMzA5YzEuNDM4LTAuNDIzLDIuOTA5LTAuNzYzLDQuMzctMS4wMDdjMC4wNjItMC4wMSwwLjEwOC0wLjA2NCwwLjExMS0wLjEyNmMwLjAwMi0wLjA2My0wLjA0My0wLjExOS0wLjEwMy0wLjEzNEMxOS45MTYsMC4xNTMsMTguNTg4LDAsMTcuMjYzLDBDMTIuNjUxLDAsOC4zMTcsMS43OTQsNS4wNTcsNS4wNTJDMy45Myw2LjE4MywyLjk2Miw3LjQ2NiwyLjE4MSw4Ljg2NkMyLjE1LDguOTIzLDIuMTYyLDguOTkzLDIuMjE0LDkuMDMzQzIuMjM4LDkuMDU0LDIuMjY4LDkuMDYyLDIuMjk4LDkuMDYyeiIvPjxwYXRoIGZpbGw9IiMxN0E2NjkiIGQ9Ik0zMy4zMTIsMTAuOTQzYzAuMDA2LTAuMDI2LDAuMDAzLTAuMDU1LTAuMDA3LTAuMDc5Yy0wLjI4MS0wLjcwOS0wLjYyMi0xLjQxNi0xLjAxMS0yLjEwMmMtMC4wMjctMC4wNDQtMC4wNzctMC4wNzUtMC4xMjgtMC4wNjZjLTAuMDUyLDAuMDA0LTAuMDk1LDAuMDQyLTAuMTEzLDAuMDkxYy0wLjU5OCwxLjg0OS0xLjM5OCwzLjc4My0yLjM3Myw1Ljc1MmMtNS45MjIsMTEuNTE5LTEyLjE0NiwxOC4wMi0xOC4wMDIsMTguNzk3Yy0wLjA1OSwwLjAwNi0wLjExLDAuMDU3LTAuMTE1LDAuMTE4Yy0wLjAwNSwwLjA2LDAuMDMyLDAuMTE3LDAuMDksMC4xMzljMS44MDIsMC42MTgsMy42OSwwLjkzLDUuNjEyLDAuOTNjMC4xNTQsMCwwLjMwOS0wLjAwMSwwLjQ2NC0wLjAwNWMwLjAxNywwLDAuMDMzLTAuMDA0LDAuMDQ4LTAuMDExYzUuMTI2LTIuMTk1LDkuNzg0LTguMzA0LDEzLjg0Ni0xOC4xNTlDMzIuMzI5LDE0LjU0LDMyLjg5NywxMi43MjMsMzMuMzEyLDEwLjk0M3oiLz48cGF0aCBmaWxsPSIjMTdBNjY5IiBkPSJNMzQuMDc1LDEzLjMyNWMtMC4wMTMtMC4wNi0wLjA2My0wLjA5Ni0wLjEzMy0wLjEwMmMtMC4wNjMsMC4wMDItMC4xMTQsMC4wNDktMC4xMjUsMC4xMTJjLTAuMjQ1LDEuNDYzLTAuNTg1LDIuOTMzLTEuMDA2LDQuMzY4Yy0yLjAyMSw2LjM5MS00LjQ4MSwxMS4yNTItNy4zMTMsMTQuNDQ1Yy0wLjA0NCwwLjA0Ni0wLjA0NCwwLjExOS0wLjAwNSwwLjE2OWMwLjAyNywwLjAzMywwLjA2NiwwLjA1MSwwLjEwNCwwLjA1MWMwLjAyMiwwLDAuMDQ2LTAuMDA0LDAuMDY0LTAuMDE4YzEuNDA0LTAuNzgsMi42ODUtMS43NDgsMy44MTItMi44NzZDMzMuNzIzLDI1LjIyMywzNS40NDMsMTkuMTg4LDM0LjA3NSwxMy4zMjV6Ii8+PHBhdGggZmlsbD0iIzE3QTY2OSIgZD0iTTI2LjkyOSwxMS43MDZjMS40MTItMS44NSwyLjY2LTMuNjA5LDMuNzA5LTUuMjI1YzAuMDMxLTAuMDQ3LDAuMDI2LTAuMTEtMC4wMS0wLjE1M2MtMC4zNjYtMC40NDgtMC43NTMtMC44NzUtMS4xNTItMS4yNzdjLTAuMzQzLTAuMzQxLTAuNzEzLTAuNjgtMS4xMzQtMS4wMjljLTAuMDQ1LTAuMDM4LTAuMTA2LTAuMDQyLTAuMTU3LTAuMDA5Yy0xLjYyMiwxLjA1My0zLjM4MywyLjMwMS01LjIzNywzLjcxNkM4Ljc3MiwxOC42NzksNC41OTEsMjQuNjI2LDMuNTgxLDI3LjY4OWMtMC4wMTUsMC4wNDEtMC4wMDgsMC4wODksMC4wMiwwLjEyYzAuNDY1LDAuNjAzLDAuOTU1LDEuMTYzLDEuNDU2LDEuNjY0YzAuNTUzLDAuNTUyLDEuMTY1LDEuMDg0LDEuODE2LDEuNTc1YzAuMDIxLDAuMDE4LDAuMDUsMC4wMjcsMC4wNzksMC4wMjdjMC4wMTMsMCwwLjAyOC0wLjAwNCwwLjA0Mi0wLjAwOEMxMC4wNTcsMzAuMDQ0LDE2LjAwMSwyNS44NTMsMjYuOTI5LDExLjcwNnoiLz48L2c+PGc+PHBhdGggZD0iTTQ4LjY5NywyNC4zMzRWOS45MTloOC4wNDVjMi45NTcsMCwzLjk1LDIuMTEsMy45NSw1LjA2N2MwLDIuNjA2LTEuMjQxLDQuODYtMy45MjksNC44NmgtNC43MzZ2NC40ODhINDguNjk3eiBNNTUuNTg0LDE3LjA5NWMwLjg2OSwwLDEuNDQ4LTAuNiwxLjQ0OC0yLjEwOWMwLTEuNTcyLTAuNDk2LTIuMjEzLTEuNDA2LTIuMjEzaC0zLjU5OHY0LjMyMkg1NS41ODR6Ii8+PHBhdGggZD0iTTc1LjkxMywyNC4zMzRoLTMuMjg4di05LjQ5MmMtMS42OTYsMy4yMDYtMy41NTcsNi40NzMtNS40MTgsOS40OTJoLTQuMzY0VjkuOTE5aDMuMjY4djkuODg1YzEuOTg1LTMuMjQ3LDMuOTUtNi41OTcsNS43MjgtOS44ODVoNC4wNzRWMjQuMzM0eiIvPjxwYXRoIGQ9Ik04Ny43MDEsOS45MTl2MS42NTRjNC44NiwwLjI0OCw2LjI2NiwxLjgyLDYuMjY2LDUuNTIyYzAsMy43MjItMS40MjcsNS4yNzQtNi4yNjYsNS41MjJ2MS43MTZoLTMuMzN2LTEuNjk2Yy00Ljc5OC0wLjI0OC02LjA1OS0xLjgyLTYuMDU5LTUuNTQyczEuMjYyLTUuMjc0LDYuMDU5LTUuNTIyVjkuOTE5SDg3LjcwMXogTTg0LjM3MSwxOS45Mjl2LTUuNjI1Yy0yLjMxNiwwLjA4My0yLjY4OCwwLjc0NC0yLjY4OCwyLjc5MkM4MS42ODMsMTkuMTIyLDgyLjA1NSwxOS44MjUsODQuMzcxLDE5LjkyOXogTTg3LjcwMSwxNC4zMDR2NS42MjVjMi41MDItMC4wODMsMi44MzMtMC43NjUsMi44MzMtMi44MzNTOTAuMjAzLDE0LjM2Niw4Ny43MDEsMTQuMzA0eiIvPjxwYXRoIGQ9Ik05NS40OTgsMTUuMjk2aDMuNTM2di0zLjU1N2gzLjA0djMuNTU3aDMuNTU3djMuMDRoLTMuNTU3djMuNTM2aC0zLjA0di0zLjUzNmgtMy41MzZWMTUuMjk2eiIvPjxwYXRoIGQ9Ik0xMTYuOTAyLDI0LjMzNGMtMS44NDEtNS4yOTQtMy4yMDYtNi40NzMtNS40OC02LjcyMXY2LjcyMWgtMy4zM1Y5LjkxOWgzLjMzdjYuOTA3YzEuMTU4LTEuMjgyLDMuMjQ3LTMuOTI5LDUuMDg4LTYuOTA3aDMuOTcxYy0yLjM5OSwzLjcyMy00LjA3NCw1Ljg3My00LjcxNSw2LjQ3M2MxLjUzLDAuNTc5LDIuOTk5LDEuNjc1LDUuMDg4LDcuOTQxSDExNi45MDJ6Ii8+PHBhdGggZD0iTTEzNS4zNywyNC4zMzRoLTMuMjg4di05LjQ5MmMtMS42OTYsMy4yMDYtMy41NTcsNi40NzMtNS40MTgsOS40OTJIMTIyLjNWOS45MTloMy4yNjh2OS44ODVjMS45ODUtMy4yNDcsMy45NS02LjU5Nyw1LjcyOC05Ljg4NWg0LjA3NFYyNC4zMzR6Ii8+PHBhdGggZD0iTTE0OS43NDMsMTIuODM1aC03LjY1MnYyLjY0N2g0LjgzOWMyLjUyMywwLDMuODY3LDEuNDg5LDMuODY3LDQuNDQ2YzAsMy40MTItMS40NjgsNC40MDUtMy44MDUsNC40MDVoLTguMjMxVjkuOTE5aDEwLjk4MVYxMi44MzV6IE0xNDYuMTI0LDIxLjVjMC43MDMsMCwxLjA1NS0wLjQ3NiwxLjA1NS0xLjU5MmMwLTEuMTc5LTAuMzkzLTEuNzE3LTEuMTM4LTEuNzE3aC0zLjk1VjIxLjVIMTQ2LjEyNHoiLz48cGF0aCBkPSJNMTU4LjYxNSwxMC4yOTFjMS4xNzktMC40MTQsMy4wNC0wLjcyNCw0LjkwMS0wLjcyNGMzLjYxOSwwLDUuMzk4LDAuODI3LDUuMzk4LDQuMzIyYzAsMi45OTktMC44NDgsMy45NzEtNi4xNjMsNy41MjhoNi4yMjV2Mi45MTZIMTU4LjE2di0yLjcwOWM2LjgwNC01LjA2Nyw3LjIxNy01LjQ2LDcuMjE3LTcuMzgzYzAtMS4zMDMtMC41MzgtMS42NzUtMi4yMTMtMS42NzVjLTEuMzI0LDAtMi45MzcsMC4yNjktMy44NDcsMC41NThMMTU4LjYxNSwxMC4yOTF6Ii8+PHBhdGggZD0iTTE4Mi4zNzcsMTYuOTNjMCw1LjkzNS0xLjkwMiw3LjY5My01LjU2Myw3LjY5M2MtMy42NiwwLTUuNTg0LTEuNzU4LTUuNTg0LTcuNjkzYzAtNS44MzIsMS45MjMtNy4zNjIsNS41ODQtNy4zNjJDMTgwLjQ3NCw5LjU2NywxODIuMzc3LDExLjA5OCwxODIuMzc3LDE2LjkzeiBNMTc5LjA2OCwxNi45M2MwLTMuOTA5LTAuMzUyLTQuMzQzLTIuMjU0LTQuMzQzYy0xLjg2MSwwLTIuMjM0LDAuNDM0LTIuMjM0LDQuMzQzYzAsNC4wMTIsMC4zNzIsNC42MzIsMi4yMzQsNC42MzJDMTc4LjcxNiwyMS41NjIsMTc5LjA2OCwyMC45NDIsMTc5LjA2OCwxNi45M3oiLz48cGF0aCBkPSJNMTg4LjkxMiwyNC4zMzRWMTMuNTE3bC0zLjIyNiwxLjMwM2wtMC44NjgtMi44MTJsNy4zODMtMi43NTF2MTUuMDc2SDE4OC45MTJ6Ii8+PHBhdGggZD0iTTIwNy40NjIsOS45MTl2Mi45MTZoLTYuMTg0djIuNDgyYzAuNDc2LTAuMDQxLDAuOTUxLTAuMDYyLDEuNDI3LTAuMDYyYzQuMDk1LDAsNS4yOTQsMS4yNDEsNS4yOTQsNC41MDhjMCwzLjc2NC0xLjQ2OCw0Ljg2LTUuNjg3LDQuODZjLTEuMzY1LDAtMy42ODEtMC4yMDctNC44MTgtMC40OTZsMC42Mi0yLjk1N2MwLjc2NSwwLjI0OCwyLjQyLDAuMzkzLDMuNDEyLDAuMzkzYzIuMzc4LDAsMi44MzMtMC4yNjksMi44MzMtMS42NzVjMC0xLjQ0OC0wLjMzMS0xLjc3OS0yLjgxMi0xLjc3OWMtMS4wMTMsMC0yLjQ4MiwwLjA4My0zLjQxMiwwLjIwN1Y5LjkxOUgyMDcuNDYyeiIvPjwvZz48L3N2Zz4=" />
                </div>
            </div>
            <!-- Информация о проживании -->
            <?php if($roomProductManager !== null):?>
                <div class="col-4">
                    <table class="booking">
                        <tr>
                            <td class="text-muted">Пансионат <?=$pdf->y?></td><td><?=$roomProductManager->Hotel?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Корпус</td><td><?=$roomProductManager->Housing?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Комната</td><td><?=$roomProductManager->Number?></td>
                        </tr>
                    </table>
                </div>
            <?endif?>
        </div>
    </div>
</header>
<div role="main">
<div class="container">
<!-- Информация об участнике -->
<section class="row row-userinfo">
    <!-- Статус, ФИО, компания -->
    <div class="col-6 col-offset-1">
        <div class="userinfo status"><?=$role->Title?></div>
        <div class="userinfo"><?=$user->GetFullName()?></div>
        <?if($user->getEmploymentPrimary() !== null && $user->getEmploymentPrimary()->Company !== null):?>
            <div class="userinfo company"><?=$user->getEmploymentPrimary()->Company->Name?></div>
        <?endif?>
    </div>

    <!-- QR-код -->

    <div class="col-4">
        <figure class="qrcode text-center">
            <img src="<?=QrCode::getAbsoluteUrl($user,100)?>" />
            <figcaption>RUNET-ID / <?=$user->RunetId?></figcaption>
        </figure>
    </div>
</section>
<?php
$rif = new Rif();
$userHotel = $rif->getUserHotel($user->RunetId);

$foodProductMatrix = [
    22 => [3634, 3635, [3650, 3651], 3636],
    23 => [3637, 3638, [3652, 3653], 3639],
    24 => [3640, 3641, [3654, 3655], 3642]
];

$criteria = new \CDbCriteria();
$criteria->addInCondition('"t"."ProductId"', \CArray::to_list($foodProductMatrix));
$userFoodOrderItems = OrderItem::model()->byPaid(true)->byAnyOwnerId($user->Id)->findAll($criteria);
$userFoodProductIdList = \CHtml::listData($userFoodOrderItems, 'Id', 'ProductId');
$foodHotels = [];
switch ($userHotel) {
    case Rif::HOTEL_LD:
        $foodHotels = [
            22 => [Rif::HOTEL_LD, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P],
            23 => [Rif::HOTEL_LD, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P],
            24 => [Rif::HOTEL_LD, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P]
        ];
        break;

    case Rif::HOTEL_P:
        $foodHotels = [
            22 => [Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P],
            23 => [Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P],
            24 => [Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P]
        ];
        break;

    case Rif::HOTEL_N:
        $foodHotels = [
            22 => [Rif::HOTEL_N, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P],
            23 => [Rif::HOTEL_N, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P],
            24 => [Rif::HOTEL_N, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P]
        ];
        break;

    default:
        $foodHotels = [
            22 => [Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P],
            23 => [Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P],
            24 => [Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P, Rif::HOTEL_P]
        ];
        break;
}

$foodTimes = [
    Rif::HOTEL_P => [
        22 => ['8:30 до 10:00', '14:30 до 15:30', '14:30 до 15:30', '20:00 до 21:30'],
        23 => ['8:30 до 10:00', '14:30 до 16:00', '14:30 до 16:00', '20:30 до 22:00'],
        24 => ['8:30 до 10:00', '14:30 до 15:30', '14:30 до 15:30', '18:30 до 20:00']
    ],

    Rif::HOTEL_LD => [
        22 => ['8:00 до 9:30', '14:30 до 15:30', null, '20:30 до 22:00'],
        23 => ['8:00 до 9:30', '14:30 до 16:00', null, '21:00 до 22:30'],
        24 => ['8:00 до 9:30', '14:30 до 15:30', null, '19:00 до 20:30']
    ],

    Rif::HOTEL_N => [
        22 => ['8:00 до 10:00'],
        23 => ['8:00 до 10:00'],
        24 => ['8:00 до 10:00']
    ],
];
?>

<?if(!empty($userFoodProductIdList)):?>
    <div class="row row-timeline noborder" style="padding-bottom: 2mm; padding-top: 2mm;">
        <div class="col-12">
            <table class="food-table">
                <thead>
                <tr>
                    <th></th>
                    <th colspan="2">Завтрак</th>
                    <th colspan="2">Обед</th>
                    <th colspan="2">Ланчбокс</th>
                    <th colspan="2">Ужин</th>
                </tr>
                </thead>
                <tbody>
                <?for($d = 22; $d <= 24; $d++):?>
                    <tr>
                        <td><?=$d?>.04</td>
                        <?for($i = 0; $i < 4; $i++):?>
                            <?$hotel = isset($foodHotels[$d][$i]) ? $foodHotels[$d][$i] : null?>
                            <?if($hotel !== null):?>
                                <td><?=mb_convert_case($hotel, MB_CASE_TITLE)?>, <?=$foodTimes[$hotel][$d][$i]?></td>
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
                                    <?=$has ? '+' : '&nbsp;'?>
                                </td>
                            <?else:?>
                                <td colspan="2">&mdash;</td>
                            <?endif?>
                        <?endfor?>
                    </tr>
                <?endfor?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row row-timeline noborder">
<?else:?>
    <div class="row row-timeline">
<?endif?>
        <div class="row">
            <!-- Расписание работы регистрации -->
            <div class="col-1 text-right">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGNDM3NDFBQUI1QjExMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGNDM3NDFBQkI1QjExMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTdGQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTgwQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+RzvMSgAAAxZJREFUeNrMmT9sEnEUxx+krQnSAa1DBV1IhEEGUmxkrCM0OgixSR2aLq1/hy46uJXF2RqtQyetJiQ6KLgpGwnaMApNSAexHSgsRQaMxveOd80Bd3A/KHf3TT4J3P3uve/9+N3vfu+HbWlpCQaQHbmCzCEh5BLiRk7z+d/IL2QX+Y58Rb4h/0QTjQm29yD3kEXkQo92p5AzSAC5ycd+ItvIBlIW6Qk9Oos8R0rI4z7mtETXPOIYFGvqpAwuIAXkLjIBw2uCY/3g2AMbpJ//BfJW790Kaopjv0TGRQ06kA/IKoxeK8h7zqnL4Bjf2TwYp3nOOa7HID1l18F4Uc5n/QwucJebpZXOB0dp8Bw//mZrg6e1LoPrPLmaLTKX6DR4EVkG62iZ31rHBu/0motMEE3m92WDxG2wnuh9b5dXJR4LGiRPszQpX9NqEY1GIRgMth0rFovQaDQglUpptlEqkUiA3++HWCymej6fzx/HUtEcGZzROutwOMDr9bYdk7+TKUqu1qZTTqdTsw3dcA/NkEFfv75Op9OQTCZb/e7xwNrampQwFAqpttFSqVSSbkpAPhqD0yJXlMtlqNVqRo3DaerBSaGRiz3odrulz/V6/fh4OBwGn88nMr70aFLXkj8SiUgolcvloFAoQCAQkL67XC4JgfGluyY5Ur77tMaOMlmlUoFMJqM5Tk9QR2TwoJ9BMjeC5Hp0QAapay4PG4nGXzwe7zqezWaHCbtLBncUpeHAomlHba7b29sbJuyODQv3q3SjYE2FaR7MiRTSBop2JnJ23o54Y0GDr8mbXbHMblrIXFMuP2SD9BNvWcjgFu/ltNUkT5CqBcxV2UtX0VSVl9km66Gyozrr4nfIKxPNUe7tfjsLD5CPJpj7xLn7bn00ubr/bKA5ynVLbSbR2t1qIDeQTQPMbXKuhtrJXvuDf6C1/bY4oqe7yrFXOReIGpRFg9YPrY3Gk5jMmxzL3/lADGqQdMi7D7RceYrsD2Bsn6/1cqxDPRfZhvgbYpZr6hmuDM9Thcnn62yoyMu5L9D6G+KvaKL/AgwAZFjBTyIfWREAAAAASUVORK5CYII=" style="image-resolution: 120dpi;"/>
            </div>
            <div class="col-10" style="margin-bottom: 1.3mm;">
                <h3>Режим работы стойки регистрации</h3>
                <div>Регистрация участников, оплата участия. КПП «Поляны»</div>
            </div>
        </div>
        <!-- График по дням -->
        <div class="row row-datetime">
            <div class="col-2 col-offset-1">
                <div class="date"><big>21</big> апреля</div>
                <div class="time"><span>Начало</span> 12:00</div>
                <div class="time"><span>Окончание</span> 02:00</div>
            </div>
            <div class="col-2">
                <div class="date"><big>22</big> апреля</div>
                <div class="time"><span>Начало</span> 07:00</div>
                <div class="time"><span>Окончание</span> 02:00</div>
            </div>
            <div class="col-2">
                <div class="date"><big>23</big> апреля</div>
                <div class="time"><span>Начало</span> 08:00</div>
                <div class="time"><span>Окончание</span> 19:00</div>
            </div>
            <div class="col-2">
                <div class="date"><big>24</big> апреля</div>
                <div class="time"><span>Начало</span> 8:00</div>
                <div class="time"><span>Окончание</span> 16:00</div>
            </div>
        </div>
    </div>

    <!-- Расписание работы оргкомитета -->
    <div class="row row-timeline">
        <div class="row">
            <div class="col-1 text-right">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyRkFCM0E3REI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyRkFCM0E3RUI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTdCQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTdDQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+XcT0nAAAA7BJREFUeNrMWU1IG1EQHoNaNI1gaw+apIJCFGxBtIntRUxPHqQFe6hgT4I//cu1pfTWHOy5llYFT/3zkoAt1IO0Bw+FpHrx0CZQEdroQYOgTZSUls7szobddZPsRpPdDz42yc6+973Z9+a9mVSMjo5CEbAhvUg/8hLSg3Qi7Xw/hUwg48ivyM/IKPKf0Y4qDdq7kHeRw0h3HrtTyDPIi8gb/NtP5BvkFPKXEU/owVnkc+QP5MMC4nKBnnnAbVBbDSclcAj5HXkHWQ3HRzW39Y3bLlogvf4XyLd6R2sQDdz2S2SVUYG1yDByAkqPcWSI+9QlsJJHNgDlwwD3WaVHIK2ya1B+UJ/PCgkcYpebhXH1wpELPMfL32xMcVg7IvAJB1ezQeKCaoHnkSNgHYzwrpUVeDtfLDIBFMzvSQKJt8B6oP3eJp1KXBYUSJp8FJSv5rNyOp3g9/vB5RLHcHBwALFYDBYXF7M2/f390NnZqXguHo9DOp3O2mnZSAiHw0KbGvCTwO5c4qjRwcFB4fPu7i4cHh5CS0sLdHR0gNvthtnZWXFfrK0VfpdD+k6iJicnNW0k2O32XBK6SWBbLs9J4kKhUNYT9PvY2Bh4vV5IJpPCPQlkI30nu0AgIIjq6urStNGBNpqDjVp3enp6hGs0GlW8zkQiAUtLSwobLZAdef2YaCSBDs3TpVs8k5KX1FheXhau9fX1eeduU1OTeP5PpYoV6Mh55K+pqRGu29vbulujOUuUg94ALQCat8WABO7L9z75KqT509zcnPVYdmK0idOWFo0c6+vrwnMSaHDqZw1inwRuaQnc2NgQrj6fDxYWFmBvb0/hKcLa2tqRQRlYAHqwRQIpAF1Q31ldXRVeD63WYDAIkUhEiGsej0fwLHlvfn6+1ME6TgJXZKmhAhTnaJH09fVBb2+vYl6ROLlXS4SVCkzcL+OHL4Us6+rqwOFwCOGjjLhCHoxwIp13PyZvlcFjilBK2mxcjnhtwcPCK9Jmkx2zMxYSl5HSD0kgveI5Cwmc41qOIid5TDubBcQlWcuRpCkpHbNNRkDuKHVe/A45Y6K4GS7R5a0s3Ee+N0HcB+67YOkjw9n9xzKKo75uakWSXNWtNPI6croM4qa5r7SR8hvhD4jlt+ESre4ktz3BfYFRgRJo0raDWGg8iWCe4bba1QuiWIGEHa4+tCKfIjeLELbJz7ZyWzt6T9RGQDsOFdEf0VmWc+puzgwpATnNdr9ZUIyPc59A/Bvir9FR/RdgABYkE9ZZQEObAAAAAElFTkSuQmCC" style="image-resolution: 120dpi;"/>
            </div>
            <div class="col-10">
                <h3>Режим работы стойки орг. комитета</h3>
                <div>Выдача отчетных документов, оплата доп.услуг, отметка командировочных удостоверений, орг. вопросы: холл первого корпуса «Поляны»</div>
            </div>
        </div>
        <div class="row row-datetime">
            <div class="col-2 col-offset-1">
                <div class="date"><big>21</big> апреля</div>
                <div class="time"><span>Начало</span> 15:30</div>
                <div class="time"><span>Окончание</span> 22:00</div>
            </div>
            <div class="col-2">
                <div class="date"><big>22</big> апреля</div>
                <div class="time"><span>Начало</span> 8:00</div>
                <div class="time"><span>Окончание</span> 21:00</div>
            </div>
            <div class="col-2">
                <div class="date"><big>23</big> апреля</div>
                <div class="time"><span>Начало</span> 8:00</div>
                <div class="time"><span>Окончание</span> 20:00</div>
            </div>
            <div class="col-2">
                <div class="date"><big>24</big> апреля</div>
                <div class="time"><span>Начало</span> 8:00</div>
                <div class="time"><span>Окончание</span> 19:00</div>
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
            <li>Назарьево (Поворот налево на 2-е Успенское ш.,<br/>22-й км)</li>
        </ul>
    </div>
    <div class="col-3">
        <h2>Оплата услуг
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyRkFCM0E3REI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyRkFCM0E3RUI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTdCQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTdDQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+XcT0nAAAA7BJREFUeNrMWU1IG1EQHoNaNI1gaw+apIJCFGxBtIntRUxPHqQFe6hgT4I//cu1pfTWHOy5llYFT/3zkoAt1IO0Bw+FpHrx0CZQEdroQYOgTZSUls7szobddZPsRpPdDz42yc6+973Z9+a9mVSMjo5CEbAhvUg/8hLSg3Qi7Xw/hUwg48ivyM/IKPKf0Y4qDdq7kHeRw0h3HrtTyDPIi8gb/NtP5BvkFPKXEU/owVnkc+QP5MMC4nKBnnnAbVBbDSclcAj5HXkHWQ3HRzW39Y3bLlogvf4XyLd6R2sQDdz2S2SVUYG1yDByAkqPcWSI+9QlsJJHNgDlwwD3WaVHIK2ya1B+UJ/PCgkcYpebhXH1wpELPMfL32xMcVg7IvAJB1ezQeKCaoHnkSNgHYzwrpUVeDtfLDIBFMzvSQKJt8B6oP3eJp1KXBYUSJp8FJSv5rNyOp3g9/vB5RLHcHBwALFYDBYXF7M2/f390NnZqXguHo9DOp3O2mnZSAiHw0KbGvCTwO5c4qjRwcFB4fPu7i4cHh5CS0sLdHR0gNvthtnZWXFfrK0VfpdD+k6iJicnNW0k2O32XBK6SWBbLs9J4kKhUNYT9PvY2Bh4vV5IJpPCPQlkI30nu0AgIIjq6urStNGBNpqDjVp3enp6hGs0GlW8zkQiAUtLSwobLZAdef2YaCSBDs3TpVs8k5KX1FheXhau9fX1eeduU1OTeP5PpYoV6Mh55K+pqRGu29vbulujOUuUg94ALQCat8WABO7L9z75KqT509zcnPVYdmK0idOWFo0c6+vrwnMSaHDqZw1inwRuaQnc2NgQrj6fDxYWFmBvb0/hKcLa2tqRQRlYAHqwRQIpAF1Q31ldXRVeD63WYDAIkUhEiGsej0fwLHlvfn6+1ME6TgJXZKmhAhTnaJH09fVBb2+vYl6ROLlXS4SVCkzcL+OHL4Us6+rqwOFwCOGjjLhCHoxwIp13PyZvlcFjilBK2mxcjnhtwcPCK9Jmkx2zMxYSl5HSD0kgveI5Cwmc41qOIid5TDubBcQlWcuRpCkpHbNNRkDuKHVe/A45Y6K4GS7R5a0s3Ee+N0HcB+67YOkjw9n9xzKKo75uakWSXNWtNPI6croM4qa5r7SR8hvhD4jlt+ESre4ktz3BfYFRgRJo0raDWGg8iWCe4bba1QuiWIGEHa4+tCKfIjeLELbJz7ZyWzt6T9RGQDsOFdEf0VmWc+puzgwpATnNdr9ZUIyPc59A/Bvir9FR/RdgABYkE9ZZQEObAAAAAElFTkSuQmCC" style="width: 5.3mm; margin: 0 0.8mm;"/>
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGNDM3NDFBQUI1QjExMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGNDM3NDFBQkI1QjExMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTdGQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTgwQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+RzvMSgAAAxZJREFUeNrMmT9sEnEUxx+krQnSAa1DBV1IhEEGUmxkrCM0OgixSR2aLq1/hy46uJXF2RqtQyetJiQ6KLgpGwnaMApNSAexHSgsRQaMxveOd80Bd3A/KHf3TT4J3P3uve/9+N3vfu+HbWlpCQaQHbmCzCEh5BLiRk7z+d/IL2QX+Y58Rb4h/0QTjQm29yD3kEXkQo92p5AzSAC5ycd+ItvIBlIW6Qk9Oos8R0rI4z7mtETXPOIYFGvqpAwuIAXkLjIBw2uCY/3g2AMbpJ//BfJW790Kaopjv0TGRQ06kA/IKoxeK8h7zqnL4Bjf2TwYp3nOOa7HID1l18F4Uc5n/QwucJebpZXOB0dp8Bw//mZrg6e1LoPrPLmaLTKX6DR4EVkG62iZ31rHBu/0motMEE3m92WDxG2wnuh9b5dXJR4LGiRPszQpX9NqEY1GIRgMth0rFovQaDQglUpptlEqkUiA3++HWCymej6fzx/HUtEcGZzROutwOMDr9bYdk7+TKUqu1qZTTqdTsw3dcA/NkEFfv75Op9OQTCZb/e7xwNrampQwFAqpttFSqVSSbkpAPhqD0yJXlMtlqNVqRo3DaerBSaGRiz3odrulz/V6/fh4OBwGn88nMr70aFLXkj8SiUgolcvloFAoQCAQkL67XC4JgfGluyY5Ur77tMaOMlmlUoFMJqM5Tk9QR2TwoJ9BMjeC5Hp0QAapay4PG4nGXzwe7zqezWaHCbtLBncUpeHAomlHba7b29sbJuyODQv3q3SjYE2FaR7MiRTSBop2JnJ23o54Y0GDr8mbXbHMblrIXFMuP2SD9BNvWcjgFu/ltNUkT5CqBcxV2UtX0VSVl9km66Gyozrr4nfIKxPNUe7tfjsLD5CPJpj7xLn7bn00ubr/bKA5ynVLbSbR2t1qIDeQTQPMbXKuhtrJXvuDf6C1/bY4oqe7yrFXOReIGpRFg9YPrY3Gk5jMmxzL3/lADGqQdMi7D7RceYrsD2Bsn6/1cqxDPRfZhvgbYpZr6hmuDM9Thcnn62yoyMu5L9D6G+KvaKL/AgwAZFjBTyIfWREAAAAASUVORK5CYII=" style="width: 5.3mm;" />
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
<sethtmlpagefooter name="main-footer" value="on" show-this-page="1" />
</div>
</div>
<pagebreak />
<div class="page-transport">
<header>
    <div class="container">
        <div class="row">
            <!-- Логотип -->
            <div class="col-7">
                <div class="logo">
                    <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAyMDggMzQuNTI0IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAyMDggMzQuNTI0IiB4bWw6c3BhY2U9InByZXNlcnZlIj48Zz48cGF0aCBmaWxsPSIjMTdBNjY5IiBkPSJNMTkuODc3LDQuNzRjMS45NDgtMC45NjYsMy44NjYtMS43NTksNS42OTctMi4zNTljMC4wNTEtMC4wMTUsMC4wODctMC4wNjEsMC4wOTItMC4xMTFjMC4wMDUtMC4wNTQtMC4wMjItMC4xMDQtMC4wNjktMC4xM2MtMC42OTUtMC4zODQtMS40MjEtMC43Mi0yLjE2Mi0xLjAwNGMtMC4wMjQtMC4wMDktMC4wNTEtMC4wMDktMC4wNzgtMC4wMDVjLTEuNzM1LDAuNDExLTMuNTE1LDAuOTcxLTUuMjkxLDEuNjY5QzguMzk4LDYuNzgzLDIuMzI5LDExLjM0NywwLjAzMywxNi4zNmMtMC4wMDYsMC4wMTUtMC4wMTIsMC4wMzMtMC4wMTIsMC4wNDljLTAuMTA0LDIuMTAyLDAuMTc1LDQuMTgzLDAuODI1LDYuMTk0YzAuMDE4LDAuMDUzLDAuMDcsMC4wOTEsMC4xMjcsMC4wOTFjMC4wMDMsMCwwLjAwNywwLDAuMDExLDBjMC4wNjEtMC4wMDYsMC4xMS0wLjA1MiwwLjEyMS0wLjExMkMxLjk4OSwxNi42OSw4LjMwNSwxMC42ODcsMTkuODc3LDQuNzR6Ii8+PHBhdGggZmlsbD0iIzE3QTY2OSIgZD0iTTIuMjk4LDkuMDYyYzAuMDMxLDAsMC4wNjEtMC4wMTEsMC4wODctMC4wMzRjMy4xOS0yLjgzMSw4LjA1LTUuMjkxLDE0LjQ0LTcuMzA5YzEuNDM4LTAuNDIzLDIuOTA5LTAuNzYzLDQuMzctMS4wMDdjMC4wNjItMC4wMSwwLjEwOC0wLjA2NCwwLjExMS0wLjEyNmMwLjAwMi0wLjA2My0wLjA0My0wLjExOS0wLjEwMy0wLjEzNEMxOS45MTYsMC4xNTMsMTguNTg4LDAsMTcuMjYzLDBDMTIuNjUxLDAsOC4zMTcsMS43OTQsNS4wNTcsNS4wNTJDMy45Myw2LjE4MywyLjk2Miw3LjQ2NiwyLjE4MSw4Ljg2NkMyLjE1LDguOTIzLDIuMTYyLDguOTkzLDIuMjE0LDkuMDMzQzIuMjM4LDkuMDU0LDIuMjY4LDkuMDYyLDIuMjk4LDkuMDYyeiIvPjxwYXRoIGZpbGw9IiMxN0E2NjkiIGQ9Ik0zMy4zMTIsMTAuOTQzYzAuMDA2LTAuMDI2LDAuMDAzLTAuMDU1LTAuMDA3LTAuMDc5Yy0wLjI4MS0wLjcwOS0wLjYyMi0xLjQxNi0xLjAxMS0yLjEwMmMtMC4wMjctMC4wNDQtMC4wNzctMC4wNzUtMC4xMjgtMC4wNjZjLTAuMDUyLDAuMDA0LTAuMDk1LDAuMDQyLTAuMTEzLDAuMDkxYy0wLjU5OCwxLjg0OS0xLjM5OCwzLjc4My0yLjM3Myw1Ljc1MmMtNS45MjIsMTEuNTE5LTEyLjE0NiwxOC4wMi0xOC4wMDIsMTguNzk3Yy0wLjA1OSwwLjAwNi0wLjExLDAuMDU3LTAuMTE1LDAuMTE4Yy0wLjAwNSwwLjA2LDAuMDMyLDAuMTE3LDAuMDksMC4xMzljMS44MDIsMC42MTgsMy42OSwwLjkzLDUuNjEyLDAuOTNjMC4xNTQsMCwwLjMwOS0wLjAwMSwwLjQ2NC0wLjAwNWMwLjAxNywwLDAuMDMzLTAuMDA0LDAuMDQ4LTAuMDExYzUuMTI2LTIuMTk1LDkuNzg0LTguMzA0LDEzLjg0Ni0xOC4xNTlDMzIuMzI5LDE0LjU0LDMyLjg5NywxMi43MjMsMzMuMzEyLDEwLjk0M3oiLz48cGF0aCBmaWxsPSIjMTdBNjY5IiBkPSJNMzQuMDc1LDEzLjMyNWMtMC4wMTMtMC4wNi0wLjA2My0wLjA5Ni0wLjEzMy0wLjEwMmMtMC4wNjMsMC4wMDItMC4xMTQsMC4wNDktMC4xMjUsMC4xMTJjLTAuMjQ1LDEuNDYzLTAuNTg1LDIuOTMzLTEuMDA2LDQuMzY4Yy0yLjAyMSw2LjM5MS00LjQ4MSwxMS4yNTItNy4zMTMsMTQuNDQ1Yy0wLjA0NCwwLjA0Ni0wLjA0NCwwLjExOS0wLjAwNSwwLjE2OWMwLjAyNywwLjAzMywwLjA2NiwwLjA1MSwwLjEwNCwwLjA1MWMwLjAyMiwwLDAuMDQ2LTAuMDA0LDAuMDY0LTAuMDE4YzEuNDA0LTAuNzgsMi42ODUtMS43NDgsMy44MTItMi44NzZDMzMuNzIzLDI1LjIyMywzNS40NDMsMTkuMTg4LDM0LjA3NSwxMy4zMjV6Ii8+PHBhdGggZmlsbD0iIzE3QTY2OSIgZD0iTTI2LjkyOSwxMS43MDZjMS40MTItMS44NSwyLjY2LTMuNjA5LDMuNzA5LTUuMjI1YzAuMDMxLTAuMDQ3LDAuMDI2LTAuMTEtMC4wMS0wLjE1M2MtMC4zNjYtMC40NDgtMC43NTMtMC44NzUtMS4xNTItMS4yNzdjLTAuMzQzLTAuMzQxLTAuNzEzLTAuNjgtMS4xMzQtMS4wMjljLTAuMDQ1LTAuMDM4LTAuMTA2LTAuMDQyLTAuMTU3LTAuMDA5Yy0xLjYyMiwxLjA1My0zLjM4MywyLjMwMS01LjIzNywzLjcxNkM4Ljc3MiwxOC42NzksNC41OTEsMjQuNjI2LDMuNTgxLDI3LjY4OWMtMC4wMTUsMC4wNDEtMC4wMDgsMC4wODksMC4wMiwwLjEyYzAuNDY1LDAuNjAzLDAuOTU1LDEuMTYzLDEuNDU2LDEuNjY0YzAuNTUzLDAuNTUyLDEuMTY1LDEuMDg0LDEuODE2LDEuNTc1YzAuMDIxLDAuMDE4LDAuMDUsMC4wMjcsMC4wNzksMC4wMjdjMC4wMTMsMCwwLjAyOC0wLjAwNCwwLjA0Mi0wLjAwOEMxMC4wNTcsMzAuMDQ0LDE2LjAwMSwyNS44NTMsMjYuOTI5LDExLjcwNnoiLz48L2c+PGc+PHBhdGggZD0iTTQ4LjY5NywyNC4zMzRWOS45MTloOC4wNDVjMi45NTcsMCwzLjk1LDIuMTEsMy45NSw1LjA2N2MwLDIuNjA2LTEuMjQxLDQuODYtMy45MjksNC44NmgtNC43MzZ2NC40ODhINDguNjk3eiBNNTUuNTg0LDE3LjA5NWMwLjg2OSwwLDEuNDQ4LTAuNiwxLjQ0OC0yLjEwOWMwLTEuNTcyLTAuNDk2LTIuMjEzLTEuNDA2LTIuMjEzaC0zLjU5OHY0LjMyMkg1NS41ODR6Ii8+PHBhdGggZD0iTTc1LjkxMywyNC4zMzRoLTMuMjg4di05LjQ5MmMtMS42OTYsMy4yMDYtMy41NTcsNi40NzMtNS40MTgsOS40OTJoLTQuMzY0VjkuOTE5aDMuMjY4djkuODg1YzEuOTg1LTMuMjQ3LDMuOTUtNi41OTcsNS43MjgtOS44ODVoNC4wNzRWMjQuMzM0eiIvPjxwYXRoIGQ9Ik04Ny43MDEsOS45MTl2MS42NTRjNC44NiwwLjI0OCw2LjI2NiwxLjgyLDYuMjY2LDUuNTIyYzAsMy43MjItMS40MjcsNS4yNzQtNi4yNjYsNS41MjJ2MS43MTZoLTMuMzN2LTEuNjk2Yy00Ljc5OC0wLjI0OC02LjA1OS0xLjgyLTYuMDU5LTUuNTQyczEuMjYyLTUuMjc0LDYuMDU5LTUuNTIyVjkuOTE5SDg3LjcwMXogTTg0LjM3MSwxOS45Mjl2LTUuNjI1Yy0yLjMxNiwwLjA4My0yLjY4OCwwLjc0NC0yLjY4OCwyLjc5MkM4MS42ODMsMTkuMTIyLDgyLjA1NSwxOS44MjUsODQuMzcxLDE5LjkyOXogTTg3LjcwMSwxNC4zMDR2NS42MjVjMi41MDItMC4wODMsMi44MzMtMC43NjUsMi44MzMtMi44MzNTOTAuMjAzLDE0LjM2Niw4Ny43MDEsMTQuMzA0eiIvPjxwYXRoIGQ9Ik05NS40OTgsMTUuMjk2aDMuNTM2di0zLjU1N2gzLjA0djMuNTU3aDMuNTU3djMuMDRoLTMuNTU3djMuNTM2aC0zLjA0di0zLjUzNmgtMy41MzZWMTUuMjk2eiIvPjxwYXRoIGQ9Ik0xMTYuOTAyLDI0LjMzNGMtMS44NDEtNS4yOTQtMy4yMDYtNi40NzMtNS40OC02LjcyMXY2LjcyMWgtMy4zM1Y5LjkxOWgzLjMzdjYuOTA3YzEuMTU4LTEuMjgyLDMuMjQ3LTMuOTI5LDUuMDg4LTYuOTA3aDMuOTcxYy0yLjM5OSwzLjcyMy00LjA3NCw1Ljg3My00LjcxNSw2LjQ3M2MxLjUzLDAuNTc5LDIuOTk5LDEuNjc1LDUuMDg4LDcuOTQxSDExNi45MDJ6Ii8+PHBhdGggZD0iTTEzNS4zNywyNC4zMzRoLTMuMjg4di05LjQ5MmMtMS42OTYsMy4yMDYtMy41NTcsNi40NzMtNS40MTgsOS40OTJIMTIyLjNWOS45MTloMy4yNjh2OS44ODVjMS45ODUtMy4yNDcsMy45NS02LjU5Nyw1LjcyOC05Ljg4NWg0LjA3NFYyNC4zMzR6Ii8+PHBhdGggZD0iTTE0OS43NDMsMTIuODM1aC03LjY1MnYyLjY0N2g0LjgzOWMyLjUyMywwLDMuODY3LDEuNDg5LDMuODY3LDQuNDQ2YzAsMy40MTItMS40NjgsNC40MDUtMy44MDUsNC40MDVoLTguMjMxVjkuOTE5aDEwLjk4MVYxMi44MzV6IE0xNDYuMTI0LDIxLjVjMC43MDMsMCwxLjA1NS0wLjQ3NiwxLjA1NS0xLjU5MmMwLTEuMTc5LTAuMzkzLTEuNzE3LTEuMTM4LTEuNzE3aC0zLjk1VjIxLjVIMTQ2LjEyNHoiLz48cGF0aCBkPSJNMTU4LjYxNSwxMC4yOTFjMS4xNzktMC40MTQsMy4wNC0wLjcyNCw0LjkwMS0wLjcyNGMzLjYxOSwwLDUuMzk4LDAuODI3LDUuMzk4LDQuMzIyYzAsMi45OTktMC44NDgsMy45NzEtNi4xNjMsNy41MjhoNi4yMjV2Mi45MTZIMTU4LjE2di0yLjcwOWM2LjgwNC01LjA2Nyw3LjIxNy01LjQ2LDcuMjE3LTcuMzgzYzAtMS4zMDMtMC41MzgtMS42NzUtMi4yMTMtMS42NzVjLTEuMzI0LDAtMi45MzcsMC4yNjktMy44NDcsMC41NThMMTU4LjYxNSwxMC4yOTF6Ii8+PHBhdGggZD0iTTE4Mi4zNzcsMTYuOTNjMCw1LjkzNS0xLjkwMiw3LjY5My01LjU2Myw3LjY5M2MtMy42NiwwLTUuNTg0LTEuNzU4LTUuNTg0LTcuNjkzYzAtNS44MzIsMS45MjMtNy4zNjIsNS41ODQtNy4zNjJDMTgwLjQ3NCw5LjU2NywxODIuMzc3LDExLjA5OCwxODIuMzc3LDE2LjkzeiBNMTc5LjA2OCwxNi45M2MwLTMuOTA5LTAuMzUyLTQuMzQzLTIuMjU0LTQuMzQzYy0xLjg2MSwwLTIuMjM0LDAuNDM0LTIuMjM0LDQuMzQzYzAsNC4wMTIsMC4zNzIsNC42MzIsMi4yMzQsNC42MzJDMTc4LjcxNiwyMS41NjIsMTc5LjA2OCwyMC45NDIsMTc5LjA2OCwxNi45M3oiLz48cGF0aCBkPSJNMTg4LjkxMiwyNC4zMzRWMTMuNTE3bC0zLjIyNiwxLjMwM2wtMC44NjgtMi44MTJsNy4zODMtMi43NTF2MTUuMDc2SDE4OC45MTJ6Ii8+PHBhdGggZD0iTTIwNy40NjIsOS45MTl2Mi45MTZoLTYuMTg0djIuNDgyYzAuNDc2LTAuMDQxLDAuOTUxLTAuMDYyLDEuNDI3LTAuMDYyYzQuMDk1LDAsNS4yOTQsMS4yNDEsNS4yOTQsNC41MDhjMCwzLjc2NC0xLjQ2OCw0Ljg2LTUuNjg3LDQuODZjLTEuMzY1LDAtMy42ODEtMC4yMDctNC44MTgtMC40OTZsMC42Mi0yLjk1N2MwLjc2NSwwLjI0OCwyLjQyLDAuMzkzLDMuNDEyLDAuMzkzYzIuMzc4LDAsMi44MzMtMC4yNjksMi44MzMtMS42NzVjMC0xLjQ0OC0wLjMzMS0xLjc3OS0yLjgxMi0xLjc3OWMtMS4wMTMsMC0yLjQ4MiwwLjA4My0zLjQxMiwwLjIwN1Y5LjkxOUgyMDcuNDYyeiIvPjwvZz48L3N2Zz4=" />
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
                <img alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAZCAYAAAAv3j5gAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA0tJREFUeNqklk1oE1EQxzebTdKGGFM/UrSWVihUbQzSYnuJFnrwpgjFc0DwJB6l0rMHD0VB6sGzgqBCb3rSgoJFD7loL1rwI0q1FFsLanezSfxN+jY8Y5Lu4sDwvmbn6/1n3oby+bwRCoWMSqViQCbzC4yn4OewDYcMf1SFIpZlja+vry/Mzc3dTCQSzuTkpBEOhw1LSXjCoxi6jtEP7E2ZphkOYojvXCifSqXODg4OLhaLxcfeoRg6ifJuFD9kvMI6zrikWHeiLYmseA7Jd8PZbHaa+VP4NDpWLDZvsBi2bXsgGo3uU8IZ9s8wbsKOz4hicATOlstlIx6Pd+VyuQwRPiDSguVJYaSTVP1megsP3jiOE2W9EolEbNbbpg/lHSjs5Y5mxXG+GcNITE+dd5Od8Bp8jeVnBQ7faZMUa2k+zN4dxo5/DHEQgWVdNf6fShgVT6PiRM0QGzOMvWyswlHJghySAt9aJRIPDEpxSZwmK6ucXWb+RbTdU/J94oGqB4O7MRqg35a4T11eDIUUkGb+Sp0YUUJuK48DkBioqAxtOaLdkeQz3O6OdGMyb2O8JIZUhoxmEQm5zRT7uacmhurwNj1YSp9iHRZLQaDdIkIxVNYjMuUSFccQLDM63uX6BYIeEUUqxSvwdtAX8xwwdeDA++EJeFeAZtpIKWCeQ/kBXYeleV3lcAB+RA2tsX4vjZWxyPgN/sH8l4ZKAU4cTsLdSvEAZXGQ+W5lpNIMDDGlRHLbJSxduB3y2gDGVvrqLcj0cghLp14kv8fgceYXifZlgJQVkL8EkCYYj8CvVfffiqhUKnnzt6RMno0eeV0x9oxxL1tj24FCHEXPPHKzyAvSjktdMl+qy2QymTpqhoaGXvD8juLVV9YbAgp5FH2iTvraCmjdKd/wvr3jhT0qSK5FNDIy4slKPhMYkUvuUZEFqaM9wto6DjDE6PeaoeXlZc8jO51OuzyAgeqnVU1hxO3v77frd5RMJuvnhH0XoUPMO7WPPjFs6H2xgQTCO/C8T2+qZOY+/LOZIalo+QOSJ/2qtneevScNpaCTi/wJLn5e1Zb8ut2mQ0zr0Lea9DV5gj+qd2kTJa+UjNsqVXSCAsM5VcAS+UJjC/sjwAAT6pRt15sXzAAAAABJRU5ErkJggg==" />
            </div>
            <div class="col-4">
                <h3>Автобусы конференции</h3>
                Автобусы отправляются от ст. м. «Молодёжная» до пансионата «Лесные Дали» см. место посадки
            </div>

            <div class="col-1 text-right">
                <img alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAVCAYAAABYHP4bAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAutJREFUeNq8ls9LVFEUx+978+aHkw0WYlimIBk62CqiGgmDMgSRatUiBUHcBUGt+gtq4y6IWrsMNxNiLoQEa6MYJNMwRbscBWPQIZvf0+drzxCbwmfggcO579xzzvfee86591mjo6MmmUya+fl5I2pubjYDAwNma2vLrlQqp0KhUHu1Wj1hWdYxZAiTkPlFOXQ5dBnkWj6f/4L8Gg6HK1NTU2ZlZWXbqKenx3R2dhrH1CCcLziOM47jeQVG2tIj/7B1dZVAICDQRcYP4IW9dnYNx9PwpG3bV5DhWjY1yJatfBi/hFv2GjilUsm0tbWZpqYmw1EZVna3XC63sLo3zM/AfrM/KsI38O3luIYKhcITgE1dXZ0RhkNABTfBYNBg5Pf5fMPSQQ/hReONXuO7UF9fP0yscWIVFUsb0LEo6Y0oWlnBHWQU3Vudtwu4L5KtmyP5Rt1YrYotDBXDfZT3kFI4rtOEkuw67xvM9ZFvjM/ncInY64A9dfx+/zUG7bsCbjKedccBL+eGXwExC9AmMuKCR8Dos6jx7mg0OhiJRIbQ69hknMKpJDuPOaoSWKdyVoskRiKbzU4kEom4s7Gxsby6urpMY/ZREFEmtYvuWj3jheRP5a0R+zEYxhoZGdGWzzHxjvkjbpmqSHwHxCirgd22+E5aLpOnD2o0w6BLIAB+hnuZvIlc94ogH8r6FvKqYikmJd4lDCeXyxk+GkiYDOe0M4wF/p7xdS9ALHCpWCy+Uk9Cc/AZvhvURw7naACxBAT1A3Yb4OOAXPS6I/wuwWME/oZ/v3bCrWABZhx97CQeeRIx+R81cBR+oatnd1Fsp8ccEh0aUK33SFeEKu5ADevGbNzrWwsoS0EMIj/CQY9AeVjlPLNzBf0GisfjpqOjIx2LxdTJKvE0nHTvK+OxvOWfpPLSuuO2c2PbaRWHTz2TyWRSPH7rXEM/MHzE/Ke/Pd3/unL0wMF5gJb4FYhw9Tybnp6eSKVS5qcAAwAj+HJyQ4fmhwAAAABJRU5ErkJggg==" />
            </div>
            <div class="col-4">
                <h3>Личный автотранспорт</h3>
                38 км. от МКАД по Рублёво-Успенскому шоссе<br/>Московская область, Одинцовский район, поселок Горки-10, пансионат «Лесные Дали»
            </div>
        </div>

        <!-- Электричка -->
        <div class="row" style="margin-bottom: 5mm;">
            <div class="col-1 text-right">
                <img alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAmCAYAAADa8osYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABMdJREFUeNrsl01oXFUUgN+8efOXzGQyJE5k4k+kKUm1JEiLCxe2tabFhQ1IESFQ0KyqUqkiWdSN2CJqC/5sdNO60IULF4oFUVQ0QlHUCCXShcWYMMMU0iZNMiQzycz4nTf3jtfJm5nXjSsvHO59755zz/+55wbGx8etQCBgyQiHw1YsFnO/q9WqVSqVrK2tLfeb//dWKpXI3NzcTCqV6unt7d1dLpd/YW+N/y5uKBSyHMdxaRYXF921nCPDWV5edhfyo6+vr77WQ5jYtj3M/BOz3d/fv48DjoPzFNvvMp+wjCG0QrO6uuoCJDVGWpvGoQlESpC3+FXmu4zWReai7KNJCa086ZWA/zCyvEcKxAEgwprzKqLiK2JdDk7w/2sOWIbZD6z3GAJfB/4UoRoPbGQUguAk87PAXaKNGmUOnWa+GQwGH2G9yXodmAD/ToN+A/gWmALn8r8YaX8oM73J/LzpI2XG74GHdZDUuZfLR/DXpwZqFHgUYe7HxAfX1tZ+1/i2RIbYMZFI7I9GoycamahR8GBuKa28/HN7Op0+E4lE3EgWcIgivXkYXwRMZxoHHgDOAisinNovCY3GF2ElzK2aUy2EfnBoaEjMutDoo7TB5MbGxsaHMMmRP8IxhDnELCEDv4N/3zF/AV51ZWUlGI/Hx/jep/eBbi9G2jYV6I4Vi8WLErqdnZ1WsxA2zSg5A6PXWV9E0EPqvLq9bQ+iWaZvdB408ZlnzjAk3z7xwvHKo6IkYkdHR93efkZPT4/GLXgVAS9GgZqQgW3lqJXpdAVQ9L4YycmVZqWpmekMoTxNsM1HJG06n8/fls1mLaMy+NJqdnZWNNvhixEEUnpeJpFTrIVT2Ae4eOTOAbR7xpfpJJS5Lp5j+Tjr6wF/NqyC5gwPD98DTdSvj3T0ZBT4Hq3yzbb+o/E/o5a51CpumjGSwipXctYnn8Lm5uYVgmH1lhgRda8ySeLtBC60YZIlScfm5+d3kej7ycGFdoy03leBd2q5W5Ub9LQU2mbmoof7mJ7uktQ6tPqV7/NeNc9kdFNfWBDFpKQoSDbLN9WSJSR/BgYGrJmZGSuXyyWlPRDh2FvXvguOjIxoujg/nmBOAHeoe0larrek9Wpqe5pLphvgXKMEHc1kMqdYh6H/DThX135iYqJeT5FEbscx9b2uNI74iDgJngL0nWhni83x8xG2PvcynfRqx0D4UpX7mB8myoRyTgL/2DBa4nvSZLIt6pAsTy9+GHjBuMhu5aq4jI/uQ9gLho9rF6P5IS+Crq6uCK+Fx/xe4Q2C7qZ9e0CCoxGcxoqLnaekj1MNxxVCNsd3sJUisg/uXjE389sI/SOC5s1K4Ug3aai+F8QpQUC77NLS0qHu7u4Fn+XnNHCKM+6mMz2DgJOmVWz9tACiNITnVGMoD6mp6enpBb++4tDXYHJJMX4auqPm08U85SXgIaXZB5jwo2Qy6btfgFEBkJdIQbngDayV0b13cHR0VP7vgft5dff/BeGTdJ2FwcFB15HtWi4xkWImdU80OihvLGmJ+f+ZjroxNt5XeSO160XgGjZ2o7Bd9MnB0i1p4Kyz6o0kY1KeoMLIUQ8pUfdn4A8O/qpRg3b9ifjUGCXo34Mmrh52GSD1twADAOz0d+YcPWtKAAAAAElFTkSuQmCC" />
            </div>
            <div class="col-4">
                <h3>Электричка</h3>
                Электричкой с Белорусского вокзала или платформ "Беговая", "Фили", "Кунцево" (около одноименных станций метро) до платформы Жаворонки, а далее местным автобусом №32 до пансионата "Лесные Дали" (ходит редко).
            </div>
            <div class="col-1 text-right">
                <img alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3NJREFUeNq0lstrE2EQwHc3mzSJsXlJmlRikKonixW9iO2hUMG7hyhePYj9F7yJgvQg3kUvguJJqh7Vgz14sD2ViiW0PkBCEDUmzfvhb7bfhm0am0RxYJjd+eY9882unk6nNYFms2lRr9erZbNZedcnJiaCjUYj2G6393E0ouu6W2R4F1IHq/C2oD9rtdovwzDa9XrdssWzVq1WtUwmo5mtVstSQtiivB+JRqNXoIcR9sEzMFIDGzzrEg/oEl+gCc8DbZmmWcZwBif3eN8UWy6XS0skEpopxt1utyYRIJTk+QHGFwOBwDOi+4DCD3hNFf0OEF30XNAoBo+VSqVpn88n+hfhZdHXqIRmSlpEYSmAl9F9XalUFqRsdnZ9QDLLIZcrl8tLOAkR1CV070iVBAxVrgQHp4hmhsPn4XBYGwZURhbm8/kX2JwFT2J3TOwbGD9DNo+QfYfwUeiGrTxAFh05j8ejxWIxbXR0NIOd4+AKQT8kYK+JkxnkzoJLCH+ClmxlaZwY+JMz4Uu5JRM7I9GH/xbMoj8diURShpRKTckXaBFa6mXYNtQNEojtSGFBjbXY82InLNN1UBkpMg2tQqGwIzIZAMFux7ZRuxeO7FrIt3BeUO8RExpXlzFL6SKhUGhXpHv1R85tGUcAMvI5FUhIynSVCfBydgDGhW4F+6L2m64uGRc2X3JHnhL4pjhZUxHNqls9kOFeIOOqHLbUlli27okwpXFqTcRA6ZFH+zsYAZPgmOwx2SQCpqMsNSkXeA78LCMIW/C7TJ29ENUNN1UgYmU/GAETGB6DHgL96N+0N4bprKOiQYQnSX2yT923V8Z2FTrPapU05NUeFsMhLw51yaBYLC6rmg4DVaWXU7Y6CTidSPo5JmJudXX1NM5uD+OBK3BD9KDnef2mSrnLiQvDXynJRiqVEqWVYRYkwa0kk9JzLaN6aTpLZEMd4SlGeSEej7/ByfVBnVjNNc1b4+PjAXoyB0sWZKPjxNFMQ0U1j9K8s6GDAMFNoffEYU/vVa7/BsYg9f6X8+6eONfDXcr1nr6kwCA3V/5WvGpDyIDIhZQLUWFzb9GPPPyP8E+gd20vJ87b/wpclF8bvtvWP4AzcudGlnO/329tYoJLO5z0nK518D7o4/uwbi+7fgMg5/JHIn8mOFojoMewtwik8xn/LcAALeLg3cqH3A8AAAAASUVORK5CYII=" />
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
                    <div class="col-3"><h3>22 апреля</h3></div>
                    <div class="col-3"><h3>23 апреля</h3></div>
                    <div class="col-3"><h3>24 апреля</h3></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>M. «Молодёжная» → П-т «Поляны» <span>(время в пути – 60 минут без учета пробок)</span></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-3">07:30, 08:00, 08:10, 08:20, 08:30, 08:40, 08:50, 09:00, 09:15, 09:30, 10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30, 14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
                    <div class="col-3">07:30, 08:00, 08:10, 08:20, 08:30, 08:40, 08:50, 09:00, 09:15, 09:30, 10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30, 14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00, 17:30</div>
                    <div class="col-3">07:30, 08:00, 08:15, 08:30, 08:40, 08:50, 09:00, 09:15, 09:30, 10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30, 14:00, 14:30, 15:00, 15:30, 16:00, 16:30</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>П-т «Поляны» → M. «Молодёжная» <span>(время в пути – 60 минут без учета пробок)</span></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-3">08:45, 09:15, 09:45, 10:15, 10:45, 11:15, 12:00, 12:30, 13:00, 13:30, 14:00, 14:40, 15:00, 15:30, 16:30, 17:40, 17:50, 18:30, 19:10, 20:10, 20:20, 20:30, 20:40, 20:50, 21:30, 22:10, 23:10</div>
                    <div class="col-3">08:45, 09:15, 09:45, 10:15, 10:45, 11:15, 12:00, 12:30, 13:00, 13:30, 14:00, 14:40, 15:00, 15:30, 16:00, 17:00, 18:10, 18:20, 19:00, 20:40, 20:50, 21:00, 21:10, 21:20, 22:00, 23:10</div>
                    <div class="col-3">08:45, 09:15, 09:45, 10:15, 10:45, 11:15, 12:00, 12:30, 13:00, 13:30, 14:00, 14:40, 15:00, 15:30, 16:30, 17:50, 18:00, 18:10, 18:15, 18:20, 18:25, 18:30, 18:40, 19:00, 19:30, 20:00, 20:30</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>П-т «Лесные дали» → П-т «Поляны»<span>(время в пути – 5 минут)</span></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-3">с 8.00 до 24.00</div>
                    <div class="col-3">с 8:00 до 24:00</div>
                    <div class="col-3">c 8.00 до 20.20</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>П-т «Назарьево» → П-т «Поляны»<span>(время в пути – 30 минут без учета пробок)</span></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-3">09:10, 09:20, 10:45, 11:45, 13:45, 14:45, 16:00, 17:15, 18:45, 19:45, 21:00, 22:00</div>
                    <div class="col-3">09:10, 09:20, 10:45, 11:45, 13:45, 15:15, 16:30, 17:45, 19:00, 20:15, 21:20, 22:20</div>
                    <div class="col-3">09:10, 09:20, 10:45, 11:45, 13:45, 14:45, 16:00, 17:30, 19:00</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>П-т «Поляны» → П-т «Назарьево»<span>(время в пути – 30 минут без учета пробок)</span></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-3">10:00, 11:00, 12:30, 14:00, 15:00, 15:45, 18:00, 19:00, 20:20, 20:30, 22:00, 23:10</div>
                    <div class="col-3">10:00, 11:00, 12:30, 14:00, 15:00, 16:15, 18:15, 19:30, 20:50, 21:00, 22:00, 23:10</div>
                    <div class="col-3">10:00, 11:00, 12:30, 14:00, 15:00, 15:45, 18:15, 18:30, 19:45</div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>
<sethtmlpagefooter name="main-footer" value="on" show-this-page="1" />
</div>
</div>

<pagebreak />
<div class="text-center">
    <img src="/img/event/rif15/ticket/map.jpg" class="img-responsive"/>
</div>
<sethtmlpagefooter name="main-footer" value="on" show-this-page="1" />


<?if(!empty($parking) && $roomProductManager !== null):?>
<?php
    $showText2 = false;
    switch ($roomProductManager->Hotel) {
        case Rif::HOTEL_LD:
            $y = 2080;
            $name = 'car_dali';
            break;

        case Rif::HOTEL_N:
            $y = 2080;
            $name = 'car_nazarevo';
            break;

        case RIF::HOTEL_P:
            $y = 1430;
            $name = 'car_polyany';
            $showText2 = true;
            break;
    }

    $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot.img.event.rif15.ticket.'.$name).'.jpg');
    $text1 = mb_strtoupper($parking['carNumber']);

    $path = '/img/event/rif15/ticket/car_rendered/'.$user->RunetId.'.jpg';
    $image->text($text1,250,0,$y);
    $image->save(\Yii::getPathOfAlias('webroot').$path);

    if ($showText2) {
        $dates = [];
        $datetime = new \DateTime($roomOrderItem->getItemAttribute('DateIn'));
        while ($datetime->format('Y-m-d') <= $roomOrderItem->getItemAttribute('DateOut')) {
            $dates[] = $datetime->format('d');
            $datetime->modify('+1 day');
        }
        $text2 = implode(',', $dates);

        $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot') . $path);
        $image->text($text2, 220, 530, 2100);
        $image->save(\Yii::getPathOfAlias('webroot') . $path);
    }
   ?>
    <pagebreak orientation="L"/>
    <div class="text-center">
        <img src="<?=$path?>" />
    </div>
    <pagebreak orientation="L"/>
    <div class="text-center">
        <img src="/img/event/rif15/ticket/map_all.jpg" />
    </div>
<?endif?>

<?if($parkingReporter):?>
    <pagebreak orientation="L"/>
    <?php
    $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot.img.event.rif15.ticket.car_reporter').'.jpg');
    $text1 = mb_strtoupper($parking['carNumber']);
    $path = '/img/event/rif15/ticket/car_rendered/'.$user->RunetId.'-r.jpg';
    $image->text($text1,250,0,1300);
    $image->save(\Yii::getPathOfAlias('webroot').$path);
    $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot') . $path);
    $image->text('22,23,24', 250, 700, 2100);
    $image->save(\Yii::getPathOfAlias('webroot') . $path)
   ?>
    <div class="text-center">
        <img src="<?=$path?>" />
    </div>
    <pagebreak orientation="L"/>
    <div class="text-center">
        <img src="/img/event/rif15/ticket/map_reporter.jpg" />
    </div>
<?endif?>


