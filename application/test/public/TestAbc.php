<?php

class MyTest
{
  protected function makeSomething($t, $t1 = '123', $t2 = '567')
  {

  }
}

class TestAbc extends GeneralCommand
{
  protected function doExecute()
  {
    echo serialize(array(
      '195.218.191.216',
      '188.93.61.140',
      '128.140.168.83',
      '128.140.168.194',
      '195.218.191.36',
      '195.218.191.81'
    ));
//    AutoLoader::Import('comission.source.*');
//    $vote = ComissionVote::GetById(6);
//
//    $list = array(44057, 111283);
//
//    foreach ($list as $rocid)
//    {
//      echo $rocid . ' : ' . RouteRegistry::GetUrl('comission', 'vote', 'process',
//        array('id' => $vote->VoteId, 'rocid' => $rocid, 'hash' => $vote->GetHash($rocid))) . '<br>';
//    }


//    AutoLoader::Import('library.rocid.event.*');
//    AutoLoader::Import('library.rocid.user.*');
//    AutoLoader::Import('library.rocid.pay.*');
//
//    $criteria = new CDbCriteria();
//    $criteria->condition = 't.ProductId = :ProductId AND t.Paid = :Paid';
//    $criteria->params = array(':ProductId' => 3, ':Paid' => 1);
//
//    /** @var $orderItems OrderItem[] */
//    $orderItems = OrderItem::model()->findAll($criteria);
//
//    echo 'Order Items: ' . sizeof($orderItems) . '<br>';
//
//    $ids = array();
//    foreach ($orderItems as $order)
//    {
//      $ids[] = $order->OwnerId;
//    }
//
//    $criteria = new CDbCriteria();
//    $criteria->condition = 't.EventId = :EventId AND t.RoleId = :RoleId';
//    $criteria->params = array(':EventId' => 236, ':RoleId' => 1);
//    $criteria->addNotInCondition('t.UserId', $ids);
//
//    /** @var $eventUsers EventUser[] */
//    $eventUsers = EventUser::model()->findAll($criteria);
//
//    echo 'Event Users: ' . sizeof($eventUsers) . '<br>';
//
//    foreach ($eventUsers as $eUser)
//    {
//      $item = new OrderItem();
//      $item->ProductId = 3;
//      $item->PayerId = $eUser->UserId;
//      $item->OwnerId = $eUser->UserId;
//      $item->save();
//
//      $eUser->RoleId = 24;
//      $eUser->save();
//      echo $eUser->UserId . '<br>';
//    }
//
//    echo 'DONE!';




    //print_r($_REQUEST);
    //print_r($_SERVER);
//    $userModel = User::model();//->with(array('Employments' => array('on' => 'Employments.Primary = 1'), 'Employments.Company'));
//
//    $criteria = new CDbCriteria();
//    $criteria->addInCondition('t.RocId', array(337, 454, 35287, 4926));
//    //$criteria->limit = 2000;
//    /** @var $users User[] */
//    $users = $userModel->findAll($criteria);
//
//    echo 'Done: ' . sizeof($users) . '<br>';
//
//    foreach ($users as $user)
//    {
//      echo $user->RocId . ' ' . sizeof($user->Employments(array('on' => 'Employments.Primary = 1'))) . '<br>';
//    }

//    set_time_limit(0);
//
//    $userModel = User::model()->with('EventUsers', 'Settings', 'Emails', 'Addresses.City')->together();
//
//    $criteria = new CDbCriteria();
//    $criteria->condition = 't.UserId NOT IN (SELECT UserId FROM EventUser WHERE EventId = :EventId) AND City.RegionId = :RegionId AND Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews';
//    $criteria->params = array(':EventId' => 196, ':RegionId' => 4925, ':Visible' => '1', ':ProjNews' => '1');
//
//    //$criteria->condition = 'EventUsers.EventId = :EventId AND Settings.Visible = :Visible AND Settings.ProjNews = :ProjNews';
//    //$criteria->params = array(':EventId' => 139, ':Visible' => '1', ':ProjNews' => '1');
//
//    $criteria->offset = 0;
//    $criteria->limit = 2000;
//    $users = $userModel->findAll($criteria);
//
//    foreach($users as $user)
//    {
//      echo $user->RocId . '<br>';
//    }


//     Проверка XCache
//        if (xcache_isset('rocid_count'))
//        {
//          $count = intval(xcache_get('rocid_count'));
//          echo $count;
//          $count +=1;
//          xcache_set('rocid_count', $count);
//        }
//        else
//        {
//          xcache_set('rocid_count', 1);
//          echo 'rocid_count is not set!';
//        }


    //echo RouteRegistry::GetUrl('company', '', 'show', array('companyid' => 234, 'menu' => 23));


    //    $str = '/test/abc';
    //
    //    $result =
    //
    //    print_r($result);








    /********  PHOTO **************/

    //    Photo::AddPhotoDirectory('/files/photo');
    //
    //    $container = new ViewContainer();
    //    $photo = new Photo();
    //    $photos = $photo->with('Attachment')->findAll();
    //    if (! empty($photos))
    //    {
    //      foreach ($photos as $img)
    //      {
    //        echo $img->GetTitle();
    //        echo date('F j, Y, H:m:s', $img->Attachment->GetTime());
    //        echo $img->Attachment->GetUrl();
    //        $view = new View();
    //        $view->SetTemplate('attachment');
    //        $view->Name = $file->GetName();
    //        $view->Url = $file->GetUrl();
    //        $container->AddView($view);
    //      }
    //    }
    //$this->view->List = $container;
    //echo $this->view->__toString();  
  }
}