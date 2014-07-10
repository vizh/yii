<?php
namespace pay\controllers\admin\orderjuridicaltemplate;


class EditAction extends \CAction
{
  private $template;
  private $form;

  public function run($templateId = null, $view = false)
  {
    if ($templateId == null)
    {
      if ($view)
        throw new \CHttpException(404);
      else
        $this->template = new \pay\models\OrderJuridicalTemplate();
    }
    else
    {
      $this->template = \pay\models\OrderJuridicalTemplate::model()->findByPk($templateId);
      if ($this->template == null)
        throw new \CHttpException(404);
    }

    if ($view)
    {
      $this->view();
      \Yii::app()->end();
    }

    $this->form = new \pay\models\forms\admin\OrderTemplate();
    if ($this->template->ParentTemplateId !== null)
    {
      $this->form->setScenario(\pay\models\forms\admin\OrderTemplate::ChildScenario);
    }

    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $this->form->attributes = $request->getParam(get_class($this->form));
      $this->form->SignFirstImage = \CUploadedFile::getInstance($this->form, 'SignFirstImage');
      $this->form->SignSecondImage = \CUploadedFile::getInstance($this->form, 'SignSecondImage');
      $this->form->Stamp = \CUploadedFile::getInstance($this->form, 'Stamp');
      if ($this->form->validate())
      {
        $this->processForm();
        \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Шаблон счета успешно сохранен!'));
        $this->getController()->redirect(
          $this->getController()->createUrl('/pay/admin/orderjuridicaltemplate/edit', ['templateId' => $this->template->Id])
        );
      }
    }
    elseif (!$this->template->getIsNewRecord())
    {
      foreach ($this->template->getAttributes() as $attr => $value)
      {
        if (property_exists($this->form, $attr))
          $this->form->$attr = $this->template->$attr;
      }
      $this->form->SignFirstImageMarginTop = $this->template->SignFirstImageMargin[0];
      $this->form->SignFirstImageMarginLeft = $this->template->SignFirstImageMargin[1];
      $this->form->SignSecondImageMarginTop = $this->template->SignSecondImageMargin[0];
      $this->form->SignSecondImageMarginLeft = $this->template->SignSecondImageMargin[1];
      $this->form->StampMarginTop = $this->template->StampImageMargin[0];
      $this->form->StampMarginLeft = $this->template->StampImageMargin[1];
    }

    \Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
    $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование шаблона счета'));
    $this->getController()->render('edit',['form' => $this->form, 'template' => $this->template]);
  }

  public function view()
  {
    $this->getController()->layout = 'pay.views.layouts.bill';
    \Yii::app()->getClientScript()->reset();
    $cssPath = \Yii::app()->getAssetManager()->publish(
      \Yii::getPathOfAlias('pay.assets.css.order.index').'.css'
    );
    \Yii::app()->getClientScript()->registerCssFile($cssPath);
    $order = \pay\models\Order::model()->findByPk(830);
    $total = 0;
    $viewName = $this->template->OrderTemplateName !== null ? $this->template->OrderTemplateName : 'template';
    $this->getController()->setPageTitle(\Yii::t('app', 'Просмотр шаблона счета'));
    $this->getController()->render('pay.views.order.bills.'.$viewName, [
      'order' => $order,
      'billData' => [],
      'total' => 0,
      'withSign' => true,
      'template' => $this->template,
      'nds' => $total - round($total / 1.18, 2, PHP_ROUND_HALF_DOWN)
    ]);
  }

  public function processForm()
  {
    $scenario = $this->form->getScenario();
    foreach ($this->template->getAttributes() as $attr => $value)
    {
      if (in_array($attr, $this->form->getSafeAttributeNames()))
        $this->template->$attr = !empty($this->form->$attr) ? $this->form->$attr : null;
    }
    $this->template->VAT = (bool) $this->form->VAT;
    if (empty($scenario))
    {
      $this->template->SignFirstImageMargin = [
        $this->form->SignFirstImageMarginTop, $this->form->SignFirstImageMarginLeft
      ];
      $this->template->SignSecondImageMargin = [
        $this->form->SignSecondImageMarginTop, $this->form->SignSecondImageMarginLeft
      ];
      $this->template->StampImageMargin = [
        $this->form->StampMarginTop, $this->form->StampMarginLeft
      ];
    }
    $this->template->save();

    if (empty($scenario))
    {
      if ($this->form->SignFirstImage !== null)
        $this->form->SignFirstImage->saveAs($this->template->getFirstSignImagePath(true));

      if ($this->form->Stamp !== null)
        $this->form->Stamp->saveAs($this->template->getStampImagePath(true));

      if ($this->form->SignSecondImage !== null)
        $this->form->SignSecondImage->saveAs($this->template->getSecondSignImagePath(true));
    }

    if ($this->template->ParentTemplateId == null)
    {
      $childTemplates = \pay\models\OrderJuridicalTemplate::model()->byParentId($this->template->Id)->findAll();
      foreach ($childTemplates as $childTemplate)
      {
        $attributes = $this->template->getAttributes();
        unset(
          $attributes['Id'],
          $attributes['Title'],
          $attributes['Number'],
          $attributes['NumberFormat'],
          $attributes['CreationTime'],
          $attributes['ParentTemplateId']
        );

        $childTemplate->setAttributes($attributes, false);
        $childTemplate->save();
      }
    }
  }
} 