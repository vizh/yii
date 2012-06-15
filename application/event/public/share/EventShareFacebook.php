<?php
AutoLoader::Import('library.social.*');
 
class EventShareFacebook extends GeneralCommand
{

  private $result = array();
  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($idName = '')
  {
    if (empty($idName))
    {
      $this->result['error'] = true;
      $this->result['err_msg'] = 'Empty event name';
      echo json_encode($this->result);
      exit;
    }

    $event = Event::GetEventByIdName($idName);
    if (empty($event))
    {
      $this->result['error'] = true;
      $this->result['err_msg'] = 'Event not found';
      echo json_encode($this->result);
      exit;
    }



    $fb = RocidFacebook::GetConnection();
    //$fb->api('/me/events', 'post', );


  }
}
