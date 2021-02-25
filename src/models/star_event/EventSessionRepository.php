<?php


namespace app\models\star_event;


use app\DB;


class EventSessionRepository
{

    public function save(StarEvent $starEvent): int
    {
        $db = DB::getInstance();
        DB::setCharsetEncoding();

        $sql = 'INSERT INTO test.star_event_registrations (name, email, town_fk, event_session, comment) 
                VALUES (:name, :email, :town_fk, :event_session, :comment);';

        $stmt = $db->prepare($sql);

        $name = $starEvent->getName();
        $stmt->bindParam(':name', $name);

        $email = $starEvent->getEmail();
        $stmt->bindParam(':email', $email);

        $town = $starEvent->getTown()->getId();
        $stmt->bindParam(':town_fk', $town);

        $eventSession = $starEvent->getEventSession()->getDateTime()->getTimestamp();
        $stmt->bindParam(':event_session', $eventSession);

        $comment = $starEvent->getComment();
        $stmt->bindParam(':comment', $comment);

        return $stmt->execute();
    }
}
