<?php
/**
 * @var event\widgets\DetailedRegistration $this
 */
?>

<?foreach($this->form->getUsedAttributes() as $attribute):?>
    <div class="row-fluid">
        <div class="control-group" id="control-group_<?=$attribute?>">
            <?if($attribute === 'Document'):?>
                <h5 class="title"><?=$this->form->getAttributeLabel('Document')?></h5>
            <?php else:?>
                <?=CHtml::label(
                    $this->form->getAttributeLabel($attribute) .
                    ($this->form->isAttributeRequired($attribute) ? ' <span class="required-asterisk">*</span>' : ''),
                    CHtml::activeId($this->form, $attribute),
                    ['class' => 'control-label']
                )?>
            <?endif?>

            <div class="controls">
                <?if($attribute == 'Birthday'):?>
                    <?=CHtml::activeTextField($this->form, $attribute, [
                        'disabled' => $this->form->isDisabled($attribute),
                        'class' => 'span12',
                        'placeholder' => Yii::t('app', 'Например: 01.01.1980')
                    ])?>
                <?php elseif ($attribute == 'Document'):?>
                    <?=$this->form->Document->renderEditView($this->getController(), true)?>
                <?php elseif ($attribute == 'ContactAddress'):?>
                    <?$this->widget('contact\widgets\AddressControls', [
                        'form' => $this->form->ContactAddress,
                        'address' => false,
                        'place' => false,
                        'inputClass' => 'span12',
                        'inputPlaceholder' => false,
                        'disabled' => $this->form->isDisabled($attribute)
                    ])?>
                <?php elseif ($attribute == 'Photo'):?>
                    <?if($this->form->isUpdateMode()):?>
                        <?=CHtml::image($this->form->getActiveRecord()->getPhoto()->get50px(), '', [
                            'class'=>'img-polaroid'
                        ])?>
                    <?php else:?>
                        <?=CHtml::activeFileField($this->form, $attribute)?>
                        <p class="help-block m-top_5">
                            <?=Yii::t('app', 'Фотографии должны быть предоставлены в цветном исполнении, с четким изображением лица, строго в анфас, без головного убора. Размер изображения овала лица на фотографии должен занимать не менее 80 процентов от размера фотографии. Задний фон светлее изображения лица, ровный, без полос, пятен и посторонних предметов.')?>
                        </p>
                    <?endif?>
                <?php else:?>
                    <?=CHtml::activeTextField($this->form, $attribute, [
                        'disabled' => $this->form->isDisabled($attribute),
                        'class' => 'span12'
                    ])?>
                <?endif?>
            </div>
        </div>
    </div>
<?endforeach?>
