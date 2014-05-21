<?php
namespace widget\controllers\link;

class IndexAction extends \widget\components\Action
{
  private $order;
  private $paginator;

  public function run()
  {
    if (\Yii::app()->getRequest()->getIsAjaxRequest())
    {
      $this->processAjaxRequest();
    }
    $this->order = \Yii::app()->getRequest()->getParam('order', 'date');
    $this->getController()->render('index', [
      'users' => $this->getUsers(),
      'orderTypeList' => $this->getOrderTypeList(),
      'order' => $this->order,
      'userLinks' => $this->getUserLinks(),
      'userLinksCount' => $this->getUserLinksCount(),
      'paginator' => $this->paginator
    ]);
  }


  private function getUsers()
  {
    $idList = [];
    $params = [
      'EventId' => $this->getEvent()->Id
    ];

    $condition = '';
    $join = '';

    if ($this->getController()->getWidgetParamValue('product') !== null)
    {
      $product = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->byPublic(true)->findByPk($this->getController()->getWidgetParamValue('product'));
      if ($product == null)
        throw new \CHttpException(500);

      $params['ProductId'] = $product->Id;
      $join .= 'LEFT JOIN "PayOrderItem" ON "PayOrderItem"."OwnerId" = "t"."UserId"';
      $condition .= 'AND "PayOrderItem"."Paid" AND "PayOrderItem"."ProductId" = :ProductId';
    }



    $profInteresIdList = !\Yii::app()->getUser()->getIsGuest() ? \CHtml::listData(\Yii::app()->getUser()->getCurrentUser()->LinkProfessionalInterests, 'Id', 'ProfessionalInterestId') : [];
    if ($this->order == 'interests' && !empty($profInteresIdList))
    {
      $sql = '
        SELECT (cast (sumpi as real) / (cpi + '.sizeof($profInteresIdList).' - sumpi)) as coef, "UserId"
          FROM (
            SELECT count("ProfessionalInterestId") as cpi, sum(
            CASE WHEN "ProfessionalInterestId" IN ('.implode(',', $profInteresIdList).') THEN 1
              ELSE 0
            END
          ) as sumpi, "t"."UserId" FROM "UserLinkProfessionalInterest" "t"
          LEFT JOIN "EventParticipant" ON "EventParticipant"."UserId" = "t"."UserId"
          LEFT JOIN "UserSettings" ON "UserSettings"."UserId" = "t"."UserId"
          '.$join.'
          WHERE "t"."UserId" != :UserId AND "EventParticipant"."EventId" = :EventId AND "UserSettings"."Visible" AND "EventParticipant"."RoleId" NOT IN ('. implode(',',$this->getExcludedRoles()) .')
          '.$condition.'
          GROUP BY "t"."UserId"
          ORDER BY count("ProfessionalInterestId") desc
        ) AS sumpilist
        ORDER BY coef desc
      ';
      $params['UserId'] = \Yii::app()->getUser()->getId();
      $command = \Yii::app()->getDb()->createCommand($sql);
      $rows = $command->queryAll(true, $params);
      foreach ($rows as $row)
      {
        $idList[] = $row['UserId'];
      }
    }
    else
    {
      $sql = '
        SELECT "t"."UserId" FROM "EventParticipant" "t"
          LEFT JOIN "User" ON "User"."Id" = "t"."UserId"
          LEFT JOIN "UserSettings" ON "User"."Id" = "UserSettings"."UserId"
          '.$join.'
          WHERE "UserSettings"."Visible" AND "t"."EventId" = :EventId AND "t"."RoleId" NOT IN ('. implode(',',$this->getExcludedRoles()) .')
          '.$condition.'
          GROUP BY "t"."UserId",
           '.($this->order == 'date' ?
                '"t"."CreationTime" ORDER BY "t"."CreationTime" ASC '
              : '"User"."LastName", "User"."FirstName" ORDER BY "User"."LastName" ASC, "User"."FirstName" ASC').'
      ';
      $command = \Yii::app()->getDb()->createCommand($sql);
      $idList = $command->queryColumn($params);
    }

    $this->paginator = new \application\components\utility\Paginator(sizeof($idList));
    $this->paginator->perPage = 99;
    $idList = array_slice($idList, $this->paginator->getOffset(), $this->paginator->perPage);
    $criteria = new \CDbCriteria();
    $criteria->with = ['Employments.Company', 'Settings'];
    $criteria->addInCondition('"t"."Id"', $idList);
    $users = \user\models\User::model()->findAll($criteria);
    $positions = array_flip($idList);
    $result = [];
    foreach ($users as $user)
    {
      $result[$positions[$user->Id]] = $user;
    }
    ksort($result);
    return $result;
  }

  private function getOrderTypeList()
  {
    return [
      'date' => \Yii::t('app', 'По дате регистрации'),
      'name' => \Yii::t('app', 'По алфавиту'),
      'interests' => \Yii::t('app', 'По интересам')
    ];
  }

  private function getUserLinks()
  {
    $result = [];
    $userId = \Yii::app()->getUser()->getId();
    $links = \link\models\Link::model()->byAnyUserId($userId)->byEventId($this->getEvent()->Id)->findAll();
    foreach ($links as $link)
    {
      $result[] = $link->UserId == $userId ? $link->OwnerId : $link->UserId;
    }
    return $result;
  }

  private function getExcludedRoles()
  {
    return [24,23];
  }

  private function processAjaxRequest()
  {
    $action = \Yii::app()->getRequest()->getParam('action');
    $method = 'processAjaxAction'.ucfirst($action);
    if (method_exists($this, $method))
    {
      $result = $this->$method();
      echo json_encode($result);
      \Yii::app()->end();
    }
    else
      throw new \CHttpException(404);
  }

  private function processAjaxActionSuggest()
  {
    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."EventId" = :EventId');
    $criteria->addNotInCondition('"t"."RoleId"', $this->getExcludedRoles());
    $criteria->params['EventId'] = $this->getEvent()->Id;

    $request = \Yii::app()->getRequest();
    $result = new \stdClass();
    if (!\Yii::app()->getUser()->getIsGuest()
      && \event\models\Participant::model()->byUserId(\Yii::app()->getUser()->getId())->exists($criteria))
    {
      $owner = \user\models\User::model()->byRunetId($request->getParam('ownerRunetId'))->find();
      if ($owner !== null && \event\models\Participant::model()->byUserId($owner->Id)->exists($criteria))
      {
        $exists = \link\models\Link::model()->byEventId($this->getEvent()->Id)
                      ->byOwnerId($owner->Id)
                      ->byAnyUserId(\Yii::app()->getUser()->getId())
                      ->exists();

        if (!$exists)
        {
          $link = new \link\models\Link();
          $link->EventId = $this->getEvent()->Id;
          $link->UserId  = \Yii::app()->getUser()->getId();
          $link->OwnerId = $owner->Id;
          $link->save();
        }
        $result->success = true;
      }
      else
      {
        $result->error = \Yii::t('app', 'Пользователь, которому вы хотите отправить приглашение, не найден.');
      }
    }
    else
      $result->error = \Yii::t('app', 'Для назначения встречи вы должны быть зарегистрированы на мероприятие.');


    return $result;
  }

  /**
   * @return \stdClass
   */
  private function getUserLinksCount()
  {
    $result = new \stdClass();
    $result->all = 0;
    $result->new = 0;

    $userId = \Yii::app()->getUser()->getId();
    $links = \link\models\Link::model()->byAnyUserId($userId)->byEventId($this->getEvent()->Id)->findAll();
    /** @var \link\models\Link $link */
    foreach ($links as $link)
    {
      if ($userId == $link->OwnerId && $link->Approved == \event\models\Approved::None)
      {
        $result->all++;
        $result->new++;
      }
      elseif ($link->Approved == \event\models\Approved::Yes) {
        $result->all++;
      }
    }
    return $result;
  }
} 