<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 14.12.2015
 * Time: 12:30
 */

namespace partner\models\forms\user;

use application\components\form\EventItemCreateUpdateForm;
use application\components\helpers\ArrayHelper;
use event\models\Event;
use event\models\Part;
use event\models\UserData;
use pay\models\OrderItem;
use pay\models\Product;
use user\models\User;
use event\models\Participant as ParticipantModel;

class Participant extends EventItemCreateUpdateForm
{
    /** @var null|User */
    protected $model;

    /**
     * @param Event $event
     * @param User $model
     */
    public function __construct(Event $event, User $model)
    {
        parent::__construct($event, $model);
    }

    /**
     * @return string
     */
    public function getParticipantJson()
    {
        $user = $this->model;
        $event = $this->event;

        $result = new \stdClass();

        $this->fillParticipantJsonProducts($result);
        $this->fillParticipantJsonData($result);

        $result->participants = null;
        if (!empty($this->event->Parts)) {
            $result->participants = ArrayHelper::toArray($this->event->Parts, ['event\models\Part' => [
                'Title',
                'role' => function (Part $part) use ($user, $event) {
                    $participant = ParticipantModel::model()
                        ->byPartId($part->Id)
                        ->byUserId($user->Id)
                        ->find();
                    return $participant !== null
                        ? $participant->RoleId
                        : null;
                },
                'part' => 'Id'
            ]]);
        } else {
            $participant = ParticipantModel::model()
                ->byEventId($event->Id)
                ->byUserId($this->model->Id)
                ->find();

            $result->participants[] = [
                'role' => $participant !== null
                    ? $participant->RoleId
                    : null,
            ];
        }

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Заполняет информацию о товарах участника
     * @param \stdClass $result
     */
    private function fillParticipantJsonProducts(\stdClass &$result)
    {
        $result->products = [];
        $user = $this->model;

        $products = Product::model()
            ->byEventId($this->event->Id)
            ->byManagerName('FoodProductManager')
            ->findAll();

        $products = array_filter($products, function (Product $product) {
            return $product->getPrice() === 0;
        });

        $products = ArrayHelper::toArray($products, ['pay\models\Product' => [
            'Id', 'Title', 'Paid' => function (Product $product) use ($user) {
                return OrderItem::model()
                    ->byAnyOwnerId($user->Id)
                    ->byProductId($product->Id)
                    ->byPaid(true)
                    ->exists();
            }
        ]]);

        $result->products = array_values($products);
    }

    /**
     * Заполняет информацию о дополниьельных атрибутах участника участника
     * @param \stdClass $result
     */
    private function fillParticipantJsonData(\stdClass &$result)
    {
        $data = $this->event->getUserData($this->model);
        if (empty($data)) {
            return;
        }

        $result->data = ArrayHelper::toArray($data, ['event\models\UserData' => [
            'Id',
            'titles' => function (UserData $data) {
                $titles = [];
                foreach ($data->getManager()->getDefinitions() as $definition) {
                    $titles[$definition->name] = $definition->title;
                }
                return $titles;
            },
            'attributes' => function (UserData $data) {
                $manager = $data->getManager();
                $attributes = [];
                foreach ($manager->getDefinitions() as $definition) {
                    $attributes[$definition->name] = [
                        'value' => $definition->getPrintValue($manager, true),
                        'edit'  => $definition->activeEdit($manager, ['class' => 'form-control'])
                    ];
                }
                return $attributes;
            }
        ]]);
    }

    /**
     * @return string
     */
    public function getRoleDataJson()
    {
        $data = ArrayHelper::toArray($this->event->getRoles(), ['event\models\Role' => ['Id', 'Title']]);
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}