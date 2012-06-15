<?php
AutoLoader::Import('news.source.*');
 
class NewsUpdateRss extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    NewsRss::UpdateFirstInQueue();
    echo 'updated';
  }
}
