<?php
namespace application\widgets\grid;

\Yii::import('zii.widgets.grid.CGridView');

class GridView extends \CGridView
{
    const DEFAULT_PAGE_SIZE = 30;

    public $itemsCssClass = 'table';

    public $rowCssClass = [];

    public $cssFile = false;

    public $pagerCssClass = 'pagination pagination-centered';

    public $template="{items}\n{pager}";

    public $enableHistory = true;

    public $pager = [
        'class' => '\application\widgets\grid\pager\LinkPager',
    ];

    public function init()
    {
        $this->dataProvider->getPagination()->setPageSize(self::DEFAULT_PAGE_SIZE);
        parent::init();
    }


} 