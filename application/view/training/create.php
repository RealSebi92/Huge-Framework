<h2>Training erstellen</h2>

<div style="border:1px solid #ccc; border-radius:10px; padding:20px; margin-bottom:25px; background:#f9f9f9;">

    <form action="<?php echo Config::get('URL'); ?>training/create" method="post">

        <label for="title">Titel:</label><br>
        <input type="text" name="title" id="title" required style="width:250px;"><br><br>

        <label for="training_date">Datum:</label><br>
        <input type="date" name="training_date" id="training_date" required><br><br>

        <button type="submit" name="training_erstellen" style="padding:8px 12px;">
            Training erstellen
        </button>

    </form>

</div>