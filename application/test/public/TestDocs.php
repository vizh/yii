<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 19.10.11
 * Time: 14:10
 * To change this template use File | Settings | File Templates.
 */

class TestDocs extends GeneralCommand
{
  const Delta = '  ';

  private $output;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $object = $this->getObjectUserApiSearch();

    echo '<pre>';
    $this->printObject($object);
    echo '</pre>';

    $this->output = "<table class=\"docs\">\n<tr>
    <th>Название свойства</th>
    <th>Тип</th>
    <th>Описание</th>
  </tr>
  ";
    $this->printTable($object);
    $this->output .= "</table>";
    echo '<pre>' . htmlspecialchars($this->output) . '</pre>';
  }

  private function printObject($object, $delta = '')
  {
    echo "$delta{\n";
    foreach ($object as $key => $value)
    {
      if (is_object($value))
      {
        echo self::Delta . "$delta\"$key\": ";
        $this->printObject($value, $delta.self::Delta);
      }
      elseif (is_array($value))
      {
        echo self::Delta . "$delta\"$key\": [\n";
        if (is_object($value[0]))
        {
          $this->printObject($value[0], $delta . self::Delta . self::Delta);
        }
        else
        {
          echo self::Delta . self::Delta . "$delta{{$value[0]}},\n";
        }
        echo self::Delta . "$delta],\n";
      }
      else
      {
        echo self::Delta . "$delta\"$key\": {{$value}},\n";
      }
    }
    echo "$delta}\n";
  }

  private function printTable($object, $prefix = '')
  {
    foreach ($object as $key => $value)
    {
      if (is_array($value))
      {
        $key .= '[]';
        $value = $value[0];
      }
      $this->output .= "<tr>\n<td><code>{$prefix}{$key}</code></td>\n";
      if (is_object($value))
      {
        $this->output .= "<td><code>Object</code></td>\n<td></td>\n</tr>\n";
        $this->printTable($value, $prefix.$key.'.');
      }
      else
      {
        $this->output .= "<td><code>$value</code></td>\n<td></td>\n</tr>\n";
      }
    }
  }

  private function getObjectUser()
  {
    //$object-> = '';
    //$object-> = (object) array(''=>'', ''=>'', ''=>'', ''=>'');

    $object = new stdClass();

    $object->RocId = 'int';
    $object->LastName = 'string';
    $object->LastName = 'string';
    $object->FirstName = 'string';
    $object->FatherName = 'string';
    $object->Email = 'string';

    $object->Photo = (object) array('Small' => 'string', 'Medium' => 'string', 'Large' => 'string');
    $object->Work = (object) array('Company'=>'Company', 'Position'=>'string', 'Start'=>'date', 'Finish'=>'date');
    $object->Status = (object) array('RoleId'=>'int', 'RoleName'=>'string', 'CreationTime'=>'int', 'UpdateTime'=>'int');

    $object->UpdateTime = 'int';


    return $object;

  }

  private function getObjectCompany()
  {
    $object = new stdClass();

    $object->CompanyId = 'int';
    $object->Name = 'string';
    $object->Email = 'string';
    $object->Phones = array((object) array('Phone'=>'string', 'Type' => 'string'));
    $object->Sites = array('string');
    $object->Address = (object) array('Country'=>'string', 'Region'=>'string', 'City'=>'string', 'Street'=>'string', 'House'=>'string');

    $object->Users = array('User');
    return $object;
  }

  private function getObjectEventProgram()
  {
    $object = new stdClass();

    //$object-> = '';
    //$object-> = (object) array(''=>'', ''=>'', ''=>'', ''=>'');

    $object->EventProgramId = 'int';
    $object->Type = 'string';
    $object->Abbr = 'string';
    $object->Title = 'string';
    $object->Comment = 'string';
    $object->Audience = 'string';
    $object->Rubricator = 'string';
    $object->LinkPhoto = 'string';
    $object->LinkVideo = 'string';
    $object->LinkShorthand = 'string';
    $object->LinkAudio = 'string';
    $object->Start = 'datetime';
    $object->Finish = 'datetime';
    $object->Place = 'string';
    $object->Description = 'string';
    $object->Partners = 'string';
    $object->Fill = 'string';

    $object->Reports = array((object) array('User' => 'User', 'RoleId' => 'int', 'RoleName' => 'string', 'Order' => 'int', 'Header' => 'string', 'Thesis' => 'string', 'LinkPresentation' => 'string'));

    return $object;
  }

  private function getObjectUserApiGet()
  {
    $object = new stdClass();

    //$object-> = '';
    //$object-> = (object) array(''=>'', ''=>'', ''=>'', ''=>'');
    $object->Users = array('User');

    return $object;
  }

  private function getObjectApiGeneral()
  {
    $object = new stdClass();

    $object->api_key = 'string';
    $object->timestamp = 'int';
    $object->hash = 'string';

    return $object;
  }

  private function getObjectUserApiSearch()
  {
    $object = new stdClass();

    //$object-> = '';
    //$object-> = (object) array(''=>'', ''=>'', ''=>'', ''=>'');
    $object->Users = array('User');
    $object->NextPageToken = 'string';

    return $object;
  }
}
