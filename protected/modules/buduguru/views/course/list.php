<?php

/** @var $courses   \buduguru\models\Course[] */
/** @var $paginator \application\components\utility\Paginator */

?>

<section id="section" role="main">
    <h2 class="b-header_large light">
        <div class="line"></div>
        <div class="container">
            <div class="title">
                <span class="backing runet">Runet</span>
                <span class="backing text">Курсы</span>
            </div>
        </div>
    </h2>

    <div class="b-jobs">
        <?=$this->renderPartial('jobs', ['courses' => array_slice($courses, 0, 4)])?>
        <?=$this->renderPartial('jobs', ['courses' => array_slice($courses, 4, sizeof($courses) - 4)])?>
    </div>

    <?$this->widget('application\widgets\Paginator', [
        'paginator' => $paginator
    ])?>
</section>
