<?php
namespace event\components\tickets;

use event\models\Event;
use event\models\Participant;
use user\models\User;

class Ticket
{
    const VIEW_ALIAS = 'event.views.ticket';

    private $event;
    private $user;

    /**
     * @param Event $event
     * @param User $user
     */
    function __construct(Event $event, User $user)
    {
        $this->event = $event;
        $this->user = $user;
    }

    /** @var \mPDF|null */
    protected $pdf;

    /**
     * @return \mPDF
     */
    public function getPdf()
    {
        if ($this->pdf == null) {
            $this->createPdf();
        }
        return $this->pdf;
    }

    protected function createPdf()
    {
        $this->pdf = new \mPDF('', 'A4', 0, '', 5, 5, 5, 5);
        $this->pdf->WriteHTML($this->getHtml());
    }

    /**
     * @return array
     */
    protected function getViewParams()
    {
        $params = [
            'user' => $this->user,
            'event' => $this->event
        ];

        $participant = Participant::model()->byUserId($this->user->Id)->byEventId($this->event->Id);
        if (!empty($this->event->Parts)) {
            $params['participant'] = $participant->orderBy('"Part"."Order"')->with('Part')->findAll();
        } else {
            $params['participant'] = $participant->find();
        }
        return $params;
    }

    protected function getHtml()
    {
        $controller = new \CController('default', null);
        return $controller->renderPartial($this->getViewAlias(), $this->getViewParams(), true);
    }

    /**
     * @return string
     */
    private function getViewAlias()
    {
        $alias = static::VIEW_ALIAS.'.'.$this->event->IdName;
        $path = \Yii::getPathOfAlias($alias).'.php';
        return file_exists($path) ? $alias : static::VIEW_ALIAS.'.base';
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return \Yii::t('app', 'Билет участника {event}.pdf', ['{event}' => $this->event->Title]);
    }

    /**
     * Сохраняет pdf и возвращает его путь
     * @return string
     */
    public function save()
    {
        $name = $this->user->RunetId.'_'.$this->event->IdName.'.pdf';
        $path = \Yii::getPathOfAlias('application').'/../data/tickets/'.substr(md5($name), 0, 3);
        if (!file_exists($path)) {
            mkdir($path);
        }
        $path .= '/'.$name;
        $this->getPdf()->Output($path, 'F');
        return $path;
    }
}