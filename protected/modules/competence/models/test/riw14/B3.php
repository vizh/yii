<?php
namespace competence\models\test\riw14;

class B3 extends B1
{
    public function getQuestions()
    {
        return [
            1 => 'Удобство онлайн регистрации/аккредитации – через систему RUNET-ID',
            2 => 'Удобство регистрации на входе в Экспоцентр – через систему RUVENTS',
            3 => 'Пакет участника форума (бейдж, программа, журнал "Интернет в цифрах", материалы от партнеров)',
            4 => 'Работа тех.персонала в залах и на площадке'
        ];
    }

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.riw14.b1';
    }
}
