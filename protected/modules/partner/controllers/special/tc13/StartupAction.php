<?php
namespace partner\controllers\special\tc13;

class StartupAction extends \partner\components\Action
{
    private $prefixes = [
        1440 => 'wp',
        1441 => 'np',
        1442 => 'bs'
    ];

    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', [1440, 1441, 1442]);
        $criteria->order = '"t"."Id"';
        $products = \pay\models\Product::model()->findAll($criteria);

        $result = null;

        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $test = \competence\models\Test::model()->findByPk(4);
            $product = $request->getParam('product');
            $count = (int)$request->getParam('count', 1);
            if (!empty($product)) {
                for ($i = 0; $i < $count; $i++) {
                    $result .= $this->getResult($test, $product).'<br>';
                }
            }
        }

        $this->getController()->render('tc13/startup', ['products' => $products, 'result' => $result]);
    }

    /**
     * @param \competence\models\Test $test
     * @param int $product
     *
     * @return string
     */
    private function getResult($test, $product)
    {
        $prefix = isset($this->prefixes[$product]) ? $this->prefixes[$product] : 'np';
        $userKey = $prefix.\application\components\utility\Texts::GenerateString(6, true);
        $hash = $test->getKeyHash($userKey);
        return \Yii::app()->createUrl('/event/view/index', [
            'userKey' => $userKey,
            'userHash' => $hash,
            'idName' => $this->getEvent()->IdName
        ]);
    }
}