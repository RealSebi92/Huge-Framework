<!-- Form zum Hochladen von Bildern -->
<form action="<?php echo Config::get('URL'); ?>gallery/upload" method="post" enctype="multipart/form-data">
    <input type="file" name="datei" required>
    <button type="submit">Hochladen</button>
</form>

<h1>Meine Galerie</h1>

<?php if (!empty($this->images)) { ?>

    <?php foreach ($this->images as $image) { ?>

        <div style="margin-bottom: 20px;">

            <img src="<?php echo Config::get('URL'); ?>gallery/show/<?php echo $image->id; ?>"
                alt="<?php echo htmlspecialchars($image->name); ?>"
                class="gallery-thumb"
                onclick="openFullscreen(this.src)">

            <strong><?php echo htmlspecialchars($image->name); ?></strong><br>
            Größe: <?php echo $image->size; ?> Bytes<br>
            Downloads: <?php echo $image->downloads; ?><br>

            <br>

           <?php if ($image->Shared == 1 && !empty($image->share_hash)) { ?>

                <a href="<?php echo Config::get('URL'); ?>gallery/unshare/<?php echo $image->id; ?>">
                Freigabe entfernen
                </a>
                <br>

                <input type="text"
                    value="<?php echo Config::get('URL') . 'gallery/public/' . $image->share_hash; ?>"
                    readonly
                    style="width: 500px;">

            <?php } else { ?>

            <a href="<?php echo Config::get('URL'); ?>gallery/share/<?php echo $image->id; ?>">
                Freigeben
            </a>

            <?php } ?>  

            <br><br>
            <a href="<?php echo Config::get('URL'); ?>gallery/download/<?php echo $image->id; ?>">
            Download
            </a>
            <br>
            

            <a href="<?php echo Config::get('URL'); ?>gallery/delete/<?php echo $image->id; ?>"
               onclick="return confirm('Bild wirklich löschen?');">
                Löschen
            </a>



        </div>

        <hr>

    <?php } ?>

<?php } else { ?>

    <p>Noch keine Bilder hochgeladen.</p>

<?php } ?>

<div id="fullscreenOverlay" onclick="closeFullscreen()">
    <span id="closeFullscreen">&times;</span>
    <img id="fullscreenImage">
</div>

<style>
.gallery-thumb {
    max-width: 250px;
    max-height: 250px;
    height: auto;
    cursor: pointer;
}

#fullscreenOverlay {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.9);
    justify-content: center;
    align-items: center;
}

#fullscreenImage {
    max-width: 95vw;
    max-height: 95vh;
    width: auto;
    height: auto;
}

#closeFullscreen {
    position: fixed;
    top: 20px;
    right: 35px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}
</style>

<script>
function openFullscreen(src) {
    document.getElementById('fullscreenImage').src = src;
    document.getElementById('fullscreenOverlay').style.display = 'flex';
}

function closeFullscreen() {
    document.getElementById('fullscreenOverlay').style.display = 'none';
}
</script>