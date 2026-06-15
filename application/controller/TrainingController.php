<?php

class TrainingController extends Controller
{
    public function index()
    {
        Auth::checkAuthentication();

        $this->View->render('training/index');
    }

    /**
     * Erstellt neue Trainingseinheit
     */
    public function create()
    {
        Auth::checkAuthentication();

        if(isset($_POST["training_erstellen"]))
        {
            $user_id = Session::get('user_id');
            $title = $_POST('title');
            $traning_data = $_POST('training_date');

            Training::createTraining($user_id, $title, $traning_data);
        }

        Redirect::to('training/index');

    }

   
}


?>