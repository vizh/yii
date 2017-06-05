<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 17.08.2015
 * Time: 15:26
 */

namespace event\widgets\content;

use event\components\Widget;
use event\components\WidgetPosition;
use event\models\section\LinkUser;
use user\models\User;

/**
 * Class Reporters
 * @package event\widgets\content
 *
 * @property string $WidgetReportersOrder
 */
class Reporters extends Widget
{
    /**
     * @return string[]
     */
    public function getAttributeNames()
    {
        return [
            'WidgetReportersOrder'
        ];
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return WidgetPosition::Tabs;
    }

    /**
     * Название виджета
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Докладчики');
    }

    public function run()
    {
        $this->render('reporters');
        parent::run();
    }

    /**
     * @return User
     */
    public function getUsers()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."UserId" IS NOT NULL');
        $links = LinkUser::model()->byEventId($this->getEvent()->Id)->findAll($criteria);

        $order = !isset($this->WidgetReportersOrder) ? '"t"."LastName"' : $this->WidgetReportersOrder;
        return User::model()->with(['Employments', 'Settings'])->orderBy($order)->findAllByPk(\CHtml::listData($links, 'Id', 'UserId'));
    }

    public function getIsHasDefaultResources()
    {
        return true;
    }

}