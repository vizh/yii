<?php
AutoLoader::Import('news.source.*');

class NewsCategoryList extends ApiNonAuthCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $result = $this->Account->DataBuilder()->CreateAllCategories();
    $this->SendJson($result);
  }
}
