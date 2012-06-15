<?php
AutoLoader::Import('news.source.*');
 
class NewsPromoDelete extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($promoId = 0)
  {
    $promoId = intval($promoId);
    $promo = NewsPromo::GetById($promoId);
    if ($promo != null)
    {
      $promo->delete();
    }

    Lib::Redirect('/admin/news/promo/list/');
  }
}
