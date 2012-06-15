<?php

class StructureManager
{
  /**
   * @var StructureManager
   */
  private static $instance = null;

  /**
   * @static
   * @return null|StructureManager
   */
  public static function Instance()
  {
    if (self::$instance == null)
    {
      self::$instance = new StructureManager();
      self::$instance->init();
    }

    return self::$instance;
  }

  /**
   * @var Structure[]
   */
  private $elements = null;
  /**
   * @var Structure[]
   */
  private $menu = null;

  private function __construct()
  {

  }

  private function init()
  {
    $elements = Structure::GetAll();
    $this->elements = array();
    $this->menu = array();
    foreach ($elements as $element)
    {
      $this->elements[$element->StructureId] = $element;
    }

    foreach ($elements as $element)
    {
      if ($element->ShowInMenu != 0)
      {        
        $this->menu[$element->StructureId] = $element;
        $parentId = $element->ParentId;
        if ($parentId != null && $this->elements[$parentId]->FirstChildId == null)
        {
          $this->elements[$parentId]->FirstChildId = $element->StructureId;
        }
      }
    }
  }

  /**
   * @var Structure[]
   */
  private $topMenu = null;
  /**
   * @param string $sectionDir
   * @return Structure[]
   */
  public function GetTopMenu($sectionDir)
  {
    if ($this->topMenu == null)
    {
      $this->topMenu = array();
      foreach ($this->menu as $structure)
      {
        if ($structure->ParentId == null && $structure->SectionDir == $sectionDir)
        {
          $this->topMenu[$structure->StructureId] = $structure;
        }
      }
    }

    return $this->topMenu;
  }

  /**
   * @param Structure $parent
   * @return Structure[]
   */
  public function GetSubMenu($module, $sectionDir)
  {
    $subMenu = array();
    foreach ($this->menu as $structure)
    {
      if ($structure->Module == $module &&  $structure->SectionDir == $sectionDir
          && !empty($structure->Command))
      {
        $subMenu[$structure->StructureId] = $structure;
      }
    }

    return $subMenu;
  }

  /**
   * @param int $itemId
   * @return null|Structure
   */
  public function GetItem($itemId)
  {
    if (isset($this->elements[$itemId]))
    {
      return $this->elements[$itemId];
    }

    return null;
  }


  public static function GrabStructure()
  {
    set_time_limit(1000);
    self::recursiveGrabStructure(AutoLoader::ModulesPath(),
      array('Module'=>'', 'SectionDir' => '' ,'Section' => '', 'Command' => ''), null, 0);
  }

  private static function recursiveGrabStructure($path, $route, $parentId,  $iterate)
  {
    if ($iterate > 10)
    {
      return;
    }
    $dirs = scandir($path);
    foreach ($dirs as $value)
    {
      if ($value !== '.' && $value !== '..' && stristr($value, '.svn') === false )
      {
        $tmpDir = $path . DIRECTORY_SEPARATOR . $value;

        if (is_dir($tmpDir))
        {
          $temp = $route;
          if (empty($temp['Module']))
          {
            $temp['Module'] = $value;
          }
          elseif (empty($temp['SectionDir']))
          {
            if ($value != RouteRegistry::SectionDirPublic && $value != RouteRegistry::SectionDirAdmin )
            {
              continue;
            }
            $temp['SectionDir'] = $value;
          }
          elseif (empty($temp['Section']))
          {
            $temp['Section'] = $value;
          }
          $tmpParentId = $parentId;
          if (! empty($temp['SectionDir']))
          {
//            if (!empty($temp['section']))
//            {
//              $name = $temp['section'];
//            }
//            else
//            {
//              $name = $temp['module'];
//            }
            $structure = Structure::GetOrCreate($value, $temp, $parentId);
            $tmpParentId = $structure->StructureId;
          }
          self::recursiveGrabStructure($tmpDir, $temp, $tmpParentId, $iterate + 1);
        }
        elseif (is_file($tmpDir))
        {
          $pathInfo = pathinfo($tmpDir);

          if (isset($pathInfo['extension']) && $pathInfo['extension'] === 'php')
          {
            $prefix = $route['Module'] . $route['Section'];
            $name = strtolower(substr($pathInfo['filename'], strlen($prefix)));
            $temp = $route;
            $temp['Command'] = $name;
            Structure::GetOrCreate($name, $temp, $parentId);
          }
        }
      }
    }
  }
}
