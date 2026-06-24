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

    /**
    * Löscht ein Training eines Benutzers.
    */
    public static function deleteTraining($training_id, $user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM trainings
                WHERE id = :training_id
                AND user_id = :user_id";

        $query = $database->prepare($sql);

        return $query->execute([
            ':training_id' => $training_id,
            ':user_id' => $user_id
        ]);
    }

    /**
    * Fügt eine Übung zu einer Trainingseinheit hinzu.
    */
    public static function addExerciseToTraining($training_id, $exercise_id, $sets, $reps, $weight, $pr)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO training_exercises (training_id, exercise_id, sets, reps, weight, pr)
                VALUES (:training_id, :exercise_id, :sets, :reps, :weight, :pr)";

        $query = $database->prepare($sql);

        return $query->execute([
            ':training_id' => $training_id,
            ':exercise_id' => $exercise_id,
            ':sets' => $sets,
            ':reps' => $reps,
            ':weight' => $weight,
            ':pr' => $pr
        ]);
    }

    /**
    * Holt alle Übungen eines Trainings.
    */
    public static function getExercisesByTraining($training_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT 
                training_exercises.id,
                exercises.name,
                training_exercises.sets,
                training_exercises.reps,
                training_exercises.weight,
                training_exercises.pr
            FROM training_exercises
            INNER JOIN exercises
            ON training_exercises.exercise_id = exercises.id
            WHERE training_exercises.training_id = :training_id";

        $query = $database->prepare($sql);

        $query->execute([
            ':training_id' => $training_id
        ]);

        return $query->fetchAll();
    }

    /**
    * Löscht eine zugeordnete Übung aus einem Training.
    */
    public static function deleteTrainingExercise($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM training_exercises
                WHERE id = :id";

        $query = $database->prepare($sql);

        return $query->execute([
            ':id' => $id
        ]);
    }

    public static function updateTrainingExercise($id, $sets, $reps, $weight, $pr)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE training_exercises
                SET sets = :sets,
                    reps = :reps,
                weight = :weight,
                    pr = :pr
                WHERE id = :id";

        $query = $database->prepare($sql);

        return $query->execute([
            ':id' => $id,
            ':sets' => $sets,
            ':reps' => $reps,
            ':weight' => $weight,
            ':pr' => $pr
        ]);
    }

}




?>