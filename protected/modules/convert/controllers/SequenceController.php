<?php


class SequenceController extends CController
{
  public function actionStart()
  {
    $sequences = $this->getSequences();
    foreach ($sequences as $seq)
    {
      $name = $seq['sequence_name'];
      $command = Yii::app()->getDb()->createCommand(sprintf('SELECT setval(\'"%s"\', 1, false)', $name));
      $result = $command->query();
    }
  }

  public function actionEnd()
  {
    $sequences = $this->getSequences();
    foreach ($sequences as $seq)
    {
      $name = $seq['sequence_name'];
      $column = $seq['related_column'];
      $table = $seq['related_table'];
      $command = Yii::app()->getDb()->createCommand(sprintf('SELECT setval(\'"%s"\', (SELECT MAX("%s") FROM "%s"))', $name, $column, $table));
      $result = $command->query();
    }
  }

  private function getSequences()
  {
    $command = Yii::app()->getDb()->createCommand('
SELECT t.relname as related_table,
       a.attname as related_column,
       s.relname as sequence_name
FROM pg_class s
  JOIN pg_depend d ON d.objid = s.oid
  JOIN pg_class t ON d.objid = s.oid AND d.refobjid = t.oid
  JOIN pg_attribute a ON (d.refobjid, d.refobjsubid) = (a.attrelid, a.attnum)
  JOIN pg_namespace n ON n.oid = s.relnamespace
WHERE s.relkind     = \'S\'
  AND n.nspname     = \'public\'
ORDER BY related_table');
    return $command->queryAll();
  }
}
