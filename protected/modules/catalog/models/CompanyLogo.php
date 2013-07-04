<?php
namespace catalog\models;

class CompanyLogo
{
  protected $id;
  protected $company;
  
  public function __construct($id, $company)
  {
    $this->id = $id;
    $this->company = $company;
  }
  
  public function getVector($absolute = false)
  {
    
  }
  
  public function getOriginal($absolute = false)
  {
    
  }
  
  public function get150px($absolute = false)
  {
    
  }
}
