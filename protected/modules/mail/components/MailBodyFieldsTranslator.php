<?php
namespace mail\components;

trait MailBodyFieldsTranslator
{
    /**
     * Инициализирует массив полей, используемых в теле письма
     * Должен возвращать массив ввиде: ['FieldName' => ['FieldTitle', 'PhpCode']]
     * @return array
     */
    abstract public function initBodyFields();

    /**
     * Переводит контект со вставками в инсполняемый php код
     * @param string $content
     * @return string
     */
    public function translatePreview($content)
    {
        foreach ($this->initBodyFields() as $name => $field) {
            preg_match($this->getFieldNameRegexPattern($name), $content, $matches);
            if (false === empty($matches)) {
                if (count($matches) > 1) {
                    $vars = [];
                    foreach (explode(';', $matches[1]) as $key => $value) {
                        $vars['$_'.($key + 1)] = $value;
                    }
                    $field[1] = strtr($field[1], $vars);
                }
                $content = str_replace($matches[0], $field[1], $content);
            }
        }

        return $content;
    }


    /**
     * Переводит инсполняемый php код в контект со вставками
     * @param $content
     * @return mixed
     */
    public function translateCode($content)
    {
        foreach ($this->initBodyFields() as $name => $field) {
            $result = $this->parseContent($field, $content);
            if ($result == null) {
                continue;
            }
            if (!empty($result['vars'])) {
                $name = $this->getClearFieldName($name).':'.implode(';', $result['vars']);
            }
            $content = str_replace($result['content'], ('{'.$name.'}'), $content);
        }
        return $content;
    }

    /**
     *
     * @param string $name
     * @return string
     */
    private function getFieldNameRegexPattern($name)
    {
        $clear = $this->getClearFieldName($name);
        if ($clear !== $name) {
            return '/\{' . str_replace(['.'], ['\.'], $clear) . ':([^\}]+)\}/';
        }
        return '/\{' . $clear . '\}/';
    }


    /**
     * @param $name
     * @return string
     */
    private function getClearFieldName($name)
    {
        $position = strpos($name, ':');
        if ($position !== false) {
            return substr($name, 0, $position);
        }
        return $name;
    }

    /**
     * Возвращает пары ключ->значения со значениями переменных
     * @param array $field
     * @param string $content
     * @return array
     */
    private function parseContent($field, $content)
    {
        $result = [];
        for ($i = 1;;$i++) {
            $pattern = '/' . str_replace(['\(.*)', '\.*'], ['(.*)', '.*'], preg_replace(['/\$\_(' . $i . ')/', '/\$\_([0-9])/'], ['(.*)', '.*'], preg_quote($field[1]))) . '/';
            preg_match($pattern, $content, $matches);
            if (!isset($result['content']) && !empty($matches)) {
                $result['content'] = $matches[0];
            }

            if (sizeof($matches) < 2) {
                break;
            }
            $result['vars']['$_'.$i] = $matches[1];
        }
        return !empty($result) ? $result : null;
    }

    /**
     * @return string
     */
    public function getBodyFieldsNote()
    {
        $note = '';
        foreach ($this->initBodyFields() as $name => $field) {
            $note .= \CHtml::tag('li', [], '<strong>{' . $name . '}</strong> &mdash; ' . $field[0]);
        }
        return \CHtml::tag('ul', [], $note);
    }
}