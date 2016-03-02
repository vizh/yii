<?php
namespace application\components\web;

/**
 * Class PgDbHttpSession Implementation of the database session storage for the PostgreSQL
 */
class PgDbHttpSession extends \CDbHttpSession
{
    /**
     * Adds a regeneration session identifier ability
     * @inheritdoc
     */
    public function open()
    {
        parent::open();

        if (session_id() === '') {
            session_regenerate_id(true);
        }
    }

    /**
     * Escapes data for the session
     * @inheritdoc
     */
    public function writeSession($id, $data)
    {
        $data = str_replace('\\', '\\\\', $data);

        return parent::writeSession($id, $data);
    }
}
