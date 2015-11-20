<?php

/** @var $courses \buduguru\models\Course[] */

?>

<div class="container">
    <div class="row">
        <?foreach($courses as $course):?>
            <div class="job span3">
                <div class="details">
                    <?if($course->DateStart):?>
                        <span class="label label-warning"><?=Yii::app()->dateFormatter->format('dd MMMM', $course->DateStart)?></span>
                    <?else:?>
                        <span class="label" style="visibility:hidden"></span>
                    <?endif?>
                </div>
                <header>
                    <h4 class="title">
                        <a target="_blank" href="<?=$course->Url?>"><?=$course->Name?></a>
                    </h4>
                </header>
                <article>
                    <p><?=$course->Announce?></p>
                    <a target="_blank" href="<?=$course->Url?>"><?=Yii::t('app', 'Подробнее')?></a>
                </article>
                <br><br><br>
            </div>
        <?endforeach?>
    </div>
</div>