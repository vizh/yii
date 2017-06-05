<?php
namespace application\widgets\grid;

\Yii::import('zii.widgets.grid.CGridView');

class GridView extends \CGridView
{
    const DEFAULT_PAGE_SIZE = 30;

    public $itemsCssClass = 'table table-striped';

    public $rowCssClass = [];

    public $cssFile = false;

    public $pagerCssClass = 'text-center';

    public $summaryCssClass = 'table-header';

    public $template = "{summary}\n{items}\n{pager}";

    public $enableHistory = true;

    public function init()
    {
        $this->pager = array_merge([
            'pageSize' => self::DEFAULT_PAGE_SIZE
        ], $this->pager);
        $this->dataProvider->getPagination()->setPageSize($this->pager['pageSize']);
        parent::init();
        $this->pager['class'] = '\application\widgets\grid\pager\LinkPager';
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

            if (isset($column['width'])) {
                $width = $column['width'];
                if (is_numeric($width)) {
                    $width .= 'px;';
                }
                $column['htmlOptions']['style'] = (isset($column['htmlOptions']['style']) ? $column['htmlOptions']['style'].'; ' : '').'width:'.$width;
                $column['headerHtmlOptions']['style'] = (isset($column['headerHtmlOptions']['style']) ? $column['headerHtmlOptions']['style'].'; ' : '').'width:'.$width;
            }
        }
        parent::initColumns();
        $this->initColumnFilterScripts();
    }

    /**
     *
     */
    protected function initColumnFilterScripts()
    {
        $functions = '';
        if (!empty($this->afterAjaxUpdate)) {
            $functions .= $this->afterAjaxUpdate.'();';
        }

        foreach ($this->columns as $column) {
            if ($column instanceof DataColumn && $column->getFilterWidget() !== null) {
                $functions .= $column->getFilterWidget()->getInitJsFunctionName().'();';
            }
        }

        if (!empty($functions)) {
            $this->afterAjaxUpdate = 'function (id, data) {'.$functions.'}';
            \Yii::app()->getClientScript()->registerScript(
                $this->getId().'_filters',
                ('$(function () {'.$functions.'});')
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function renderFilter()
    {
        if ($this->filter !== null) {
            echo "<tr class=\"{$this->filterCssClass}\">\n";
            $skip = 0;
            foreach ($this->columns as $column) {
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

    public function renderTableHeader()
    {
        if (!$this->hideHeader) {
            echo "<thead>\n";

            if ($this->filterPosition === self::FILTER_POS_HEADER) {
                $this->renderFilter();
            }

            echo "<tr>\n";
            $skip = 0;
            /** @var \CDataColumn $column */
            foreach ($this->columns as $column) {
                if ($skip == 0) {
                    $column->renderHeaderCell();
                } else {
                    $skip--;
                }
                if (isset($column->headerHtmlOptions['colspan'])) {
                    $skip = $column->headerHtmlOptions['colspan'] - 1;
                }
            }
            echo "</tr>\n";

            if ($this->filterPosition === self::FILTER_POS_BODY) {
                $this->renderFilter();
            }

            echo "</thead>\n";
        } elseif ($this->filter !== null && ($this->filterPosition === self::FILTER_POS_HEADER || $this->filterPosition === self::FILTER_POS_BODY)) {
            echo "<thead>\n";
            $this->renderFilter();
            echo "</thead>\n";
        }
    }

} 