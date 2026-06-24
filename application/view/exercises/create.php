<h2>Übung erstellen</h2>

<div style="border:1px solid #ccc; border-radius:10px; padding:20px; margin-bottom:25px; background:#f9f9f9;">

    <form action="<?php echo Config::get('URL'); ?>exercise/create" method="post">

        <label for="name">Übungsname:</label><br>
        <input type="text" name="name" id="name" required style="width:250px;"><br><br>

        <label for="description">Beschreibung:</label><br>
        <textarea name="description" id="description" style="width:250px; height:80px;"></textarea><br><br>

        <label for="muscle_group">Muskelgruppe:</label><br>
        <input type="text" name="muscle_group" id="muscle_group" style="width:250px;"><br><br>

        <button type="submit" name="exercise_erstellen" style="padding:8px 12px;">
            Übung erstellen
        </button>

    </form>

</div>