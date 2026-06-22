<h2>Training erstellen</h2>

<form action="<?php echo Config::get('URL'); ?>training/create" method="post">
    <label for="title">Titel:</label><br>
    <input type="text" name="title" id="title" required><br><br>

    <label for="training_date">Datum:</label><br>
    <input type="date" name="training_date" id="training_date" required><br><br>

    <button type="submit" name="training_erstellen">Training erstellen</button>
</form>

<hr>

<h2>Übung zu Training hinzufügen</h2>

<form action="<?php echo Config::get('URL'); ?>training/addExercise" method="post">
    <label for="training_id">Training:</label><br>
    <select name="training_id" id="training_id" required>
        <?php foreach ($this->trainings as $training) { ?>
            <option value="<?php echo $training->id; ?>">
                <?php echo htmlspecialchars($training->title); ?> -
                <?php echo htmlspecialchars($training->training_date); ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label for="exercise_id">Übung:</label><br>
    <select name="exercise_id" id="exercise_id" required>
        <?php foreach ($this->exercises as $exercise) { ?>
            <option value="<?php echo $exercise->id; ?>">
                <?php echo htmlspecialchars($exercise->name); ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label for="sets">Sätze:</label><br>
    <input type="number" name="sets" id="sets" min="1"><br><br>

    <label for="reps">Wiederholungen:</label><br>
    <input type="number" name="reps" id="reps" min="1"><br><br>

    <label for="weight">Gewicht:</label><br>
    <input type="number" name="weight" id="weight" step="0.01" min="0"><br><br>

    <label for="pr">PR:</label><br>
    <input type="number" name="pr" id="pr" step="0.01" min="0"><br><br>

    <button type="submit" name="exercise_hinzufuegen">Übung hinzufügen</button>
</form>

<hr>

<h2>Meine Trainings</h2>

<?php if (!empty($this->trainings)) { ?>

    <?php foreach ($this->trainings as $training) { ?>

        <h3>
            <?php echo htmlspecialchars($training->title); ?> -
            <?php echo htmlspecialchars($training->training_date); ?>
        </h3>

        <?php $training_exercises = TrainingModel::getExercisesByTraining($training->id); ?>

        <?php if (!empty($training_exercises)) { ?>
            <ul>
                <?php foreach ($training_exercises as $exercise) { ?>
                    <li>
                        <strong><?php echo htmlspecialchars($exercise->name); ?></strong>
                        |
                        <?php echo htmlspecialchars($exercise->sets); ?> Sätze
                        |
                        <?php echo htmlspecialchars($exercise->reps); ?> Wdh
                        |
                        <?php echo htmlspecialchars($exercise->weight); ?> kg

                        <?php if (!empty($exercise->pr)) { ?>
                            |
                            PR: <?php echo htmlspecialchars($exercise->pr); ?> kg
                        <?php } ?>

                        |
                        <a href="<?php echo Config::get('URL'); ?>training/deleteExercise/<?php echo $exercise->id; ?>">
                            Löschen
                        </a>

                        |
                        <details style="display:inline;">
                            <summary style="display:inline; cursor:pointer; color:blue; text-decoration:underline;">
                                Bearbeiten
                            </summary>

                            <br><br>

                            <form action="<?php echo Config::get('URL'); ?>training/updateExercise" method="post">
                                <input type="hidden" name="id" value="<?php echo $exercise->id; ?>">

                                <label>Sätze:</label>
                                <input type="number" name="sets" value="<?php echo htmlspecialchars($exercise->sets); ?>" min="1">

                                <label>Wdh:</label>
                                <input type="number" name="reps" value="<?php echo htmlspecialchars($exercise->reps); ?>" min="1">

                                <label>Gewicht:</label>
                                <input type="number" name="weight" value="<?php echo htmlspecialchars($exercise->weight); ?>" step="0.01" min="0">

                                <label>PR:</label>
                                <input type="number" name="pr" value="<?php echo htmlspecialchars($exercise->pr); ?>" step="0.01" min="0">

                                <button type="submit" name="exercise_bearbeiten">Speichern</button>
                            </form>
                        </details>
                    </li>
                    <br>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>Keine Übungen vorhanden.</p>
        <?php } ?>

        <hr>

    <?php } ?>

<?php } else { ?>
    <p>Noch keine Trainings vorhanden.</p>
<?php } ?>