<h2>Kalender</h2>

<div style="border:1px solid #ccc; border-radius:10px; padding:20px; margin-bottom:25px; background:#f9f9f9;">

    <form action="<?php echo Config::get('URL'); ?>calendar/saveStatus" method="post">

        <label>Hast du heute trainiert?</label><br>
        <select name="trained" style="width:180px; padding:5px;">
            <option value="1">Ja</option>
            <option value="0">Nein</option>
        </select>

        <br><br>

        <label>Welches Training?</label><br>
        <select name="training_id" style="width:180px; padding:5px;">
            <?php foreach ($this->trainings as $training) { ?>
                <option value="<?php echo $training->id; ?>">
                    <?php echo htmlspecialchars($training->title); ?>
                </option>
            <?php } ?>
        </select>

        <br><br>

        <button type="submit" name="status_speichern" style="padding:8px 12px;">
            Speichern
        </button>

    </form>

</div>

<?php
$monate = [
    1 => 'Jänner', 2 => 'Februar', 3 => 'März', 4 => 'April',
    5 => 'Mai', 6 => 'Juni', 7 => 'Juli', 8 => 'August',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Dezember'
];

$training_dates = [];

if (!empty($this->training_days)) {
    foreach ($this->training_days as $day) {
        $training_dates[$day->training_date] = $day->title ?? 'Training';
    }
}

$year = date("Y");
$month = date("m");
$days_in_month = date("t");
$aktueller_monat = $monate[(int)$month];
?>

<h2>Trainingstage im <?php echo $aktueller_monat; ?></h2>

<div style="display:grid; grid-template-columns:repeat(7, 110px); gap:10px; margin-top:20px;">

    <?php for ($day = 1; $day <= $days_in_month; $day++) { ?>

        <?php
        $date = $year . "-" . $month . "-" . str_pad($day, 2, "0", STR_PAD_LEFT);
        $trained = array_key_exists($date, $training_dates);
        ?>

        <div style="
            padding:15px;
            border:1px solid #ccc;
            border-radius:8px;
            text-align:center;
            min-height:90px;
            background-color: <?php echo $trained ? '#8fd19e' : '#f2f2f2'; ?>;
        ">
            <strong><?php echo $day; ?></strong>

            <?php if ($trained) { ?>
                <br><br>
                ✓
                <br>
                <small><?php echo htmlspecialchars($training_dates[$date]); ?></small>
            <?php } ?>
        </div>

    <?php } ?>

</div>