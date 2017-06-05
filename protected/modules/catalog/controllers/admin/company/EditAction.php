<?php
namespace catalog\controllers\admin\company;

class EditAction extends \CAction
{
    private $company;

    public function run($companyId = null)
    {
        $form = new \catalog\models\company\forms\Edit();
        $formLogo = new \catalog\models\company\forms\Logo();

        if ($companyId == null) {
            $this->company = new \catalog\models\company\Company();
        } else {
            $this->company = \catalog\models\company\Company::model()->findByPk($companyId);
            $form->Title = $this->company->Title;
            $form->Url = $this->company->Url;
            $form->CompanyId = $this->company->CompanyId;
            foreach ($this->company->getLogos() as $logo) {
                $form->Logos[] = new \catalog\models\company\forms\Logo($logo);
            }
        }

        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest() && $request->getParam('Form') !== null) {
            $proccessResult = false;
            switch ($request->getParam('Form')) {
                case get_class($form):
                    $form->attributes = $request->getParam(get_class($form));
                    $proccessResult = $this->processForm($form);
                    break;

                case get_class($formLogo):
                    $formLogo->attributes = $request->getParam(get_class($formLogo));
                    $proccessResult = $this->processFormLogo($form, $formLogo);
                    break;
            }

            if ($proccessResult) {
                \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Данные компании успешно сохранены!'));
                $this->getController()->redirect(
                    $this->getController()->createUrl('/catalog/admin/company/edit', ['companyId' => $this->company->Id])
                );
            }
        }
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование компании в каталоге'));
        $this->getController()->render('edit', ['company' => $this->company, 'form' => $form, 'formLogo' => $formLogo]);
    }

    /**
     *
     * @param catalog\models\company\forms\Edit $form
     * @return boolean
     */
    private function processForm($form)
    {
        if ($form->validate()) {
            $this->company->Title = $form->Title;
            $this->company->Url = !empty($form->Url) ? $form->Url : null;
            $this->company->CompanyId = !empty($form->CompanyId) ? $form->CompanyId : null;
            $this->company->save();
            return true;
        }
        return false;
    }

    /**
     *
     * @param catalog\models\company\forms\Edit $form
     * @param catalog\models\company\forms\Logo $formLogo
     * @return boolean
     */
    private function processFormLogo($form, $formLogo)
    {
        if ($formLogo->validate()) {
            if (!empty($formLogo->Delete)) {
                $this->company->deleteLogo($formLogo->Id);
            } else {
                $this->company->saveLogo($formLogo);
            }
            return true;
        } else {
            if (!empty($formLogo->Id)) {
                foreach ($form->Logos as $fLogo) {
                    if ($formLogo->Id == $fLogo->Id) {
                        $fLogo->addErrors($formLogo->getErrors());
                        $formLogo->clearErrors();
                        break;
                    }
                }
            }
        }
        return false;
    }
}
