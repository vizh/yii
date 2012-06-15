<?php
AutoLoader::Import('news.source.*');

class NewsInfo extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $postId = Registry::GetRequestVar('PostId');

    $newsPost = NewsPost::GetById($postId);
    if (empty($newsPost))
    {
      throw new ApiException(501, array($postId));
    }

    $this->Account->DataBuilder()->CreateNewsPost($newsPost);
    $this->Account->DataBuilder()->BuildNewsPostCategories($newsPost);
    $result = $this->Account->DataBuilder()->BuildNewsPostContent($newsPost);

    $this->SendJson($result);
  }
}