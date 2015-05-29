<?php
namespace application\widgets\grid;

\Yii::import('zii.widgets.grid.CGridView');

class GridView extends \CGridView
{
    const DEFAULT_PAGE_SIZE = 30;

    public $itemsCssClass = 'table';

    public $rowCssClass = [];

    public $cssFile = false;

    public $pagerCssClass = 'text-center';

    public $summaryCssClass = 'table-header';

    public $template="{summary}\n{items}\n{pager}";

    public $enableHistory = true;

    public $pager = [
        'class' => '\application\widgets\grid\pager\LinkPager',
    ];

    public function init()
    {
        $this->dataProvider->getPagination()->setPageSize(self::DEFAULT_PAGE_SIZE);
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function registerClientScript()
    {
        /** @var \CClientScript $clientScript */
        $clientScript = \Yii::app()->getClientScript();
        $clientScript->registerPackage('runetid.jquery.migrate');
        parent::registerClientScript();
    }

    protected function initColumns()
    {
        foreach ($this->columns as &$column) {
            if (!isset($column['class'])) {
                $column['class'] = '\application\widgets\grid\DataColumn';
            }
        }
        parent::initColumns();
    }

    /**
     * @inheritdoc
     */
    public function renderFilter()
    {
        if($this->filter !== null) {
            echo "<tr class=\"{$this->filterCssClass}\">\n";
            $skip = 0;
            foreach($this->columns as $column) {
                if ($skip == 0) {
                    $column->renderFilterCell();
                } else {
                    $skip--;
                }
                if (isset($column->filterHtmlOptions['colspan'])) {
                    $skip = $column->filterHtmlOptions['colspan'] - 1;
                }
            }
            echo "</tr>\n";
        }
    }
} 