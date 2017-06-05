<?php
namespace application\widgets\grid\pager;

class LinkPager extends \CLinkPager
{
    public $selectedPageCssClass = 'active';

    public $header = '';

    public $nextPageLabel = '';

    public $htmlOptions = ['class' => 'pagination'];

    /**
     * @inheritdoc
     */
    public function registerClientScript()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    protected function createPageButtons()
    {
        if (($pageCount = $this->getPageCount()) <= 1) {
            return [];
        }

        list($beginPage, $endPage) = $this->getPageRange();
        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()

        $buttons = [];
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->createPageButton($i + 1, $i, $this->internalPageCssClass, false, $i == $currentPage);
        }

        return $buttons;
    }

}