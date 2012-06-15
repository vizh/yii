<?php
AutoLoader::Import('photo.source.*');
AutoLoader::Import('library.rocid.user.User');

class MainPagePhotoHook extends AbstractHook
{
  public function __toString()
  {
    ob_start();
    $user = new User();//только для работы автозаполнения методов в пхпЕд
    $user = Registry::GetVariable('LoginUser');
    
    if ($user !== null)
    {
      
      $events = $user->Events(array('order' => 'DateStart DESC', 'limit' => 3));
      print_r($events);
      $eventsId = array();
      foreach ($events as $event)
      {
        $eventsId[] = $event->GetEventId();
      }    
      $photos = Photo::GetRandomPhotos(3, $eventsId, 100);    
      foreach ($photos as $photo)
      {
        $pathGetter = new PhotoAttachmentPath($photo->GetEventId());
        echo '<a target="_blank" href="'. $pathGetter->GetUrl($photo->Attachment->GetHash()) . 
          '"><img src="' . $pathGetter->GetUrl($photo->PreviewImage->GetHash()) . '"/>' . 
          $photo->Attachment->GetName() . '</a>';
      }     
    }
    else
    {
      echo 'User is null';
    }
    return ob_get_clean();
    //return $view;
  }
}
