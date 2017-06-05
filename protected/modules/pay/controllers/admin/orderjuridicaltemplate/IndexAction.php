<?php
namespace pay\controllers\admin\orderjuridicaltemplate;

class IndexAction extends \CAction
{
    public function run()
    {
        $copy = \Yii::app()->getRequest()->getParam('copy');
        if ($copy !== null) {
            $template = $this->createCopyTemplate($copy);
            $this->getController()->redirect(
                $this->getController()->createUrl('/pay/admin/orderjuridicaltemplate/edit', ['templateId' => $template->Id])
            );
        }
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."CreationTime" DESC';
        $paginator = new \application\components\utility\Paginator(
            \pay\models\OrderJuridicalTemplate::model()->count($criteria)
        );
        $paginator->perPage = \Yii::app()->getParams()['AdminOrderJuridicalTemplatePerPage'];
        $criteria->mergeWith($paginator->getCriteria());
        $templates = \pay\models\OrderJuridicalTemplate::model()->findAll($criteria);
        $this->getController()->setPageTitle(\Yii::t('app', 'Шаблоны юридических счетов и квитанций'));
        $this->getController()->render('index', ['templates' => $templates, 'paginator' => $paginator]);
    }

    /**
     * @param $parentTemplateId
     * @return \pay\models\OrderJuridicalTemplate
     * @throws \CHttpException
     */
    private function createCopyTemplate($parentTemplateId)
    {
        $template = \pay\models\OrderJuridicalTemplate::model()->findByPk($parentTemplateId);
        if ($template == null) {
            throw new \CHttpException(404);
        }

        $attributes = $template->getAttributes();
        $attributes['Id'] = null;
        $attributes['Title'] = $attributes['Title'].'_'.\Yii::t('app', 'копия');
        $attributes['CreationTime'] = null;
        $attributes['ParentTemplateId'] = $parentTemplateId;
        $attributes['Number'] = 1;

        $template = new \pay\models\OrderJuridicalTemplate();
        $template->setAttributes($attributes, false);
        $template->save();

        return $template;
    }
} 