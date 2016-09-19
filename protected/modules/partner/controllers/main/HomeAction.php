<?php
namespace partner\controllers\main;

use application\components\helpers\ArrayHelper;

class HomeAction extends \partner\components\Action
{
    protected $sidebar;
    protected $menu;

    public function run()
    {
        $this->sidebar = \Yii::createComponent([
            'class' => 'partner\widgets\Sidebar',
            'event' => $this->getEvent()
        ]);

        $this->menu = \Yii::createComponent([
            'class' => 'partner\widgets\Menu',
        ]);

        return $this->controller->redirect($this->getAvailableItem($this->sidebar->getItemsConfig())['url']);
    }

    protected function getAvailableItem($items)
    {
        foreach ($items as $item) {
            $result = null;
            if (isset($item['items']) ){
                $result = $this->getAvailableItem(ArrayHelper::getValue($item, 'items', []));
            }
            else{
                $result = $this->menu->checkAccess($item['url']) ? $item : null;
            }
            if ($result){
                return $result;
            }
        }
        return null;
    }
}