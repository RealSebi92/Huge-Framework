<?php

class MessengerModel
{
    /**
     * Holt alle User aus der DB, abgesehen vom angemeldeten User.
     */
    public static function getAllUsersExceptMe($current_user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_get_users_except_me(:current_user_id)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':current_user_id' => $current_user_id
        ));

        return $query->fetchAll();
    }

    /**
     * Holt alle Nachrichten zwischen dem eingeloggten User und dem ausgewählten Chat-Partner.
     */
    public static function getMessagesBetweenUsers($current_user_id, $partner_user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_get_private_messages(:current_user_id, :partner_user_id)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':current_user_id' => $current_user_id,
            ':partner_user_id' => $partner_user_id
        ));

        return $query->fetchAll();
    }

    /**
     * Holt einen bestimmten User anhand seiner ID.
     */
    public static function getUserById($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_get_user_by_id(:user_id)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':user_id' => $user_id
        ));

        return $query->fetch();
    }

    public static function sendMessage($sender_user_id, $receiver_user_id, $message_text){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_send_private_message(:sender_user_id, :receiver_user_id, :message_text)";

        $query = $database->prepare($sql);

        $query->execute(array(':sender_user_id' => $sender_user_id, ':receiver_user_id' => $receiver_user_id, ':message_text' => $message_text));
    }

    public static function markMessagesAsRead($current_user_id, $partner_user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_mark_messages_as_read(:current_user_id, :partner_user_id)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':current_user_id' => $current_user_id,
            ':partner_user_id' => $partner_user_id
        ));
    }

    public static function getUnreadMessageCount($current_user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_get_unread_count(:current_user_id)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':current_user_id' => $current_user_id
        ));

        return $query->fetch()->unread_count;
    }

//Start of Groupchat Code

    public static function createGroup($group_name, $created_by)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_create_group(:group_name, :created_by)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_name' => $group_name,
            ':created_by' => $created_by
        ));

        return $query->fetch()->group_id;
    }

    public static function addUserToGroup($group_id, $user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_add_user_to_group(:group_id, :user_id)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_id' => $group_id,
            ':user_id' => $user_id
        ));
    }

    public static function getUserGroups($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_get_user_groups(:user_id)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':user_id' => $user_id
        ));

        return $query->fetchAll();
    }

    public static function sendGroupMessage($group_id, $sender_user_id, $message_text)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_send_group_message(:group_id, :sender_user_id, :message_text)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_id' => $group_id,
            ':sender_user_id' => $sender_user_id,
            ':message_text' => $message_text
        ));
    }

    public static function getGroupMessages($group_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_get_group_messages(:group_id)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_id' => $group_id
        ));

        return $query->fetchAll();
    }

    public static function isUserInGroup($group_id, $user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL sp_messenger_is_user_in_group(:group_id, :user_id)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_id' => $group_id,
            ':user_id' => $user_id
        ));

        return $query->fetch()->count > 0;
    }

    public static function getUserByUsername($user_name)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        // sucht einen User anhand seines Benutzernamens
        $sql = "CALL sp_messenger_get_user_by_username(:user_name)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':user_name' => $user_name
        ));

        return $query->fetch();
    }
}