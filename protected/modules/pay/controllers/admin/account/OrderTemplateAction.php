<?php
namespace pay\controllers\admin\account;

class OrderTemplateAction extends \CAction
{
  private $template;
  
  public function run($templateId = null, $backUrl = '', $view = false)
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
    
    $form = new \pay\models\forms\admin\OrderTemplate();
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $form->attributes = $request->getParam(get_class($form));
      $form->SignFirstImage = \CUploadedFile::getInstance($form, 'SignFirstImage');
      $form->SignSecondImage = \CUploadedFile::getInstance($form, 'SignSecondImage');
      
      $form->Stamp = \CUploadedFile::getInstance($form, 'Stamp');
      if ($form->validate())
      {
        foreach ($this->template->getAttributes() as $attr => $value)
        {
          if (property_exists($form, $attr))
            $this->template->$attr = $form->$attr;
        }
        
        $this->template->SignFirstImageMargin  = $form->SignFirstImageMarginTop.','.$form->SignFirstImageMarginLeft;
        $this->template->SignSecondImageMargin = $form->SignSecondImageMarginTop.','.$form->SignSecondImageMarginLeft;
        $this->template->StampImageMargin = $form->StampMarginTop.','.$form->StampMarginLeft;
        $this->template->save();
        
        if ($form->SignFirstImage !== null)
          $form->SignFirstImage->saveAs($this->template->getFirstSignImagePath(true));
         
        if ($form->Stamp !== null)
          $form->Stamp->saveAs($this->template->getStampImagePath(true));
        
        if ($form->SignSecondImage !== null)
          $form->SignSecondImage->saveAs($this->template->getSecondSignImagePath(true));
               
        \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Шаблон счета успешно сохранен!'));
        $this->getController()->redirect(
          $this->getController()->createUrl('/pay/admin/account/ordertemplate', ['templateId' => $this->template->Id, 'backUrl' => $backUrl])
        );
      }
    }
    elseif (!$this->template->getIsNewRecord())
    {
      foreach ($this->template->getAttributes() as $attr => $value)
      {
        if (property_exists($form, $attr))
          $form->$attr = $this->template->$attr;
      }
      $form->SignFirstImageMarginTop = $this->template->SignFirstImageMargin[0];
      $form->SignFirstImageMarginLeft = $this->template->SignFirstImageMargin[1];
      $form->SignSecondImageMarginTop = $this->template->SignSecondImageMargin[0];
      $form->SignSecondImageMarginLeft = $this->template->SignSecondImageMargin[1];
      $form->StampMarginTop = $this->template->StampImageMargin[0];
      $form->StampMarginLeft = $this->template->StampImageMargin[1];
    }
    
    $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование шаблона счета'));
    $this->getController()->render('ordertemplate',['form' => $form, 'template' => $this->template, 'backUrl' => $backUrl]);
  }
  
  public function view()
  {
    $order = \pay\models\Order::model()->findByPk(830);
    $total = 0;
    $this->getController()->renderPartial('pay.views.order.bills.template', [
      'order' => $order,
      'billData' => [],
      'total' => 0,
      'withSign' => true,
      'template' => $this->template,
      'nds' => $total - round($total / 1.18, 2, PHP_ROUND_HALF_DOWN)
    ]);
  }
}
