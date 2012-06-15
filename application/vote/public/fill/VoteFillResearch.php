<?php
AutoLoader::Import('vote.source.*');
AutoLoader::Import('vote.public.*');


class VoteFillResearch extends VoteFill
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    return;

    $this->fillStepA();
    $this->fillStepB_1();
    $this->fillStepB_2();
    $this->fillStepB_3();
    $this->fillStepB_4();
    $this->fillStepB_5();
    $this->fillStepB_6();
    $this->fillStepB_7();
    $this->fillStepB_8();
    $this->fillStepB_9();
    $this->fillStepB_10();
    $this->fillStepB_11();


    $this->fillStepC_1();
    $this->fillStepC_2();
    $this->fillStepC_3();
    $this->fillStepC_4();
    $this->fillStepC_5();
    $this->fillStepC_6();
    $this->fillStepC_7();
    $this->fillStepC_8();
    $this->fillStepC_9();
    $this->fillStepC_10();
    $this->fillStepC_11();

  }

  private $answer_a8_1;
  private $answer_a8_2;
  private $answer_a8_3;
  private $answer_a8_4;
  private $answer_a8_5;
  private $answer_a8_6;
  private $answer_a8_7;
  private $answer_a8_8;
  private $answer_a8_9;
  private $answer_a8_10;
  private $answer_a8_11;

  private $answer_a10_1;
  private $answer_a10_2;
  private $answer_a10_3;
  private $answer_a10_4;
  private $answer_a10_5;
  private $answer_a10_6;
  private $answer_a10_7;
  private $answer_a10_8;
  private $answer_a10_9;
  private $answer_a10_10;
  private $answer_a10_11;

  private function fillStepA()
  {
    //    $question = $this->addQuestion('УКАЖИТЕ ВАШИ ФАМИЛИЮ, ИМЯ, ОТЧЕСТВО (ПОЛНОСТЬЮ)', 7, 'InputQuestionType');
    //    $this->addAnswer($question, 'УКАЖИТЕ ВАШИ ФАМИЛИЮ, ИМЯ, ОТЧЕСТВО (ПОЛНОСТЬЮ)');
    //
    //
    //    $question = $this->addQuestion('НАЗОВИТЕ ДАТУ ВАШЕГО РОЖДЕНИЯ (ДД.ММ.ГГГГ)', 7, 'InputQuestionType');
    //    $this->addAnswer($question, 'НАЗОВИТЕ ДАТУ ВАШЕГО РОЖДЕНИЯ');
    //
    //    $question = $this->addQuestion('УКАЖИТЕ ВАШЕ ОСНОВНОЕ МЕСТО РАБОТЫ (ПОЛНОЕ НАЗВАНИЕ КОМПАНИИ/ОРГАНИЗАЦИИ)', 8, 'InputQuestionType');
    //    $this->addAnswer($question, 'УКАЖИТЕ ВАШЕ ОСНОВНОЕ МЕСТО РАБОТЫ (ПОЛНОЕ НАЗВАНИЕ КОМПАНИИ/ОРГАНИЗАЦИИ)');
    //
    //    $question = $this->addQuestion('НАЗОВИТЕ ВАШУ ДОЛЖНОСТЬ ПО ОСНОВНОМУ МЕСТУ РАБОТЫ', 8, 'InputQuestionType');
    //    $this->addAnswer($question, 'НАЗОВИТЕ ВАШУ ДОЛЖНОСТЬ ПО ОСНОВНОМУ МЕСТУ РАБОТЫ');

    $question = $this->addQuestion('СКОЛЬКО ПОЛНЫХ ЛЕТ ВЫ РАБОТАЕТЕ', 8, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('')
    ));
    $this->addAnswer($question, 'В УКАЗАННОЙ ДОЛЖНОСТИ');
    $this->addAnswer($question, 'В УКАЗАННОЙ КОМПАНИИ');
    $this->addAnswer($question, 'В ИНДУСТРИИ, СВЯЗАННОЙ С ИНТЕРНЕТОМ');

    $question = $this->addQuestion('УКАЖИТЕ, ПОЖАЛУЙСТА, ВАШУ КОНТАКТНУЮ ИНФОРМАЦИЮ', 9, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('')
    ));
    $this->addAnswer($question, 'РАБОЧИЙ ТЕЛЕФОН');
    $this->addAnswer($question, 'МОБИЛЬНЫЙ ТЕЛЕФОН');
    $this->addAnswer($question, 'РАБОЧИЙ ПОЧТОВЫЙ АДРЕС');
    $this->addAnswer($question, 'ОСНОВНОЙ АДРЕС ЭЛЕКТРОННОЙ ПОЧТЫ');
    $this->addAnswer($question, 'ДОПОЛНИТЕЛЬНЫЙ АДРЕС ЭЛЕКТРОННОЙ ПОЧТЫ');


    $question = $this->addQuestion('ЕСТЬ ЛИ У ВАС УЧЕНАЯ СТЕПЕНЬ?', 10, 'SingleQuestionType');

    $this->addAnswer($question, 'Нет');
    $this->addAnswer($question, 'Есть. Какая?', 1);



    $question = $this->addQuestion('ЕСТЬ ЛИ У ВАС УЧЕНОЕ ЗВАНИЕ?', 10, 'SingleQuestionType');

    $this->addAnswer($question, 'Нет');
    $this->addAnswer($question, 'Есть. Какая?', 1);


    $question = $this->addQuestion('ЕСТЬ ЛИ У ВАС СТЕПЕНЬ MBA?', 10, 'SingleQuestionType');

    $this->addAnswer($question, 'Нет');
    $this->addAnswer($question, 'Есть. В каком учебном заведении получена?', 1);

    $question = $this->addQuestion('В ПРИВЕДЕННОМ СПИСКЕ ОТМЕТЬТЕ ОДИН ИЛИ ДВА ИНТЕРНЕТ-РЫНКА, ПО КОТОРЫМ ВЫ ГОТОВЫ ВЫСТУПИТЬ В КАЧЕСТВЕ ЭКСПЕРТА', 11, 'MultipleQuestionType', '', 1, '');

    $this->answer_a8_1 = $this->addAnswer($question, 'Рынок Веб-разработки');
    $this->answer_a8_2 = $this->addAnswer($question, 'Рынок контекстной рекламы');
    $this->answer_a8_3 = $this->addAnswer($question, 'Рынок медийной рекламы');
    $this->answer_a8_4 = $this->addAnswer($question, 'Рынок видеорекламы');
    $this->answer_a8_5 = $this->addAnswer($question, 'Рынок маркетинга в социальных медиа (SMM)');
    $this->answer_a8_6 = $this->addAnswer($question, 'Рынок поисковой оптимизации');
    $this->answer_a8_7 = $this->addAnswer($question, 'Рынок электронной коммерции – ритейл');
    $this->answer_a8_8 = $this->addAnswer($question, 'Рынок электронной коммерции – контент и игры');
    $this->answer_a8_9 = $this->addAnswer($question, 'Рынок электронной коммерции - платежи');
    $this->answer_a8_10 = $this->addAnswer($question, 'Рынок хостинга и доменов');
    $this->answer_a8_11 = $this->addAnswer($question, 'Рынок программного обеспечения как услуги (SaaS)');


    /*** ВАРИАНТЫ ДЛЯ ВОПРОСА А9 */
    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА Веб-разработки', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_1);
    $answer_a9_1 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');

    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА контекстной рекламы', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_2);
    $answer_a9_2 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');

    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА медийной рекламы', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_3);
    $answer_a9_3 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');

    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА видеорекламы', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_4);
    $answer_a9_4 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');

    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА маркетинга в социальных медиа (SMM)', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_5);
    $answer_a9_5 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');

    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА поисковой оптимизации', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_6);
    $answer_a9_6 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');

    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА электронной коммерции – ритейл', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_7);
    $answer_a9_7 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');

    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА электронной коммерции – контент и игры', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_8);
    $answer_a9_8 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');

    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА электронной коммерции - платежи', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_9);
    $answer_a9_9 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');

    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА хостинга и доменов', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_10);
    $answer_a9_10 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');

    $question = $this->addQuestion('ЯВЛЯЕТСЯ ЛИ ВАША КОМПАНИЯ УЧАСТНИКОМ РЫНКА программного обеспечения как услуги (SaaS)', 12, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_11);
    $answer_a9_11 = $this->addAnswer($question, 'Да, является');
    $this->addAnswer($question, 'Нет, не является');


    /*** ВАРИАНТЫ ДЛЯ ВОПРОСА А10 */

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ Веб-разрабоки?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_1);
    $this->answer_a10_1 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ контекстной рекламы?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_2);
    $this->answer_a10_2 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ медийной рекламы?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_3);
    $this->answer_a10_3 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ видеорекламы?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_4);
    $this->answer_a10_4 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ маркетинга в социальных медиа (SMM)?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_5);
    $this->answer_a10_5 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ поисковой оптимизации?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_6);
    $this->answer_a10_6 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ электронной коммерции – ритейл?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_7);
    $this->answer_a10_7 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ электронной коммерции – контент и игры?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_8);
    $this->answer_a10_8 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ электронной коммерции - платежи?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_9);
    $this->answer_a10_9 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ хостинга и доменов?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_10);
    $this->answer_a10_10 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');

    $question = $this->addQuestion('ГОТОВЫ ЛИ ВЫ ПРЕДОСТАВИТЬ ДЕТАЛЬНУЮ ИНФОРМАЦИЮ О СВОЕЙ КОМПАНИИ ИЛИ ЖЕ СОГЛАСНЫ ДАТЬ ОЦЕНКУ ТОЛЬКО ПО ВСЕМУ РЫНКУ программного обеспечения как услуги (SaaS)?', 12, 'SingleQuestionType', 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам.');
    $question->AddDepend($answer_a9_11);
    $this->answer_a10_11 = $this->addAnswer($question, 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом');
    $this->addAnswer($question, 'Готов(-а) ответить на вопросы только о рынке в целом');


  }

  //<editor-fold desc="StepB">



  private function fillStepB_1()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ Веб-разрабоки ПО ИТОГАМ 2011 Г. (РУБ)', 13, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_1);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ Веб-разрабоки ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 13, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_1);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ Веб-разрабоки ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 14, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_1);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ Веб-разрабоки ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 14, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_1);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ Веб-разрабоки ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 15, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a10_1);
    $this->addAnswer($question, 'Обычная');
    $this->addAnswer($question, 'Веб-студии');
    $this->addAnswer($question, 'Мобильная');
    $this->addAnswer($question, 'Фрилансеры');

    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ Веб-разрабоки ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 16, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_1);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ Веб-разрабоки ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 17, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_1);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ Веб-разрабоки ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 17, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_1);
    $this->addAnswer($question, '% от оборота');

  }

  private function fillStepB_2()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы ПО ИТОГАМ 2011 Г. (РУБ)', 18, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_2);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 18, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_2);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 19, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_2);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 19, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_2);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 20, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a10_2);
    $this->addAnswer($question, 'Поисковая');
    $this->addAnswer($question, 'Непоисковая');

    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 21, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_2);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 22, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_2);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 22, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_2);
    $this->addAnswer($question, '% от оборота');

  }

  private function fillStepB_3()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ медийной рекламы ПО ИТОГАМ 2011 Г. (РУБ)', 23, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_3);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ медийной рекламы ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 23, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_3);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ медийной рекламы ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 24, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_3);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ медийной рекламы ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 24, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_3);
    $this->addAnswer($question, '%');

//    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ медийной рекламы ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 25, 'InputListQuestionType');
//    $question->QuestionType()->SetParams(array(
//      'Criterions' => array('Оборот, %')
//    ));
//    $question->AddDepend($this->answer_a10_3);
//    $this->addAnswer($question, 'B2C');
//    $this->addAnswer($question, 'B2B');

    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ медийной рекламы ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 26, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_3);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ медийной рекламы ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 27, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_3);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ медийной рекламы ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 27, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_3);
    $this->addAnswer($question, '% от оборота');

  }

  private function fillStepB_4()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ видеорекламы ПО ИТОГАМ 2011 Г. (РУБ)', 28, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_4);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ видеорекламы ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 28, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_4);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ видеорекламы ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 29, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_4);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ видеорекламы ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 29, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_4);
    $this->addAnswer($question, '%');

//    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ видеорекламы ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 30, 'InputListQuestionType');
//    $question->QuestionType()->SetParams(array(
//      'Criterions' => array('Оборот, %')
//    ));
//    $question->AddDepend($this->answer_a10_4);
//    $this->addAnswer($question, 'B2C');
//    $this->addAnswer($question, 'B2B');

    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ видеорекламы ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 31, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_4);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ видеорекламы ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 32, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_4);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ видеорекламы ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 32, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_4);
    $this->addAnswer($question, '% от оборота');

  }

  private function fillStepB_5()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) ПО ИТОГАМ 2011 Г. (РУБ)', 33, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_5);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 33, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_5);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 34, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_5);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 34, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_5);
    $this->addAnswer($question, '%');

//    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 35, 'InputListQuestionType');
//    $question->QuestionType()->SetParams(array(
//      'Criterions' => array('Оборот, %')
//    ));
//    $question->AddDepend($this->answer_a10_5);
//    $this->addAnswer($question, 'B2C');
//    $this->addAnswer($question, 'B2B');

    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 36, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_5);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 37, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_5);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 37, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_5);
    $this->addAnswer($question, '% от оборота');

  }

  private function fillStepB_6()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации ПО ИТОГАМ 2011 Г. (РУБ)', 38, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_6);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 38, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_6);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 39, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_6);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 39, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_6);
    $this->addAnswer($question, '%');

//    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 40, 'InputListQuestionType');
//    $question->QuestionType()->SetParams(array(
//      'Criterions' => array('Оборот, %')
//    ));
//    $question->AddDepend($this->answer_a10_6);
//    $this->addAnswer($question, 'B2C');
//    $this->addAnswer($question, 'B2B');

    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 41, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_6);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 42, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_6);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 42, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_6);
    $this->addAnswer($question, '% от оборота');

  }

  private function fillStepB_7()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл ПО ИТОГАМ 2011 Г. (РУБ)', 43, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_7);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 43, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_7);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 44, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_7);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 44, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_7);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 45, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a10_7);
    $this->addAnswer($question, 'Физические товары и продукты питания');
    $this->addAnswer($question, 'Купоны');
    $this->addAnswer($question, 'Билеты (транспорт)');
    $this->addAnswer($question, 'Билеты (мероприятия)');
    $this->addAnswer($question, 'Бытовые услуги и медицина');


    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 46, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_7);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 47, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_7);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 47, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_7);
    $this->addAnswer($question, '% от оборота');

  }

  private function fillStepB_8()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры ПО ИТОГАМ 2011 Г. (РУБ)', 48, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_8);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 48, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_8);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 49, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_8);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 49, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_8);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 50, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a10_8);
    $this->addAnswer($question, 'Электронные книги');
    $this->addAnswer($question, 'Видео');
    $this->addAnswer($question, 'Музыка');
    $this->addAnswer($question, 'Игры');
    $this->addAnswer($question, 'Приложения (неигровые)');


    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 51, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_8);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 52, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_8);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 52, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_8);
    $this->addAnswer($question, '% от оборота');

  }

  private function fillStepB_9()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи ПО ИТОГАМ 2011 Г. (РУБ)', 53, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_9);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 53, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_9);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 54, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_9);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 54, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_9);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 55, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a10_9);
    $this->addAnswer($question, 'Платежные системы');
    $this->addAnswer($question, 'Мобильные платежи');

    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 56, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_9);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 57, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_9);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 57, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_9);
    $this->addAnswer($question, '% от оборота');

  }

  private function fillStepB_10()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов ПО ИТОГАМ 2011 Г. (РУБ)', 58, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_10);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 58, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_10);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 59, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_10);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 59, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_10);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 60, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a10_10);
    $this->addAnswer($question, 'Хостинг (кроме облачного)');
    $this->addAnswer($question, 'Домены');
    $this->addAnswer($question, 'Облачный хостинг');

    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 61, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_10);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 62, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_10);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 62, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_10);
    $this->addAnswer($question, '% от оборота');

  }

  private function fillStepB_11()
  {
    $question = $this->addQuestion('НАЗОВИТЕ, ПОЖАЛУЙСТА, ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) ПО ИТОГАМ 2011 Г. (РУБ)', 63, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_11);
    $this->addAnswer($question, 'РУБ');

    $question = $this->addQuestion('КАКОВА ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В %)', 63, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_11);
    $this->addAnswer($question, 'Увеличился на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшился на', 1);

    $question = $this->addQuestion('КАКОВА ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) ПО ИТОГАМ 2011 Г. (В % ОТ ОБОРОТА)?', 64, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_11);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА БЫЛА ЧИСТАЯ ПРИБЫЛЬ В ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) ПО ИТОГАМ 2010 Г. (В % ОТ ОБОРОТА)?', 64, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_11);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ СЛЕДУЮЩИМИ СЕГМЕНТАМИ?', 65, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a10_11);
    $this->addAnswer($question, 'Сегмент B2C');
    $this->addAnswer($question, 'Сегмент B2B');

    $question = $this->addQuestion('ЕСЛИ ПРЕДСТАВИТЬ СЕБЕ ДИНАМИКУ ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ ПО КВАРТАЛАМ 2011 Г. (В %)?', 66, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('1 КВАРТАЛ 2011 Г.', '2 КВАРТАЛ 2011 Г.', '3 КВАРТАЛ 2011 Г.', '4 КВАРТАЛ 2011 Г.')
    ));
    $question->AddDepend($this->answer_a10_11);
    $this->addAnswer($question, 'Распределение оборота, %');


    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ДИНАМИКА ОБОРОТА ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) ПО ИТОГАМ 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.?', 67, 'SingleQuestionType');
    $question->AddDepend($this->answer_a10_11);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ЧИСТАЯ ПРИБЫЛЬ ВАШЕЙ КОМПАНИИ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) ПО ИТОГАМ 2012 Г. (В % ОТ ОБОРОТА)?', 67, 'InputQuestionType');
    $question->AddDepend($this->answer_a10_11);
    $this->addAnswer($question, '% от оборота');

  }

  //</editor-fold>





  private function fillStepC_1()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ Веб-разработки В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ Веб-разработки В 2011 Г.', 68, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

//    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 69, 'InputListQuestionType');
//    $question->QuestionType()->SetParams(array(
//      'Criterions' => array('Название компании', 'Доля рынка (в %)')
//    ));
//    $question->AddDepend($this->answer_a8_1);
//    $this->addAnswer($question, 'Компания 1');
//    $this->addAnswer($question, 'Компания 2');
//    $this->addAnswer($question, 'Компания 3');
//    $this->addAnswer($question, 'Компания 4');
//    $this->addAnswer($question, 'Компания 5');
//    $this->addAnswer($question, 'Компания 6');
//    $this->addAnswer($question, 'Компания 7');
//    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ Веб-разработки В 2011 Г. (В РУБЛЯХ)?', 70, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ Веб-разработки В 2011 Г. (В % ОТ ОБОРОТА)?', 71, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ Веб-разработки ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 72, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ Веб-разработки В 2010 Г. (В % ОТ ОБОРОТА)?', 73, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ Веб-разработки ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 74, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ Веб-разработки В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 75, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ Веб-разработки В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 75, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ Веб-разработки В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 75, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ Веб-разработки?', 76, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ Веб-разработки В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 77, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_1);
    $this->addAnswer($question, 'Прибыль, %');

  }

  private function fillStepC_2()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы В 2011 Г.', 78, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

    //    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 79, 'InputListQuestionType');
    //    $question->QuestionType()->SetParams(array(
    //      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    //    ));
    //    $question->AddDepend($this->answer_a8_2);
    //    $this->addAnswer($question, 'Компания 1');
    //    $this->addAnswer($question, 'Компания 2');
    //    $this->addAnswer($question, 'Компания 3');
    //    $this->addAnswer($question, 'Компания 4');
    //    $this->addAnswer($question, 'Компания 5');
    //    $this->addAnswer($question, 'Компания 6');
    //    $this->addAnswer($question, 'Компания 7');
    //    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы В 2011 Г. (В РУБЛЯХ)?', 80, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ контекстной рекламы В 2011 Г. (В % ОТ ОБОРОТА)?', 81, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ контекстной рекламы ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 82, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ контекстной рекламы В 2010 Г. (В % ОТ ОБОРОТА)?', 83, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 84, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 85, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 85, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 85, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы?', 86, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ контекстной рекламы В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 87, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_2);
    $this->addAnswer($question, 'Прибыль, %');

  }

  private function fillStepC_3()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ медийной рекламы В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ медийной рекламы В 2011 Г.', 88, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

    //    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 89, 'InputListQuestionType');
    //    $question->QuestionType()->SetParams(array(
    //      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    //    ));
    //    $question->AddDepend($this->answer_a8_3);
    //    $this->addAnswer($question, 'Компания 1');
    //    $this->addAnswer($question, 'Компания 2');
    //    $this->addAnswer($question, 'Компания 3');
    //    $this->addAnswer($question, 'Компания 4');
    //    $this->addAnswer($question, 'Компания 5');
    //    $this->addAnswer($question, 'Компания 6');
    //    $this->addAnswer($question, 'Компания 7');
    //    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ медийной рекламы В 2011 Г. (В РУБЛЯХ)?', 90, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ медийной рекламы В 2011 Г. (В % ОТ ОБОРОТА)?', 91, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ медийной рекламы ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 92, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ медийной рекламы В 2010 Г. (В % ОТ ОБОРОТА)?', 93, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ медийной рекламы ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 94, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ медийной рекламы В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 95, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ медийной рекламы В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 95, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ медийной рекламы В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 95, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ медийной рекламы?', 96, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ медийной рекламы В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 97, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_3);
    $this->addAnswer($question, 'Прибыль, %');

  }

  private function fillStepC_4()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ видеорекламы В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ видеорекламы В 2011 Г.', 98, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

    //    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 99, 'InputListQuestionType');
    //    $question->QuestionType()->SetParams(array(
    //      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    //    ));
    //    $question->AddDepend($this->answer_a8_4);
    //    $this->addAnswer($question, 'Компания 1');
    //    $this->addAnswer($question, 'Компания 2');
    //    $this->addAnswer($question, 'Компания 3');
    //    $this->addAnswer($question, 'Компания 4');
    //    $this->addAnswer($question, 'Компания 5');
    //    $this->addAnswer($question, 'Компания 6');
    //    $this->addAnswer($question, 'Компания 7');
    //    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ видеорекламы В 2011 Г. (В РУБЛЯХ)?', 100, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ видеорекламы В 2011 Г. (В % ОТ ОБОРОТА)?', 101, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ видеорекламы ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 102, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ видеорекламы В 2010 Г. (В % ОТ ОБОРОТА)?', 103, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ видеорекламы ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 104, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ видеорекламы В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 105, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ видеорекламы В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 105, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ видеорекламы В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 105, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ видеорекламы?', 106, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ видеорекламы В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 107, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_4);
    $this->addAnswer($question, 'Прибыль, %');

  }

  private function fillStepC_5()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) В 2011 Г.', 108, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

    //    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 109, 'InputListQuestionType');
    //    $question->QuestionType()->SetParams(array(
    //      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    //    ));
    //    $question->AddDepend($this->answer_a8_5);
    //    $this->addAnswer($question, 'Компания 1');
    //    $this->addAnswer($question, 'Компания 2');
    //    $this->addAnswer($question, 'Компания 3');
    //    $this->addAnswer($question, 'Компания 4');
    //    $this->addAnswer($question, 'Компания 5');
    //    $this->addAnswer($question, 'Компания 6');
    //    $this->addAnswer($question, 'Компания 7');
    //    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) В 2011 Г. (В РУБЛЯХ)?', 110, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ маркетинга в социальных медиа (SMM) В 2011 Г. (В % ОТ ОБОРОТА)?', 111, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 112, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ маркетинга в социальных медиа (SMM) В 2010 Г. (В % ОТ ОБОРОТА)?', 113, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 114, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 115, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 115, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 115, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM)?', 116, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ маркетинга в социальных медиа (SMM) В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 117, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_5);
    $this->addAnswer($question, 'Прибыль, %');

  }

  private function fillStepC_6()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации В 2011 Г.', 118, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

    //    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 119, 'InputListQuestionType');
    //    $question->QuestionType()->SetParams(array(
    //      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    //    ));
    //    $question->AddDepend($this->answer_a8_6);
    //    $this->addAnswer($question, 'Компания 1');
    //    $this->addAnswer($question, 'Компания 2');
    //    $this->addAnswer($question, 'Компания 3');
    //    $this->addAnswer($question, 'Компания 4');
    //    $this->addAnswer($question, 'Компания 5');
    //    $this->addAnswer($question, 'Компания 6');
    //    $this->addAnswer($question, 'Компания 7');
    //    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации В 2011 Г. (В РУБЛЯХ)?', 120, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ поисковой оптимизации В 2011 Г. (В % ОТ ОБОРОТА)?', 121, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 122, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ поисковой оптимизации В 2010 Г. (В % ОТ ОБОРОТА)?', 123, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 124, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 125, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 125, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 125, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации?', 126, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ поисковой оптимизации В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 127, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_6);
    $this->addAnswer($question, 'Прибыль, %');

  }

  private function fillStepC_7()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл В 2011 Г.', 128, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

    //    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 129, 'InputListQuestionType');
    //    $question->QuestionType()->SetParams(array(
    //      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    //    ));
    //    $question->AddDepend($this->answer_a8_7);
    //    $this->addAnswer($question, 'Компания 1');
    //    $this->addAnswer($question, 'Компания 2');
    //    $this->addAnswer($question, 'Компания 3');
    //    $this->addAnswer($question, 'Компания 4');
    //    $this->addAnswer($question, 'Компания 5');
    //    $this->addAnswer($question, 'Компания 6');
    //    $this->addAnswer($question, 'Компания 7');
    //    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл В 2011 Г. (В РУБЛЯХ)?', 130, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ электронной коммерции – ритейл В 2011 Г. (В % ОТ ОБОРОТА)?', 131, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 132, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ электронной коммерции – ритейл В 2010 Г. (В % ОТ ОБОРОТА)?', 133, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 134, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 135, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 135, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 135, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл?', 136, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – ритейл В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 137, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_7);
    $this->addAnswer($question, 'Прибыль, %');

  }

  private function fillStepC_8()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры В 2011 Г.', 138, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

    //    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 139, 'InputListQuestionType');
    //    $question->QuestionType()->SetParams(array(
    //      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    //    ));
    //    $question->AddDepend($this->answer_a8_8);
    //    $this->addAnswer($question, 'Компания 1');
    //    $this->addAnswer($question, 'Компания 2');
    //    $this->addAnswer($question, 'Компания 3');
    //    $this->addAnswer($question, 'Компания 4');
    //    $this->addAnswer($question, 'Компания 5');
    //    $this->addAnswer($question, 'Компания 6');
    //    $this->addAnswer($question, 'Компания 7');
    //    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры В 2011 Г. (В РУБЛЯХ)?', 140, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ электронной коммерции – контент и игры В 2011 Г. (В % ОТ ОБОРОТА)?', 141, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 142, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ электронной коммерции – контент и игры В 2010 Г. (В % ОТ ОБОРОТА)?', 143, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 144, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 145, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 145, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 145, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры?', 146, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции – контент и игры В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 147, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_8);
    $this->addAnswer($question, 'Прибыль, %');

  }

  private function fillStepC_9()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи В 2011 Г.', 148, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

    //    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 149, 'InputListQuestionType');
    //    $question->QuestionType()->SetParams(array(
    //      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    //    ));
    //    $question->AddDepend($this->answer_a8_9);
    //    $this->addAnswer($question, 'Компания 1');
    //    $this->addAnswer($question, 'Компания 2');
    //    $this->addAnswer($question, 'Компания 3');
    //    $this->addAnswer($question, 'Компания 4');
    //    $this->addAnswer($question, 'Компания 5');
    //    $this->addAnswer($question, 'Компания 6');
    //    $this->addAnswer($question, 'Компания 7');
    //    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи В 2011 Г. (В РУБЛЯХ)?', 150, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ электронной коммерции - платежи В 2011 Г. (В % ОТ ОБОРОТА)?', 151, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 152, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ электронной коммерции - платежи В 2010 Г. (В % ОТ ОБОРОТА)?', 153, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 154, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 155, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 155, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 155, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи?', 156, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ электронной коммерции - платежи В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 157, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_9);
    $this->addAnswer($question, 'Прибыль, %');

  }

  private function fillStepC_10()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов В 2011 Г.', 158, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

    //    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 159, 'InputListQuestionType');
    //    $question->QuestionType()->SetParams(array(
    //      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    //    ));
    //    $question->AddDepend($this->answer_a8_10);
    //    $this->addAnswer($question, 'Компания 1');
    //    $this->addAnswer($question, 'Компания 2');
    //    $this->addAnswer($question, 'Компания 3');
    //    $this->addAnswer($question, 'Компания 4');
    //    $this->addAnswer($question, 'Компания 5');
    //    $this->addAnswer($question, 'Компания 6');
    //    $this->addAnswer($question, 'Компания 7');
    //    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов В 2011 Г. (В РУБЛЯХ)?', 160, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ хостинга и доменов В 2011 Г. (В % ОТ ОБОРОТА)?', 161, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ хостинга и доменов ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 162, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ хостинга и доменов В 2010 Г. (В % ОТ ОБОРОТА)?', 163, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 164, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 165, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 165, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 165, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов?', 166, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ хостинга и доменов В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 167, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_10);
    $this->addAnswer($question, 'Прибыль, %');

  }

  private function fillStepC_11()
  {
    $question = $this->addQuestion('ПОЖАЛУЙСТА, НАЗОВИТЕ ВЕДУЩИЕ КОМПАНИИ, ДЕЙСТВОВАВШИЕ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) В 2011 Г. И ДОЛЮ КАЖДОЙ ИЗ УКАЗАННЫХ ВАМИ  КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) В 2011 Г.', 168, 'InputListQuestionType');
    $question->Required = 0;
    $question->save();
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    ));
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, 'Компания 1');
    $this->addAnswer($question, 'Компания 2');
    $this->addAnswer($question, 'Компания 3');
    $this->addAnswer($question, 'Компания 4');
    $this->addAnswer($question, 'Компания 5');
    $this->addAnswer($question, 'Компания 6');
    $this->addAnswer($question, 'Компания 7');
    $this->addAnswer($question, 'Компания 8');

    //    $question = $this->addQuestion('РЕЗЕРВНЫЙ ВОПРОС', 169, 'InputListQuestionType');
    //    $question->QuestionType()->SetParams(array(
    //      'Criterions' => array('Название компании', 'Доля рынка (в %)')
    //    ));
    //    $question->AddDepend($this->answer_a8_11);
    //    $this->addAnswer($question, 'Компания 1');
    //    $this->addAnswer($question, 'Компания 2');
    //    $this->addAnswer($question, 'Компания 3');
    //    $this->addAnswer($question, 'Компания 4');
    //    $this->addAnswer($question, 'Компания 5');
    //    $this->addAnswer($question, 'Компания 6');
    //    $this->addAnswer($question, 'Компания 7');
    //    $this->addAnswer($question, 'Компания 8');

    $question = $this->addQuestion('ОЦЕНИТЕ, ПОЖАЛУЙСТА, ОБЩИЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) В 2011 Г. (В РУБЛЯХ)?', 170, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, 'РУБЛЕЙ');

    $question = $this->addQuestion('КАКОВА, НА ВАШ ВЗГЛЯД, ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ программного обеспечения как услуги (SaaS) В 2011 Г. (В % ОТ ОБОРОТА)?', 171, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, '%');

    $question = $this->addQuestion('КАКОВА ОБЩАЯ ДИНАМИКА ОБОРОТА НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) ПО ИТОГАМ 2011 Г. ПО СРАВНЕНИЮ С 2010 Г. (В % ОТ ОБОРОТА)?', 172, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, 'Увеличится на', 1);
    $this->addAnswer($question, 'Остался без изменений');
    $this->addAnswer($question, 'Уменьшится на', 1);

    $question = $this->addQuestion('КАКОВА БЫЛА ОБЩАЯ ПРИБЫЛЬ ПО РОССИЙСКОМУ РЫНКУ программного обеспечения как услуги (SaaS) В 2010 Г. (В % ОТ ОБОРОТА)?', 173, 'InputQuestionType');
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, '%');


    $question = $this->addQuestion('ЕСЛИ ПРИНЯТЬ ОБОРОТ ВСЕХ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) ПО ИТОГАМ 2011 Г. ЗА 100%, КАКИМ ОБРАЗОМ ОН РАСПРЕДЕЛИЛСЯ МЕЖДУ <СЛЕДУЮЩИМИ СЕГМЕНТАМИ>?', 174, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Оборот, %')
    ));
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, 'Сегмент1');
    $this->addAnswer($question, 'Сегмент2');


    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ ПРОГНОЗ.', 175, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ОПТИМИСТИЧНЫЙ ПРОГНОЗ.', 175, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);

    $question = $this->addQuestion('КАК И НАСКОЛЬКО, ПО ВАШЕМУ МНЕНИЮ, ИЗМЕНИТСЯ ОБЩИЙ, СУММАРНЫЙ ОБОРОТ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) В 2012 Г. ПО СРАВНЕНИЮ С 2011 Г.(В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 175, 'SingleQuestionType');
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, 'Вырастет на', 1);
    $this->addAnswer($question, 'Останется без изменений');
    $this->addAnswer($question, 'Сократится на', 1);


    $question = $this->addQuestion('КАК БЫ ВЫ ОЦЕНИЛИ ВЕРОЯТНОСТЬ РЕАЛИЗАЦИИ ДАННЫХ ПРОГНОЗОВ ПО ИЗМЕНЕНИЮ СУММАРНЫХ ОБОРОТОВ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS)?', 176, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, 'Вероятность, %');

    $question = $this->addQuestion('КАКОВА, ПО ВАШЕМУ МНЕНИЮ, БУДЕТ ОБЩАЯ ПРИБЫЛЬ КОМПАНИЙ НА РОССИЙСКОМ РЫНКЕ программного обеспечения как услуги (SaaS) В 2012 Г. (В % ОТ ОБОРОТА)? ДАЙТЕ, ПОЖАЛУЙСТА, РЕАЛИСТИЧНЫЙ, ОПТИМИСТИЧНЫЙ И ПЕССИМИСТИЧНЫЙ ПРОГНОЗ.', 177, 'InputListQuestionType');
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Реалистичный прогноз', 'Оптимистичный прогноз.', 'Пессимистичный прогноз')
    ));
    $question->AddDepend($this->answer_a8_11);
    $this->addAnswer($question, 'Прибыль, %');

  }

  /**
   * @param $questionText
   * @param $stepId
   * @param $type
   * @param string $description
   * @param int $required
   * @param $validator
   * @return VoteQuestion
   */
  private function addQuestion($questionText, $stepId, $type, $description = '', $required = 1, $validator = null)
  {
    $question = new VoteQuestion();
    $question->VoteId = 2;
    $question->Question = $questionText;
    $question->Description = $description;
    $question->StepId = $stepId;
    $question->Type = $type;
    $question->Validator = $validator;
    $question->Required = $required;
    $question->save();

    return $question;
  }

  /**
   * @param $question
   * @param $answerText
   * @param int $custom
   * @return VoteAnswer
   */
  private function addAnswer($question, $answerText, $custom = 0)
  {
    $answer = new VoteAnswer();
    $answer->QuestionId = $question->QuestionId;
    $answer->Answer = $answerText;
    $answer->Custom = $custom;
    $answer->save();

    return $answer;
  }

}
