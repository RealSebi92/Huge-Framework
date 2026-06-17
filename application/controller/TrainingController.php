<?php

class TrainingController extends Controller
{
    public function index()
    {
        Auth::checkAuthentication();

        $user_id = Session::get('user_id');
        $trainings = TrainingModel::getTrainingsByUser($user_id);

        $this->View->render('training/index', [
            'trainings' => $trainings
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
}