<?
/**
 * @var \user\models\User[] $users
 * @var \application\widgets\Paginator $paginator
 * @var string $char
 */
?>
<?if (!empty($alphabet->ru)):?>
    <div class="alphabet">
        <?foreach($alphabet->ru as $ch):?>
            <?=\CHtml::link($ch, $this->createUrl('/widget/speaker/index', ['char' => $ch]), ['class' => ($char == $ch ? 'active' : null)]);?>
        <?endforeach;?>
    </div>
<?endif;?>

<?if (!empty($alphabet->en)):?>
    <div class="alphabet">
        <?foreach($alphabet->en as $ch):?>
            <?=\CHtml::link($ch, $this->createUrl('/widget/speaker/index', ['char' => $ch]), ['class' => ($char == $ch ? 'active' : null)]);?>
        <?endforeach;?>
    </div>
<?endif;?>
<hr/>
<ul class="users clearfix">
    <?foreach($users as $user):?>
        <li>
            <figure class="user-profile">
                <img src="<?=$user->getPhoto()->get90px();?>">
                <figcaption>
                    <h5><a href="<?=$user->getUrl();?>" target="_blank"><?=$user->getFullName();?></a></h5>
                    <?if ($user->getEmploymentPrimary() !== null):?>
                        <p><?=$user->getEmploymentPrimary()->Company->Name;?></p>
                    <?endif;?>
                </figcaption>
            </figure>
        </li>
    <?endforeach;?>
</ul>
<?$this->widget('\application\widgets\Paginator', ['paginator' => $paginator]);?>