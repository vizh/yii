<?php
class TheRunetController extends \application\components\controllers\PublicMainController
{
  private $RSSUrl = 'http://therunet.com/feed.rss';
  public function actionParseRSS()
  {
    $rss = simplexml_load_file($this->RSSUrl);
    foreach ($rss->channel->item as $item)
    {
      $news = \news\models\News::model()->byUrl($item->link)->find();
      if ($news == null)
      {
        $news = new \news\models\News();
        $news->Title = $item->title;
        $news->Url = $item->link;
        $news->PreviewText = strip_tags($item->description,'');
        $news->Date = date('Y-m-d H:i:s', strtotime(str_replace('+0000', '+0400', $item->pubDate))); //TODO: Убрать str_replace когда на theRunet поправят дату
        
        
        echo '<pre>';
        print_r($news->attributes);
        echo '</pre>';
        //$news->save();
      }
    }
  }
}
