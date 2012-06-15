<?php
AutoLoader::Import('video.source.*');
 
class VideoLoad extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    echo 'video.admin.load';

    VideoPost::UploadVideo();

    echo 'video.admin.load 2';
  }
}
