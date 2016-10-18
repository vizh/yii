<?php
namespace ruvents\components;

class Action extends \CAction
{
    /**
     * @return Controller
     */
    public function getController()
    {
        return parent::getController();
    }

    public function getAccount()
    {
        return $this->getController()->getAccount();
    }

    /**
     * @return DataBuilder
     */
    public function getDataBuilder()
    {
        return $this->getController()->getDataBuilder();
    }

    /**
     * @return \ruvents\models\DetailLog
     */
    public function getDetailLog()
    {
        return $this->getController()->getDetailLog();
    }

    /**
     * @return \ruvents\models\Operator
     */
    public function getOperator()
    {
        return $this->getController()->getOperator();
    }

    /**
     * @return \event\models\Event
     */
    public function getEvent()
    {
        return $this->getController()->getEvent();
    }

    public function renderJson($data)
    {
        $this->getController()->renderJson($data);
    }

    /**
     * Validates the date, returns true if the date is valid and vice versa
     * @param string $date The string with date for validation
     * @param string|string[]|null $format Format for validation. It can be a string or an array of strings
     * @return bool Whether the date is valid
     */
    protected function validateDate($date, $format = null)
    {
        if (is_null($date)) {
            return true;
        }

        if (is_null($format)) {
            $formats = [
                'yyyy-MM-dd HH:mm:ss',
                'yyyy-MM-dd'
            ];
        } else {
            $formats = is_string($format) ? [$format] : $format;
        }

        $valid = false;
        foreach ($formats as $format) {
            $timestamp = \CDateTimeParser::parse($date, $format, [
                'month' => 1,
                'day' => 1,
                'hour' => 0,
                'minute' => 0,
                'second' => 0
            ]);

            if ($timestamp !== false) {
                $valid = true;
                break;
            }
        }

        return $valid;
    }
}
