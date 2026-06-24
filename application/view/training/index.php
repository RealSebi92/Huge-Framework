<h2>Meine Trainings</h2>

<a href="<?php echo Config::get('URL'); ?>training/createPage"
   style="
        display:inline-block;
        padding:10px 15px;
        background:#4CAF50;
        color:white;
        text-decoration:none;
        border-radius:5px;
        margin-bottom:20px;
   ">
    + Training erstellen
</a>

<hr>

<?php if (!empty($this->trainings)) { ?>

    <?php foreach ($this->trainings as $training) { ?>

        <div style="
            border:1px solid #ccc;
            border-radius:10px;
            padding:20px;
            margin-bottom:25px;
            background:#f9f9f9;
        ">

            <h3>
                <?php echo htmlspecialchars($training->title); ?> -
                <?php echo htmlspecialchars($training->training_date); ?>
                <a href="<?php echo Config::get('URL'); ?>training/delete/<?php echo $training->id; ?>">
                    Training löschen
                </a>
            </h3>

            <details style="margin-bottom:15px;">
                <summary style="cursor:pointer; color:blue; text-decoration:underline;">
                    Übung hinzufügen
                </summary>

                <br>

                <form action="<?php echo Config::get('URL'); ?>training/addExercise" method="post">
                    <input type="hidden" name="training_id" value="<?php echo $training->id; ?>">

                    <label>Übung:</label><br>
                    <select name="exercise_id" required style="width:250px;">
                        <?php foreach ($this->exercises as $exercise_option) { ?>
                            <option value="<?php echo $exercise_option->id; ?>">
                                <?php echo htmlspecialchars($exercise_option->name); ?>
                            </option>
                        <?php } ?>
                    </select><br><br>

                    <label>Sätze:</label><br>
                    <input type="number" name="sets" min="1" style="width:250px;"><br><br>

                    <label>Wiederholungen:</label><br>
                    <input type="number" name="reps" min="1" style="width:250px;"><br><br>

                    <label>Gewicht:</label><br>
                    <input type="number" name="weight" step="0.01" min="0" style="width:250px;"><br><br>

                    <label>PR:</label><br>
                    <input type="number" name="pr" step="0.01" min="0" style="width:250px;"><br><br>

                    <button type="submit" name="exercise_hinzufuegen">
                        Hinzufügen
                    </button>
                </form>
            </details>

            <?php $training_exercises = TrainingModel::getExercisesByTraining($training->id); ?>

            <?php if (!empty($training_exercises)) { ?>

                <ul>
                    <?php foreach ($training_exercises as $exercise) { ?>
                        <li style="margin-bottom:10px;">
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

                                    <button type="submit" name="exercise_bearbeiten">
                                        Speichern
                                    </button>
                                </form>
                            </details>
                        </li>
                    <?php } ?>
                </ul>

            <?php } else { ?>

                <p>Keine Übungen vorhanden.</p>

            <?php } ?>

        </div>

    <?php } ?>

<?php } else { ?>

    <p>Noch keine Trainings vorhanden.</p>

<?php } ?>