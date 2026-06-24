<h2>Öffentliche Übungen</h2>

<a href="<?php echo Config::get('URL'); ?>exercise/createPage"
   style="
        display:inline-block;
        padding:10px 15px;
        background:#4CAF50;
        color:white;
        text-decoration:none;
        border-radius:5px;
        margin-bottom:20px;
   ">
    + Übung erstellen
</a>

<hr>

<?php if (!empty($this->exercises)) { ?>

    <?php foreach ($this->exercises as $exercise) { ?>

        <div style="
            border:1px solid #ccc;
            border-radius:10px;
            padding:20px;
            margin-bottom:25px;
            background:#f9f9f9;
        ">

            <h3>
                <?php echo htmlspecialchars($exercise->name); ?>

                |

                <a href="<?php echo Config::get('URL'); ?>exercise/delete/<?php echo $exercise->id; ?>"
                   style="color:red; text-decoration:none;">
                    Löschen
                </a>

                |

                <details style="display:inline;">
                    <summary style="
                        display:inline;
                        cursor:pointer;
                        color:blue;
                        text-decoration:underline;
                    ">
                        Bearbeiten
                    </summary>

                    <br><br>

                    <form action="<?php echo Config::get('URL'); ?>exercise/update" method="post">

                        <input type="hidden"
                               name="id"
                               value="<?php echo $exercise->id; ?>">

                        <label>Übungsname:</label><br>

                        <input type="text"
                               name="name"
                               value="<?php echo htmlspecialchars($exercise->name); ?>"
                               style="width:250px;">

                        <br><br>

                        <label>Beschreibung:</label><br>

                        <textarea name="description"
                                  style="width:250px; height:80px;"><?php echo htmlspecialchars($exercise->description); ?></textarea>

                        <br><br>

                        <label>Muskelgruppe:</label><br>

                        <input type="text"
                               name="muscle_group"
                               value="<?php echo htmlspecialchars($exercise->muscle_group); ?>"
                               style="width:250px;">

                        <br><br>

                        <button type="submit"
                                name="exercise_bearbeiten">
                            Speichern
                        </button>

                    </form>

                </details>

            </h3>

            <p>
                <strong>Muskelgruppe:</strong>
                <?php echo htmlspecialchars($exercise->muscle_group); ?>
            </p>

            <p>
                <strong>Beschreibung:</strong><br>
                <?php echo nl2br(htmlspecialchars($exercise->description)); ?>
            </p>

        </div>

    <?php } ?>

<?php } else { ?>

    <p>Keine Übungen vorhanden.</p>

<?php } ?>