<?php
AutoLoader::Import('news.source.*');
 
class NewsPromoList extends AdminCommand
{
  protected function doExecute()
  {
    $promolist = NewsPromo::GetByPage(1, 50);
    $container = new ViewContainer();
    foreach ($promolist as $promo)
    {
      $view = new View();
      $view->SetTemplate('item');

      $view->NewsPromoId = $promo->NewsPromoId;
      $view->TitleTop = $promo->TitleTop;
      $view->Title = $promo->Title;
      $view->Date = getdate(strtotime($promo->PostDate));
      $view->Description = $promo->Description;
      $view->Status = $promo->Status;
      $view->Position = $promo->Position;

      $container->AddView($view);
    }

    if (!$container->IsEmpty())
    {
      $this->view->PromoList = $container;
    }
    else
    {
      $view = new View();
      $view->SetTemplate('empty');
      $this->view->News = $view;
    }

    echo $this->view;
  }
}
