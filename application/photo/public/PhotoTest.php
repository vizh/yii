<?php
AutoLoader::Import('photo.source.*');

class PhotoTest extends GeneralCommand
{
  protected function doExecute()
  {
    set_time_limit(1000);
    echo 'here';
    //$photo = new Photo();
    //echo 'created photo';
    Photo::AddPhotos(0);
    
    
    $photo = new Photo();
    $photos = $photo->with('Attachment', 'PreviewImage')->findAll();
    if (! empty($photos))
    {
      foreach ($photos as $img)
      {
        echo $img->GetTitle();
        echo date('F j, Y, H:m:s', $img->Attachment->GetCreationTime());
        echo '<a target="_blank" href="'. $img->Attachment->GetUrl() .'"><img src="' . $img->PreviewImage->GetUrl() . '"/>' . $img->Attachment->GetName() . '</a>';
//        $view = new View();
//        $view->SetTemplate('attachment');
//        $view->Name = $file->GetName();
//        $view->Url = $file->GetUrl();
//        $container->AddView($view);
      }
    }
    //$this->view->List = $container;
    //echo $this->view->__toString();  
  }
}

