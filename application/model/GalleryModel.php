<?php

class GalleryModel
{
    public static function uploadImage()
    {
        //überprüfung ob beim upload etwas schief gegangen ist
        if ($_FILES['datei']['error'] !== UPLOAD_ERR_OK)
        {
            die('Upload fehlgeschlgen');
        }

        //überprüfung ob datei zu groß ist
        if ($_FILES['datei']['size'] > 5 * 1024 * 1024)
        {
            die('Datei zu groß');
        }

        //PHP klasse die echten Daten Typ aus Inhalt erkennt (Magic Bytes)
        //Erstellung eines Objekted das den MIME_TYPE erkennt
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        //finfo liest den inhalt und gibt z.B. soetwas zurück: 'image/jpeg'
        $mime = $finfo->file($_FILES['datei']['tmp_name']);

        //hier geben wir die erlaubten Datentypen, in diesem fall .jpeg, .png, .gif
        $allowed = [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        //Hier überprüfen wir dann ob der erkannte DatenTyp in der List ist, wenn nicht Upload abbrechen.
        if(!in_array($mime, $allowed))
        {
            die('Datentyp nicht erlaubt');
        }

        //User_id des aktuell angemeldeten users holen
        $user_id = Session::get('user_id');

        //Das Verzeichniss, in das das bild gespeichert wird.
        $upload_dir = dirname(dirname(__DIR__)) . '/userpictures/' . $user_id . '/';

        //erstellen des Verzeichnisses falls es dies noch nicht gibt. 0755 Sind rechte, true steht dafür das Zwischenverzeichnisse wie z.B. /userpictures/ erstellt werden.
        if(!is_dir($upload_dir))
        {
            mkdir($upload_dir, 0755, true);
        }

        //ersetzt alle nicht sicheren zeichen durch '_'
        $safe_name = preg_replace(
            '/[^a-zA-Z0-9._-]/',
            '_',
        basename($_FILES['datei']['name'])
);
    }
}