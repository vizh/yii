<?php
AutoLoader::Import('news.source.*');
AutoLoader::Import('library.graphics.*');
 
class NewsPromoEdit extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($newsPromoId = 0)
  {
    $newsPromoId = intval($newsPromoId);
    $promo = NewsPromo::GetById($newsPromoId);
    if ($promo == null)
    {
      Lib::Redirect('/admin/news/promo/list/');
    }

    $promoId = Registry::GetRequestVar('promo_post_id');
    if (! empty($promoId) && $promoId == $newsPromoId)
    {
      $data = Registry::GetRequestVar('data');

      $promo->TitleTop = trim($data['title_top']);
      $promo->Title = trim($data['title']);      
      $promo->Description = $data['description'];
      $promo->Link = $data['link'];
      $promo->Position = $data['position'];
      $promo->Status = $data['status'];
      $promo->OnTop = isset($data['on_top']) ? 1 : 0;



      $this->saveTapeImage($promo);

      if ((empty($promo->TitleTop) || empty($promo->Link)) && $promo->Status == 'publish')
      {
        $promo->Status == 'draft';
      }

      $promo->save();
    }

    $this->view->NewsPromoId = $promo->NewsPromoId;
    $this->view->TitleTop = $promo->TitleTop;
    $this->view->Title = $promo->Title;
    $this->view->Description = $promo->Description;
    $this->view->Link = $promo->Link;
    $this->view->Position = $promo->Position;
    $this->view->Status = $promo->Status;
    $this->view->Date = getdate(strtotime($promo->PostDate));
    $this->view->OnTop = $promo->OnTop;
    
    $this->view->TapeImage = $promo->GetImage();

    echo $this->view;
  }

  /**
   * @param NewsPromo $promo
   * @return void
   */
  private function saveTapeImage($promo)
  {
    if ($_FILES['tape_image']['error'] == UPLOAD_ERR_OK)
    {
      $path = $promo->GetImageDir(true);
      if (! is_dir($path))
      {
        mkdir($path);
      }
      $namePrefix = $promo->NewsPromoId;
      $clearSaveTo = $path . $namePrefix . '_clear.jpg';
      Graphics::SaveImageFromPost('tape_image', $clearSaveTo);
      $newImage = $path . $namePrefix . '_200.jpg';
      Graphics::ResizeAndSave($clearSaveTo, $newImage, 200, 130, array('x1'=>0, 'y1'=>0));
      $newImage = $path . $namePrefix . '_400.jpg';
      Graphics::ResizeAndSave($clearSaveTo, $newImage, 400, 285, array('x1'=>0, 'y1'=>0));
    }
  }
}
