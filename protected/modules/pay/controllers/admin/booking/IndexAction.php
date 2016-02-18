<?php
namespace pay\controllers\admin\booking;

use pay\models\forms\admin\BookingSearch;

/**
 * Class IndexAction Shows the page with rooms
 */
class IndexAction extends \CAction
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $form = new BookingSearch();
        if (\Yii::app()->getRequest()->isPostRequest) {
            $form->attributes = \Yii::app()->getRequest()->getParam(get_class($form));
        }

        $this->getController()->render('index', [
            'form' => $form,
            'rooms' => $form->searchRooms()
        ]);
    }
}
