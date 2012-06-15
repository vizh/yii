<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class PayFilterList extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $manager = Registry::GetRequestVar('Manager');
    $params = Registry::GetRequestVar('Params', array());
    $filter = Registry::GetRequestVar('Filter', array());

    $product = Product::GetByManager($manager, $this->Account->EventId);

    if (empty($product))
    {
      throw new ApiException(420);
    }

    $filterResult = $product->ProductManager()->Filter($params, $filter);
    $result = array();
    foreach ($filterResult as $value)
    {
      $result[] = (object) $value;
    }

    $this->SendJson($result);
  }
}
