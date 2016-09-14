<?php
namespace partner\widgets;

use competence\models\Test;
use event\models\Event;
use event\models\InviteRequest;
use Yii;

/**
 * Class Sidebar
 *
 * Сайдбар партнерского интерфейса
 *
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

        $this->findAndSetActiveItem(
            str_replace('partner/', '', Yii::app()->getController()->getRoute()),
            $this->items
        );
    }

    /**
     * Отрисовка виджета
     *
     * @return string|void
     * @throws \CException
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
     *
     * @param $route
     * @param $items
     * @return bool
     */
    private function findAndSetActiveItem($route, &$items)
    {
        foreach ($items as &$item) {
            $active = false;

            if (isset($item['items'])) {
                $active = $this->findAndSetActiveItem($route, $item['items']);
            } else {
                $url = is_array($item['url']) ? $item['url'][0] : $item['url'];
                if ($route === $url) {
                    $active = true;
                }
            }

            if ($active) {
                $item['active'] = true;

                return true;
            }
        }

        return false;
    }

    /**
     * Возвращает элементы меню сайдбара
     *
     * @return array
     */
    private function getItemsConfig()
    {
        $event = $this->event;

        $items = [
            [
                'label' => 'Статистика',
                'icon' => 'dashboard',
                'url' => ['main/index'],
                'items' => [
                    ['label' => 'Участники', 'url' => ['main/index']],
                    ['label' => 'Финансы', 'url' => ['main/pay']]
                ]
            ],
            [
                'label' => 'Регистрации',
                'icon' => 'male',
                'url' => ['ruvents/index'],
                'items' => [
                    ['label' => 'Статистика', 'url' => ['ruvents/index']],
                    ['label' => 'Генерация операторов', 'url' => ['ruvents/operator']],
                    ['label' => 'Итоги мероприятия (csv)', 'url' => ['ruvents/csvinfo']],
                    ['label' => 'Настройки клиента', 'url' => ['ruvents/settings']],
                ]
            ],
            [
                'label' => 'Участники',
                'icon' => 'group',
                'url' => false,
                'items' => [
                    ['label' => 'Список участников', 'url' => ['user/index']],
                    ['label' => 'Редактирование', 'url' => ['user/find']],
                    ['label' => 'Регистрация', 'url' => ['user/register']],
                    ['label' => 'Экспорт участников в Excel', 'url' => ['user/export']],
                    ['label' => 'Импорт участников', 'url' => ['user/import']],
                    [
                        'label' => 'Приглашения',
                        'url' => ['user/invite'],
                        'visible' => InviteRequest::model()->byEventId($event->Id)->exists()
                    ],
                    [
                        'label' => 'Опрос участников',
                        'url' => ['user/competence'],
                        'visible' => Test::model()->byEventId($event->Id)->exists()
                    ],
                    [
                        'label' => 'Атрибуты пользователей',
                        'url' => ['user/data'],
                        'visible' => $event->hasAttributeDefinitions()
                    ],
                ]
            ],
            [
                'label' => 'Промо-коды',
                'icon' => 'ticket',
                'url' => ['coupon/index'],
                'items' => [
                    ['label' => 'Промо-коды', 'url' => ['coupon/index']],
                    ['label' => 'Генерация промо-кодов', 'url' => ['coupon/generate']]
                ]
            ],
            [
                'label' => 'Счета',
                'icon' => 'building-o',
                'url' => ['order/index'],
                'items' => [
                    ['label' => 'Счета', 'url' => ['order/index']],
                    ['label' => 'Сформировать счет', 'url' => ['order/edit']]
                ]
            ],
            [
                'label' => 'Заказы',
                'icon' => 'shopping-cart ',
                'url' => ['orderitem/index'],
                'items' => [
                    ['label' => 'Заказы', 'url' => ['orderitem/index']],
                    ['label' => 'Добавить заказ', 'url' => ['orderitem/create']]
                ]
            ],
            ['label' => 'Программа', 'icon' => 'th', 'url' => ['program/index']],
            [
                'label' => 'Настройки',
                'icon' => 'cog',
                'url' => ['settings/roles'],
                'items' => [
                    ['label' => 'Статусы', 'url' => ['settings/roles']],
                    ['label' => 'Программа лояльности', 'url' => ['settings/loyalty']],
                    ['label' => 'API', 'url' => ['settings/api']],
                    ['label' => 'Дополнительные атрибуты пользователей', 'url' => ['settings/definitions']]
                ]
            ],
        ];

        return $items;
    }
}