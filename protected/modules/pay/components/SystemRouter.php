<?php
namespace pay\components;

class SystemRouter
{
    public static $SystemNames = [/*'ChronoPay',*/ 'PayOnline', /*'Robokassa', 'Test',*/ 'PayPal', 'Uniteller'];
    const Prefix = 'pay\components\systems\\';

    private $addition = null;

    private function __construct($addition = null)
    {
        $this->addition = $addition;
    }

    public static function create($addition = null)
    {
        $router = new SystemRouter($addition);
        $router->init();
        return $router;
    }

    /**
     * @var \pay\components\systems\Base
     */
    private $system = null;

    private function init()
    {
        foreach (self::$SystemNames as $name) {
            $className = self::Prefix . $name;
            if (!class_exists($className)) {
                throw new MessageException('Not exist class: ' . $className);
            }
            /** @var $system \pay\components\systems\Base */
            $system = new $className($this->addition);
            if ($system->check()) {
                $this->system = $system;
                return;
            }
        }
        throw new MessageException('Not find payment system for request', 102);
    }

    public function parseSystemCallback()
    {
        try {
            $this->system->fillParams();
            $this->system->parseSystem();
            self::logSuccess($this);
        } catch (Exception $e) {
            self::logError($e->getMessage(), $e->getCode());
        }
        $this->system->endParseSystem();
    }

    /**
     * Логгирует возникающие ошибки
     * @param string $message
     * @param string $code
     * @param SystemRouter $router
     * @return void
     */
    public static function LogError($message, $code, $router = null)
    {
        $log = new \pay\models\Log();
        $log->Message = $message;
        $log->Code = $code;
        if ($router != null && $router->system != null)
        {
            $log->Info = $router->system->Info();
            $log->OrderId = $router->system->getOrderId();
            $log->Total = $router->system->getTotal();
            $log->PaySystem = get_class($router->system);
        }
        else
        {
            ob_start();
            print_r($_REQUEST);
            $log->Info = ob_get_clean();
        }
        $log->Error = true;
        $log->save();
    }

    /**
     * @param SystemRouter $router
     */
    public function LogSuccess($router)
    {
        self::LogSuccessWithParams($router->system->Info(), get_class($router->system), $router->system->getOrderId(), $router->system->getTotal());
    }

    public static function LogSuccessWithParams($info, $paySystem, $orderId, $total)
    {
        $log = new \pay\models\Log();
        $log->Message = 'Success payment';
        $log->Info = $info;
        $log->PaySystem = $paySystem;
        $log->OrderId = $orderId;
        $log->Total = $total;
        $log->Error = false;
        $log->save();
    }
}