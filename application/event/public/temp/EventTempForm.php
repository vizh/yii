<?php
AutoLoader::Import('main.source.*');

class EventTempForm extends GeneralCommand
{
  private $access = array(35287, 454);

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    if (empty($this->LoginUser) || !in_array($this->LoginUser->RocId, $this->access))
    {
      $this->Send404AndExit();
    }
    $criteria = new CDbCriteria();
    $criteria->condition = 't.FormId = :FormId';
    $criteria->params = array(':FormId' => 'startupmixer2012');
    $results = TmpForms::model()->findAll($criteria);

    echo '<table style="border-collapse: collapse;" border="1" cellpadding="5" cellspacing="0">';
    $this->printRow(
      array(
        'Name of your startup', 'Website', '1-liner', 'Contact info',
        'Explain the problem you\'re solving', 'Describe the solution you provide',
        'How do you make or plan to make money?', 'What have you done so far?',
        'Who\'s your competitor?', 'Describe your team',
        'Are you already incorporated?', 'If yes, where and when?',
        'Are you already funded?', 'If yes, how much and by whom?',
        'Are you or have you been part of some accelerator/incubator?',
        'If yes, which one?', 'URL to your pitch deck',
        'URL to your online product demo', 'Any additional relevant information'
      )
    );
    foreach ($results as $result)
    {
      $data = unserialize(base64_decode($result->Value));
      $this->printRow($data);
    }
    echo '</table>';
  }

  private function printRow($row)
  {
    echo '<tr>';
    foreach ($row as $value)
    {
      echo '<td>'.$value.'</td>';
    }
    echo '</tr>';
  }
}
