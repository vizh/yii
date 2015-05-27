<?php
namespace partner\widgets;

use event\models\Event;

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
     * @return Event
     * @throws \application\components\Exception
     */
    private function getCurrentEvent()
    {
        return \Yii::app()->partner->getEvent();
    }

    /**
     * Возвращает элементы меню сайдбара
     * @return array
     */
    private function getItemsConfig()
    {
        $items = [
            'common' => ['label' => 'Общая информация', 'icon' => 'dashboard', 'url' => ['event/view']],
            'participants' => [
                'label' => 'Участники', 'icon' => 'group', 'url' => '#',
                'items' => [
                    ['label' => 'Список участников', 'url' => ['participant/list']],
                    ['label' => 'Импорт', 'url' => ['participant/import']],
                    ['label' => 'Экспорт', 'url' => ['participant/export']],
                ]
            ],
            'finance' => ['label' => 'Финансы', 'icon' => 'building-o', 'url' => ['order/list']],
            'mail' => ['label' => 'Рассылки', 'icon' => 'envelope', 'url' => ['mail/list']],
            'discounts' => [
                'label' => 'Программа лояльности', 'icon' => 'ticket', 'url' => '#',
                'items' => [
                    ['label' => 'Скидки', 'url' => ['discount/template-list']],
                    ['label' => 'Купоны', 'url' => ['discount/list']],
                ]
            ],
            'settings' => [
                'label' => 'Настройки', 'icon' => 'cog', 'url' => '#',
                'items' => [
                    ['label' => 'Основные', 'url' => ['event/edit']],
                    ['label' => 'Место проведения', 'url' => ['event/place']],
                    ['label' => 'Контакты', 'url' => ['event/contacts']],
                    ['label' => 'Настройки шапки', 'url' => ['event/header']],
                    ['label' => 'Поля участников', 'url' => ['participant/attributes']],
                    ['label' => 'Статусы', 'url' => ['event/statuses']],
                    ['label' => 'Товары', 'url' => ['pay/products']],
                    [
                        'label' => 'Тариф',
                        'url' => ['event/tariff']
                    ],
                    [
                        'label' => 'Шаблон юр. счета',
                        'url' => ['pay/order-template']
                    ],
                ]
            ]
        ];
        return $items;
    }
}