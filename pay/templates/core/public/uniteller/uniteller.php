<script type="text/javascript">
  function listener(event) {
    if ( event.origin !== 'https://wpay.uniteller.ru' ) { return;
    }
    $('#pay_iframe').animate({height: event.data + 'px'}, 500);
  }
  if (window.addEventListener) {
    window.addEventListener('message', listener, false);
  } else {
    window.attachEvent('onmessage', listener);
  }
</script>



<iframe src="<?=$this->Url;?>" width="800" height="800" name="pay_iframe" id="pay_iframe"></iframe>


<script type="text/javascript">
  if ($.browser.msie && Number($.browser.version) < 9)
  {
    $('#pay_iframe').width(800 + 4);
    $('#pay_iframe').height(800 + 22);
  }
  if ($.browser.webkit)
  { // Chrome добавляет перед body отступ.
    $('#pay_iframe').height(800 + 10);
  }
</script>