<?php

class TrainingModel
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

    /**
    * Holt alle Trainingseinheiten eines Benutzers.
   *
    * @param int $user_id
    * @return array
    */
    public static function getTrainingsByUser($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT id, title, training_date, created_at
                FROM trainings
                WHERE user_id = :user_id
                ORDER BY training_date DESC";

        $query = $database->prepare($sql);
        $query->execute([
        ':user_id' => $user_id
        ]);

    return $query->fetchAll();
}

}




?>