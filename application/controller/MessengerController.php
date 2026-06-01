<?php
class MessengerController extends Controller{

    public function __construct(){
        parent::__construct();

        Auth::checkAuthentication(); //nur für eingeloggde user
    }

    public function index(){
        $current_user_id = Session::get('user_id'); //damit der User selbst nicht angezeigt wird brauchen wir seine user id

        $users = MessengerModel::getAllUsersExceptMe($current_user_id); //holt alle user aus der db außer aktuell eingeloggeden user

        $this->View->render('messenger/index', array('users' => $users)); // View bekommt user liste und kann diese dann anzeigen
    }

    public function chat($partner_user_id)
    {
        $current_user_id = Session::get('user_id');

        MessengerModel::markMessagesAsRead($current_user_id, $partner_user_id);

        $messages = MessengerModel::getMessagesBetweenUsers($current_user_id, $partner_user_id);

        $partner = MessengerModel::getUserById($partner_user_id);

        $this->View->render('messenger/chat', array(
            'messages' => $messages,
            'partner' => $partner,
            'current_user_id' => $current_user_id
        ));
    }
    public function sendMessage(){
        $sender_user_id = Session::get('user_id');
        $receiver_user_id = Request::post('receiver_user_id');
        $message_text = Request::post('message_text');

        if (!empty($receiver_user_id) && !empty($message_text)) {
        MessengerModel::sendMessage($sender_user_id, $receiver_user_id, $message_text);
        }

        Redirect::to('messenger/chat/' . $receiver_user_id);
    }

//Start von Groupchat Code

    public function createGroup()
    {
        $current_user_id = Session::get('user_id');
        $group_name = Request::post('group_name');

        if (!empty($group_name)) {
            $group_id = MessengerModel::createGroup($group_name, $current_user_id);

            // Ersteller wird automatisch Mitglied der Gruppe
            MessengerModel::addUserToGroup($group_id, $current_user_id);
        }

        Redirect::to('messenger/index');
    }

   public function addUserToGroup()
    {
        $group_id = Request::post('group_id');
        $user_name = Request::post('user_name');

        if (!empty($group_id) && !empty($user_name)) {
            $user = MessengerModel::getUserByUsername($user_name);

            if ($user) {
                MessengerModel::addUserToGroup($group_id, $user->user_id);
            }
        }

        Redirect::to('messenger/groupChat/' . $group_id);
    }

    public function groupChat($group_id)
    {
        $current_user_id = Session::get('user_id');

        // Sicherheitsprüfung: User darf Gruppe nur sehen, wenn er Mitglied ist
        if (!MessengerModel::isUserInGroup($group_id, $current_user_id)) {
            Redirect::to('messenger/index');
        }

        $messages = MessengerModel::getGroupMessages($group_id);

        $this->View->render('messenger/group_chat', array(
            'messages' => $messages,
            'group_id' => $group_id,
            'current_user_id' => $current_user_id
        ));
    }

    public function sendGroupMessage()
    {
        $current_user_id = Session::get('user_id');
        $group_id = Request::post('group_id');
        $message_text = Request::post('message_text');

        if (!empty($group_id) && !empty($message_text)) {
            if (MessengerModel::isUserInGroup($group_id, $current_user_id)) {
                MessengerModel::sendGroupMessage($group_id, $current_user_id, $message_text);
            }
        }

        Redirect::to('messenger/groupChat/' . $group_id);
    }

}
