<?php
/**
 * @var string $video
 */
$prefix = 'v';
$port = false;
if ($video == '0b75ffed81')
{
  $prefix = 'v2';
  $port = '8080';
}
elseif($video == '74f08d3c86')
{
  $prefix = 'v3';
}
?>
<html>
<head>
  <style>
    #web-rtc {
      width: 640px;
      height: 352px;
      margin: auto;
      border: 1px solid #B3B3B3;
    }
    #web-rtc h1 {
      text-align: center;
      margin-top: 25px;
    }
  </style>

  <script src="http://<?=$prefix?>.tpprf.ru<?=!empty($port)?':'.$port : ''?>/handlers/webrtc.php?key=<?=$video?>"></script>
  <script type="text/javascript">
    $(function () {
      $('#web-rtc').webRTC();
    });
  </script>
</head>
<body style="width: 640px; height: 352px; overflow: hidden; margin: 0;">
<div id="web-rtc"></div>
</body>
</html>