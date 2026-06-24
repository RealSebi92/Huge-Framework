<?php

class TrainingController extends Controller
{
    public function index()
    {
        Auth::checkAuthentication();

        $user_id = Session::get('user_id');
        $trainings = TrainingModel::getTrainingsByUser($user_id);
        $exercises = ExerciseModel::getAllExercises();

        $this->View->render('training/index', [
            'trainings' => $trainings,
            'exercises' => $exercises
        ]);
    }

    /**
     * Erstellt eine neue Trainingseinheit.
     */
    public function create()
    {
        Auth::checkAuthentication();

        if (isset($_POST["training_erstellen"])) {
            $user_id = Session::get('user_id');
            $title = $_POST["title"];
            $training_date = $_POST["training_date"];

            TrainingModel::createTraining($user_id, $title, $training_date);
        }

        Redirect::to('training/index');
    }

    /**
    * Löscht ein Training.
    */
    public function delete($training_id)
    {
        Auth::checkAuthentication();

        $user_id = Session::get('user_id');

        TrainingModel::deleteTraining($training_id, $user_id);

        Redirect::to('training/index');
    }

    /**
    * Fügt eine Übung zu einer Trainingseinheit hinzu.
    */
    public function addExercise()
    {
        Auth::checkAuthentication();

        if (isset($_POST["exercise_hinzufuegen"])) {
            $training_id = $_POST["training_id"];
            $exercise_id = $_POST["exercise_id"];
            $sets = $_POST["sets"];
            $reps = $_POST["reps"];
            $weight = $_POST["weight"];
            $pr = !empty($_POST["pr"]) ? $_POST["pr"] : null;

            TrainingModel::addExerciseToTraining($training_id, $exercise_id, $sets, $reps, $weight, $pr);
        }

        Redirect::to('training/index');
    }

    /**
    * Löscht eine Übung aus einer Trainingseinheit.
    */
    public function deleteExercise($id)
    {
        Auth::checkAuthentication();

        TrainingModel::deleteTrainingExercise($id);

        Redirect::to('training/index');
    }


    /**
    * Aktualisiert eine Übung innerhalb einer Trainingseinheit.
    */
    public function updateExercise()
    {
        Auth::checkAuthentication();

        if (isset($_POST["exercise_bearbeiten"])) {
            $id = $_POST["id"];
            $sets = $_POST["sets"];
            $reps = $_POST["reps"];
            $weight = $_POST["weight"];
            $pr = !empty($_POST["pr"]) ? $_POST["pr"] : null;

            TrainingModel::updateTrainingExercise($id, $sets, $reps, $weight, $pr);
        }

        Redirect::to('training/index');
    }

    /**
    * Zeigt die Seite zum Erstellen eines Trainings.
    */
    public function createPage()
    {
        Auth::checkAuthentication();

        $exercises = ExerciseModel::getAllExercises();
        $trainings = TrainingModel::getTrainingsByUser(Session::get('user_id'));

        $this->View->render('training/create', [
            'exercises' => $exercises,
            'trainings' => $trainings
        ]);
    }

}