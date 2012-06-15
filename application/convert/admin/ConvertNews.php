<?php
AutoLoader::Import('news.source.*');

class ConvertNews extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $db = Registry::GetDb();
    $sql = 'INSERT INTO Mod_NewsLinkCompany (`NewsPostId`, `CompanyId`)
      VALUES (:NewsPostId, :CompanyId)';
    $cmd = $db->createCommand($sql);
    $newsList = NewsPost::model()->findAll();
    foreach ($newsList as $news)
    {
      if ($news->CompanyId != null)
      {
        $cmd->bindValue(':NewsPostId', $news->NewsPostId);
        $cmd->bindValue(':CompanyId', $news->CompanyId);
        $cmd->execute();
      }
    }
    echo 'Success';
  }
}
