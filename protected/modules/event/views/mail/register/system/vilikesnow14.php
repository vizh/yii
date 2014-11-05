<?
/**
 *  @var \user\models\User $user
 *  @var \event\models\Role $role
 */
?>
<p>Данные пользователя:</p>
<p><strong>ФИО</strong>: <?=$user->getFullName();?><br/>
<strong>Email</strong>: <?=$user->Email;?><br/>

<?if ($user->getEmploymentPrimary() !== null):?>
    <strong>Компания</strong>: <?=$user->getEmploymentPrimary()->Company->Name;?><br/>
<?endif;?>

<strong>Статус</strong>: <?=$role->Title;?></p>