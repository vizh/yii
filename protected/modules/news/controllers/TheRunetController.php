<?php

class TheRunetController extends \application\components\controllers\MainController
{
    private $theRunetUrl = 'http://therunet.com';
    private $theRunetRSSUrl = 'http://therunet.com/feed.rss';

    public function actionParseRSS()
    {
        $rss = new SimpleXMLElement(file_get_contents($this->theRunetRSSUrl));
        foreach ($rss->channel->item as $item) {
            $news = \news\models\News::model()->byUrlHash($item->link)->find();
            if ($news == null) {
                $news = new \news\models\News();
                $news->Title = $item->title;
                $news->Url = $item->link;
                $news->Date = date('Y-m-d H:i:s', strtotime(str_replace('+0000', '+0400', $item->pubDate))); //TODO: Убрать str_replace когда на theRunet поправят дату
                $previewText = trim($item->description);
                $news->PreviewText = strip_tags($previewText);
                $news->save();

                preg_match('/<img(.*)src="([а-яa-z\/_0-9-.]+)"/iu', $previewText, $imageMatch);
                if (!empty($imageMatch)) {
                    $image = file_get_contents($this->theRunetUrl.array_pop($imageMatch));
                    $news->getPhoto()->savePhoto($image);
                }
            }
        }
    }
}
