<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<style type="text/css" media="all">
	  @page {
	     size: landscape;
	     margin: 1mm 2mm 0;
	  }
		div.wrapper {
			font-family: Arial;
			margin: 0;
		}
		div.wrapper .rocid {
		  font-size: 10px;
			margin-top: 5mm;
			margin-left: 56mm;
			position: absolute;
			width: 40mm;
			-webkit-transform: rotate(-90deg); /* Chrome y Safari */
			-moz-transform: rotate(-90deg); /* Firefox */
		}
		div.wrapper .name {
			font-size: 38px;
			font-weight: bold;
			line-height: 100%;
		}
		div.wrapper .company {
			font-size: 20px;
			font-weight: normal;
			margin-top: 10px;
		}
	</style>
</head>
<body>
    <div class="wrapper">
      <div class="rocid">RUNET—ID / %ROCID%</div>
      <div class="name">%FIRSTNAME%<br />%LASTNAME%</div>
      <div class="company">%COMPANY%</div>
    </div>
</body>
</html>