<?php
use application\components\console\BaseConsoleCommand;
use event\models\section\Hall;
use event\models\section\LinkHall;
use event\models\section\LinkUser;
use event\models\section\Section;

/**
 * Class EventSectionCommand contains actions that helps with event's sections
 */
class EventSectionCommand extends BaseConsoleCommand
{
    /**
     * Copies section with $id and inserts for the event with $targetEventId
     *
     * @param int $id Section identifier
     * @param int $targetEventId Target event identifier
     * @throws Exception
     */
    public function actionCopy($id, $targetEventId)
    {
        if (!$section = Section::model()->findByPk($id)) {
            throw new Exception("Section with $id is not found");
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            /** @var Section $newSection */
            $newSection = $section->copy(['EventId' => $targetEventId]);

            foreach ($section->Attributes as $attr) {
                $attr->copy(['SectionId' => $newSection->Id]);
            }

            $halls = Hall::model()->findAll('"EventId" = :eventId', [
                ':eventId' => $section->EventId
            ]);
            foreach ($halls as $hall) {
                $hallExists = Hall::model()->exists('"EventId" = :eventId AND "Title" = :name', [
                    ':eventId' => $targetEventId,
                    ':name' => $hall->Title
                ]);

                if ($hallExists) {
                    continue;
                }

                /** @var Hall $newHall */
                $newHall = $hall->copy(['EventId' => $targetEventId]);

                $link = new LinkHall();
                $link->SectionId = $newSection->Id;
                $link->HallId = $newHall->Id;
                $link->save();
            }

            $linkUsers = LinkUser::model()->findAll('"SectionId" = :sectionId', [
                ':sectionId' => $section->Id
            ]);
            foreach ($linkUsers as $link) {
                $link->copy(['SectionId' => $newSection->Id]);
            }

            $transaction->commit();

            echo "Section was copied successfully!\n";
        } catch (CDbException $e) {
            $transaction->rollback();
            echo $e->getMessage() . "\n";
        }
    }
}
