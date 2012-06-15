<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('gate.source.*');

class GateRole extends GateCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {

    $DOM = new DOMDocument('1.0', 'CP1251');
    $response = $DOM->appendChild(new DOMElement('response'));
    $errorCode = $response->appendChild(new DOMElement('error-code'));
    $this->AddDomTextNode($errorCode, '0');

    //$DB->Query('SELECT `role_id`, `name` FROM `proj_user_roles` ORDER BY `role_id`;');
    $roles = EventRoles::GetAll();
    foreach ($roles as $role)
    {
      $domRole = $response->appendChild(new DOMElement('role'));
      $domRole->setAttribute('id', $role->RoleId);
      $this->AddDomTextNode($domRole, $role->Name);
    }

    header('Content-type: text/xml');
    echo $DOM->saveXML();
  }

  private function addDomTextNode($parent, $text)
  {
    $textNode = new DOMText($text);
    return $parent->appendChild($textNode);
  }
}