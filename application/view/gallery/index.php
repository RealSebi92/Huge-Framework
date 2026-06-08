<!-- Form zum Hochladen von Bildern -->

<form action="<?php echo Config::get('URL'); ?>gallery/upload" method="post" enctype="multipart/form-data">
    <input type="file" name="datei" requierd>
    <button type="submit">Hochladen</button>
</form>