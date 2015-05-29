<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 29.05.2015
 * Time: 12:49
 */

namespace application\widgets\grid;


class DataColumn extends \CDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderFilterCellContent()
    {
        if(is_string($this->filter)) {
            echo $this->filter;
        }
        elseif($this->filter!==false && $this->grid->filter!==null && $this->name!==null && strpos($this->name,'.')===false) {
            if(is_array($this->filter)) {
                echo \CHtml::activeDropDownList($this->grid->filter, $this->name, $this->filter, ['id' => false, 'prompt' => '', 'class' => 'form-control']);
            }
            elseif($this->filter===null) {
                echo \CHtml::activeTextField($this->grid->filter, $this->name, ['id' => false, 'class' => 'form-control']);
            }
        }
        else {
            parent::renderFilterCellContent();
        }
    }
} 