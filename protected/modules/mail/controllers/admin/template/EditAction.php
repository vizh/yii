<?php
namespace mail\controllers\admin\template;

use mail\components\filter\EmailCondition;
use mail\components\filter\EventCondition;
use mail\components\filter\GeoCondition;
use mail\components\filter\RunetIdCondition;
use \mail\models\forms\admin\Template;
use user\models\User;
use \mail\models\Template as TemplateModel;

class EditAction extends \CAction
{
    private $count = 0;
    private $countAll = 0;
    /** @var  Template */
    private $form;

    /** @var  \mail\models\Template */
    private $template;

    private $viewHasExternalChanges = false;

    public function run($templateId = null)
    {
        if ($templateId !== null)
        {
            $this->template = TemplateModel::model()->findByPk($templateId);
            if ($this->template == null)
                throw new \CHttpException(404);

            $this->form = new Template($this->template->getMailer());
            foreach ($this->template->getAttributes() as $attribute => $value){
                if (property_exists($this->form, $attribute))
                    $this->form->$attribute = $value;
            }

            if (md5_file($this->template->getViewPath()) != $this->template->ViewHash)
                $this->viewHasExternalChanges = true;

            if (!$this->viewHasExternalChanges){
                $body = file_get_contents($this->template->getViewPath());
                $this->form->Body = str_replace($this->form->bodyFields(), array_keys($this->form->bodyFields()), $body);
            }

            $filter = $this->template->getFilter();
            $this->form->Conditions = $this->getFormConditionsList($filter->getFilters());

            if ($this->template->Success){
                $this->countAll = \mail\models\TemplateLog::model()->byTemplateId($this->template->Id)->byHasError(false)->count();
            } else{
                $this->count = \user\models\User::model()->count($this->template->getCriteria());
                $this->countAll = \user\models\User::model()->count($this->template->getCriteria(true));
            }
            if ($this->template->Active){
                $this->form->addError('Active', \Yii::t('app', 'Рассылка была активирована, внесни изменения невозможно!'));
            }
        } else{
            $this->template = new \mail\models\Template();
            $this->form = new \mail\models\forms\admin\Template($this->template->getMailer());
        }

        $request = \Yii::app()->getRequest();
        $this->form->attributes = $request->getParam(get_class($this->form));
        if ($request->getIsPostRequest() && $this->form->validate(null, false)){
            $this->processForm();
        }

        \Yii::app()->getClientScript()->registerPackage('runetid.backbone');
        \Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование рассылки'));
        $this->getController()->render('edit', [
            'form' => $this->form,
            'count' => $this->count,
            'template' => $this->template,
            'countAll' => $this->countAll,
            'viewHasExternalChanges' => $this->viewHasExternalChanges
        ]);
    }

    private function processForm()
    {
        $this->template->Title = $this->form->Title;
        $this->template->Subject = $this->form->Subject;
        $this->template->From = $this->form->From;
        $this->template->FromName = $this->form->FromName;
        $this->template->SendPassbook = $this->form->SendPassbook == 1 ? true : false;
        $this->template->SendUnsubscribe = $this->form->SendUnsubscribe == 1 ? true : false;
        $this->template->SendInvisible = $this->form->SendInvisible == 1 ? true : false;
        $this->template->Active = $this->form->Active == 1 ? true : false;
        $this->template->Layout = $this->form->Layout;
        $this->template->ShowUnsubscribeLink = $this->form->ShowUnsubscribeLink == 1 ? true : false;
        $this->template->ShowFooter = $this->form->ShowFooter == 1 ? true : false;
        $this->template->RelatedEventId = !empty($this->form->RelatedEventId) ? $this->form->RelatedEventId : null;
        if ($this->template->Active){
            $this->template->ActivateTime = date('Y-m-d H:i:s');
        }

        $filter = new \mail\components\filter\Main();
        foreach ($this->form->Conditions as $key => $condition)
        {
            $positive = $condition['type'] == Template::TypePositive ? true : false;
            switch ($condition['by'])
            {
                case Template::ByEvent:
                    $condition = new EventCondition($condition['eventId'], $condition['roles']);
                    $filter->addCondition('\mail\components\filter\Event', $condition, $positive);
                    break;

                case Template::ByEmail:
                    $condition = new EmailCondition(explode(',', $condition['emails']));
                    $filter->addCondition('\mail\components\filter\Email', $condition, $positive);
                    break;

                case Template::ByRunetId:
                    $condition = new RunetIdCondition(explode(',', $condition['runetIdList']));
                    $filter->addCondition('\mail\components\filter\RunetId', $condition, $positive);
                    break;

                case Template::ByGeo:
                    $condition = new GeoCondition($condition['label'], $condition['countryId'], $condition['regionId'], $condition['cityId']);
                    $filter->addCondition('\mail\components\filter\Geo', $condition, $positive);
                    break;
            }
        }
        $this->template->setFilter($filter);
        $this->template->save();

        $Attachments = \CUploadedFile::getInstancesByName('Attachments');
        $dir =  \Yii::getpathOfAlias('webroot.files.upload.mails.'.$this->template->Id);
        if (!file_exists($dir))
            mkdir($dir, 0777, true);
        if (isset($Attachments) && count($Attachments) > 0) {
            foreach ($Attachments as $attachment => $file) {
                $file->saveAs($dir . '/' . str_replace(' ', '-', $file->name));
            };
        };

        if (!$this->viewHasExternalChanges){
            $this->form->Body = str_replace(array_keys($this->form->bodyFields()), $this->form->bodyFields(), $this->form->Body);
            file_put_contents($this->template->getViewPath(), $this->form->Body);
            $this->template->ViewHash = md5_file($this->template->getViewPath());
            $this->template->save();
        }

        if ($this->form->Test == 1) {
            $this->template->setTestMode(true);
            $users = User::model()->byRunetIdList(explode(', ', $this->form->TestUsers))->findAll();
            foreach ($users as $user) {
                $criteria = $this->template->getCriteria();
                $criteria->addCondition('"t"."Id" = :UserId');
                $criteria->params['UserId'] = $user->Id;
                if (!User::model()->exists($criteria)) {
                    $this->form->addError('Test', \Yii::t('app', 'В тестовой рассылке пользователь с RUNET-ID: {runetId} не попадает в общую выборку!', ['{runetId}' => $user->RunetId]));
                    return;
                }
            }

            $this->template->setTestUsers($users);
            $this->template->send();
            \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Тестовая рассылка успешно отправлена!'));
        } else {
            \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Рассылка успешно сохранена!'));
        }

        $this->getController()->redirect(
            $this->getController()->createUrl('/mail/admin/template/edit', ['templateId' => $this->template->Id])
        );
    }

    private function getFormConditionsList($filter)
    {
        $filterMap = [
            '\mail\components\filter\Event'   => Template::ByEvent,
            '\mail\components\filter\Email'   => Template::ByEmail,
            '\mail\components\filter\RunetId' => Template::ByRunetId,
            '\mail\components\filter\Geo'     => Template::ByGeo
        ];

        $filters = [];
        foreach (array_keys($filter) as $class) {
            $filters[$class] = $filterMap[$class];
        }
        $conditions = [];
        $types = [
            Template::TypePositive,
            Template::TypeNegative
        ];
        foreach ($filters as $className => $by){
            foreach ($types as $type){
                if (isset($filter[$className])){
                    foreach ($filter[$className]->$type as $criteria){
                        $condition = ['type' => $type, 'by' => $by];
                        $class = new \ReflectionClass($criteria);
                        foreach ($class->getProperties() as $property){
                            $condition[$property->getName()] = isset($criteria->{$property->getName()}) ? $criteria->{$property->getName()} : null;
                        }

                        switch ($by){
                            case Template::ByEvent:
                                $event = \event\models\Event::model()->findByPk($condition['eventId']);
                                $condition['eventLabel'] = $event->Id.', '.$event->Title;
                                break;

                            case Template::ByEmail:
                                $condition['emails'] = implode(',', $condition['emails']);
                                break;

                            case Template::ByRunetId:
                                $condition['runetIdList'] = implode(',', $condition['runetIdList']);
                                break;
                        }
                        $conditions[] = $condition;
                    }
                }
            }
        }
        return $conditions;
    }
}