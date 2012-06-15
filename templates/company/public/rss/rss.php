<?echo '<';?>?xml version="1.0"?>
<rss version="2.0">
  <channel>
    <title><?=$this->Title;?></title>
    <link><?=$this->Link;?></link>
    <description></description>

    <?php echo $this->Items;?>
  </channel>
</rss>