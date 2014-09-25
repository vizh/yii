<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alaris
 * Date: 2/21/13
 * Time: 12:31 PM
 * To change this template use File | Settings | File Templates.
 */ 
class AjaxController extends \application\components\controllers\PublicMainController
{
  public function actionSearch($term)
  {
    $companyCmd = \Yii::app()->db->createCommand()
      ->from(\company\models\Company::model()->tableName().' Company')
      ->select('"Company"."Id", "Company"."Name", "Company"."FullName", Count("Employment".*) as Count')
      ->leftJoin(\user\models\Employment::model()->tableName().' Employment', '"Company"."Id" = "Employment"."CompanyId"')
      ->group('Company.Id');
    
    if (is_numeric($term))
    {
      $companyCmd->where('"Company"."Id" = :Id', array('Id' => $term));
    }
    else
    {
      $companyCmd->where('to_tsvector("Company"."Name") @@ plainto_tsquery(:Query) OR to_tsvector("Company"."FullName") @@ plainto_tsquery(:Query) OR "Company"."Name" ILIKE :LikeQuery OR "Company"."FullName" ILIKE :LikeQuery', [
          'Query' => $term,
          'LikeQuery' => $term.'%'
      ])
        ->limit(10);
    }
    $companies = $companyCmd->queryAll();
    
    usort($companies, function($company1, $company2) {
      if ($company1['count'] == $company2['count']) {
        return 0;
      }
      return ($company1['count'] > $company2['count']) ? -1 : 1;
    });
    
    $result = array();
    foreach ($companies as $company)
    {
      $item = new \stdClass();
      $item->Id = $item->value = $company['Id'];
      $item->Name = $item->label = (!empty($company['FullName']) ? $company['FullName'] : $company['Name']);
      $result[] = $item;
    }
    echo json_encode($result);
  }
}
