<h2>Training erstellen</h2>

<form action="<?php echo Config::get('URL'); ?>training/create" method="post">
    <label for="title">Titel:</label><br>
    <input type="text" name="title" id="title" required><br><br>

    <label for="training_date">Datum:</label><br>
    <input type="date" name="training_date" id="training_date" required><br><br>

    <button type="submit" name="training_erstellen">Training erstellen</button>
</form>

<h2>Meine Trainings</h2>

<?php if (!empty($this->trainings)) { ?>
    <ul>
        <?php foreach ($this->trainings as $training) { ?>
            <li>
                <?php echo htmlspecialchars($training->title); ?>
                -
                <?php echo htmlspecialchars($training->training_date); ?>
            </li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>Noch keine Trainings vorhanden.</p>
<?php } ?>