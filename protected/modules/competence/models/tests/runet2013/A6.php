<?php
namespace competence\models\tests\runet2013;

class A6 extends \competence\models\Question
{
  public $work_phone;
  public $mobile_phone;
  public $work_email;
  public $main_email;
  public $additional_email;
  
  protected function getQuestionData()
  {
    return [
      'work_phone'        => $this->work_phone,
      'mobile_phone'      => $this->mobile_phone,
      'work_email'        => $this->work_email,
      'main_email'        => $this->main_email,
      'additional_email'  => $this->additional_email
    ];
  }
  
  
  public function getNext()
  {
    return new A7($this->test);
  }

  public function getPrev()
  {
    return new A5($this->test);
  }  
  
  public function rules()
  {
    return [
      ['mobile_phone', 'required', 'message' => 'Укажите ваш номер мобильного телефона'],
      ['main_email', 'required', 'message' => 'Укажите ваш адрес основной электронной почты'],
      ['main_email,work_email,additional_email', 'email']
    ];
  }
  
  public function attributeLabels()
  {
    return [
      'main_email'       => 'Основной  адрес электронной почты',
      'work_email'       => 'Рабочий адрес электронной почты',
      'additional_email' => 'Дополнительный адрес электронной почты'
    ];
  }
}
