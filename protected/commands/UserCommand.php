<?php

use application\components\console\BaseConsoleCommand;
use user\models\User;

class UserCommand extends BaseConsoleCommand
{
    public function actionUpdateSearch()
    {
        $total = User::model()->count();
        echo $total;
        $data = new CActiveDataProvider('\user\models\User', [
            'pagination' => [
                'pageSize'=>1000
            ]
        ]);
        $iterator = new CDataProviderIterator($data, 100);
        foreach ($iterator as $i => $user) {
            echo "\033[2K\r";
            echo ($i+1).'/'.$total;
            $user->updateSearchIndex(true);
            $user->save(false);
        }
        echo "\033[2K\r";
    }
}