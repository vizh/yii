<div class="container">
<div class="row">
    <div class="span12">
        <?$user = \user\models\User::model()->findByPk(1);?>
        <?$user->updateSearchIndex();?>
        <?$user->save();?>
        <?=\application\components\utility\PhoneticSearch::getIndex($user->LastName);?>
    </div>
</div>
</div>
