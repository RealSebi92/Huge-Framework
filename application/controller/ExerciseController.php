<?php

class ExerciseController extends Controller
{

    public function index()
    {
        Auth::checkAuthentication();

        $exercises = ExerciseModel::getAllExercises();

        $this->View->render('exercises/index', ['exercises' => $exercises]);
    }

    public function create()
    {
        Auth::checkAuthentication();

        if (isset($_POST["exercise_erstellen"])) {
            $name = $_POST["name"];
            $description = $_POST["description"];
            $muscle_group = $_POST["muscle_group"];
            $created_by = Session::get('user_id');

            ExerciseModel::createExercise($name, $description, $muscle_group, $created_by);
        }

        Redirect::to('exercise/index');
    }

    /**
    * Zeigt die Seite zum Erstellen einer Übung.
    */
    public function createPage()
    {
        Auth::checkAuthentication();

        $this->View->render('exercises/create');
    }

    public function update()
    {
        Auth::checkAuthentication();

        if (isset($_POST["exercise_bearbeiten"])) {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $description = $_POST["description"];
            $muscle_group = $_POST["muscle_group"];

            ExerciseModel::updateExercise($id, $name, $description, $muscle_group);
        }

        Redirect::to('exercise/index');
    }

    public function delete($id)
    {
        Auth::checkAuthentication();

        ExerciseModel::deleteExercise($id);

        Redirect::to('exercise/index');
    }
}