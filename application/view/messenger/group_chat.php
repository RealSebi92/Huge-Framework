<?php
$messages = isset($this->messages) ? $this->messages : array();
$group_id = isset($this->group_id) ? $this->group_id : null;
$current_user_id = isset($this->current_user_id) ? $this->current_user_id : null;
?>

<div class="container">
    <h1>Gruppenchat</h1>

    <p>
        <a href="<?php echo Config::get('URL'); ?>messenger/index">Zurück zur Übersicht</a>
    </p>

    <hr>

    <?php if (!empty($messages)) { ?>

        <?php foreach ($messages as $message) { ?>

            <?php if ($message->sender_user_id == $current_user_id) { ?>

                <div style="text-align: right; margin: 10px;">
                    <?php echo htmlspecialchars($message->message_text); ?>
                </div>

            <?php } else { ?>

                <div style="text-align: left; margin: 10px;">
                    <strong><?php echo htmlspecialchars($message->user_name); ?>:</strong>
                    <?php echo htmlspecialchars($message->message_text); ?>
                </div>

            <?php } ?>

        <?php } ?>

    <?php } else { ?>

        <p>Noch keine Nachrichten in dieser Gruppe.</p>

    <?php } ?>

    <hr>

    <form action="<?php echo Config::get('URL'); ?>messenger/sendGroupMessage" method="post">
        <input type="hidden" name="group_id" value="<?php echo htmlspecialchars($group_id); ?>">

        <textarea name="message_text" rows="3" style="width: 100%;" placeholder="Nachricht schreiben..."></textarea>

        <br><br>

        <button type="submit">Senden</button>
    </form>

    <hr>

<h3>User zur Gruppe hinzufügen</h3>

<form action="<?php echo Config::get('URL'); ?>messenger/addUserToGroup" method="post">
    <input type="hidden" name="group_id" value="<?php echo htmlspecialchars($group_id); ?>">

    <input type="text" name="user_name" placeholder="Benutzername eingeben">

    <button type="submit">Hinzufügen</button>
</form>
</div>
