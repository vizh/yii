<?php
class VisitController extends CController
{
  //TODO: когда этот контролеер перестанет быть костылем, нужно убрать getDataBuilder
  //и getEvent и унаследовать RuventsController
  protected $dataBuilder = null;
  /**
   * @return DataBuilder
   */
  public function getDataBuilder()
  {
    if ($this->dataBuilder == null)
    {
      $this->dataBuilder = new \ruvents\components\DataBuilder($this->getEvent()->Id);
    }

    return $this->dataBuilder;
  }


  public function getEvent()
  {
    return \event\models\Event::model()->findByPk(831);
  }

  public function renderJson($data)
  {
    // Рендер JSON
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);

    // Оставим за разработчиком право обернуть возвращаемый JSON глобальным JSON объектом
    if (($layoutFile = $this->getLayoutFile($this->layout)) !== false)
      $json = $this->renderFile($layoutFile, array('content' => $json), true);

    header('Content-type: application/json; charset=utf-8');
    echo $json;
  }

  public function actions()
  {
    return [
      'halls' => '\ruvents\controllers\visit\HallsAction',
      'create' => '\ruvents\controllers\visit\CreateAction'
    ];
  }


} 