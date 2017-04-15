<?php
namespace api\components;

use application\components\helpers\ArrayHelper;
use connect\models\Meeting;
use pay\models\OrderItem;
use pay\models\Product;
use Throwable;
use user\models\User;
use Yii;

class Action extends \CAction
{
    /**
     * @return Controller
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @return \api\models\Account
     */
    public function getAccount()
    {
        return $this->getController()->getAccount();
    }

    /**
     * @return builders\Builder
     */
    public function getDataBuilder()
    {
        static $builder;

        if ($builder === null) {
            $builder = $this->getAccount()->getDataBuilder();
        }

        return $builder;
    }

    /**
     * @throws Exception
     * @return \event\models\Event
     */
    public function getEvent()
    {
        if ($this->getAccount()->Event == null) {
            throw new \api\components\Exception(301);
        }

        return $this->getAccount()->Event;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->getController()->setResult($result);
    }

    public function setSuccessResult()
    {
        $this->getController()->setResult([
            'Success' => true
        ]);
    }

    /**
     * Устанавливает ошибочный результат ответа api.
     * Может принимать ошибки валидации моделей, но отдаёт их в формате ошибок api для совместимости с остальными методами
     *
     * @param string|array[][] $error
     * @internal param array $result
     * @throws \api\components\Exception
     */
    public function setErrorResult($error)
    {
        // В целях совместимости с отображением ошибок всего api, мы будем отдавать по одной ошибке, даже если пришли результаты валидации моделей
        if (is_array($error)) {
            $fld = array_pop(array_keys($error));
            $msg = implode(', ', $error[$fld]);
            $error = "$msg: $fld";
        }

        throw new Exception(100, $error);
    }

    /**
     * @return int
     */
    protected function getMaxResults()
    {
        return \Yii::app()->getParams()['ApiMaxResults'];
    }

    /**
     * @return Meeting
     * @throws Exception
     */
    protected function getRequestedMeeting()
    {
        static $meeting;

        if ($meeting !== null) {
            return $meeting;
        }

        try {
            $id = Yii::app()
                ->getRequest()
                ->getParam('MeetingId');

            if ($id === null) {
                throw new Exception(109, ['MeetingId']);
            }

            $meeting = Meeting::model()
                ->findByPk($id);

            if ($meeting === null) {
                throw new Exception(4001, [$id]);
            }
        } catch (Exception $e) {
            $meeting = null;
            throw $e;
        } catch (Throwable $e) {
            $meeting = null;
            throw new Exception(100, [$e->getMessage()]);
        }

        return $meeting;
    }

    /**
     * @param string $param параметр запроса из которого взять RUNET-ID пользователя
     * @return User
     * @throws Exception
     */
    protected function getRequestedUser($param = 'RunetId')
    {
        static $users;

        if (isset($users[$param]) === false) {
            if ($users !== null) {
                $users = [];
            }

            try {
                $id = Yii::app()
                    ->getRequest()
                    ->getParam($param);

                if ($id === null) {
                    throw new Exception(109, [$param]);
                }

                $user = User::model()
                    ->byRunetId($id)
                    ->find();

                if ($user === null) {
                    throw new Exception(202, [$id]);
                }

                $users[$param] = $user;
            } catch (Exception $e) {
                throw $e;
            } catch (Throwable $e) {
                throw new Exception(100, [$e->getMessage()]);
            }
        }

        return $users[$param];
    }

    /**
     * @return User[]
     */
    protected function getRequestedUsers()
    {
        $users = [];

        foreach (ArrayHelper::str2nums($this->getRequestParam('RunetId')) as $id) {
            $user = User::model()
                ->byRunetId($id)
                ->find();

            if ($user === null) {
                throw new Exception(202, [$id]);
            }

            $users[$id] = $user;
        }

        return $users;
    }

    /**
     * @return Product
     * @throws Exception
     */
    protected function getRequestedProduct()
    {
        static $product;

        if ($product !== null) {
            return $product;
        }

        try {
            $id = Yii::app()
                ->getRequest()
                ->getParam('ProductId');

            if ($id === null) {
                throw new Exception(110);
            }

            $product = Product::model()
                ->findByPk($id);

            if ($product === null) {
                throw new Exception(401, [$id]);
            }

            if ($product->EventId !== $this->getEvent()->Id) {
                throw new Exception(402);
            }
        } catch (Exception $e) {
            $product = null;
            throw $e;
        } catch (Throwable $e) {
            $product = null;
            throw new Exception(100, [$e->getMessage()]);
        }

        return $product;
    }

    protected function getRequestedOrderItem()
    {
        static $orderItem;

        if ($orderItem !== null) {
            return $orderItem;
        }

        try {
            $id = Yii::app()
                ->getRequest()
                ->getParam('OrderItemId');

            if ($id === null) {
                throw new Exception(110);
            }

            $orderItem = OrderItem::model()
                ->findByPk($id);

            if ($orderItem === null) {
                throw new Exception(409);
            }

            if ($orderItem->Product->EventId !== $this->getEvent()->Id) {
                throw new Exception(402);
            }

            if ($orderItem->PayerId !== $this->getRequestedPayer()->Id) {
                throw new Exception(410);
            }

            if ($orderItem->Paid) {
                throw new Exception(411);
            }
        } catch (Exception $e) {
            $orderItem = null;
            throw $e;
        } catch (Throwable $e) {
            $orderItem = null;
            throw new Exception(100, [$e->getMessage()]);
        }

        return $orderItem;
    }

    protected function getRequestedPayer()
    {
        static $payer;

        if ($payer !== null) {
            return $payer;
        }

        try {
            $id = Yii::app()
                ->getRequest()
                ->getParam('PayerRunetId');

            if ($id === null) {
                throw new Exception(110);
            }

            $payer = User::model()
                ->byRunetId($id)
                ->find();

            if ($payer === null) {
                throw new Exception(202, [$id]);
            }
        } catch (Exception $e) {
            $payer = null;
            throw $e;
        } catch (Throwable $e) {
            $payer = null;
            throw new Exception(100, [$e->getMessage()]);
        }

        return $payer;
    }

    protected function getRequestedOwner()
    {
        static $owner;

        if ($owner !== null) {
            return $owner;
        }

        try {
            $id = Yii::app()
                ->getRequest()
                ->getParam('OwnerRunetId');

            if ($id === null) {
                throw new Exception(110);
            }

            $owner = User::model()
                ->byRunetId($id)
                ->find();

            if ($owner === null) {
                throw new Exception(202, [$id]);
            }
        } catch (Exception $e) {
            $owner = null;
            throw $e;
        } catch (Throwable $e) {
            $owner = null;
            throw new Exception(100, [$e->getMessage()]);
        }

        return $owner;
    }

    /**
     * @param string $param
     * @return string
     * @throws Exception
     */
    protected function getRequestedDate($param = 'FromUpdateTime')
    {
        static $time;

        if ($time === null) {
            if (($time = strtotime($this->getRequestParam($param))) === false) {
                throw new Exception(112, $param);
            }
            $time = date('Y-m-d H:i:s', $time);
        }

        return $time;
    }

    /**
     * Проверяет наличие указанного параметра запроса и его непустоту
     *
     * @param $param string
     * @return bool
     */
    protected function hasRequestParam($param)
    {
        return $this->getRequestParam($param, null) !== null;
    }

    protected function getRequestParam($param, $defaultValue = PHP_INT_SIZE)
    {
        static $params;

        if ($params === null) {
            $params = [];
        }

        if (isset($params[$param]) === false) {
            $params[$param] = Yii::app()
                ->getRequest()
                ->getParam($param, $defaultValue === PHP_INT_SIZE ? null : $defaultValue);
        }

        if ($defaultValue === PHP_INT_SIZE && empty($params[$param]) === true) {
            throw new Exception(109, [$param]);
        }

        return $params[$param];
    }

    /**
     * @param string $param
     * @param bool $defaultValue
     * @return bool
     */
    protected function getRequestParamBool($param, $defaultValue = false)
    {
        return (boolean)$this->getRequestParam($param, $defaultValue);
    }

    protected function getRequestParamArray($param, $defaultValue = PHP_INT_SIZE)
    {
        return explode(',', $this->getRequestParam($param, $defaultValue));
    }
}
