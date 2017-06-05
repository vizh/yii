<?php
namespace runetid\components\form;

class RegisterForm extends \CFormModel
{
    public $FirstName;
    public $LastName;
    public $SecondName;
    public $Company;
    public $Position;
    public $Email;
    public $Phone;
    public $Password;

    public function rules()
    {
        return [
            ['FirstName, LastName, Email, Password', 'required'],
            ['Email', 'email'],
            ['Email', 'unique', 'className' => '\user\models\User', 'attributeName' => 'Email'],
            ['FirstName, LastName, SecondName, Company, Position, Email, Phone', 'filter', 'filter' => [$this, 'filterPurify']]
        ];
    }

    public function filterPurify($value)
    {
        $purifier = new \CHtmlPurifier();
        $purifier->options = [
            'HTML.AllowedElements' => []
        ];
        $value = $purifier->purify($value);
        return $value;
    }
}

?>
