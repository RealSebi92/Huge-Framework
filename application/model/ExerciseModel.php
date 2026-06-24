<?php

class ExerciseModel{
    
    public static function createexercise($name, $description, $muscle_group, $created_by)
    {

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO exercises (name, description, muscle_group, created_by)
                VALUES (:name, :description, :muscle_group, :created_by)";

        $query = $database->prepare($sql);

        return $query->execute([
            ':name' => $name,
            ':description' => $description,
            ':muscle_group' => $muscle_group,
            ':created_by' => $created_by
        ]);
    }

    public static function getAllExercises()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT id, name, description, muscle_group
                FROM exercises
                ORDER BY name ASC";

        $query = $database->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public static function updateExercise($id, $name, $description, $muscle_group)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE exercises
                SET name = :name,
                description = :description,
                muscle_group = :muscle_group
                WHERE id = :id";

        $query = $database->prepare($sql);

        return $query->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
            ':muscle_group' => $muscle_group
        ]);
    }

    public static function deleteExercise($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM exercises WHERE id = :id";

        $query = $database->prepare($sql);

        return $query->execute([
            ':id' => $id
        ]);
    }
}