<?php

namespace competence\controllers\admin\main;

use competence\models\Test;

/**
 * Class EditTestAction
 */
class EditTestAction extends \CAction
{
    /**
     * @param int $id
     * @throws \CHttpException
     */
    public function run($id = null)
    {
        if ($id) {
            $test = Test::model()->findByPk($id);

            if (!isset($test)) {
                throw new \CHttpException(404);
            }
        } else {
            $test = new Test();
        }

        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $test->attributes = $request->getParam(get_class($test));

            if ($test->save()) {
                $dir = \Yii::getPathOfAlias($test::DIR_PATH.'/'.$test->Code);

                if (!is_dir($dir)) {
                    mkdir($dir);
                }

                $this->getController()->redirect(
                    $this->getController()->createUrl('/competence/admin/main/edit', ['id' => $test->Id])
                );
            }
        }

        $this->getController()->render('edit_test', ['test' => $test]);
    }
}
