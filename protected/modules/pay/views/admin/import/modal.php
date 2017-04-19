<?php
/**
 * @var $this \pay\components\Controller
 * @var $entry \pay\models\ImportEntry
 */

foreach ($entry->Data as $key => $data) {
    echo $key, ' = ', $data, '<br/>';
}