<!--<div class="right-banner">
  <a href="http://rocid.ru/lunch/" title="Бизнес Ланч">
    <img src="/images/lunch/business_lunch_banner.gif" alt="Бизнес Ланч" />
  </a>
</div>-->
<div class="side-title">реклама</div>
<div class="right-banner">
  <!--AdFox START-->
  <!--raecru-->
  <!--Площадка: rocid.ru / * / *-->
  <!--Тип баннера: 240*400JS-->
  <!--Расположение: <верх страницы>-->
  <script type="text/javascript">
    <!--
    if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 1000000); }
    if (typeof(document.referrer) != 'undefined') {
      if (typeof(afReferrer) == 'undefined') {
        afReferrer = escape(document.referrer);
      }
    } else {
      afReferrer = '';
    }
    var addate = new Date();
    document.write('<scr' + 'ipt type="text/javascript" src="http://ads.adfox.ru/167676/prepareCode?pp=g&amp;ps=sij&amp;p2=ekqy&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '"><\/scr' + 'ipt>');
    // -->
  </script>
  <!--AdFox END-->
</div>

<?if (!$this->HideSocial):?>
<div class="right-banner">
  <iframe src="http://www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Frocidru&amp;width=240&amp;colorscheme=light&amp;show_faces=false&amp;border_color&amp;stream=false&amp;header=false&amp;height=72" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:240px; height:72px;" allowTransparency="true"></iframe>
</div>
<?endif;?>

<?if ($this->ShowSmi2):?>
<div class="right-banner">
  <div id="smi2adblock_44839"><a href="http://smi2.ru/">Новости СМИ2</a></div>
  <script type="text/javascript" charset="windows-1251">
    (function() {
      var sc = document.createElement('script'); sc.type = 'text/javascript'; sc.async = true;
      sc.src = 'http://js.smi2.ru/data/js/44839.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sc, s);
    }());
  </script>
</div>
<?endif;?>