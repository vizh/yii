<?php
namespace application\widgets;

class News extends \CWidget
{
    public $limit = 5;

    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->limit = $this->limit;
        $criteria->order = '"t"."Date" DESC';

        $news = \news\models\News::model()
            ->findAll($criteria);

        $this->render('news', [
            'news' => $news
        ]);
    }
}
