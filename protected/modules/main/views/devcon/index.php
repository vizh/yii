<?php
/**
 * @var \competence\models\Question[] $questions
 * @var \competence\models\Test $test
 * @var bool $hasErrors
 */
?>

<div class="devcon">
    <div class="container m-top_30 m-bottom_30">
        <div class="row">
            <div class="span9 offset2">
                <a target="_blank" href="http://www.msdevcon.ru/"><img src="/img/event/devcon14/logo.png" alt=""/></a>
            </div>
        </div>
    </div>

    <div class="devcon-hero"></div>

    <div class="container m-top_40">
        <h3 class="text-center competence-title"><?=$test->Title;?></h3>
    </div>

    <div class="container interview m-top_30 m-bottom_40">
        <div class="row m-top_30">
            <div class="span9 offset2">
                <?=CHtml::beginForm();?>

                <?if ($hasErrors):?>
                    <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        Вы не ответили на один или несколько вопросов. Заполните вопросы, отмеченные сообщением об ошибке, и отправьте данные анкеты повторно.
                    </div>
                <?endif;?>

                <?foreach($questions as $question):?>
                    <h3>
                        <?=$question->Title;?>
                        <?if (!empty($question->SubTitle)):?>
                            <br><span><?=$question->SubTitle;?></span>
                        <?endif;?>
                    </h3>
                    <?
                    $this->widget('competence\components\ErrorsWidget', array('form' => $question->getForm()));
                    $this->renderPartial($question->getForm()->getViewPath(), ['form' => $question->getForm()]);
                    ?>
                <?endforeach;?>

                <div class="m-top_40">
                    <label class="checkbox"><?=CHtml::checkBox('DevCon2014RulesAgree', false, ['value' => 'yes', 'uncheckValue' => null,]);?> Я ознакомлен с информацией ниже</label>


                    <p class="devcon-rules">Отмечая последний пункт настоящей анкеты я&nbsp;даю согласие O<nobr>ОО &laquo;Майкрософт Рус&raquo;</nobr> (место нахождения: Российская Федерация, 121614, Москва, ул.&nbsp;Крылатская, 17, корпус 1), а&nbsp;также его аффилированным и/или уполномоченным лицам, на&nbsp;обработку моих персональных данных, указанных в&nbsp;настоящей Анкете, любыми способами, включая сбор, запись, систематизацию, накопление, хранение, обновление, уточнение, изменение, электронное копирование, извлечение, использование, передачу, обезличивание, трансграничную передачу, блокирование, удаление, уничтожение для целей, указанных ниже, и&nbsp;подтверждаю, что, давая такое согласие, я&nbsp;действую свободно, своей волей и&nbsp;в&nbsp;своем интересе. Я&nbsp;подтверждаю, что данное согласие является конкретным, информированным и&nbsp;сознательным.</p>
                    <p class="devcon-rules">Цели обработки персональных данных: персональные данные, представленные мною в&nbsp;настоящей Анкете, будут использоваться <nobr>ООО &laquo;Майкрософт Рус&raquo;</nobr>, а&nbsp;также его аффилированными и/или уполномоченными лицам в&nbsp;целях проведения исследований и&nbsp;анализа по&nbsp;улучшению качества продуктов и&nbsp;услуг Майкрософт, а&nbsp;также для предоставления информации о&nbsp;продуктах и&nbsp;услугах Майкрософт, мероприятиях и&nbsp;рекламных акциях, организуемых <nobr>ООО &laquo;Майкрософт Рус&raquo;</nobr> и/или его аффилированными и/или уполномоченными лицами.</p>
                    <p class="devcon-rules">Настоящим я&nbsp;признаю и&nbsp;подтверждаю, что в&nbsp;случае необходимости предоставления персональных данных для достижения указанных выше целей третьим лицам, в&nbsp;том числе сертифицированным партнерам Майкрософт, а&nbsp;также в&nbsp;случае привлечения третьих лиц к&nbsp;оказанию услуг в&nbsp;указанных выше целях, <nobr>ООО &laquo;Майкрософт Рус&raquo;</nobr> вправе в&nbsp;необходимом объеме раскрывать мои персональные данные таким третьим лицам, их&nbsp;агентам и&nbsp;иным уполномоченным ими лицам для совершения вышеуказанных действий. Также настоящим признаю и&nbsp;подтверждаю, что настоящее согласие считается данным мною любым третьим лицам, указанным выше, с&nbsp;учетом указанных выше условий, и&nbsp;любые такие третьи лица имеют право на&nbsp;обработку персональных данных способами, указанными выше, на&nbsp;основании настоящего согласия.</p>
                    <p class="devcon-rules">Настоящее согласие вступает в&nbsp;силу с&nbsp;момента его подписания и&nbsp;действует на&nbsp;неограниченный срок. Настоящее согласие может быть отозвано мною путем предоставления в&nbsp;<nobr>ООО &laquo;Майкрософт Рус&raquo;</nobr> соответствующего письменного уведомления о&nbsp;его отзыве. В&nbsp;этом случае персональные данные будут уничтожены в&nbsp;течение 7 (семи) календарных дней с&nbsp;даты поступления уведомления, а&nbsp;их&nbsp;обработка будет прекращена за&nbsp;исключением случаев, прямо предусмотренных законодательством Российской Федерации.</p>

                </div>


                <div class="row interview-controls">
                    <div class="span8 text-center">
                        <input type="submit" class="btn btn-success" value="<?=$test->StartButtonText;?>" name="next">
                    </div>
                </div>
                <?=CHtml::endForm();?>
            </div>
        </div>

    </div>

</div>


