<?php
use application\components\controllers\AdminMainController;

/**
 * @var AdminMainController $this
 * @var array $data
 */

$this->setPageTitle('Поис дубликатов пользователей');
?>

<div class="btn-toolbar clearfix">
</div>

<div class="well">
    <table class="table table-bordered">
        <?php foreach ($data as $item): ?>
            <?php
            /**
             * @var \user\models\User $user
             * @var \user\models\User[] $duplicates
             */
            $user = $item['user'];
            $duplicates = $item['duplicates'];
            ?>
            <tr>
                <td><?= $user->RunetId; ?></td>
                <td><?= $user->getFullName(); ?></td>
                <td><?= $user->Email; ?></td>
                <td><?= $user->EventCount; ?></td>
                <td></td>
            </tr>
            <?php foreach ($duplicates as $duplicate): ?>
                <tr class="info">
                    <td><?= $duplicate->RunetId; ?></td>
                    <td><?= $duplicate->getFullName(); ?></td>
                    <td><?= $duplicate->Email; ?></td>
                    <td><?= $duplicate->EventCount; ?></td>
                    <td>
                        <form action="<?= $this->createUrl('merge'); ?>" method="post" style="margin: 0">
                            <input type="hidden" name="user_id" value="<?= $user->Id; ?>">
                            <input type="hidden" name="duplicate_id" value="<?= $duplicate->Id; ?>">
                            <button type="submit" class="btn btn-primary">Объединить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
</div>