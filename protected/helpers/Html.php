<?php

use user\models\User;

/**
 * Расширение стандартного хелпера.
 */
class Html extends CHtml
{
    public static $alertSuccessClass = 'alert alert-success';

    public static $alertErrorClass = 'alert alert-error';

    public static $alertInfoClass = 'alert alert-info';

    public static $alertWarningClass = 'alert alert-warning';

    /**
     * Возвращает аватар пользователя в html представлении. Если аватара нет, то возвращается пустая строка
     * @param User $user
     * @param string $size
     * @param bool $addTime
     * @return string
     */
    public static function userPhoto(User $user, $size = null, $addTime = false)
    {
        $photoUrl = empty($size) ? $user->getPhoto()->getOriginal() : $user->getPhoto()->{'get'.$size}();
        if ($addTime) {
            $photoUrl .= '?'.time();
        }

        return \CHtml::link(
            \CHtml::image($photoUrl),
            ['/user/view/index', 'id' => $user->Id],
            ['target' => '_blank']
        );
    }

    /**
     * Разбивает данные по столбцам
     * @param array $data Входной массив данных
     * @param int $colsCount Число столбцов
     * @return array Разбитые по столбцам данные с числовым, начинающимся с нуля, индексом
     */
    public static function splitByCols(array $data, $colsCount)
    {
        $col = 0;
        $splitedData = [];
        foreach ($data as $k => $v) {
            $splitedData[$col++][$k] = $v;
            if ($col == $colsCount) {
                $col = 0;
            }
        }

        return $splitedData;
    }

    /**
     * Разбивает данные по строкам
     * @param array $data Входной массив данных
     * @param int $rowsCount Число столбцов
     * @return array Разбитые по столбцам данные с числовым, начинающимся с нуля, индексом
     */
    public static function splitByRows(array $data, $rowsCount)
    {
        $row = 0;
        $i = 0;
        $splitedData = [];
        foreach ($data as $k => $v) {
            $splitedData[$row][$k] = $v;
            if (++$i == $rowsCount) {
                $row++;
            }
        }

        return $splitedData;
    }

    /**
     * Generates a text field input for a model attribute.
     * If the attribute has input error, the input field's CSS class will
     * be appended with {@link errorCss}.
     * @param CModel $model the data model
     * @param string $attribute the attribute
     * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
     * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
     * @return string the generated input field
     * @see clientChange
     * @see activeInputField
     */
    public static function activeTextField($model, $attribute, $htmlOptions = [])
    {
        self::resolveNameID($model, $attribute, $htmlOptions);
        self::clientChange('change', $htmlOptions);
        return self::activeInputField('text', $model, $attribute, $htmlOptions);
    }

    /**
     * Generates an email field input for a model attribute.
     * If the attribute has input error, the input field's CSS class will
     * be appended with {@link errorCss}.
     * @param CModel $model the data model
     * @param string $attribute the attribute
     * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
     * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
     * @return string the generated input field
     * @see clientChange
     * @see activeInputField
     * @since 1.1.11
     */
    public static function activeEmailField($model, $attribute, $htmlOptions = [])
    {
        self::resolveNameID($model, $attribute, $htmlOptions);
        self::clientChange('change', $htmlOptions);
        return self::activeInputField('email', $model, $attribute, $htmlOptions);
    }

    /**
     * Generates a url field input for a model attribute.
     * If the attribute has input error, the input field's CSS class will
     * be appended with {@link errorCss}.
     * @param CModel $model the data model
     * @param string $attribute the attribute
     * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
     * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
     * @return string the generated input field
     * @see clientChange
     * @see activeInputField
     * @since 1.1.11
     */
    public static function activeUrlField($model, $attribute, $htmlOptions = [])
    {
        self::resolveNameID($model, $attribute, $htmlOptions);
        self::clientChange('change', $htmlOptions);
        return self::activeInputField('url', $model, $attribute, $htmlOptions);
    }

    /**
     * Generates an input HTML tag for a model attribute.
     * Unlike the {@link CHtml} this method adds placeholder attribute with attribute name.
     * This method generates an input HTML tag based on the given data model and attribute.
     * If the attribute has input error, the input field's CSS class will
     * be appended with {@link errorCss}.
     * This enables highlighting the incorrect input.
     * @param string $type the input type (e.g. 'text', 'radio')
     * @param CModel $model the data model
     * @param string $attribute the attribute
     * @param array $htmlOptions additional HTML attributes for the HTML tag
     * @return string the generated input tag
     */
    protected static function activeInputField($type, $model, $attribute, $htmlOptions)
    {
        if (!isset($htmlOptions['placeholder'])) {
            $htmlOptions['placeholder'] = $model->getAttributeLabel($attribute);

            if ($model->isAttributeRequired($attribute)) {
                $htmlOptions['placeholder'] .= '*';
            }
        }

        return parent::activeInputField($type, $model, $attribute, $htmlOptions);
    }

    /**
     * @inheritdoc
     */
    public static function truncate($str, $length = 50, $ellipsis = '...')
    {
        if (mb_strlen($str) < $length) {
            return $str;
        }

        $tmp = mb_substr($str, 0, ($length - mb_strlen($ellipsis)));
        return $tmp.$ellipsis;
    }

    /**
     * Возвращает строку таблицы
     * @param array $data Данные для каждого столбца
     * @param string $tagName Наименование тега обертки
     * @return string Строка таблицы
     */
    public static function tableRow($data = [], $tagName = 'td')
    {
        $result = CHtml::openTag('tr');
        foreach ($data as $d) {
            $result .= CHtml::tag($tagName, [], $d);
        }

        return $result.CHtml::closeTag('tr');
    }

    /**
     * Возвращает заголовок таблицы
     * @param array $titles Массив заголовков
     * @return string Строка таблицы
     */
    public static function tableHead($titles = [])
    {
        $result = CHtml::openTag('thead');
        $result .= self::tableRow($titles, 'th');
        return $result.CHtml::closeTag('thead');
    }

    /**
     * Возвращает Flash сообщение если оно есть
     * @param string $key
     * @param bool $closable
     * @param string $class
     * @return string
     */
    public static function flash($key, $closable = true, $class = null)
    {
        $user = Yii::app()->getUser();
        if (!$user->hasFlash($key)) {
            return '';
        }

        $options = [
            'class' => $class ? $class : self::$alertInfoClass,
            'role' => 'alert'
        ];
        if ($closable) {
            $options['class'] .= ' alert-dismissible';
        }

        $close = '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
        $close .= '<span class="sr-only">Close</span></button>';

        $content = $closable ? $close.self::encode($user->getFlash($key)) : self::encode($user->getFlash($key));
        return self::tag('div', $options, $content);
    }

    /**
     * Возвращает Flash с ключем 'error'
     * @param bool $closable
     * @return string
     */
    public static function flashError($closable = true)
    {
        return self::flash('error', $closable, self::$alertErrorClass);
    }

    /**
     * Возвращает Flash с ключем 'success'
     * @param bool $closable
     * @return string
     */
    public static function flashSuccess($closable = true)
    {
        return self::flash('success', $closable, self::$alertSuccessClass);
    }

    /**
     * Возвращает вспомогательный текст по поиску в GridView таблице
     * @return string
     */
    public static function gridViewHelpInfo()
    {
        $text = <<<HTML
        <div class="help-block">
            Для поиска могут использоваться операторы "&gt;" - больше, "&lt;" - меньше, "=&lt;" - меньше или равно,
            "&gt;=" - больше или равно, "&lt;&gt;" - не равно, "=" - равно
            (например выражение "> 3" в поле фильтрации ID выберет всех пользователей с ID больше, чем "3"; если
            вводится просто значение, то подразумевается,
            что используется оператор равно "=").
        </div>
HTML;
        return $text;
    }

    /**
     * Корректно обрабатывает группы. Результаты данного метода можно использовать для dropDownList, при этом гуппы
     * будет невозможно выбрать
     * @inheritdoc
     */
    public static function listData($models, $valueField, $textField, $groupField = '')
    {
        $listData = [];
        if ($groupField === '') {
            foreach ($models as $model) {
                $value = self::value($model, $valueField);
                $text = self::value($model, $textField);
                $listData[$value] = $text;
            }
        } else {
            $groups = [];
            foreach ($models as $model) {
                $group = self::value($model, $groupField);
                $value = self::value($model, $valueField);
                $text = self::value($model, $textField);

                if ($group === null) {
                    $groups[$value] = $text;

                    if (!isset($listData[$group])) {
                        $listData[$value] = [];
                    }
                } else {
                    if (!isset($listData[$group])) {
                        $listData[$group] = [];
                    }

                    $listData[$group][$value] = $text;
                }
            }

            // Заменяем идентификторы на имена групп, объединяем пустые группы в одну
            $groupNamedListData = [];
            array_walk($listData, function ($item, $key) use (&$groupNamedListData, $groups) {
                if (empty($item)) {
                    if (!isset($groupNamedListData[0])) {
                        $groupNamedListData[0] = [];
                    }

                    $groupNamedListData[0][$key] = $groups[$key];
                } else {
                    $groupNamedListData[$groups[$key]] = $item;
                }
            });
            $listData = $groupNamedListData;
        }

        return $listData;
    }

    /**
     * @inheritdoc
     */
    public static function errorSummary(
        $models,
        $header = null,
        $footer = null,
        $htmlOptions = [],
        $errorClass = 'alert-danger'
    ) {
        if (is_null($header) && is_null($footer)) {
            $header = '<div class="alert '.$errorClass.'">';
            $header .= '<strong>Пожалуйста исправьте следующие ошибки:</strong>';
            $footer = '</div>';
        }

        return parent::errorSummary($models, $header, $footer, $htmlOptions);
    }

    /**
     * Adds a CSS class to the specified options.
     * If the CSS class is already in the options, it will not be added again.
     * @param array $options the options to be modified.
     * @param string $class the CSS class to be added
     */
    public static function addCssClass(&$options, $class)
    {
        if (isset($options['class'])) {
            $classes = ' '.$options['class'].' ';
            if (strpos($classes, ' '.$class.' ') === false) {
                $options['class'] .= ' '.$class;
            }
        } else {
            $options['class'] = $class;
        }
    }

    /**
     * Converts a CSS style array into a string representation.
     *
     * For example,
     *
     * ```php
     * print_r(Html::cssStyleFromArray(['width' => '100px', 'height' => '200px']));
     * // will display: 'width: 100px; height: 200px;'
     * ```
     *
     * @param array $style the CSS style array. The array keys are the CSS property names,
     * and the array values are the corresponding CSS property values.
     * @return string the CSS style string. If the CSS style is empty, a null will be returned.
     */
    public static function cssStyleFromArray(array $style)
    {
        $result = '';
        foreach ($style as $name => $value) {
            $result .= "$name: $value; ";
        }
        // return null if empty to avoid rendering the "style" attribute
        return $result === '' ? null : rtrim($result);
    }

    /**
     * Converts a CSS style string into an array representation.
     *
     * The array keys are the CSS property names, and the array values
     * are the corresponding CSS property values.
     *
     * For example,
     *
     * ```php
     * print_r(Html::cssStyleToArray('width: 100px; height: 200px;'));
     * // will display: ['width' => '100px', 'height' => '200px']
     * ```
     *
     * @param string $style the CSS style string
     * @return array the array representation of the CSS style
     */
    public static function cssStyleToArray($style)
    {
        $result = [];
        foreach (explode(';', $style) as $property) {
            $property = explode(':', $property);
            if (count($property) > 1) {
                $result[trim($property[0])] = trim($property[1]);
            }
        }
        return $result;
    }

    /**
     * Adds the specified CSS style to the HTML options.
     *
     * If the options already contain a `style` element, the new style will be merged
     * with the existing one. If a CSS property exists in both the new and the old styles,
     * the old one may be overwritten if `$overwrite` is true.
     *
     * For example,
     *
     * ```php
     * Html::addCssStyle($options, 'width: 100px; height: 200px');
     * ```
     *
     * @param array $options the HTML options to be modified.
     * @param string|array $style the new style string (e.g. `'width: 100px; height: 200px'`) or
     * array (e.g. `['width' => '100px', 'height' => '200px']`).
     * @param boolean $overwrite whether to overwrite existing CSS properties if the new style
     * contain them too.
     * @see removeCssStyle()
     * @see cssStyleFromArray()
     * @see cssStyleToArray()
     */
    public static function addCssStyle(&$options, $style, $overwrite = true)
    {
        if (!empty($options['style'])) {
            $oldStyle = static::cssStyleToArray($options['style']);
            $newStyle = is_array($style) ? $style : static::cssStyleToArray($style);
            if (!$overwrite) {
                foreach ($newStyle as $property => $value) {
                    if (isset($oldStyle[$property])) {
                        unset($newStyle[$property]);
                    }
                }
            }
            $style = array_merge($oldStyle, $newStyle);
        }
        $options['style'] = is_array($style) ? static::cssStyleFromArray($style) : $style;
    }
}
