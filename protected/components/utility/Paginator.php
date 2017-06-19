<?php
namespace application\components\utility;

class Paginator
{
    const AllPageName = 'all';

    private $count;
    private $countPages;
    private $showButtonAll;
    private $params = [];

    public $page;
    public $perPage = 20;
    public $pages = 13;

    public $pageParam = 'page';

    /**
     * @param int $count
     * @param array $params
     */
    public function __construct($count, $params = [], $showButtonAll = false, $pageParam = 'page')
    {
        $this->count = $count;
        $this->params = $params;
        $this->page = \Yii::app()->request->getParam($pageParam, 1);
        $this->pageParam = $pageParam;
        $this->showButtonAll = $showButtonAll;

        if ($this->page != self::AllPageName || !$this->showButtonAll) {
            $this->page = (int)$this->page;
            $this->page = max($this->page, 1);
        }
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    public function getCountPages()
    {
        if ($this->countPages === null) {
            $this->countPages = ceil($this->count / $this->perPage);
        }
        return $this->countPages;
    }

    /**
     *
     * @return int
     */
    public function getOffset()
    {
        return ($this->page - 1) * $this->perPage;
    }

    /**
     * @return \CDbCriteria
     */
    public function getCriteria()
    {
        $criteria = new \CDbCriteria();
        if ($this->page == self::AllPageName && $this->showButtonAll) {
            return $criteria;
        }
        $criteria->limit = $this->perPage;
        $criteria->offset = $this->getOffset();
        return $criteria;
    }

    /**
     * @return array
     */
    public function getPages()
    {
        $count = $this->getCountPages();
        $pages = [];
        if ($this->pages === null || $count <= $this->pages) {
            for ($i = 1; $i <= $count; $i++) {
                $page = new \stdClass();
                $page->value = $i;
                $page->url = $this->getUrl($i);
                $page->current = ($i == $this->page);
                $pages[] = $page;
            }
        } else {
            $center = ceil($this->pages / 2);
            if ($this->page < $center) {
                $start = 1;
                $end = $this->pages;
            } else if ($this->page > $count - $center + 1) {
                $end = $count;
                $start = $count - $this->pages + 1;
            } else {
                $start = $this->page - $center + 1;
                $end = $this->page + $center - 1;
            }

            for ($i = $start; $i <= $end; $i++) {

                if (($i == $start && $i != 1) || ($i == $end && $i != $count)) {
                    $value = '...';
                } else {
                    $value = $i;
                }
                $page = new \stdClass();
                $page->value = $value;
                $page->url = $this->getUrl($i);
                $page->current = ($i == $this->page);
                $pages[] = $page;
            }
        }

        if ($this->showButtonAll) {
            $page = new \stdClass();
            $page->value = \Yii::t('app', 'Все');
            $page->url = $this->getUrl(self::AllPageName);
            $page->current = ($this->page == self::AllPageName);
            $pages[] = $page;
        }
        return $pages;
    }

    /**
     * @param $page
     *
     * @return string
     */
    public function getUrl($page)
    {
        $route = '/'.\Yii::app()->getController()->getModule()->getId().'/'.\Yii::app()->getController()->getId().'/'.\Yii::app()->getController()->getAction()->getId();
        $this->params[$this->pageParam] = $page;
        $params = array_merge($_GET, $this->params);
        return \Yii::app()->createUrl($route, $params);
    }

}