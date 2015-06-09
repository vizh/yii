<?php
namespace partner\widgets;

use competence\models\Test;
use event\models\Event;
use event\models\InviteRequest;

/**
 * Class Sidebar
 *
 * Сайдбар партнерского интерфейса
 * @package partner\widgets
 */
class Sidebar extends \CWidget
{
    /**
     * @var Event
     */
    public $event;

    /**
     * @var array Элементы меню
     */
    private $items = [];

    /**
     * Инициализация виджета
     */
    public function init()
    {
        $this->items = $this->getItemsConfig();
        $this->findAndSetActiveItem();
    }

    /**
     * Отрисовка виджета
     * @return string|void
     */
    public function run()
    {
        return $this->render('sidebar', [
            'items' => $this->items,
            'event' => $this->event
        ]);
    }

    /**
     * Устанавливает активный элемент меню
     */
    private function findAndSetActiveItem()
    {
        $route = \Yii::app()->getController()->getRoute();
        foreach ($this->items as &$item) {
            $url = is_array($item['url']) ? $item['url'][0] : $item['url'];
            if ($route === $url) {
                $item['active'] = true;
            }
        }
    }

    /**
     * Возвращает элементы меню сайдбара
     * @return array
     */
    private function getItemsConfig()
    {
        $event = $this->event;

        $items = [
            ['label' => 'Главная', 'icon' => 'dashboard', 'url' => ['main/index'], 'items' => [
                ['label' => 'Участники', 'url' => ['main/index']],
                ['label' => 'Фин. статистика', 'url' => ['main/pay']]
            ]],
            ['label' => 'Регистрации', 'icon' => 'male', 'url' => ['ruvents/index'], 'items' => [
                ['label' => 'Статистика', 'url' => ['ruvents/index']],
                ['label' => 'Генерация операторов', 'url' => ['ruvents/operator']],
                ['label' => 'Итоги мероприятия (csv)', 'url' => ['ruvents/csvinfo']]
            ]],
            ['label' => 'Участники', 'icon' => 'group', 'url' => ['user/index'], 'items' => [
                ['label' => 'Участники', 'url' => ['user/index']],
                ['label' => 'Редактирование', 'url' => ['user/edit']],
                ['label' => 'Регистрация', 'url' => ['user/register']],
                ['label' => 'Экспорт участников в CSV', 'url' => ['user/export']],
                ['label' => 'Импорт участников', 'url' => ['user/import']],
                ['label' => 'Приглашения', 'url' => ['user/invite'], 'visible' => InviteRequest::model()->byEventId($event->Id)->exists()],
                ['label' => 'Опрос участников', 'url' => ['user/competence'], 'visible' => Test::model()->byEventId($event->Id)->exists()],
            ]],
            ['label' => 'Промо-коды', 'icon' => 'ticket', 'url' => ['coupon/index'], 'items' => [
                ['label' => 'Промо-коды', 'url' => ['coupon/index']],
                ['label' => 'Генерация промо-кодов', 'url' => ['coupon/generate']]
            ]],
            ['label' => 'Счета', 'icon' => 'building-o', 'url' => ['order/index'], 'items' => [
                ['label' => 'Поиск счетов', 'url' => ['order/index']],
                ['label' => 'Выставить счет', 'url' => ['order/create']]
            ]],
            ['label' => 'Заказы', 'icon' => 'shopping-cart ', 'url' => ['orderitem/index'], 'items' => [
                ['label' => 'Заказы', 'url' => ['orderitem/index']],
                ['label' => 'Добавить заказ', 'url' => ['orderitem/create']]
            ]],
            ['label' => 'Программа', 'icon' => 'align-justify', 'url' => ['program/index']],
            ['label' => 'Настройки', 'icon' => 'cog', 'url' => ['settings/roles'], 'items' => [
                ['label' => 'Статусы', 'url' => ['settings/roles']],
                ['label' => 'Программа лояльности', 'url' => ['settings/loyalty']]
            ]],
        ];
        return $items;
    }
}