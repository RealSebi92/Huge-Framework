<?php
$messages = isset($this->messages) ? $this->messages : array();
$partner = isset($this->partner) ? $this->partner : null;
$current_user_id = isset($this->current_user_id) ? $this->current_user_id : null;
?>

<div class="container">

    <h1>Messenger</h1>

    <div class="box">

        <?php if ($partner) { ?>
            <h2>Chat mit <?php echo htmlentities($partner->user_name); ?></h2>
        <?php } else { ?>
            <h2>Chat</h2>
        <?php } ?>

        <p>
            <a href="<?php echo Config::get('URL'); ?>messenger/index">Zurück zur Userliste</a>
        </p>

        <hr>

        <?php if (!empty($messages)) { ?>

            <?php foreach ($messages as $message) { ?>

                <?php if ($message->sender_user_id == $current_user_id) { ?>

                    <div style="text-align: right; margin: 10px;">
                        <strong>Ich:</strong>
                        <?php echo htmlentities($message->message_text); ?>
                    </div>

                <?php } else { ?>

                    <div style="text-align: left; margin: 10px;">
                        <strong><?php echo htmlentities($partner->user_name); ?>:</strong>
                        <?php echo htmlentities($message->message_text); ?>
                    </div>

                <?php } ?>

            <?php } ?>

        <?php } else { ?>

            <p>Noch keine Nachrichten mit diesem User.</p>

        <?php } ?>

        <hr>

<form action="<?php echo Config::get('URL'); ?>messenger/sendMessage" method="post">
    <input type="hidden" name="receiver_user_id" value="<?php echo $partner->user_id; ?>">

    <textarea name="message_text" rows="3" style="width: 100%;" placeholder="Nachricht schreiben..."></textarea>

    <br><br>

    <button type="submit">Senden</button>
</form>

    </div>
</div>