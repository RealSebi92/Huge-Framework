<?php

class MessengerModel
{
    /**
     * Holt alle User aus der DB, abgesehen vom angemeldeten User.
     */
    public static function getAllUsersExceptMe($current_user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, user_name 
                FROM users 
                WHERE user_id != :current_user_id 
                ORDER BY user_name ASC";

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

        $sql = "SELECT * 
                FROM message 
                WHERE 
                    (sender_user_id = :current_user_id AND receiver_user_id = :partner_user_id)
                    OR
                    (sender_user_id = :partner_user_id AND receiver_user_id = :current_user_id)
                ORDER BY message_id ASC";

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

        $sql = "SELECT user_id, user_name 
                FROM users 
                WHERE user_id = :user_id";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':user_id' => $user_id
        ));

        return $query->fetch();
    }

    public static function sendMessage($sender_user_id, $receiver_user_id, $message_text){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO message (sender_user_id, receiver_user_id, message_text, is_read) VALUES (:sender_user_id, :receiver_user_id, :message_text, 0)";

        $query = $database->prepare($sql);

        $query->execute(array(':sender_user_id' => $sender_user_id, ':receiver_user_id' => $receiver_user_id, ':message_text' => $message_text));
    }

   public static function markMessagesAsRead($current_user_id, $partner_user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE message
            SET is_read = 1
            WHERE receiver_user_id = :current_user_id
            AND sender_user_id = :partner_user_id
            AND is_read = 0";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':current_user_id' => $current_user_id,
            ':partner_user_id' => $partner_user_id
        ));
    }

    public static function getUnreadMessageCount($current_user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT COUNT(*) AS unread_count
            FROM message
            WHERE receiver_user_id = :current_user_id
            AND is_read = 0";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':current_user_id' => $current_user_id
        ));

        return $query->fetch()->unread_count;
}

}