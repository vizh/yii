<?php

/**
 * @var array $times
 * @var string $time
 * @var User[] $users
 */
use user\models\User;

?>

<div class="container">
    <div class="row m-top_30">
        <div class="span12">
            <ul class="nav nav-pills">
                <?php foreach ($times as $start => $end):?>
                    <li <?=$time==$start ? 'class="active"' : '';?>>
                        <a href="<?= Yii::app()->createUrl('/main/info/appday14', ['time' => $start]);?>">
                            <?=$start;?> &mdash; <?=$end;?>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>

    <div class="row m-top_30">
        <div class="span12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>RUNET-ID</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user):?>
                        <tr>
                            <td><?=$user->RunetId;?></td>
                            <td><?=$user->getFullName();?></td>
                            <td><?=$user->PrimaryPhone;?></td>
                            <td><?=$user->Email;?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
