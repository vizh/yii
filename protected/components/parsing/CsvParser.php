<?php
namespace application\components\parsing;

class CsvParser
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path Путь к csv файлу
     * @throws \Exception
     */
    public function __construct($path)
    {
        if (!file_exists($path)) {
            throw new \Exception('Wrong file path! File not exist. Path:'.$path);
        }
        $this->path = $path;
    }

    public function UseRuLocale()
    {
        setlocale(LC_ALL, 'ru_RU.CP1251');
    }

    private $delimeter = ';';

    public function SetDelimeter($delimeter = ';')
    {
        $this->delimeter = $delimeter;
    }

    private $inEncoding = 'Windows-1251';

    public function SetInEncoding($encoding = 'Windows-1251')
    {
        $this->inEncoding = $encoding;
    }

    private $outEncoding = 'utf-8';

    public function SetOutEncoding($encoding = 'utf-8')
    {
        $this->outEncoding = $encoding;
    }

    private $file;

    /**
     * @param array $fieldMap
     * @param bool $skipFirst
     * @return \stdClass[]
     */
    public function Parse($fieldMap, $skipFirst = false)
    {
        $this->file = fopen($this->path, 'r');

        $result = [];

        if ($skipFirst) {
            fgetcsv($this->file, 0, $this->delimeter);
        }

        while (($data = fgetcsv($this->file, 0, $this->delimeter)) !== false) {
            $result[] = $this->parseRow($data, $fieldMap);
        }

        fclose($this->file);

        return $result;
    }

    /**
     * @param array $data
     * @param array $fieldMap
     * @return \stdClass
     */
    private function parseRow($data, $fieldMap)
    {
        $result = new \stdClass();
        foreach ($fieldMap as $key => $value) {
            if ($value !== null) {
                $result->$key = isset($data[$value]) ? trim($this->encode($data[$value])) : null;
            } else {
                $result->$key = '';
            }
        }
        return $result;
    }

    protected function encode($value)
    {
        if ($this->inEncoding != $this->outEncoding) {
            return iconv($this->inEncoding, $this->outEncoding, $value);
        }

        return $value;
    }

}