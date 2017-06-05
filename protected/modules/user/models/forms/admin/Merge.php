<?php
namespace user\models\forms\admin;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use commission\models\ProjectUser;
use commission\models\User as CommissionUser;
use event\models\Participant;
use event\models\section\LinkUser;
use event\models\UserData;
use iri\models\User as IriUser;
use pay\models\CouponActivation;
use pay\models\Order;
use pay\models\OrderItem;
use raec\models\BriefLinkUser;
use raec\models\CompanyUser;
use user\models\Document;
use user\models\Education;
use user\models\Employment;
use user\models\LinkAddress;
use user\models\LinkPhone;
use user\models\LinkProfessionalInterest;
use user\models\LinkServiceAccount;
use user\models\User;

/**
 * Class Merge
 * @package user\models\forms\admin
 *
 * @method User getActiveRecord()
 */
class Merge extends CreateUpdateForm
{
    public $Email;

    public $Employments = [];

    public $PrimaryEmployment;

    public $Address;

    public $PrimaryPhone;

    /** @var User */
    protected $modelSecond;

    /** @var User */
    protected $model;

    /**
     * @inheritDoc
     */
    public function __construct(User $userPrimary, User $userSecond)
    {
        $this->modelSecond = $userSecond;
        parent::__construct($userPrimary);
    }

    /**
     * @return User
     */
    public function getSecondActiveRecord()
    {
        return $this->modelSecond;
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['PrimaryPhone', 'safe'],
            ['Email', 'required'],
            ['Email', 'email'],
            ['Employments', 'type', 'type' => 'array'],
            ['PrimaryEmployment', 'application\components\validators\ExistValidator', 'className' => 'user\models\Employment', 'attributeName' => 'Id'],
            ['Address', 'exist', 'className' => 'contact\models\Address', 'attributeName' => 'Id']
        ];
    }

    /**
     * @inheritDoc
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            foreach ($this->model->Employments as $employment) {
                $this->Employments[$employment->Id] = 1;
                if ($employment->Primary) {
                    $this->PrimaryEmployment = $employment->Id;
                }
            }
            if ($this->model->getContactAddress() !== null) {
                $this->Address = $this->model->getContactAddress()->Id;
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->fillActiveRecord();

            $this->mergeEmployments();
            $this->mergeAddress();
            $this->mergeContacts();
            $this->mergeParticipants();
            $this->mergeProgram();
            $this->mergeFinancial();
            $this->mergeProfessionalInterests();
            $this->mergeRaecIri();
            $this->mergeEducation();
            $this->mergeDocuments();
            $this->mergePhoto();

            $this->modelSecond->MergeUserId = $this->model->Id;
            $this->modelSecond->MergeTime = date('Y-m-d H:i:s');
            $this->modelSecond->Visible = false;

            $this->model->save();
            $this->modelSecond->save();

            if ($this->PrimaryPhone === $this->modelSecond->PrimaryPhone) {
                $this->model->PrimaryPhoneVerify = $this->modelSecond->PrimaryPhoneVerify;
                $this->model->save();
            }

            $transaction->commit();

            return $this->model;
        } catch (\Exception $e) {
            Flash::setError($e->getMessage());
            $transaction->rollback();
        }
        return null;
    }

    /**
     * Обьединение мест работы
     */
    public function mergeEmployments()
    {
        foreach ($this->Employments as $id => $value) {
            $employment = Employment::findOne($id);
            if ($value == 1) {
                $employment->UserId = $this->model->Id;
                $employment->Primary = ($id == $this->PrimaryEmployment);
                $employment->save();
            } elseif ($value == 0 && $employment->UserId === $this->model->Id) {
                $employment->delete();
            }
        }
    }

    /**
     * Обьединение адресов
     */
    public function mergeAddress()
    {
        if (empty($this->Address)) {
            return null;
        }

        if (!empty($this->model->LinkAddress)) {
            $this->model->LinkAddress->delete();
        }
        LinkAddress::insertOne([
            'UserId' => $this->model->Id,
            'AddressId' => $this->Address
        ]);
    }

    /**
     * Обьединение контактной информации
     */
    public function mergeContacts()
    {
        $this->mergeLinkModel(LinkPhone::model());
        $this->mergeLinkModel(LinkServiceAccount::model());

        if ($this->model->getContactSite() === null && $this->modelSecond->getContactSite() !== null) {
            $this->modelSecond->LinkSite->UserId = $this->model->Id;
            $this->modelSecond->LinkSite->save();
        }
    }

    /**
     * Обьединение участия в мероприятиях
     */
    public function mergeParticipants()
    {
        foreach ($this->modelSecond->Participants as $participant) {
            $model = Participant::model()->byEventId($participant->EventId)->byUserId($this->model->Id);
            if (!empty($participant->PartId)) {
                $model->byPartId($participant->PartId);
            }
            $primaryParticipant = $model->find();
            if ($primaryParticipant === null) {
                $participant->UserId = $this->model->Id;
                $participant->save();
            } elseif ($primaryParticipant->Role->Priority < $participant->Role->Priority) {
                $primaryParticipant->RoleId = $participant->RoleId;
                $primaryParticipant->save();
            }
        }

        $this->mergeLinkModel(UserData::model());
    }

    /**
     * Обьединение участия в секциях
     */
    public function mergeProgram()
    {
        $this->mergeLinkModel(LinkUser::model());
    }

    /**
     * Обьединение финансовой статистики
     */
    private function mergeFinancial()
    {
        $this->mergeLinkModel(Order::model(), 'PayerId');
        $this->mergeLinkModel(OrderItem::model(), 'PayerId');
        $this->mergeLinkModel(OrderItem::model(), 'OwnerId');
        $this->mergeLinkModel(OrderItem::model(), 'ChangedOwnerId');
        $this->mergeLinkModel(CouponActivation::model());
    }

    /**
     * Обьединение профессиональных интересов
     */
    private function mergeProfessionalInterests()
    {
        $links = LinkProfessionalInterest::model()->byUserId($this->modelSecond->Id)->findAll();
        foreach ($links as $link) {
            $exists = LinkProfessionalInterest::model()->byUserId($this->model->Id)->byProfessionalInterestId($link->ProfessionalInterestId)->exists();
            if (!$exists) {
                $link->UserId = $this->model->Id;
                $link->save();
            }
        }
    }

    /**
     * Обьединение деятельности в РАЭК
     */
    private function mergeRaecIri()
    {
        $this->mergeLinkModel(CommissionUser::model());
        $this->mergeLinkModel(ProjectUser::model());
        $this->mergeLinkModel(CompanyUser::model());
        $this->mergeLinkModel(BriefLinkUser::model());
        $this->mergeLinkModel(IriUser::model());
    }

    /**
     * Обьединение образования
     */
    private function mergeEducation()
    {
        $this->mergeLinkModel(Education::model());
    }

    /**
     * Обьединенение документов
     */
    private function mergeDocuments()
    {
        foreach ($this->modelSecond->Documents as $document) {
            $exists = Document::model()->byUserId($this->model->Id)->byTypeId($document->TypeId)->exists();
            if (!$exists) {
                $document->UserId = $this->model->Id;
                $document->save();
            }
        }
    }

    /**
     * Обьединение фотографии
     */
    private function mergePhoto()
    {
        $primaryPhoto = $this->model->getPhoto()->getOriginal(true);
        $secondPhoto = $this->modelSecond->getPhoto()->getOriginal(true);
        if (!file_exists($primaryPhoto) && file_exists($secondPhoto)) {
            $this->model->getPhoto()->save($secondPhoto);
        }
    }

    /**
     * Обеинение моделей связей
     * @param \CActiveRecord $model
     * @param string $by
     */
    private function mergeLinkModel(\CActiveRecord $model, $by = 'UserId')
    {
        $models = call_user_func([$model, ('by'.$by)], $this->modelSecond->Id);

        /** @var \CActiveRecord[] $links */
        $links = $models->findAll();
        foreach ($links as $link) {
            $link->$by = $this->model->Id;
            $link->save();
        }
    }

}