<h2>Kalender</h2>

<form action="<?php echo Config::get('URL'); ?>calendar/saveStatus" method="post">
    <label>Hast du heute trainiert?</label><br><br>

    <select name="trained">
        <option value="1">Ja</option>
        <option value="0">Nein</option>
    </select>

    <br><br>

    <button type="submit" name="status_speichern">Speichern</button>
</form>

<hr>

<h2>Trainingstage im aktuellen Monat</h2>

<?php
$training_dates = [];

if (!empty($this->training_days)) {
    foreach ($this->training_days as $day) {
        $training_dates[] = $day->training_date;
    }
}

$year = date("Y");
$month = date("m");
$days_in_month = date("t");
?>

<div style="display: grid; grid-template-columns: repeat(7, 80px); gap: 8px; margin-top: 20px;">

    <?php for ($day = 1; $day <= $days_in_month; $day++) { ?>

        <?php
        $date = $year . "-" . $month . "-" . str_pad($day, 2, "0", STR_PAD_LEFT);
        $trained = in_array($date, $training_dates);
        ?>

        <div style="
            padding: 15px;
            text-align: center;
            border: 1px solid #999;
            background-color: <?php echo $trained ? '#8fd19e' : '#f2f2f2'; ?>;
            font-weight: <?php echo $trained ? 'bold' : 'normal'; ?>;
        ">
            <?php echo $day; ?>

            <?php if ($trained) { ?>
                <br>
                ✓
            <?php } ?>
        </div>

    <?php } ?>

</div>