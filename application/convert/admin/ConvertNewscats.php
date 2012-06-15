<?php
AutoLoader::Import('news.source.*');

class ConvertNewscats extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $db = Registry::GetDb();
    $sql = 'INSERT INTO Mod_NewsLinkCategory (`NewsPostId`, `CategoryId`)
      VALUES (:NewsPostId, :CategoryId)';
    $cmd = $db->createCommand($sql);
    $newsList = NewsPost::model()->findAll();
    foreach ($newsList as $news)
    {
      if ($news->NewsCategoryId != null && $news->NewsCategoryId != 0)
      {
        $cmd->bindValue(':NewsPostId', $news->NewsPostId);
        $cmd->bindValue(':CategoryId', $news->NewsCategoryId);
        $cmd->execute();
      }
    }
    echo 'Success';
  }
}
