<?php

class CalendarModel
{
    /**
    * Speichert den Trainingsstatus eines Tages.
    */
    public static function saveTrainingStatus($user_id, $training_date, $trained)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO training_status (user_id, training_date, trained)
                VALUES (:user_id, :training_date, :trained)
                ON DUPLICATE KEY UPDATE trained = VALUES(trained)";

        $query = $database->prepare($sql);

        return $query->execute([
            ':user_id' => $user_id,
            ':training_date' => $training_date,
            ':trained' => $trained
        ]);
    }

    /**
    * Holt alle Trainingstage eines Benutzers.
    */
    public static function getTrainingDays($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT training_date
                FROM training_status
                WHERE user_id = :user_id
                AND trained = 1";

        $query = $database->prepare($sql);

        $query->execute([
            ':user_id' => $user_id
        ]);

        return $query->fetchAll();
    }
}