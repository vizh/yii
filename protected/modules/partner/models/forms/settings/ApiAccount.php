<?php
namespace partner\models\forms\settings;

use api\models\Account as AccountModel;
use api\models\Domain;
use application\components\form\CreateUpdateForm;
use application\components\utility\Texts;
use application\helpers\Flash;

/**
 * Class ApiAccount
 * @package partner\models\forms\settings
 *
 * @property AccountModel $model
 */
class ApiAccount extends CreateUpdateForm
{
    public $Domains = [];

    public function rules()
    {
        return [
            ['Domains', 'validateDomains'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Domains' => \Yii::t('app', 'Домены')
        ];
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function validateDomains($attribute)
    {
        foreach ($this->Domains as $val) {
            $val = Texts::clear($val);
            if (empty($val)) {
                $this->addError($attribute, \Yii::t('app', 'Некорректно заполнен домен.'));
                return false;
            }
        }
        return true;
    }

    /**
     * Загружает данные из модели в модель формы
     * @return bool Удалось ли загрузить данные
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            foreach ($this->model->Domains as $domain) {
                $this->Domains[] = $domain->Domain;
            }
            return true;
        }
        return false;
    }

    /**
     * Обновляет запись в базе
     * @return \CActiveRecord|null
     * @throws Exception
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        /** @var \CDbTransaction $transaction */
        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $domains = [];
            foreach ($this->model->Domains as $domain) {
                if (!in_array($domain->Domain, $this->Domains)) {
                    $domain->delete();
                } else {
                    $domains[] = $domain->Domain;
                }
            }

            foreach ($this->Domains as $host) {
                if (!in_array($host, $domains)) {
                    $domain = new Domain();
                    $domain->AccountId = $this->model->Id;
                    $domain->Domain = $host;
                    $domain->save();
                }
            }
            $transaction->commit();
            return $this->model;
        } catch (\Exception $e) {
            Flash::setError($e->getMessage());
            return null;
        }
    }
}
