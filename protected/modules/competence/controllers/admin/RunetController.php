<?php
use competence\models\form\attribute\RadioValue;
use competence\models\Question;
use competence\models\QuestionType;
use competence\models\Test;

class RunetController extends \application\components\controllers\AdminMainController
{
    /**
     * @var Test
     */
    public $test = null;

    public function actionReplacetitle()
    {
        echo 'already done';
        return;
        $questions = Question::model()->byTestId(8)->findAll();

        $types = [
            1 => 'Веб-разработка и мобильная разработка',
            2 => 'Контекстная реклама/ Performance',
            3 => 'Медийная реклама /Display',
            4 => 'Видеореклама',
            5 => 'Маркетинг в социальных медиа (SMM)',
            6 => 'Поисковая оптимизация',
            7 => 'Программное обеспечение как услуга (SaaS)',
            8 => 'Хостинг',
            9 => 'Домены',
            10 => 'Ретейл',
            11 => 'Электронные платежи',
            12 => 'Туризм',
            13 => 'Игры',
            14 => 'Видео',
            15 => 'Музыка',
            16 => 'Книги и СМИ',
        ];

        foreach ($questions as $question) {
            foreach ($types as $type) {
                $question->Title = str_replace(' «'.$type.'»', ' <strong>«'.$type.'»</strong>', $question->Title);
            }
            $question->save();
        }
        echo 'done';
    }

    public function actionIndex()
    {
        echo 'already done';
        return;
        $this->test = Test::model()->findByPk(8);

        $types = [
            1 => 'Веб-разработка и мобильная разработка',
            2 => 'Контекстная реклама/ Performance',
            3 => 'Медийная реклама /Display',
            4 => 'Видеореклама',
            5 => 'Маркетинг в социальных медиа (SMM)',
            6 => 'Поисковая оптимизация',
            7 => 'Программное обеспечение как услуга (SaaS)',
            8 => 'Хостинг',
            9 => 'Домены',
            10 => 'Ретейл',
            11 => 'Электронные платежи',
            12 => 'Туризм',
            13 => 'Игры',
            14 => 'Видео',
            15 => 'Музыка',
            16 => 'Книги и СМИ',
        ];

        foreach ($types as $id => $market) {
            $this->createQuestions($id, $market);
        }


        echo 'done';

    }

    private function createQuestions($id, $market)
    {
        /**
         * B3
         */
        $title = sprintf('Является ли ваша компания участником рынка «%s»?', $market);
        $values = [
            new RadioValue('1', 'Да, является', false, 10),
            new RadioValue('2', 'Нет, не является', false, 20)
        ];
        $b3 = $this->createQuestion(2, 'B3_'.$id, $title, $values);

        /**
         * B4
         */
        $title = sprintf('Готовы ли вы предоставить детальную информацию о своей компании ны рынке «%s» или же согласны дать оценку только по всему рынку?', $market);
        $subTitle = 'Мы гарантируем полную конфиденциальность собираемой информации по отдельным компаниям, она необходима для получения более точных обобщенных показателей по рынкам';
        $values = [
            new RadioValue('1', 'Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом', false, 10),
            new RadioValue('2', 'Готов(-а) ответить на вопросы только о рынке в целом', false, 20)
        ];
        $b4 = $this->createQuestion(2, 'B4_'.$id, $title, $values, $subTitle);


        /**
         * C1
         */
        $title = sprintf('Оцените, пожалуйста, общий оборот компаний на российском рынке «%s» в 2013 г.?', $market);
        $c1 = $this->createQuestion(3, 'C1_'.$id, $title);

        /**
         * C2
         */
        $title = sprintf('Какова общая динамика оборота компаний на российском рынке «%s» по итогам 2013 г. По сравнению с 2012 г.?', $market);
        $values = [
            new RadioValue('1', 'Увеличился на (%)', true, 10),
            new RadioValue('2', 'Остался без изменений', false, 20),
            new RadioValue('3', 'Уменьшился на (%)', true, 20)
        ];
        $c2 = $this->createQuestion(2, 'C2_'.$id, $title, $values);

        /**
         * C3
         */
        $title = sprintf('Какова, по вашему мнению, будет общая динамика оборота компаний на российском рынке «%s» по итогам 2014 г. По сравнению с 2013 г.?', $market);
        $values = [
            new RadioValue('1', 'Увеличится на (%)', true, 10),
            new RadioValue('2', 'Останется без изменений', false, 20),
            new RadioValue('3', 'Уменьшится на (%)', true, 20)
        ];
        $c3 = $this->createQuestion(2, 'C3_'.$id, $title, $values);

        /**
         * C3A
         */
        $title = 'Если вы хотите оставить комментарий к ответам на вопросы C1, C2 и/или C3, вы можете сделать это здесь.';
        $c3a = $this->createQuestion(3, 'C3A_'.$id, $title);

        /**
         * C4
         */
        $title = sprintf('Назовите примерное количество компаний на российском рынке «%s».', $market);
        $c4 = $this->createQuestion(3, 'C4_'.$id, $title);

        /**
         * C5
         */
        $title = sprintf('Назовите примерный штат средней компании на российском рынке «%s», включая специалистов, административный и технический персонал (штатных единиц).', $market);
        $c5 = $this->createQuestion(3, 'C5_'.$id, $title);

        /**
         * C6
         */
        $title = sprintf('Сколько всего человек занято на российском рынке «%s», включая штатных и внештатных работников?', $market);
        $c6 = $this->createQuestion(3, 'C6_'.$id, $title);

        /**
         * C6A
         */
        $title = 'Если вы хотите оставить комментарий к ответам на вопросы С4, С5 и/или С6, вы можете сделать это здесь.';
        $c6a = $this->createQuestion(3, 'C6A_'.$id, $title);

        /**
         * C7
         */
        $title = sprintf('Назовите тройку компаний-лидеров российского рынка «%s» на 2013 г.', $market);
        $c7 = $this->createQuestion(1, 'C7_'.$id, $title);

        /**
         * C8
         */
        if (in_array($id, [1, 2, 3, 5, 7, 8, 10, 11, 12])) {
            $title = sprintf('Если принять оборот всех компаний на российском рынке «%s» по итогам 2012 г. за 100%%, каким образом он распределился между следующими сегментами?', $market);
            $c8 = $this->createQuestion(1, 'C8_'.$id, $title);
        }

        /**
         * C9
         */
        $title = sprintf('Оцените, пожалуйста, оборот вашей компании на российском рынке «%s» в 2013 г.', $market);
        $c9 = $this->createQuestion(3, 'C9_'.$id, $title);

        /**
         * C10
         */
        $title = sprintf('Какова, по вашему мнению, будет динамика оборота вашей компании на российском рынке «%s» по итогам 2014 г. по сравнению с 2013 г.?', $market);
        $values = [
            new RadioValue('1', 'Увеличится на (%)', true, 10),
            new RadioValue('2', 'Останется без изменений', false, 20),
            new RadioValue('3', 'Уменьшится на (%)', true, 20)
        ];
        $c10 = $this->createQuestion(2, 'C10_'.$id, $title, $values);

        /**
         * C10A
         */
        $title = 'Если вы хотите оставить комментарий к ответам на вопросы С7, С8, С9 и/или С10, вы можете сделать это здесь.';
        $c10a = $this->createQuestion(3, 'C10A_'.$id, $title);


        $b3->NextQuestionId = $b4->Id;
        $b3->save();

        $b4->PrevQuestionId = $b3->Id;
        $b4->NextQuestionId = $c1->Id;
        $b4->save();

        $c1->PrevQuestionId = $b4->Id;
        $c1->NextQuestionId = $c2->Id;
        $c1->save();

        $c2->PrevQuestionId = $c1->Id;
        $c2->NextQuestionId = $c3->Id;
        $c2->save();

        $c3->PrevQuestionId = $c2->Id;
        $c3->NextQuestionId = $c3a->Id;
        $c3->save();

        $c3a->PrevQuestionId = $c3->Id;
        $c3a->NextQuestionId = $c4->Id;
        $c3a->save();

        $c4->PrevQuestionId = $c3a->Id;
        $c4->NextQuestionId = $c5->Id;
        $c4->save();

        $c5->PrevQuestionId = $c4->Id;
        $c5->NextQuestionId = $c6->Id;
        $c5->save();

        $c6->PrevQuestionId = $c5->Id;
        $c6->NextQuestionId = $c6a->Id;
        $c6->save();

        $c6a->PrevQuestionId = $c6->Id;
        $c6a->NextQuestionId = $c7->Id;
        $c6a->save();

        $c7->PrevQuestionId = $c6a->Id;

        if (isset($c8)) {
            $c7->NextQuestionId = $c8->Id;
            $c8->PrevQuestionId = $c7->Id;
            $c8->save();
        }
        $c7->save();


        $c9->NextQuestionId = $c10->Id;
        $c9->save();

        $c10->PrevQuestionId = $c9->Id;
        $c10->NextQuestionId = $c10a->Id;
        $c10->save();

        $c10a->PrevQuestionId = $c10->Id;
        $c10a->save();
    }

    private function createQuestion($typeId, $code, $title, $values = [], $subTitle = '')
    {
        $question = new \competence\models\Question();
        $question->TestId = $this->test->Id;
        $question->TypeId = $typeId;
        $question->Code = $code;
        $question->Sort = $this->getSort();
        $question->Title = $title;
        $question->SubTitle = $subTitle;

        if (!empty($values)) {
            $question->setFormData(['Values' => $values]);
        }
        $question->Test = $this->test;
        $question->save();

        return $question;
    }

    private $sort = 110;

    private function getSort()
    {
        $this->sort = $this->sort+10;
        return $this->sort;
    }
} 