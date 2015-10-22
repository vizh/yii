<?php
namespace mail\components;

trait MailBodyFieldsTranslator
{



    /**
     * Инициализирует массив полей, используемых в теле письма
     * Должен возвращать массив ввиде:
     * [
     *      'FieldName' => ['FieldTitle', 'PhpCode']
     * ]
     * @return array
     */
    abstract public function initBodyFields();


    /**
     * @param string $content
     */
    public function translatePreview($content)
    {
        foreach ($this->initBodyFields() as $name => $field) {
            preg_match('/Name(\:(".+";)*)?/g', $name, $matches);
            var_dump($matches);
        }
    }
}