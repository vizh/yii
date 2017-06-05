<?php
namespace partner\controllers\user\import;

class ProductsAction extends \partner\components\Action
{
    public function run($id)
    {
        $import = \partner\models\Import::model()->findByPk($id);
        if ($import == null || $import->EventId != $this->getEvent()->Id) {
            throw new \CHttpException(404);
        }

        $request = \Yii::app()->getRequest();
        $productNames = $this->getProductNames($import);
        $values = $request->getParam('values', []);

        $check = true;
        if (empty($productNames) || $request->getIsPostRequest() && $check = $this->checkProductValues($values)) {
            $import->Products = base64_encode(serialize($values));
            $import->save();

            $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/importprocess', ['id' => $import->Id]));
        }

        $products = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->findAll(['order' => '"t"."Id"']);

        $this->getController()->render('import/products', [
            'productNames' => $productNames,
            'products' => $products,
            'values' => $values,
            'error' => !$check
        ]);
    }

    /**
     * @param \partner\models\Import $import
     * @return array
     */
    private function getProductNames($import)
    {
        $productNames = [];
        foreach ($import->Users as $user) {
            if ($user->Product == null) {
                continue;
            }
            $productNames[] = (string)$user->Product;
        }
        return array_unique($productNames);
    }

    /**
     * @param array $values
     * @return bool
     */
    private function checkProductValues($values)
    {
        foreach ($values as $key => $value) {
            if ($value == 0) {
                return false;
            }
        }
        return true;
    }
}
