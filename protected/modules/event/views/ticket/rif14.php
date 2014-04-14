<?/** @var \user\models\User $user */?>
<?
$criteria = new \CDbCriteria();
$criteria->with = ['Product'];
$criteria->addCondition('("t"."OwnerId" = :OwnerId AND "t"."ChangedOwnerId" IS NULL) OR "t"."ChangedOwnerId" = :OwnerId');
$criteria->addCondition('"Product"."ManagerName" = :ManagerName');
$criteria->params['OwnerId'] = $user->Id;
$criteria->params['ManagerName'] = 'RoomProductManager';
$roomOrderItem = \pay\models\OrderItem::model()->byEventId($event->Id)->byPaid(true)->find($criteria);
$roomProductManager = $roomOrderItem !== null ? $roomOrderItem->Product->getManager() : null;
?>

<body>
<style>
  html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block}audio,canvas,progress,video{display:inline-block;vertical-align:baseline}audio:not([controls]){display:none;height:0}[hidden],template{display:none}a{background:transparent}a:active,a:hover{outline:0}abbr[title]{border-bottom:1px dotted}b,strong{font-weight:bold}dfn{font-style:italic}h1{font-size:2em;margin:0.67em 0}mark{background:#ff0;color:#000}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{top:-0.5em}sub{bottom:-0.25em}img{border:0}svg:not(:root){overflow:hidden}figure{margin:1em 40px}hr{-moz-box-sizing:content-box;box-sizing:content-box;height:0}pre{overflow:auto}code,kbd,pre,samp{font-family:monospace, monospace;font-size:1em}button,input,optgroup,select,textarea{color:inherit;font:inherit;margin:0}button{overflow:visible}button,select{text-transform:none}button,html input[type="button"],input[type="reset"],input[type="submit"]{-webkit-appearance:button;cursor:pointer}button[disabled],html input[disabled]{cursor:default}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0}input{line-height:normal}input[type="checkbox"],input[type="radio"]{box-sizing:border-box;padding:0}input[type="number"]::-webkit-inner-spin-button,input[type="number"]::-webkit-outer-spin-button{height:auto}input[type="search"]{-webkit-appearance:textfield;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box}input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration{-webkit-appearance:none}fieldset{border:1px solid #c0c0c0;margin:0 2px;padding:0.35em 0.625em 0.75em}legend{border:0;padding:0}textarea{overflow:auto}optgroup{font-weight:bold}table{border-collapse:collapse;border-spacing:0}td,th{padding:0}@media print{*{text-shadow:none !important;color:#000 !important;box-shadow:none !important}a,a:visited{text-decoration:underline}a[href]:after{content:" (" attr(href) ")"}abbr[title]:after{content:" (" attr(title) ")"}a[href^="javascript:"]:after,a[href^="#"]:after{content:""}pre,blockquote{border:1px solid #999;page-break-inside:avoid}thead{display:table-header-group}tr,img{page-break-inside:avoid}img{max-width:100% !important}p,h2,h3{orphans:3;widows:3}h2,h3{page-break-after:avoid}select{background:#fff !important}.navbar{display:none}.table td,.table th{background-color:#fff !important}.btn>.caret,.dropup>.btn>.caret{border-top-color:#000 !important}.label{border:1px solid #000}.table{border-collapse:collapse !important}.table-bordered th,.table-bordered td{border:1px solid #ddd !important}}*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}*:before,*:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}html{font-size:62.5%;-webkit-tap-highlight-color:rgba(0,0,0,0)}body{font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1.42857143;color:#1a1a1a;background-color:#fff}input,button,select,textarea{font-family:inherit;font-size:inherit;line-height:inherit}a{color:#2eaff2;text-decoration:none}a:hover,a:focus{color:#0c87c7;text-decoration:underline}a:focus{outline:thin dotted;outline:5px auto -webkit-focus-ring-color;outline-offset:-2px}figure{margin:0}img{vertical-align:middle}.img-responsive{display:block;max-width:100%;height:auto}.img-rounded{border-radius:6px}.img-thumbnail{padding:4px;line-height:1.42857143;background-color:#fff;border:1px solid #ddd;border-radius:4px;-webkit-transition:all .2s ease-in-out;transition:all .2s ease-in-out;display:inline-block;max-width:100%;height:auto}.img-circle{border-radius:50%}hr{margin-top:20px;margin-bottom:20px;border:0;border-top:1px solid #eee}.sr-only{position:absolute;width:1px;height:1px;margin:-1px;padding:0;overflow:hidden;clip:rect(0, 0, 0, 0);border:0}h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{font-family:inherit;font-weight:500;line-height:1.1;color:inherit}h1 small,h2 small,h3 small,h4 small,h5 small,h6 small,.h1 small,.h2 small,.h3 small,.h4 small,.h5 small,.h6 small,h1 .small,h2 .small,h3 .small,h4 .small,h5 .small,h6 .small,.h1 .small,.h2 .small,.h3 .small,.h4 .small,.h5 .small,.h6 .small{font-weight:normal;line-height:1;color:#999}h1,.h1,h2,.h2,h3,.h3{margin-top:5px;margin-bottom:10px}h1 small,.h1 small,h2 small,.h2 small,h3 small,.h3 small,h1 .small,.h1 .small,h2 .small,.h2 .small,h3 .small,.h3 .small{font-size:65%}h4,.h4,h5,.h5,h6,.h6{margin-top:10px;margin-bottom:10px}h4 small,.h4 small,h5 small,.h5 small,h6 small,.h6 small,h4 .small,.h4 .small,h5 .small,.h5 .small,h6 .small,.h6 .small{font-size:75%}h1,.h1{font-size:36px}h2,.h2{font-size:18px}h3,.h3{font-size:16px}h4,.h4{font-size:13px}h5,.h5{font-size:14px}h6,.h6{font-size:12px}p{margin:0 0 10px}.lead{margin-bottom:20px;font-size:16px;font-weight:200;line-height:1.4}@media (min-width:768px){.lead{font-size:21px}}small,.small{font-size:85%}cite{font-style:normal}.text-left{text-align:left}.text-right{text-align:right}.text-center{text-align:center}.text-justify{text-align:justify}.text-muted{color:#999}.text-primary{color:#2eaff2}a.text-primary:hover{color:#0e98df}.text-success{color:#3c763d}a.text-success:hover{color:#2b542c}.text-info{color:#31708f}a.text-info:hover{color:#245269}.text-warning{color:#8a6d3b}a.text-warning:hover{color:#66512c}.text-danger{color:#a94442}a.text-danger:hover{color:#843534}.bg-primary{color:#fff;background-color:#2eaff2}a.bg-primary:hover{background-color:#0e98df}.bg-success{background-color:#dff0d8}a.bg-success:hover{background-color:#c1e2b3}.bg-info{background-color:#d9edf7}a.bg-info:hover{background-color:#afd9ee}.bg-warning{background-color:#fcf8e3}a.bg-warning:hover{background-color:#f7ecb5}.bg-danger{background-color:#f2dede}a.bg-danger:hover{background-color:#e4b9b9}.page-header{padding-bottom:9px;margin:40px 0 20px;border-bottom:1px solid #eee}ul,ol{margin-top:0;margin-bottom:10px}ul ul,ol ul,ul ol,ol ol{margin-bottom:0}.list-unstyled{padding-left:0;list-style:none}.list-inline{padding-left:0;list-style:none;margin-left:-5px}.list-inline>li{display:inline-block;padding-left:5px;padding-right:5px}dl{margin-top:0;margin-bottom:20px}dt,dd{line-height:1.42857143}dt{font-weight:bold}dd{margin-left:0}@media (min-width:768px){.dl-horizontal dt{float:left;width:160px;clear:left;text-align:right;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.dl-horizontal dd{margin-left:180px}}abbr[title],abbr[data-original-title]{cursor:help;border-bottom:1px dotted #999}.initialism{font-size:90%;text-transform:uppercase}blockquote{padding:10px 20px;margin:0 0 20px;font-size:17.5px;border-left:5px solid #eee}blockquote p:last-child,blockquote ul:last-child,blockquote ol:last-child{margin-bottom:0}blockquote footer,blockquote small,blockquote .small{display:block;font-size:80%;line-height:1.42857143;color:#999}blockquote footer:before,blockquote small:before,blockquote .small:before{content:'\2014 \00A0'}.blockquote-reverse,blockquote.pull-right{padding-right:15px;padding-left:0;border-right:5px solid #eee;border-left:0;text-align:right}.blockquote-reverse footer:before,blockquote.pull-right footer:before,.blockquote-reverse small:before,blockquote.pull-right small:before,.blockquote-reverse .small:before,blockquote.pull-right .small:before{content:''}.blockquote-reverse footer:after,blockquote.pull-right footer:after,.blockquote-reverse small:after,blockquote.pull-right small:after,.blockquote-reverse .small:after,blockquote.pull-right .small:after{content:'\00A0 \2014'}blockquote:before,blockquote:after{content:""}address{margin-bottom:20px;font-style:normal;line-height:1.42857143}code,kbd,pre,samp{font-family:Menlo,Monaco,Consolas,"Courier New",monospace}code{padding:2px 4px;font-size:90%;color:#c7254e;background-color:#f9f2f4;white-space:nowrap;border-radius:4px}kbd{padding:2px 4px;font-size:90%;color:#fff;background-color:#333;border-radius:3px;box-shadow:inset 0 -1px 0 rgba(0,0,0,0.25)}pre{display:block;padding:9.5px;margin:0 0 10px;font-size:13px;line-height:1.42857143;word-break:break-all;word-wrap:break-word;color:#333;background-color:#f5f5f5;border:1px solid #ccc;border-radius:4px}pre code{padding:0;font-size:inherit;color:inherit;white-space:pre-wrap;background-color:transparent;border-radius:0}.pre-scrollable{max-height:340px;overflow-y:scroll}.container{margin-right:auto;margin-left:auto;padding-left:15px;padding-right:15px; width: 700px;}.container-fluid{margin-right:auto;margin-left:auto;padding-left:15px;padding-right:15px}.row{margin-left:-15px;margin-right:-15px}.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12{position:relative;min-height:1px;padding-left:15px;padding-right:15px}.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12{float:left}.col-xs-12{width:100%}.col-xs-11{width:91.66666667%}.col-xs-10{width:83.33333333%}.col-xs-9{width:75%}.col-xs-8{width:66.66666667%}.col-xs-7{width:58.33333333%}.col-xs-6{width:50%}.col-xs-5{width:41.66666667%}.col-xs-4{width:33.33333333%}.col-xs-3{width:25%}.col-xs-2{width:16.66666667%}.col-xs-1{width:8.33333333%}.col-xs-pull-12{right:100%}.col-xs-pull-11{right:91.66666667%}.col-xs-pull-10{right:83.33333333%}.col-xs-pull-9{right:75%}.col-xs-pull-8{right:66.66666667%}.col-xs-pull-7{right:58.33333333%}.col-xs-pull-6{right:50%}.col-xs-pull-5{right:41.66666667%}.col-xs-pull-4{right:33.33333333%}.col-xs-pull-3{right:25%}.col-xs-pull-2{right:16.66666667%}.col-xs-pull-1{right:8.33333333%}.col-xs-pull-0{right:0}.col-xs-push-12{left:100%}.col-xs-push-11{left:91.66666667%}.col-xs-push-10{left:83.33333333%}.col-xs-push-9{left:75%}.col-xs-push-8{left:66.66666667%}.col-xs-push-7{left:58.33333333%}.col-xs-push-6{left:50%}.col-xs-push-5{left:41.66666667%}.col-xs-push-4{left:33.33333333%}.col-xs-push-3{left:25%}.col-xs-push-2{left:16.66666667%}.col-xs-push-1{left:8.33333333%}.col-xs-push-0{left:0}.col-xs-offset-12{margin-left:100%}.col-xs-offset-11{margin-left:91.66666667%}.col-xs-offset-10{margin-left:83.33333333%}.col-xs-offset-9{margin-left:75%}.col-xs-offset-8{margin-left:66.66666667%}.col-xs-offset-7{margin-left:58.33333333%}.col-xs-offset-6{margin-left:50%}.col-xs-offset-5{margin-left:41.66666667%}.col-xs-offset-4{margin-left:33.33333333%}.col-xs-offset-3{margin-left:25%}.col-xs-offset-2{margin-left:16.66666667%}.col-xs-offset-1{margin-left:8.33333333%}.col-xs-offset-0{margin-left:0}@media (min-width:768px){.col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12{float:left}.col-sm-12{width:100%}.col-sm-11{width:91.66666667%}.col-sm-10{width:83.33333333%}.col-sm-9{width:75%}.col-sm-8{width:66.66666667%}.col-sm-7{width:58.33333333%}.col-sm-6{width:50%}.col-sm-5{width:41.66666667%}.col-sm-4{width:33.33333333%}.col-sm-3{width:25%}.col-sm-2{width:16.66666667%}.col-sm-1{width:8.33333333%}.col-sm-pull-12{right:100%}.col-sm-pull-11{right:91.66666667%}.col-sm-pull-10{right:83.33333333%}.col-sm-pull-9{right:75%}.col-sm-pull-8{right:66.66666667%}.col-sm-pull-7{right:58.33333333%}.col-sm-pull-6{right:50%}.col-sm-pull-5{right:41.66666667%}.col-sm-pull-4{right:33.33333333%}.col-sm-pull-3{right:25%}.col-sm-pull-2{right:16.66666667%}.col-sm-pull-1{right:8.33333333%}.col-sm-pull-0{right:0}.col-sm-push-12{left:100%}.col-sm-push-11{left:91.66666667%}.col-sm-push-10{left:83.33333333%}.col-sm-push-9{left:75%}.col-sm-push-8{left:66.66666667%}.col-sm-push-7{left:58.33333333%}.col-sm-push-6{left:50%}.col-sm-push-5{left:41.66666667%}.col-sm-push-4{left:33.33333333%}.col-sm-push-3{left:25%}.col-sm-push-2{left:16.66666667%}.col-sm-push-1{left:8.33333333%}.col-sm-push-0{left:0}.col-sm-offset-12{margin-left:100%}.col-sm-offset-11{margin-left:91.66666667%}.col-sm-offset-10{margin-left:83.33333333%}.col-sm-offset-9{margin-left:75%}.col-sm-offset-8{margin-left:66.66666667%}.col-sm-offset-7{margin-left:58.33333333%}.col-sm-offset-6{margin-left:50%}.col-sm-offset-5{margin-left:41.66666667%}.col-sm-offset-4{margin-left:33.33333333%}.col-sm-offset-3{margin-left:25%}.col-sm-offset-2{margin-left:16.66666667%}.col-sm-offset-1{margin-left:8.33333333%}.col-sm-offset-0{margin-left:0}}@media (min-width:992px){.col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12{float:left}.col-md-12{width:100%}.col-md-11{width:91.66666667%}.col-md-10{width:83.33333333%}.col-md-9{width:75%}.col-md-8{width:66.66666667%}.col-md-7{width:58.33333333%}.col-md-6{width:50%}.col-md-5{width:41.66666667%}.col-md-4{width:33.33333333%}.col-md-3{width:25%}.col-md-2{width:16.66666667%}.col-md-1{width:8.33333333%}.col-md-pull-12{right:100%}.col-md-pull-11{right:91.66666667%}.col-md-pull-10{right:83.33333333%}.col-md-pull-9{right:75%}.col-md-pull-8{right:66.66666667%}.col-md-pull-7{right:58.33333333%}.col-md-pull-6{right:50%}.col-md-pull-5{right:41.66666667%}.col-md-pull-4{right:33.33333333%}.col-md-pull-3{right:25%}.col-md-pull-2{right:16.66666667%}.col-md-pull-1{right:8.33333333%}.col-md-pull-0{right:0}.col-md-push-12{left:100%}.col-md-push-11{left:91.66666667%}.col-md-push-10{left:83.33333333%}.col-md-push-9{left:75%}.col-md-push-8{left:66.66666667%}.col-md-push-7{left:58.33333333%}.col-md-push-6{left:50%}.col-md-push-5{left:41.66666667%}.col-md-push-4{left:33.33333333%}.col-md-push-3{left:25%}.col-md-push-2{left:16.66666667%}.col-md-push-1{left:8.33333333%}.col-md-push-0{left:0}.col-md-offset-12{margin-left:100%}.col-md-offset-11{margin-left:91.66666667%}.col-md-offset-10{margin-left:83.33333333%}.col-md-offset-9{margin-left:75%}.col-md-offset-8{margin-left:66.66666667%}.col-md-offset-7{margin-left:58.33333333%}.col-md-offset-6{margin-left:50%}.col-md-offset-5{margin-left:41.66666667%}.col-md-offset-4{margin-left:33.33333333%}.col-md-offset-3{margin-left:25%}.col-md-offset-2{margin-left:16.66666667%}.col-md-offset-1{margin-left:8.33333333%}.col-md-offset-0{margin-left:0}}@media (min-width:1200px){.col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12{float:left}.col-lg-12{width:100%}.col-lg-11{width:91.66666667%}.col-lg-10{width:83.33333333%}.col-lg-9{width:75%}.col-lg-8{width:66.66666667%}.col-lg-7{width:58.33333333%}.col-lg-6{width:50%}.col-lg-5{width:41.66666667%}.col-lg-4{width:33.33333333%}.col-lg-3{width:25%}.col-lg-2{width:16.66666667%}.col-lg-1{width:8.33333333%}.col-lg-pull-12{right:100%}.col-lg-pull-11{right:91.66666667%}.col-lg-pull-10{right:83.33333333%}.col-lg-pull-9{right:75%}.col-lg-pull-8{right:66.66666667%}.col-lg-pull-7{right:58.33333333%}.col-lg-pull-6{right:50%}.col-lg-pull-5{right:41.66666667%}.col-lg-pull-4{right:33.33333333%}.col-lg-pull-3{right:25%}.col-lg-pull-2{right:16.66666667%}.col-lg-pull-1{right:8.33333333%}.col-lg-pull-0{right:0}.col-lg-push-12{left:100%}.col-lg-push-11{left:91.66666667%}.col-lg-push-10{left:83.33333333%}.col-lg-push-9{left:75%}.col-lg-push-8{left:66.66666667%}.col-lg-push-7{left:58.33333333%}.col-lg-push-6{left:50%}.col-lg-push-5{left:41.66666667%}.col-lg-push-4{left:33.33333333%}.col-lg-push-3{left:25%}.col-lg-push-2{left:16.66666667%}.col-lg-push-1{left:8.33333333%}.col-lg-push-0{left:0}.col-lg-offset-12{margin-left:100%}.col-lg-offset-11{margin-left:91.66666667%}.col-lg-offset-10{margin-left:83.33333333%}.col-lg-offset-9{margin-left:75%}.col-lg-offset-8{margin-left:66.66666667%}.col-lg-offset-7{margin-left:58.33333333%}.col-lg-offset-6{margin-left:50%}.col-lg-offset-5{margin-left:41.66666667%}.col-lg-offset-4{margin-left:33.33333333%}.col-lg-offset-3{margin-left:25%}.col-lg-offset-2{margin-left:16.66666667%}.col-lg-offset-1{margin-left:8.33333333%}.col-lg-offset-0{margin-left:0}}
  @import url(http://fonts.googleapis.com/css?family=Arimo:400,700&subset=latin,cyrillic);*,body{font-family:Arimo, sans-serif;}header{border-bottom:1px solid #E7E5E6;padding:20px 0;}.row-userinfo .userinfo{font-size:30px;line-height:30px;margin:15px 0;}.row-userinfo .userinfo.status{color:#2DAEF2;}.row-userinfo .userinfo.company{color:gray;}.row-userinfo .qrcode > figcaption{text-align:center;}.row-timeline{border-top:1px solid #E7E5E6;color:#656565;padding:25px 0 25px;}.row-datetime{font-size:10px;margin-top:25px;margin-bottom:0px;}.row-datetime .date{color:#222225;font-size:16px;line-height:25px;}.row-datetime .date > big{display:block;font-size:25px;}.row-datetime .time > span{color:#999;}.reminder{background:#F2F3F4;color:#656565;padding:10px 0;}.reminder h2{margin-bottom:15px;}.row-transport .title{color:#2DAEF2;font-size:20px;line-height:20px; margin-top: 15px;}
  .transport-icon{background-image: url(data:image/png;base64,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);background-repeat:no-repeat;display:block;}.transport-icon-t_bus{background-position:-3px -2px;height:25px;width:30px;}.transport-icon-t_car{background-position:-2px -31px;height:22px;width:30px;}.transport-icon-t_routebus{background-position:-3px -85px;height:25px;width:30px;}.transport-icon-t_taxi{background-position:-3px -56px;height:25px;width:30px;}.transport-icon-t_train{background-position:-3px -114px;height:40px;width:30px;}.row-bus_timeline{color:#656565;}.row-bus_timeline .title{font-size:20px;}.row-bus_timeline h4{margin-top:10px;}footer{color:#C8C8CB;font-size:12px;padding:20px 0 0;}ul >li{background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAYAAAA71pVKAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAESSURBVHjalNO/K8RxHMfxh08GFl0334JMyEI2SUluduEyWC47f4PZrkQhKbNSMsiirpTOhhKy6LqNjeX91amju9fyqff79fz07v2jq1KpaFIPVrCASfThHTc4wQE+M3NqAkdwiS28YQ3z2MBrxK8wlgHd8Q7jAk+RfPRbB9jEMc4xjbuEXuwFMNcCzJTlH8Lf240yRjGEuv9Vj37co5ywhCM8a08v4V9MGMepznSKiYRcG+W2Kj+X0EC+QziPRkIVxQ7hIqopZreMQptgIfzHCYeoxfrl2yj3JPyHCR9YxQDO0P8H2B/5wfB/ZLtdwwy+cItdlCJWwk7EuzAb/p/dzj6Yarqq7RhjA9dYx37zVX0PAB99QGeygeZKAAAAAElFTkSuQmCC);background-repeat:no-repeat;background-position:0 3px;list-style:none;margin-bottom:1px;padding:3px 0 2px 20px;font-size:11px;}.row-item{margin-bottom:10px;}.clearfix:after{content:" ";visibility:hidden;display:block;height:0;clear:both;}.row-userinfo,.row-transport{padding:0;}.row-timeline h3,.row-transport h3{font-size:13px;font-weight:400;margin:0;padding:0 0 3px;}.row-bus_timeline .row-fill h3,ul{margin:0;padding:0;}
  .page-transport {font-size: 10px;}
  table.booking {} table.booking td {padding: 0 5px;}
  .page-car {} .page-car>div {position: absolute; font-size: 60px; text-align: center; text-transform: uppercase;} .page-car .fline {position: absolute; margin: 220px 0 0 45px; width: 610px;} .page-car .sline {margin: 355px 0 0 97px; width: 325px;}
</style>
<div style="page-break-after: always;">
<header>
  <div class="container clearfix">
    <div class="row">
      <!-- Логотип -->
      <div class="col-xs-7">
        <div class="logo">
          <img alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAM8AAAAwCAYAAAC2RS6TAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyRkFCM0E3OUI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyRkFCM0E3QUI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTc3QjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTc4QjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+qUfmpAAACypJREFUeNrsXQmQ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" />
        </div>
      </div>
      <!-- Информация о проживании -->
      <div class="col-xs-5">
        <?if($roomProductManager !== null):?>
          <table class="booking">
            <tr>
              <td class="text-muted">Пансионат</td><td><?=$roomProductManager->Hotel;?></td>
            </tr>
            <tr>
              <td class="text-muted">Корпус</td><td><?=$roomProductManager->Housing;?></td>
            </tr>
            <tr>
              <td class="text-muted">Комната</td><td><?=$roomProductManager->Number;?></td>
            </tr>
          </table>
        <?endif;?>
      </div>
    </div>
  </div>
</header>
<div role="main">
  <div class="container">
    <!-- Информация об участнике -->
    <section class="row row-userinfo clearfix">
      <!-- Статус, ФИО, компания -->
      <div class="col-xs-6 col-xs-offset-1">
        <div class="userinfo status"><?=$role->Title;?></div>
        <div class="userinfo"><?=$user->GetFullName();?></div>
        <?if ($user->getEmploymentPrimary() !== null && $user->getEmploymentPrimary()->Company !== null):?>
          <div class="userinfo company"><?=$user->getEmploymentPrimary()->Company->Name;?></div>
        <?endif;?>
      </div>
      <!-- QR-код -->
      <div class="col-xs-4">
        <figure class="qrcode text-center">
          <img src="<?=\ruvents\components\QrCode::getAbsoluteUrl($user,120);?>" />
          <figcaption>RUNET-ID / <?=$user->RunetId;?></figcaption>
        </figure>
      </div>
    </section>
    <!-- Расписание работы регистрации -->
    <section class="row row-timeline clearfix">
      <div class="col-xs-1 text-right">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGNDM3NDFBQUI1QjExMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGNDM3NDFBQkI1QjExMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTdGQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTgwQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+RzvMSgAAAxZJREFUeNrMmT9sEnEUxx+krQnSAa1DBV1IhEEGUmxkrCM0OgixSR2aLq1/hy46uJXF2RqtQyetJiQ6KLgpGwnaMApNSAexHSgsRQaMxveOd80Bd3A/KHf3TT4J3P3uve/9+N3vfu+HbWlpCQaQHbmCzCEh5BLiRk7z+d/IL2QX+Y58Rb4h/0QTjQm29yD3kEXkQo92p5AzSAC5ycd+ItvIBlIW6Qk9Oos8R0rI4z7mtETXPOIYFGvqpAwuIAXkLjIBw2uCY/3g2AMbpJ//BfJW790Kaopjv0TGRQ06kA/IKoxeK8h7zqnL4Bjf2TwYp3nOOa7HID1l18F4Uc5n/QwucJebpZXOB0dp8Bw//mZrg6e1LoPrPLmaLTKX6DR4EVkG62iZ31rHBu/0motMEE3m92WDxG2wnuh9b5dXJR4LGiRPszQpX9NqEY1GIRgMth0rFovQaDQglUpptlEqkUiA3++HWCymej6fzx/HUtEcGZzROutwOMDr9bYdk7+TKUqu1qZTTqdTsw3dcA/NkEFfv75Op9OQTCZb/e7xwNrampQwFAqpttFSqVSSbkpAPhqD0yJXlMtlqNVqRo3DaerBSaGRiz3odrulz/V6/fh4OBwGn88nMr70aFLXkj8SiUgolcvloFAoQCAQkL67XC4JgfGluyY5Ur77tMaOMlmlUoFMJqM5Tk9QR2TwoJ9BMjeC5Hp0QAapay4PG4nGXzwe7zqezWaHCbtLBncUpeHAomlHba7b29sbJuyODQv3q3SjYE2FaR7MiRTSBop2JnJ23o54Y0GDr8mbXbHMblrIXFMuP2SD9BNvWcjgFu/ltNUkT5CqBcxV2UtX0VSVl9km66Gyozrr4nfIKxPNUe7tfjsLD5CPJpj7xLn7bn00ubr/bKA5ynVLbSbR2t1qIDeQTQPMbXKuhtrJXvuDf6C1/bY4oqe7yrFXOReIGpRFg9YPrY3Gk5jMmxzL3/lADGqQdMi7D7RceYrsD2Bsn6/1cqxDPRfZhvgbYpZr6hmuDM9Thcnn62yoyMu5L9D6G+KvaKL/AgwAZFjBTyIfWREAAAAASUVORK5CYII=" />
      </div>
      <div class="col-xs-10" style="margin-bottom: 5px;">
        <h3>Режим работы стойки регистрации</h3>
        <div>Регистрация участников, оплата участия. КПП «Поляны»</div>
      </div>
      <!-- График по дням -->
      <div class="col-xs-8 col-xs-offset-1">
        <div class="row row-datetime clearfix">
          <div class="col-xs-3">
            <div class="date"><big>16</big>апреля</div>
            <div class="time"><span>Начало</span> 12:00</div>
            <div class="time"><span>Окончание</span> 21:00</div>
          </div>
          <div class="col-xs-3">
            <div class="date"><big>17</big>апреля</div>
            <div class="time"><span>Начало</span> 8:00</div>
            <div class="time"><span>Окончание</span> 21:00</div>
          </div>
          <div class="col-xs-3">
            <div class="date"><big>18</big>апреля</div>
            <div class="time"><span>Начало</span> 8:00</div>
            <div class="time"><span>Окончание</span> 19:30</div>
          </div>
          <div class="col-xs-3">
            <div class="date"><big>19</big>апреля</div>
            <div class="time"><span>Начало</span> 8:00</div>
            <div class="time"><span>Окончание</span> 18:00</div>
          </div>
        </div>
      </div>
    </section>
    <!-- Расписание работы оргкомитета -->
    <section class="row row-timeline clearfix">
      <div class="col-xs-1 text-right">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyRkFCM0E3REI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyRkFCM0E3RUI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTdCQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTdDQjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+XcT0nAAAA7BJREFUeNrMWU1IG1EQHoNaNI1gaw+apIJCFGxBtIntRUxPHqQFe6hgT4I//cu1pfTWHOy5llYFT/3zkoAt1IO0Bw+FpHrx0CZQEdroQYOgTZSUls7szobddZPsRpPdDz42yc6+973Z9+a9mVSMjo5CEbAhvUg/8hLSg3Qi7Xw/hUwg48ivyM/IKPKf0Y4qDdq7kHeRw0h3HrtTyDPIi8gb/NtP5BvkFPKXEU/owVnkc+QP5MMC4nKBnnnAbVBbDSclcAj5HXkHWQ3HRzW39Y3bLlogvf4XyLd6R2sQDdz2S2SVUYG1yDByAkqPcWSI+9QlsJJHNgDlwwD3WaVHIK2ya1B+UJ/PCgkcYpebhXH1wpELPMfL32xMcVg7IvAJB1ezQeKCaoHnkSNgHYzwrpUVeDtfLDIBFMzvSQKJt8B6oP3eJp1KXBYUSJp8FJSv5rNyOp3g9/vB5RLHcHBwALFYDBYXF7M2/f390NnZqXguHo9DOp3O2mnZSAiHw0KbGvCTwO5c4qjRwcFB4fPu7i4cHh5CS0sLdHR0gNvthtnZWXFfrK0VfpdD+k6iJicnNW0k2O32XBK6SWBbLs9J4kKhUNYT9PvY2Bh4vV5IJpPCPQlkI30nu0AgIIjq6urStNGBNpqDjVp3enp6hGs0GlW8zkQiAUtLSwobLZAdef2YaCSBDs3TpVs8k5KX1FheXhau9fX1eeduU1OTeP5PpYoV6Mh55K+pqRGu29vbulujOUuUg94ALQCat8WABO7L9z75KqT509zcnPVYdmK0idOWFo0c6+vrwnMSaHDqZw1inwRuaQnc2NgQrj6fDxYWFmBvb0/hKcLa2tqRQRlYAHqwRQIpAF1Q31ldXRVeD63WYDAIkUhEiGsej0fwLHlvfn6+1ME6TgJXZKmhAhTnaJH09fVBb2+vYl6ROLlXS4SVCkzcL+OHL4Us6+rqwOFwCOGjjLhCHoxwIp13PyZvlcFjilBK2mxcjnhtwcPCK9Jmkx2zMxYSl5HSD0kgveI5Cwmc41qOIid5TDubBcQlWcuRpCkpHbNNRkDuKHVe/A45Y6K4GS7R5a0s3Ee+N0HcB+67YOkjw9n9xzKKo75uakWSXNWtNPI6croM4qa5r7SR8hvhD4jlt+ESre4ktz3BfYFRgRJo0raDWGg8iWCe4bba1QuiWIGEHa4+tCKfIjeLELbJz7ZyWzt6T9RGQDsOFdEf0VmWc+puzgwpATnNdr9ZUIyPc59A/Bvir9FR/RdgABYkE9ZZQEObAAAAAElFTkSuQmCC" />
      </div>
      <div class="col-xs-10">
        <h3>Режим работы стойки орг. комитета</h3>
        <div>Выдача отчетных документов, оплата доп.услуг, отметка командировочных удостоверений, орг. вопросы: холл первого корпуса «Поляны»</div>
      </div>
      <!-- График по дням -->
      <div class="col-xs-8 col-xs-offset-1">
        <div class="row row-datetime clearfix">
          <div class="col-xs-3">
            <div class="date"><big>16</big>апреля</div>
            <div class="time"><span>Начало</span> 15:30</div>
            <div class="time"><span>Окончание</span> 21:00</div>
          </div>
          <div class="col-xs-3">
            <div class="date"><big>17</big>апреля</div>
            <div class="time"><span>Начало</span> 8:00</div>
            <div class="time"><span>Окончание</span> 21:00</div>
          </div>
          <div class="col-xs-3">
            <div class="date"><big>18</big>апреля</div>
            <div class="time"><span>Начало</span> 8:00</div>
            <div class="time"><span>Окончание</span> 20:00</div>
          </div>
          <div class="col-xs-3">
            <div class="date"><big>19</big>апреля</div>
            <div class="time"><span>Начало</span> 8:00</div>
            <div class="time"><span>Окончание</span> 18:00</div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="reminder">
    <div class="container">
      <div class="row row-reminder clearfix">
        <div class="col-xs-4">
          <h2>Памятка участника</h2>
          <ul>
            <li>Распечатать путевой лист</li>
            <li>Выбрать вид транспорта</li>
            <li>Оплатить дополнительные услуги</li>
            <li>Посетить выставку и конференцию РИФ+КИБ</li>
            <li>Получить отчетные документы и оформить командировочное удостоверение</li>
          </ul>
        </div>
        <div class="col-xs-4">
          <h2>Заселение</h2>
          <ul>
            <li>Поляны (т-образный перекресток,<br/>поворот налево, 28,5 км)</li>
            <li>Лесные Дали (т-образный перекресток,<br/>поворот направо, 28,5 км)</li>
            <li>Назарьево (Поворот налево на 2-е Успенское ш.,<br/>22-й км)</li>
            <li>Сосны (Поворот направо Рублево-Успенского ш.,<br/>20-й км, пост ГАИ)</li>
          </ul>
        </div>
        <div class="col-xs-4">
          <h2>Оплата услуг</h2>
          <ul>
            <li>Регистрационный взнос</li>
            <li>Питание на мероприятии</li>
            <li>Билет на банкет (при наличии мест)</li>
            <li>Подписка на журнал «Интернет в Цифрах»</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<footer>
  <div class="container text-center">
    <p>Онлайн-регистрация участников — <u>RUNET-ID</u>, регистрация участников на площадке — <u>RUVENTS</u></p>
  </div>
</footer>
</div>

<div class="page-transport"  style="page-break-after: always;">
  <header>
    <div class="container clearfix">
      <div class="row">
        <!-- Логотип -->
        <div class="col-xs-9">
          <div class="logo">
            <img alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAM8AAAAwCAYAAAC2RS6TAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyRkFCM0E3OUI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyRkFCM0E3QUI1QUMxMUUzQkFGMEM1QTk5MzE1NTIxOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJGQUIzQTc3QjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJGQUIzQTc4QjVBQzExRTNCQUYwQzVBOTkzMTU1MjE4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+qUfmpAAACypJREFUeNrsXQmQ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" />
          </div>
        </div>
      </div>
    </div>
  </header>
  <div role="main">
    <div class="container clearfix">
      <!-- Заголовок -->
      <section class="row row-transport clearfix">
        <div class="row-item col-xs-12">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="title">Как добраться?</div>
          </div>
        </div>
        <!-- Личный автотранспорт -->
        <div class="row-item col-xs-12">
          <div class="col-xs-1 text-right">
            <i class="transport-icon transport-icon-t_car"></i>
          </div>
          <div class="col-xs-11">
            <h3>Личный автотранспорт</h3>
            <div>38 км. от МКАД по Рублёво-Успенскому шоссе (см. карту проезда)</div>
          </div>
        </div>
        <!-- Электричка -->
        <div class="row-item col-xs-12">
          <div class="col-xs-1 text-right">
            <i class="transport-icon transport-icon-t_train"></i>
          </div>
          <div class="col-xs-11">
            <h3>Электричка</h3>
            <div>Электричкой с Белорусского вокзала или платформ «Беговая»,«Фили», «Кунцево» (около одноимённых станций метро)  до платформы Жаворонки, а далее местным автобусом №32 до Пансионата «Поляны»</div>
          </div>
        </div>
        <!-- Автобусы конференции -->
        <div class="row-item col-xs-12">
          <div class="col-xs-1 text-right">
            <i class="transport-icon transport-icon-t_bus"></i>
          </div>
          <div class="col-xs-11">
            <h3>Автобусы конференции</h3>
            <div>Автобусы отправляются от ст. м. «Молодёжная» до пансионата «Поляны» см. место посадки</div>
          </div>
        </div>
        <!-- Маршрутное такси -->
        <div class="row-item col-xs-12">
          <div class="col-xs-1 text-right">
            <i class="transport-icon transport-icon-t_taxi"></i>
          </div>
          <div class="col-xs-11">
            <h3>Маршрутное такси</h3>
            <div>На маршрутном такси №121 от станции «Молодёжная» прямо до пансионата «Поляны». Маршрутка отправляется каждые 15-20 минут по наполнению. </div>
          </div>
        </div>
        <!-- Такси -->
        <div class="row-item col-xs-12">
          <div class="col-xs-1 text-right">
            <i class="transport-icon transport-icon-t_routebus"></i>
          </div>
          <div class="col-xs-11">
            <h3>Такси</h3>
            <div>Компания GetTaxi выступает официальным перевозчиком РИФ+КИБ - инновационное такси будет доступно для всех участников и докладчиков Форума, при этом действуют специальные тарифы</div>
          </div>
        </div>
      </section>
      <!-- Расписание автобусов -->
      <section class="row row-bus_timeline clearfix">
        <div class="row-item col-xs-12">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="title">Расписание автобусов</div>
          </div>
        </div>
        <!-- Даты, растяжка -->
        <div class="row-item row-fill">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-4"><h3>16 апреля</h3></div>
            <div class="col-xs-4"><h3>17 апреля</h3></div>
            <div class="col-xs-4"><h3>18 апреля</h3></div>
          </div>
        </div>
        <!-- Расписание -->
        <div class="row-item">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-12"><h4>M. «Молодёжная» → П-т «Поляны» <span>(время в пути – 60 минут без учета пробок)</span></h4></div>
          </div>
        </div>
        <div class="row-item">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
          </div>
        </div>
        <div class="row-item">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-12"><h4>M. «Молодёжная» → П-т «Поляны» <span>(время в пути – 60 минут без учета пробок)</span></h4></div>
          </div>
        </div>
        <div class="row-item">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
          </div>
        </div>
        <div class="row-item">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-12"><h4>M. «Молодёжная» → П-т «Поляны» <span>(время в пути – 60 минут без учета пробок)</span></h4></div>
          </div>
        </div>
        <div class="row-item">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
          </div>
        </div>
        <div class="row-item">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-12"><h4>M. «Молодёжная» → П-т «Поляны» <span>(время в пути – 60 минут без учета пробок)</span></h4></div>
          </div>
        </div>
        <div class="row-item">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
          </div>
        </div>
        <div class="row-item">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-12"><h4>M. «Молодёжная» → П-т «Поляны» <span>(время в пути – 60 минут без учета пробок)</span></h4></div>
          </div>
        </div>
        <div class="row-item">
          <div class="col-xs-11 col-xs-offset-1">
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
            <div class="col-xs-4">7:30, 7:40, 7:50, 8:00, 8:10, 8:20, 8:30, 8:45, 9:00, 9:30,10:00, 10:30, 11:00, 11:30, 12:00, 12:30, 13:00, 13:30,14:00, 14:30, 15:00, 15:30, 16:00, 16:30, 17:00</div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <footer>
    <div class="container text-center">
      <p>Онлайн-регистрация участников — <u>RUNET-ID</u>, регистрация участников на площадке — <u>RUVENTS</u></p>
    </div>
  </footer>
</div>

<?
$reporterRoles = [3,6];
$showParking = $roomProductManager !== null || in_array($role->Id, $reporterRoles);
if ($showParking)
{
  $connection = new \CDbConnection('mysql:host=109.234.156.202;dbname=rif2014', 'rif2014', 'eipahgoo9PeetieN');
  $command = $connection->createCommand();
  $command->select('*')->from('ext_booked_parking')->where('ownerRunetId = :RunetId');
  $parking = $command->queryRow(true, ['RunetId' => $user->RunetId]);
  ?>
  <?if ($parking !== false):?>
    <div class="page-car">
      <?if (in_array($role->Id, $reporterRoles)):?>
        <div class="fline" style="margin-top: 190px;"><?=$parking['carNumber'];?></div>
        <div class="sline">23,24,25</div>
        <img src="/img/event/rif14/ticket/car-reporter.jpg" />
        <img src="/img/event/rif14/ticket/map-reporter.jpg" />
      <?else:?>
        <?
        $dates = [];
        $datetime = new \DateTime($roomOrderItem->getItemAttribute('DateIn'));
        while ($datetime->format('Y-m-d') <= $roomOrderItem->getItemAttribute('DateOut'))
        {
          $dates[] = $datetime->format('d');
          $datetime->modify('+1 day');
        }
        ?>
        <div class="fline"><?=$parking['carNumber'];?></div>
        <div class="sline"><?=implode(',', $dates);?></div>
        <img src="/img/event/rif14/ticket/car-participant.jpg" />
      <?endif;?>
    </div>
  <?endif;?>
<?}?>
</body>