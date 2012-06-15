<?php


/**
 * @property int $TestId
 * @property int $VacancyId
 * @property int $AccountId
 * @property string $Title
 * @property string $Description
 * @property string $DescriptionShort
 * @property string $PartnerUrl
 * @property string $PartnerTitle
 * @property int $PassTime
 * @property string $RetestTime
 * @property int $QuestionNumber
 * @property int $PassResult
 * @property string $PassArray
 * @property string $Status
 * @property string $CreationTime
 *
 * @property Vacancy $Vacancy
 * @property JobTestQuestion[] $Questions
 * @property int $QuestionsCount
 */
class JobTest extends CActiveRecord
{
  public static $TableName = 'Mod_JobTest';

  const StatusAny = 'any';
  const StatusPublish = 'publish';
  const StatusDraft = 'draft';
  const StatusDeleted = 'deleted';

  public static $Statuses = array(self::StatusPublish, self::StatusDraft, self::StatusDeleted);

  const LoadOnlyTest = 0;
  const LoadFullTest = 1;
  
  /**
  * @param string $className
  * @return JobTest
  */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return self::$TableName;
  }

  public function primaryKey()
  {
    return 'TestId';
  }

  public function relations()
  {
    return array(
      'Vacancy' => array(self::BELONGS_TO, 'Vacancy', 'VacancyId'),
      'Questions' => array(self::HAS_MANY, 'JobTestQuestion', 'TestId', 'order' => 'Questions.QuestionId ASC'),
      'QuestionsCount' => array(self::STAT, 'JobTestQuestion', 'TestId'),
    );
  }

  /**
  *
  * @param int $loadingDepth
  * @return JobTest Модель пользователя, для последующего обращения к БД.
  */
  protected static function GetLoadingDepth($loadingDepth)
  {
    switch ($loadingDepth)
    {
      case self::LoadFullTest:
        $jobTest = JobTest::model()->with('Questions.Answers');
        return $jobTest;
      case self::LoadOnlyTest:
      default:
        $jobTest = JobTest::model();
        return $jobTest;
    }
  }

  private static $retestTimes = null;
  public static function GetRetestTime($retest)
  {
    if (empty(self::$retestTimes))
    {
      self::$retestTimes = array('1hour' => 60*60, '2hour' => 2*60*60, '4hour' => 4*60*60,
        '12hour' => 12*60*60, '1day' => 24*60*60, '7day' => 7*24*60*60, 'month' => 30*24*60*60,
        '3month' => 90*24*60*60, 'halfyear' => 180*24*60*60);
    }
    return self::$retestTimes[$retest];
  }

  /**
   * @static
   * @param int $id
   * @return JobTest
   */
  public static function GetById($id, $loadingDepth = self::LoadOnlyTest)
  {
    $model = self::GetLoadingDepth($loadingDepth);
    return $model->findByPk($id);
  }

  /**
   * @static
   * @param $count
   * @param int $page
   * @param int $accountId
   * @return JobTest[]
   */
  public static function GetBySingle($count, $page = 1, $accountId = null)
  {
    $model = self::GetLoadingDepth(self::LoadOnlyTest);
    $criteria = new CDbCriteria();
    $criteria->condition = 't.VacancyId IS NULL';

    if (!empty($accountId))
    {
      $criteria->addCondition('t.AccountId = :AccountId');
      $criteria->params['AccountId'] = $accountId;
    }

    $criteria->order = 't.CreationTime DESC';
    $criteria->offset = $count * ($page - 1);
    $criteria->limit = $count;
    return $model->findAll($criteria);
  }

  public static $GetByPageCountLast = 0;
  /**
   * @static
   * @param int $count
   * @param int $page
   * @param string $status
   * @param string $notStatus
   * @param bool $calcCount
   * @return JobTest[]
   */
  public static function GetByPage($count, $page = 1, $status = null, $notStatus = null, $calcCount = false)
  {
    $tests = JobTest::model();
    $criteria = new CDbCriteria();
    $criteria->condition = '1=1';
    if (!empty($status) && $status != JobTest::StatusAny)
    {
      $criteria->condition .= ' AND t.Status = :Status';
      $criteria->params[':Status'] = $status;
    }
    if (! empty($notStatus))
    {
      $criteria->condition .= ' AND t.Status != :NotStatus';
      $criteria->params[':NotStatus'] = $notStatus;
    }

    $criteria->condition .= ' AND t.VacancyId IS NULL';

    if ($calcCount)
    {
      self::$GetByPageCountLast = $tests->count($criteria);
    }

    $criteria->order = 't.CreationTime DESC';
    $criteria->offset = ($page - 1) * $count;
    $criteria->limit = $count;

    return $tests->findAll($criteria);
  }


  /**
   * @param array $passArray
   * @return void
   */
  public function SetPassArray($passArray)
  {
    $this->PassArray = base64_encode(serialize($passArray));
  }

  /**
   * @return array
   */
  public function GetPassArray()
  {
    return unserialize(base64_decode($this->PassArray));
  }

  /**
   * @param bool $onServerDisc
   * @return string
   */
	public function GetPartnerLogoDir($onServerDisc = false)
	{
		$result = '/files/logo-tests/';
		if ($onServerDisc)
		{
			$result = $_SERVER['DOCUMENT_ROOT'] . $result;
		}
		return $result;
	}

	/**
	* Возвращает путь к логотипу партнера теста
  * @param bool $onServerDisc
	* @return string
	*/
	public function GetPartnerLogo($onServerDisc = false)
	{
		$logo = $this->TestId . '.png';
		return $this->GetPartnerLogoDir($onServerDisc) . $logo;
	}
}
