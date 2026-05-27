<?php $users = isset($this->users) ? $this->users : array(); ?> <!-- holt die User die der Controller an die View weiter gibt -->

<div class="container">

    <h1>Messenger</h1>

    <div class="box">
        <h2>User auswählen</h2>

        <!-- prüfen ob user vorhanden sind -->
        <?php if (!empty($users)) { ?>
        
        <ul>
            <!-- geht jeden User aus der User-Liste einzeln durch -->
            <?php foreach($users as $user) { ?>
            <li>
                <!-- öffnet später den chat (muss noch implementiert werden) -->
                <a href="<?php echo Config::get('URL'); ?>messenger/chat/<?php echo $user->user_id; ?>">
                    <!-- gibt den username aus -->
                    <?php echo htmlentities($user->user_name); ?>
                </a>
            </li>
        <?php } ?>
        </ul>
    <?php } else { ?>
        <!-- wird angezeigt wenn es keine user gibt -->
        <p>Keine anderen Benutzer gefunden</p>
    <?php } ?>
    </div>
</div>