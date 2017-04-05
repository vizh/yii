<?php
/**
 * @var string[] $dates
 * @var array $food
 * @var array $usersFood
 */
?>

<div class="btn-toolbar"></div>
<div class="well">

    <h3>Поляны</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <?foreach($dates as $date):?>
                <th><?=date('d.m', strtotime($date))?></th>
            <?endforeach?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Завтраки</td>
            <?foreach($dates as $key => $value):?>
                <td><?=count($usersFood['breakfastP'][$food['breakfast'][$key]])?></td>
            <?endforeach?>
        </tr>
        <tr>
            <td>Обеды</td>
            <?foreach($dates as $key => $value):?>
                <td><?=count($usersFood['lunchP'][$food['lunch'][$key]])?></td>
            <?endforeach?>
        </tr>
        <tr>
            <td>Ужины</td>
            <?foreach($dates as $key => $value):?>
                <td><?=count($usersFood['dinnerP'][$food['dinner'][$key]])?></td>
            <?endforeach?>
        </tr>
        </tbody>
    </table>

    <h3>Лесные дали</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <?foreach($dates as $date):?>
                <th><?=date('d.m', strtotime($date))?></th>
            <?endforeach?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Завтраки</td>
            <?foreach($dates as $key => $value):?>
                <td><?=count($usersFood['breakfastLD'][$food['breakfast'][$key]])?></td>
            <?endforeach?>
        </tr>
        <tr>
            <td>Обеды</td>
            <?foreach($dates as $key => $value):?>
                <td><?=count($usersFood['lunchLD'][$food['lunch'][$key]])?></td>
            <?endforeach?>
        </tr>
        <tr>
            <td>Ужины</td>
            <?foreach($dates as $key => $value):?>
                <td><?=count($usersFood['dinnerLD'][$food['dinner'][$key]])?></td>
            <?endforeach?>
        </tr>
        </tbody>
    </table>


    <h3>Назарьево</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <?foreach($dates as $date):?>
                <th><?=date('d.m', strtotime($date))?></th>
            <?endforeach?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Завтраки</td>
            <?foreach($dates as $key => $value):?>
                <td><?=count($usersFood['breakfastN'][$food['breakfast'][$key]])?></td>
            <?endforeach?>
        </tr>
        <tr>
            <td>Обеды</td>
            <?foreach($dates as $key => $value):?>
                <td><?=count($usersFood['lunchN'][$food['lunch'][$key]])?></td>
            <?endforeach?>
        </tr>
        <tr>
            <td>Ужины</td>
            <?foreach($dates as $key => $value):?>
                <td><?=count($usersFood['dinnerN'][$food['dinner'][$key]])?></td>
            <?endforeach?>
        </tr>
        </tbody>
    </table>

    <h3>Завтракающие в назарьево</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <?foreach($dates as $date):?>
                <th><?=date('d.m', strtotime($date))?></th>
            <?endforeach?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?foreach($dates as $key => $value):?>
                <td>
                    <ul>
						<?if(isset($usersFood['breakfastN'][$food['breakfast'][$key]])):?>
							<?foreach($usersFood['breakfastN'][$food['breakfast'][$key]] as $id):?>
								<?$user = \user\models\User::model()->byRunetId($id)->find()?>
								<li><?=$user->getFullName()?>
									<?if($user->getEmploymentPrimary() !== null && $user->getEmploymentPrimary()->Company !== null):?>
										(<?=$user->getEmploymentPrimary()->Company->Name?>)
									<?endif?>
								</li>
							<?endforeach?>
                        <?endif?>
					</ul>
                </td>
            <?endforeach?>
        </tr>
        </tbody>
    </table>

</div>