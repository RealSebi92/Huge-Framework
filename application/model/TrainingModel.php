<?php

class Training
{
    /**
     * Erstellt eine neue Trainingseinheit für einen Benutzer.
     */
    public static function createTraining($user_id, $title, $training_date)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO trainings (user_id, title, training_date)
                VALUES (:user_id, :title, :training_date)";

        $query = $database->prepare($sql);

        return $query->execute([
            ':user_id' => $user_id,
            ':title' => $title,
            ':training_date' => $training_date
        ]);
    }

}




?>