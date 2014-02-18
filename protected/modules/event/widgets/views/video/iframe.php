<?php
/**
 * @var string $video
 */
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

  <script src="http://v.tpprf.ru/handlers/webrtc.php?key=<?=$video;?>"></script>
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