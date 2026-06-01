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

//Start of Groupchat Code

    public static function createGroup($group_name, $created_by)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO group_chats (group_name, created_by)
            VALUES (:group_name, :created_by)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_name' => $group_name,
            ':created_by' => $created_by
        ));

        return $database->lastInsertId();
    }

    public static function addUserToGroup($group_id, $user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT IGNORE INTO group_chat_members 
            (group_id, user_id)
            VALUES 
            (:group_id, :user_id)";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_id' => $group_id,
            ':user_id' => $user_id
        ));
    }

    public static function getUserGroups($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT gc.group_id, gc.group_name
            FROM group_chats gc
            INNER JOIN group_chat_members gcm
            ON gc.group_id = gcm.group_id
            WHERE gcm.user_id = :user_id
            ORDER BY gc.group_name ASC";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':user_id' => $user_id
        ));

        return $query->fetchAll();
    }

    public static function sendGroupMessage($group_id, $sender_user_id, $message_text)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO group_messages (group_id, sender_user_id, message_text)
            VALUES (:group_id, :sender_user_id, :message_text)";

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

        $sql = "SELECT gm.group_message_id,
                   gm.group_id,
                   gm.sender_user_id,
                   gm.message_text,
                   u.user_name
            FROM group_messages gm
            INNER JOIN users u
            ON gm.sender_user_id = u.user_id
            WHERE gm.group_id = :group_id
            ORDER BY gm.group_message_id ASC";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':group_id' => $group_id
        ));

        return $query->fetchAll();
    }

    public static function isUserInGroup($group_id, $user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT COUNT(*) AS count
            FROM group_chat_members
            WHERE group_id = :group_id
            AND user_id = :user_id";

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
        $sql = "SELECT user_id, user_name
            FROM users
            WHERE user_name = :user_name
            LIMIT 1";

        $query = $database->prepare($sql);

        $query->execute(array(
            ':user_name' => $user_name
        ));

        return $query->fetch();
    }
}