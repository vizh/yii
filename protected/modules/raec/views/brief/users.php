<?
/**
 * @var CActiveForm $form
 * @var Users $modelForm
 */
use raec\models\forms\brief\Users;

?>
<?if (!empty($modelForm->Users)):?>
<script type="text/javascript">
    var users = [];
    <?foreach ($modelForm->getUsers() as $user):?>
        var user = {
            'RunetId' : '<?=$user->User->RunetId;?>',
            'FullName' : '<?=\CHtml::encode($user->User->getFullName());?>',
            'Photo' : {
                'Small' : '<?=$user->User->getPhoto()->get50px();?>'
            },
            'RoleId' : <?=$user->Role->Id;?>
        };
        <?if ($user->User->getEmploymentPrimary() !== null && $user->User->getEmploymentPrimary()->Company !== null):?>
            user['Company']  = '<?=\CHtml::encode($user->User->getEmploymentPrimary()->Company->Name);?>';
            user['Position'] = '<?=\CHtml::encode($user->User->getEmploymentPrimary()->Position);?>';
        <?endif;?>
        users.push(user);
    <?endforeach;?>
</script>
<?endif;?>

<?$form = $this->beginWidget('CActiveForm');?>
    <?=$form->errorSummary($modelForm, '<div class="alert alert-error">', '</div>');?>
    <div class="row">
        <div class="span12">
            <?=$form->textField($modelForm, 'Label', ['class' => 'input-block-level']);?>
        </div>
    </div>

    <div class="registration hide">
        <div class="row">
            <div class="span12 text-center m-bottom_20">
                <h4><?=\Yii::t('app', 'Регистрация нового пользователя');?></h4>
            </div>
        </div>
        <div class="row">
            <div class="span6 offset3">
                <div class="alert alert-error hide errorSummary"></div>
            </div>
        </div>
        <div class="row">
            <div class="span3 offset3">
                <?=\CHtml::activeLabel($modelForm->getRegisterForm(), 'LastName');?>
                <?=\CHtml::activeTextField($modelForm->getRegisterForm(), 'LastName', ['class' => 'input-block-level']);?>

                <?=\CHtml::activeLabel($modelForm->getRegisterForm(), 'FirstName');?>
                <?=\CHtml::activeTextField($modelForm->getRegisterForm(), 'FirstName', ['class' => 'input-block-level']);?>

                <?=\CHtml::activeLabel($modelForm->getRegisterForm(), 'FatherName');?>
                <?=\CHtml::activeTextField($modelForm->getRegisterForm(), 'FatherName', ['class' => 'input-block-level']);?>

                <?=\CHtml::activeLabel($modelForm->getRegisterForm(), 'Email');?>
                <?=\CHtml::activeTextField($modelForm->getRegisterForm(), 'Email', ['class' => 'input-block-level']);?>
            </div>
            <div class="span3">
                <?=\CHtml::activeLabel($modelForm->getRegisterForm(), 'Phone');?>
                <?=\CHtml::activeTextField($modelForm->getRegisterForm(), 'Phone', ['class' => 'input-block-level']);?>

                <?=\CHtml::activeLabel($modelForm->getRegisterForm(), 'Company');?>
                <?=\CHtml::activeTextField($modelForm->getRegisterForm(), 'Company', ['class' => 'input-block-level']);?>

                <?=\CHtml::activeLabel($modelForm->getRegisterForm(), 'Position');?>
                <?=\CHtml::activeTextField($modelForm->getRegisterForm(), 'Position', ['class' => 'input-block-level']);?>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="form-actions text-center">
                    <button class="btn btn-cancel"><?=\Yii::t('app', 'Отмена');?></button>
                    <button class="btn btn-inverse btn-submit"><?=\Yii::t('app', 'Зарегистрировать');?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="users m-top_40">
    </div>
    <hr/>
    <div class="row">
        <div class="span12 text-center">
            <?=\CHtml::submitButton(\Yii::t('app', 'Следующий шаг'), ['class' => 'btn btn-success btn-large']);?>
        </div>
    </div>
<?=$this->getNextActionInput();?>
<?$this->endWidget();?>

<script type="text/template" id="user-tpl">
    <div class="row m-bottom_10">
        <div class="span1">
            <img class="media-object" src="<%=Photo.Small%>">
        </div>
        <div class="span5">
            <h4 style="margin-top: 0px;margin-bottom: 5px;"><%=FullName%></h4>
            <%if(typeof(Company) != "undefined"){%>
                <p><%=Company%> <%if(Position != ""){%>, <%=Position%><%}%></p>
            <%}%>
        </div>
        <div class="span4">
            <select name="<?=\CHtml::activeName($modelForm, 'Users');?>[<%=i%>][RoleId]">
                <?foreach ($modelForm->getRoleData() as $value => $label):?>
                    <option value="<?=$value;?>" <%if(RoleId == '<?=$value;?>'){%>selected="selected"<%}%>><?=$label;?></option>
                <?endforeach;?>
            </select>
        </div>
        <div class="span2">
            <a href="#" class="btn btn-danger btn-small"><?=\Yii::t('app', 'Удалить');?></a>
        </div>
        <input type="hidden" name="<?=\CHtml::activeName($modelForm, 'Users');?>[<%=i%>][RunetId]" value="<%=RunetId%>" />
    </div>
</script>

