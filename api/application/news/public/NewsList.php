<?php
AutoLoader::Import('news.source.*');

class NewsList extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $lastRequest = Registry::GetRequestVar('LastRequest', null);
    $filter = Registry::GetRequestVar('Filter', array());
    $maxResults = Registry::GetRequestVar('MaxResults', self::MaxResult);
    $pageToken = Registry::GetRequestVar('PageToken', null);

    $criteria = new CDbCriteria();
    $criteria->condition = 't.LinkFromRss IS NULL AND t.Status = :Status';
    $criteria->params[':Status'] = NewsPost::StatusPublish;

    if (! empty($lastRequest))
    {
      $criteria->addCondition('t.PostDate > :PostDate');
      $criteria->params[':PostDate'] = date('Y-m-d H:i:s', $lastRequest);
    }

    if (!empty($filter))
    {
      $criteria->addInCondition('Categories.Title', $filter);
    }

    $criteria->group = 't.NewsPostId';

    $offset = 0;
    if ($pageToken === null)
    {
      $criteria->limit = $maxResults;
      $criteria->offset = 0;
    }
    else
    {
      $criteria->limit = $maxResults;
      $criteria->offset = $offset = $this->ParsePageToken($pageToken);
    }
    $criteria->order = 't.PostDate DESC';

    $model = NewsPost::model()->with(array('Categories' => array('together' => true, 'select' => false)));

    /** @var $posts NewsPost[] */
    $posts = $model->findAll($criteria);

    $postIdList = array();
    foreach ($posts as $post)
    {
      $postIdList[] = $post->NewsPostId;
    }

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.NewsPostId', $postIdList);
    $criteria->order = 't.PostDate DESC';

    $posts = $model->findAll($criteria);

    $result = new stdClass();
    $result->Posts = array();
    foreach ($posts as $post)
    {
      $this->Account->DataBuilder()->CreateNewsPost($post);
      $stdPost = $this->Account->DataBuilder()->BuildNewsPostCategories($post);
      $result->Posts[] = $stdPost;
    }

    if (sizeof($posts) == $maxResults)
    {
      $result->NextPageToken = $this->GetPageToken($offset + $maxResults);
    }

    $this->SendJson($result);
  }
}