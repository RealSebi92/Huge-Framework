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
                <!-- öffnet  den chat -->
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

<?php
$groups = MessengerModel::getUserGroups(Session::get('user_id'));
?>

<h2>Gruppen</h2>

<?php if (!empty($groups)) { ?>
    <ul>
        <?php foreach ($groups as $group) { ?>
            <li>
                <a href="<?php echo Config::get('URL'); ?>messenger/groupChat/<?php echo $group->group_id; ?>">
                    <?php echo htmlspecialchars($group->group_name); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>Du bist in keiner Gruppe.</p>
<?php } ?>

<h2>Neue Gruppe erstellen</h2>

<form action="<?php echo Config::get('URL'); ?>messenger/createGroup" method="post">
    <input type="text" name="group_name" placeholder="Gruppenname">
    <button type="submit">Gruppe erstellen</button>
</form>