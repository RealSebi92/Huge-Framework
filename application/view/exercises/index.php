<h2>Übung erstellen</h2>

<form action="<?php echo Config::get('URL'); ?>exercise/create" method="post">

    <label for="name">Übungsname:</label><br>
    <input type="text" name="name" id="name" required><br><br>

    <label for="description">Beschreibung:</label><br>
    <textarea name="description" id="description"></textarea><br><br>

    <label for="muscle_group">Muskelgruppe:</label><br>
    <input type="text" name="muscle_group" id="muscle_group"><br><br>

    <button type="submit" name="exercise_erstellen">Übung erstellen</button>
</form>

<hr>

<h2>Öffentliche Übungen</h2>

<?php if (!empty($this->exercises)) { ?>
    <ul>
        <?php foreach ($this->exercises as $exercise) { ?>
            <li>
                <strong><?php echo htmlspecialchars($exercise->name); ?></strong>
                <?php if (!empty($exercise->muscle_group)) { ?>
                    - <?php echo htmlspecialchars($exercise->muscle_group); ?>
                <?php } ?>

                <?php if (!empty($exercise->description)) { ?>
                    <br>
                    <?php echo htmlspecialchars($exercise->description); ?>
                <?php } ?>
            </li>
            <br>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>Noch keine Übungen vorhanden.</p>
<?php } ?>