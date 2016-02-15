<?php
namespace event\components\handlers\register;

/**
 * Class Rigf16 Custom configuration for the register notification mail
 */
class Rigf16 extends Base
{
    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'rigf@cctld.ru';
    }
}
