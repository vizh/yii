<?php
namespace mail\components\mail;

class SPIC13 extends \mail\components\Mail
{
    public $user = null;

    public function getFrom()
    {
        return 'users@sp-ic.ru';
    }

    public function getFromName()
    {
        return 'СПИК-2013';
    }

    public function getSubject()
    {
        return 'Программа СПИК полностью готова!';
    }

    public function getBody()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Id" DESC';
        $order = \pay\models\Order::model()->byEventId(423)
            ->byPayerId($this->user->Id)->byJuridical(true)->byPaid(false)->byDeleted(false)->find($criteria);

        return \Yii::app()->getController()->renderPartial('mail.views.partner.spic13-6', ['user' => $this->user, 'personalLink' => $this->getPersonalLink(), 'order' => $order], true);
    }

    private function getPersonalLink()
    {
        $hash = substr(md5($this->user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16);;
        return 'http://2013.sp-ic.ru/my/'.$this->user->RunetId.'/'.$hash.'/';
    }
}

?>
