<?php

use application\components\console\BaseConsoleCommand;
use nastradamus39\slate\Parser;

class GenerateApiDocsCommand extends BaseConsoleCommand
{
    public function run($args)
    {

        $basePath = \Yii::app()->getBasePath();
        $parsePath = realpath($basePath."/modules/api/controllers");
        $buildPath = realpath($basePath."/modules/api");
        $params = [
            "title" => "Апи runet-id.com",
            "baseUrl" => "http://api.runet-id.com",
            "vars" => ["API_KEY" => "XXX", "HASH" => "XXX", "API_URL" => "http://api.runet-id.com"]
        ];
        $parser = new Parser($parsePath, $buildPath, $params);
        $parser->parse();

        echo "saved...\n";
    }
}