<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiController(
 *     controller="Competence",
 *     title="Компетенции",
 *     description="Описаие методов для работы с компетенциями."
 * )
 * * @ApiObject(
 *     code="TEST",
 *     title="Тест",
 *     json="{
'Id': 1,
'Title': 'Исследование профессионального <br>интернет-сообщества',
'Questions': {
'C2': {
'Title': 'Укажите Ваш пол',
'Values': {
'1': 'Мужской',
'2': 'Женский'
}
},
'Q10': {
'Title': 'С какого курса вы работаете на постоянной основе?',
'Values': {
'1': 'не работаю и никогда не работал на постоянной основе',
'2': 'работал еще до поступления в вуз',
'3': 'с первого курса',
'4': 'со второго курса',
'5': 'с третьего курса',
'6': 'с четвертого курса',
'7': 'с пятого курса',
'8': 'с шестого курса',
'9': 'со времен учебы в аспирантуре или получения второго высшего образования',
'10': 'начал работать на постоянной основе после завершения обучения'
}
}
}}",
 *     description="Тест",
 *     params={
"Id"        :"Идентификатор теста",
 *          "Title"     :"Название теста",
 *          "Questions" :"Список вопросов к тесту. Каждый вопрос состоит из кода вопроса(например C2), текста вопроса (например - Укажите Ваш пол) и варианты ответа в виде списка.",
 *     }
 * )
 * @ApiObject(
 *     code="TEST_RESULT",
 *     title="Результаты теста",
 *     json="{
'competence\\models\\tests\\mailru2013\\First'  : { 'Value': '2' },
'competence\\models\\tests\\mailru2013\\S2'     : { 'Value': '5' },
'competence\\models\\tests\\mailru2013\\E1_1'   : { 'Value': ['1', '3', '7'] },
'competence\\models\\tests\\mailru2013\\E2'     : { 'Value': { '1': '4', '3': '6', '7': '1' } }
}",
 *     description="Результаты теста",
 *     params={}
 * )
 */
class CompetenceController extends Controller
{
}
