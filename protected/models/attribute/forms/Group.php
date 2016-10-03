<?php
namespace application\models\attribute\forms;

use application\components\form\CreateUpdateForm;
use application\models\attribute\Definition;
use application\models\attribute\Group as GroupModel;
use application\models\attribute\forms\Definition as DefinitionForm;

/**
 * Class Group
 *
 * @property GroupModel $model
 *
 * @method Group getActiveRecord()
 */
abstract class Group extends CreateUpdateForm
{
    public $Title;

    public $Order;

    public $Delete;

    /** @var DefinitionForm[] */
    public $Definitions = [];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['Title,Order,Delete', 'filter', 'filter' => 'application\components\utility\Texts::clear'],
            ['Title', 'required'],
            ['Order', 'numerical', 'integerOnly' => true],
            ['Delete', 'boolean'],
            ['Definitions', 'application\components\validators\MultipleFormValidator', 'when' => function (DefinitionForm $form) {
                return $form->isNotEmpty();
            }]
        ];
    }


    /**
     * Загружает данные из модели в модель формы
     * @return bool Удалось ли загрузить данные
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            $this->loadDefinitionsData();
            return true;
        }
        return false;
    }

    /**
     * Загружает данные атрибутов для группы
     */
    private function loadDefinitionsData()
    {
        $definitions = Definition::model()->byGroupId($this->model->Id)->orderBy(['"t"."Order"', '"t"."Id"'])->findAll();
        foreach ($definitions as $definition) {
            $this->Definitions[] = new DefinitionForm($this, $definition);
        }
        $this->Definitions[] = new DefinitionForm($this);
    }

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        $definitions = $this->Definitions;
        parent::fillFromPost();
        foreach ($this->Definitions as $i => $attributes) {
            $definitions[$i]->setAttributes($attributes);
        }
        $this->Definitions = $definitions;
    }


    /**
     * Создает запись в базе
     * @return \CActiveRecord|null
     * @throws Exception
     */
    public function createActiveRecord()
    {
        $this->model = new GroupModel();
        return $this->updateActiveRecord();
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

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->fillActiveRecord();
            foreach ($this->Definitions as $definition) {
                if ($definition->isNotEmpty()) {
                    $definition->isUpdateMode() ? $definition->updateActiveRecord() : $definition->createActiveRecord();
                }
            }
            $transaction->commit();
            $this->model->save();
            return $this->model;
        } catch (\Exception $e) {
            $this->addError('model', 'Возникла внутреняя ошибка!');
            $transaction->rollback();
        }
        return null;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Title' => \Yii::t('app', 'Название группы'),
            'Order' => \Yii::t('app', 'Сортировка'),
            'Definitions' => \Yii::t('app', 'Атрибуты')
        ];
    }

    private $usedDefinitionNames = null;

    /**
     * @return array
     */
    abstract protected function getUsedDefinitionNamesInternal();

    /**
     * Список имен атрибутов, которые уже используются
     * @return mixed
     */
    final public function getUsedDefinitionNames()
    {
        if ($this->usedDefinitionNames === null) {
            $this->usedDefinitionNames = $this->getUsedDefinitionNamesInternal();
        }

        return $this->usedDefinitionNames;
    }
}
