<?php
AutoLoader::Import('news.source.*');

class NewsPromoAdd extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $promo = new NewsPromo();
    $promo->PostDate = date('Y-m-d H:i');
    $promo->save();

    Lib::Redirect('/admin/news/promo/edit/' . $promo->NewsPromoId . '/');
  }
}
