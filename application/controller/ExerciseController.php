<?php

class ExerciseController extends Controller
{

    public function index()
    {
        Auth::checkAdminAuthentication();

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
}