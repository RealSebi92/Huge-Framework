<?php

class ProfileController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method controls what happens when you move to /overview/index in your app.
     * Shows a list of all users.
     * Loads all users and accout types so their role names can be displayed
     */
    public function index()
    {
        $this->View->render('profile/index', array(
            'users' => UserModel::getPublicProfilesOfAllUsers(),
            'account_types' => UserModel::getAllAccountTypes())
        );
    }

    /**
     * This method controls what happens when you move to /overview/showProfile in your app.
     * Shows the (public) details of the selected user.
     * @param $user_id int id the the user
     */
    public function showProfile($user_id)
    {
        if (isset($user_id)) {
            $this->View->render('profile/showProfile', array(
                'user' => UserModel::getPublicProfileOfUser($user_id))
            );
        } else {
            Redirect::home();
        }
    }

    /**
     * Changes the Role of a selected user
     * Only for admins
     */
    public function changeUserRole(){
        if(Session::get('user_account_type') != 7){
            Redirect::to('profile/index');
        }

        UserModel::changeUserAccountType(Request::post('user_id'), Request::post('user_account_type'));

        Redirect::to('profile/index');
    }
}
