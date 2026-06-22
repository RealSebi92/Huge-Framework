<?php

class CalendarController extends Controller
{
    /**
     * Zeigt die Kalenderseite an.
     */
    public function index()
    {
        Auth::checkAuthentication();

        $user_id = Session::get('user_id');
        $training_days = CalendarModel::getTrainingDays($user_id,);

        $this->View->render('calendar/index', [
            'training_days' => $training_days
        ]);
    }

    /**
     * Speichert, ob am aktuellen Tag trainiert wurde.
     */
    public function saveStatus()
    {
        Auth::checkAuthentication();

        if (isset($_POST["status_speichern"])) {
            $user_id = Session::get('user_id');
            $training_date = date("Y-m-d");
            $trained = $_POST["trained"];

            CalendarModel::saveTrainingStatus($user_id, $training_date, $trained);
        }

        Redirect::to('calendar/index');
    }
}