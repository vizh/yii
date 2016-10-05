<?php
namespace application\models\attribute\forms;

use application\components\Exception;
use application\components\form\CreateUpdateForm;
use application\components\form\FormModel;
use application\components\helpers\ArrayHelper;
use application\models\attribute\Definition as DefinitionModel;
use application\models\attribute\forms\Group as GroupForm;
use application\models\attribute\Group as GroupModel;
use application\widgets\ActiveForm;
use event\models\Event;
use event\models\UserData;
use Yii;

/**
 * Class Definition
 *
 * @property DefinitionModel $model
 *
 */
class Definition extends CreateUpdateForm
{
    public $ClassName;

    public $Name;

    public $Title;

    public $Required;

    /**
     * @var bool It allows to add simple text field to the question
     */
    public $UseCustomTextField;

    public $Translatable;

    public $Order;

    public $Public;

    public $Delete;

    public $Params;

    /** @var GroupForm */
    private $groupForm;

    /**
     * @param GroupForm $groupForm
     * @param DefinitionModel|null $model
     */
    public function __construct(GroupForm $groupForm, DefinitionModel $model = null)
    {
        $this->groupForm = $groupForm;
        parent::__construct($model);
    }

    /**
     * Загружает данные из модели в модель формы
     *
     * @return bool Удалось ли загрузить данные
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            $this->Params = ArrayHelper::toArray(json_decode($this->Params));

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            ['Title,Required,Public,Order', 'filter', 'filter' => 'application\components\utility\Texts::clear'],
            ['Title', 'required'],
            ['Required,Public,UseCustomTextField,Translatable', 'boolean'],
            ['Order', 'numerical', 'integerOnly' => true],
        ];

        if ($this->isFullyEditable()) {
            $rules[] = ['ClassName,Name,Delete', 'filter', 'filter' => 'application\components\utility\Texts::clear'];
            $rules[] = ['ClassName,Name', 'required'];
            $rules[] = ['ClassName', 'in', 'range' => array_keys($this->getClassNameData())];
            $rules[] = ['Name', 'match', 'pattern' => '/[a-z0-9]+/i'];
            $rules[] = ['Name', 'in', 'range' => $this->groupForm->getUsedDefinitionNames(), 'not' => true];
            $rules[] = ['Delete', 'boolean'];
            $rules[] = ['Params', 'validateParams'];
        }

        return $rules;
    }

    public function validateParams($attribute)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ClassName' => Yii::t('app', 'Тип поля'),
            'Name' => Yii::t('app', 'Сивольный код'),
            'Title' => Yii::t('app', 'Имя поля'),
            'Required' => Yii::t('app', 'Обязательно для заполнения'),
            'Translatable' => Yii::t('app', 'Многоязычное'),
            'UseCustomTextField' => Yii::t('app', 'Добавить поле "Другое"'),
            'Order' => Yii::t('app', 'Сортировка'),
            'Public' => Yii::t('app', 'Видимое'),
            'Params_data' => Yii::t('app', 'Варианты ответа'),
            'Params_placeholder' => Yii::t('app', 'Текст внутри поля'),
            'Params_types' => Yii::t('app', 'Расширения файла через запятую')
        ];
    }

    /**
     * @return DefinitionModel|null
     * @throws \application\components\Exception
     */
    public function createActiveRecord()
    {
        $this->model = new DefinitionModel();
        $this->model->GroupId = $this->groupForm->getActiveRecord()->Id;

        return $this->updateActiveRecord();
    }

    /**
     * Обновляет запись в базе
     *
     * @return DefinitionModel|null
     * @throws Exception
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        if ($this->Delete) {
            $this->model->delete();
        } else {
            $this->fillActiveRecord();
            $this->model->save();
        }

        return $this->model;
    }

    /**
     * @return array
     */
    public function getClassNameData()
    {
        return [
            '' => Yii::t('app', 'Выберите тип'),
            'Definition' => Yii::t('app', 'Строка'),
            'TextDefinition' => Yii::t('app', 'Большое текстовое поле'),
            'ListDefinition' => Yii::t('app', 'Выпадающий список'),
            'BooleanDefinition' => Yii::t('app', 'Выбор Да/Нет'),
            'FileDefinition' => Yii::t('app', 'Загрузка файла'),
            'UrlDefinition' => Yii::t('app', 'Ссылка'),
            'MultiSelectDefinition' => Yii::t('app', 'Множественное значение'),
            'CounterDefinition' => Yii::t('app', 'Счётчик')
        ];
    }

    /**
     * @param ActiveForm $activeForm
     * @param FormModel $form
     * @param string $inputPrefix
     * @return string
     */
    public function getParamsHtml(ActiveForm $activeForm, FormModel $form, $inputPrefix = '')
    {
        $html = '';

        $input = $activeForm->label($this, 'Params_placeholder')
            .$activeForm->textField($form, $inputPrefix.'[Params][placeholder]', ['class' => 'form-control']);

        $html .= \CHtml::tag('div', ['class' => 'm-top_10'], $input);

        $input = $activeForm->label($this, 'Params_types')
            .$activeForm->textField($form, $inputPrefix.'[Params][types]', ['class' => 'form-control']);

        $html .= \CHtml::tag('div', ['class' => 'm-top_10', 'data-class' => 'FileDefinition'], $input);

        $i = 0;
        $attributes['data'] = '';
        $html .= \CHtml::tag('div', ['class' => 'm-top_10', 'data-class' => '"ListDefinition","MultiSelectDefinition"'],
            $activeForm->label($this, 'Params_data'), false);
        if (!empty($this->Params['data'])) {
            foreach ($this->Params['data'] as $key => $value) {
                $input = \CHtml::tag('div', ['class' => 'col-xs-2'],
                    $activeForm->textField($form, $inputPrefix."[Params][data][$i][key]", [
                        'class' => 'form-control',
                        'value' => ($key === '_empty_' ? '' : $key),
                        'placeholder' => Yii::t('app', 'Ключ')
                    ]));
                $input .= \CHtml::tag('div', ['class' => 'col-xs-10'],
                    $activeForm->textField($form, $inputPrefix."[Params][data][$i][value]",
                        ['class' => 'form-control', 'value' => $value, 'placeholder' => Yii::t('app', 'Значение')]));
                $html .= \CHtml::tag('div', ['class' => 'row m-bottom_5'], $input);
                $i++;
            }
        }
        for (; $i < 50; $i++) {
            $input = \CHtml::tag('div', ['class' => 'col-xs-2'],
                $activeForm->textField($form, $inputPrefix."[Params][data][$i][key]",
                    ['class' => 'form-control', 'placeholder' => Yii::t('app', 'Ключ')]));
            $input .= \CHtml::tag('div', ['class' => 'col-xs-10'],
                $activeForm->textField($form, $inputPrefix."[Params][data][$i][value]",
                    ['class' => 'form-control', 'placeholder' => Yii::t('app', 'Значение')]));
            $html .= \CHtml::tag('div', ['class' => 'row m-bottom_5'], $input);
        }
        $html .= '</div>';

        return $html;
    }

    public function getAvailableParamsByClassName()
    {
        $params = ['placeholder'];
        if ($this->ClassName === 'ListDefinition' || $this->ClassName === 'MultiSelectDefinition') {
            $params[] = 'data';
        } elseif ($this->ClassName === 'FileDefinition') {
            $params[] = 'types';
        }

        return $params;
    }

    /**
     * @inheritdoc
     * @throws \application\components\Exception
     */
    public function setAttributes($values, $safeOnly = true)
    {
        if ($this->model->ClassName && (boolean)$this->model->Translatable !== (boolean)$values['Translatable']) {
            if (($group = GroupModel::model()->findByPk($this->model->GroupId)) === null)
                throw new Exception("Не могу получить группу GroupId:{$this->model->GroupId} для атрибута");

            if (($event = Event::model()->findByPk($group->ModelId)) === null)
                throw new Exception('Не могу определить мероприятие группы атрибута');

            $userData = UserData::model()
                ->byEventId($event->Id)
                ->byAttributeExists($this->model->Name)
                ->findAll();

                foreach ($userData as $data) {
                    $value = json_decode($data->Attributes, true);
                    if ($values['Translatable']) {
                        $value[$this->model->Name] = isset($value[$this->model->Name]['ru'])
                            ? $value[$this->model->Name]
                            : ['ru' => $value[$this->model->Name], 'en' => ''];
                    } else {
                        $value[$this->model->Name] = isset($value[$this->model->Name]['ru'])
                            ? $value[$this->model->Name]['ru']
                            : $value[$this->model->Name];
                    }
                    $data->Attributes = json_encode($value, JSON_UNESCAPED_UNICODE);
                    $data->save();
                }
        }

        parent::setAttributes($values, $safeOnly);
        if (isset($values['Params'])) {
            foreach ($this->Params as $name => $value) {
                if (empty($value) || !in_array($name, $this->getAvailableParamsByClassName())) {
                    unset($this->Params[$name]);
                    continue;
                }

                if (is_array($value)) {
                    $value = array_filter($value, function ($val) {
                        return !empty($val['key']) && !empty($val['value']);
                    });
                    $this->Params[$name] = ArrayHelper::map($value, 'key', 'value');
                }
            }
        }
    }

    /**
     * Заполняет модель данными из формы
     *
     * @return bool
     */
    protected function fillActiveRecord()
    {
        if (parent::fillActiveRecord()) {
            $this->model->Params = json_encode($this->Params, JSON_UNESCAPED_UNICODE);

            return true;
        }

        return false;
    }

    /**
     * Возвращает true, если записей с данным атрибутом нет, и оно полностью доступно для редактирования
     */
    public function isFullyEditable()
    {
        if ($this->isUpdateMode() && in_array($this->Name, $this->groupForm->getUsedDefinitionNames())) {
            return false;
        }

        return true;
    }
}
