<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 13.07.11
 * Time: 11:23
 * To change this template use File | Settings | File Templates.
 */
 
class SettingsMaskEdit extends AdminCommand
{
  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeadScript(array('src'=>'/js/admin/mask.edit.js'));
  }

  /**
   * @var CoreMask
   */
  private $mask;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $id = intval($id);
    $this->mask = CoreMask::GetById($id);
    if (empty($this->mask))
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('settings', '', 'mask'));
    }
    //print_r($_POST);

    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $data = Registry::GetRequestVar('data');

      $data['title'] = trim($data['title']);
      $words = Registry::GetWord('news');
      $data['title'] = $data['title'] !== $words['entertitle'] ? $data['title'] : '';     
      $this->mask->Title = $data['title'];

      if ($this->mask->MaskId == CoreMask::AdminMaskId)
      {
        $this->mask->SetData(array(RouteRegistry::SectionDirAdmin => '*', RouteRegistry::SectionDirPublic => '*'));
      }
      else
      {
        if (isset($data['rules']))
        {
          $this->parseRules($data['rules']);
        }
        else
        {
          $this->mask->SetData(null);
        }
      }
      $this->mask->save();
    }

    $this->view->MaskId = $this->mask->MaskId;
    $this->view->MaskTitle = $this->mask->Title;
    $this->view->Rules = $this->getRulesHtml();

    echo $this->view;
  }

  private function getRulesHtml()
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 'SectionDir = :SectionDir';
    $criteria->params[':SectionDir'] = 'admin';
    $criteria->order = 'Module ASC, Section ASC, Command Asc';
    /**
     * @var Structure[] $structure
     */
    $structure = Structure::model()->findAll($criteria);
    $container = new ViewContainer();
    $view = null;
    $child = null;
    foreach ($structure as $item)
    {
      $checked = $this->mask->CheckAccess($item->Module, $item->Section, $item->Command, $item->SectionDir);
      if (empty($item->Section) && empty($item->Command))
      {
        if ($view != null)
        {
          if ($child != null)
          {
            $view->Childs .= (string) $child;
            $child = null;
          }
          $container->AddView($view);
        }
        $view = new View();
        $view->SetTemplate('level-0');
        $view->Childs = '';
        $view->StructureId = $item->StructureId;
        $view->ModuleName = $item->Module;
        $view->Checked = $checked;
      }
      elseif (!empty($item->Section) && empty($item->Command))
      {
        if ($child != null)
        {
          $view->Childs .= (string) $child;
        }
        $child = new View();
        $child->SetTemplate('level-1');
        $child->Childs = '';
        $child->SectionName = $item->Section;
        $child->StructureId = $item->StructureId;
        $child->Checked = $checked;
      }
      else
      {
        $temp = new View();
        $temp->SetTemplate('level-2');
        $temp->CommandName = $item->Command;
        $temp->StructureId = $item->StructureId;
        $temp->Checked = $checked;
        if (empty($item->Section))
        {
          $view->Childs .= (string) $temp;
        }
        else
        {
          $child->Childs .= (string) $temp;
        }
      }
    }
    if ($view != null)
    {
      if ($child != null)
      {
        $view->Childs .= (string) $child;
      }
      $container->AddView($view);
    }

    return $container;
  }

  private function parseRules($rules)
  {


    $result = array();
    foreach ($rules as $key => $value)
    {
      $item = StructureManager::Instance()->GetItem($key);
      if (empty($item->Section) && empty($item->Command))
      {
        $result[$item->SectionDir][$item->Module] = '*';
      }
      elseif (!empty($item->Section) && empty($item->Command))
      {
        if (!isset($result[$item->SectionDir][$item->Module]) || $result[$item->SectionDir][$item->Module] != '*')
        {
          $result[$item->SectionDir][$item->Module]['sections'][$item->Section] = '*';
        }
      }
      elseif (empty($item->Section) && !empty($item->Command))
      {
        if (!isset($result[$item->SectionDir][$item->Module]) || $result[$item->SectionDir][$item->Module] != '*')
        {
          $result[$item->SectionDir][$item->Module]['commands'][] = $item->Command;
        }
      }
      else
      {
        if (!isset($result[$item->SectionDir][$item->Module]) || ($result[$item->SectionDir][$item->Module] != '*' &&
             (!isset($result[$item->SectionDir][$item->Module]['sections'][$item->Section]) ||
              $result[$item->SectionDir][$item->Module]['sections'][$item->Section] != '*')))
        {
          $result[$item->SectionDir][$item->Module]['sections'][$item->Section][] = $item->Command;
        }
      }
    }

    $result[RouteRegistry::SectionDirPublic] = '*';

    $this->mask->SetData($result);
  }
}
