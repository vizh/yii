<?php
/**
 * @var array $sectionsByTime
 * @var array $voteValues
 * @var Vote $votes
 */
use event\models\section\Section;
use event\models\section\Vote;

?>


<div class="container interview m-top_30 m-bottom_40">
    <div class="row m-top_30">
        <div class="span9 offset2">

            <p class="help-block text-center">Вы можете голосовать за текущие доклады и доклады двух прошлых сессий.</p>


            <?=CHtml::beginForm();?>



            <?php foreach ($sectionsByTime as $sections):?>
                <?php
                /** @var Section[] $sections */

                $section = $sections[0];

                ?>

                <h3 class="text-center"><strong><?=date('H:i', strtotime($section->StartTime));?> &mdash; <?=date('H:i', strtotime($section->EndTime));?></strong></h3>

                <?php foreach ($sections as $section):?>
                    <h3 class="section-title">
                        <?=$section->Title;?>
                        <?php if (!empty($section->LinkHalls)):?>
                            <br><span><?=$section->LinkHalls[0]->Hall->Title?></span>
                        <?php endif;?>
                    </h3>
                    <p style="font-weight: 300; margin-bottom: 15px;"><?=$section->Info;?></p>

                    <table class="table table-striped">
                        <tbody>

                        <tr>
                            <td class="span8">Ваша оценка</td>
                            <td>
                                <?=CHtml::dropDownList('vote['.$section->Id.'][SpeakerSkill]', isset($votes[$section->Id]) ? $votes[$section->Id]->SpeakerSkill : null, $voteValues, ['class' => 'span1']);?>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                <?php endforeach;?>


            <?php endforeach;?>

            <div class="row interview-controls">
                <div class="span8 text-center">
                    <input type="submit" class="btn btn-success" value="Голосовать" name="next">
                </div>
            </div>

            <?=CHtml::endForm();?>
        </div>
    </div>
</div>
