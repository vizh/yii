<?php
AutoLoader::Import('news.source.*');
Yii::import('ext.feed.*');

class NewsRssYandex extends AbstractCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.Status = :Status AND t.PostDate > :PostDate';
    $criteria->order = 't.PostDate DESC';
    //$criteria->limit = 3;
    $criteria->params = array(':Status' => NewsPost::StatusPublish, ':PostDate' => date('Y-m-d', time() - 8 * 24 * 60 *60));

    /** @var $newsList NewsPost[] */
    $newsList = NewsPost::model()->with('MainCategory')->findAll($criteria);


    $feed = new EFeed(EFeed::RSS2, true);

    $titles = Registry::GetWord('titles');
    $link = 'http://rocid.ru';

    $feed->setTitle($titles['news']);
    //$feed->setDescription($description);
    $feed->setLink($link);
    $feed->setImage($titles['news'], $link, 'http://rocid.ru/images/mlogo.png');
//    $feed->addChannelTag('image', array(
//      'url' => 'http://rocid.ru/images/mlogo.png',
//      'title' => $titles['news'],
//      'link' => $link)
//    );
    $time = isset($newsList[0]) ? strtotime($newsList[0]->PostDate) : time();

    $purifier = new CHtmlPurifier();
    $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');

    foreach ($newsList as $news)
    {
      $item = new EFeedItemYandex();
      $item->setTitle($news->Title);
      $item->setLink(RouteRegistry::GetUrl('news', '', 'show', array('newslink' => $news->GetLink())));
      $item->setDate(strtotime($news->PostDate));
      $item->setDescription($news->GetDescription());
      if (!empty($news->MainCategory))
      {
        $item->addTag('category', $news->MainCategory->Title);
      }
      $item->addTag('yandex:genre', 'message');

      //!!! Обратный декод делается, так как не ясно, как отключить кодирование в CHtmlPurifier, а при записи рсс-итема кодирование производится повторно.
      $item->addTag('yandex:full-text', CHtml::decode($purifier->purify($news->Content)));
      $feed->addItem($item);
    }

    $feed->generateFeed();
  }
}
