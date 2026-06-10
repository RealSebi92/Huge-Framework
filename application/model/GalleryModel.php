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

        //erzeugen eines Neuen Namens, damit datein mit selben namen nicht überschrieben werden
        $new_name = time() . '_' . $safe_name;

        //Zielpfad wird zusammen gebaut, User-Ordner und neuer Dateiname
        $target = $upload_dir . $new_name;

        //ist zuständig dafür, das es verschoben wird und wenn nicht unterbricht er die verbindung
        if (!move_uploaded_file($_FILES['datei']['tmp_name'], $target))
        {
            die('Datei konnte nicht gespeichert werden');
        }

        //DB verbindung aus Huge holen
        $database = DatabaseFactory::getFactory()->getConnection();

        //Bild bleibt local im Ordner, Nur infos, name, größe, owner kommt online
        $sql = "INSERT INTO files
                (name, size, downloads, OwnerID, Shared)
                VALUES
                (:name, :size, 0, :owner, 0)";

        $query = $database->prepare($sql);

        $query->execute([
            ':name' => $new_name,
            ':size' => $_FILES['datei']['size'],
            ':owner' => $user_id
            ]);
    }

        public static function getOwnImages()
    {
        //DB Verbindung von huge holen
        $database = DatabaseFactory::getFactory()->getConnection();

        //user_id aus der session holen
        $user_id = Session::get('user_id');

        //nur Bilder laden, die auch wirklich dem user gehören
        $sql = "SELECT id, name, size, downloads, OwnerID, Shared, share_hash
                FROM files
                WHERE OwnerID = :owner
                ORDER BY id DESC";

        
        $query = $database->prepare($sql);

        $query->execute([
            ':owner' => $user_id
        ]);

        //Gibt alle gefundenen bilder als array zurück
        return $query->fetchAll();
    }

    public static function deleteImage($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        $user_id = Session::get('user_id');

        $sql = "SELECT name
                FROM files
                WHERE id = :id
                AND OwnerID = :owner";

        $query = $database->prepare($sql);

        $query->execute([
            ':id' => $id,
            ':owner' => $user_id
        ]);

        $file = $query->fetch();

        if (!$file)
        {
            die('Datei nicht gefunden oder keine berechtigung');
        }

        $file_path = dirname(dirname(__DIR__)) . '/userpictures/' . $user_id . '/' . $file->name;

        if(file_exists($file_path))
        {
            unlink($file_path);
        }

        $sql = "DELETE FROM files
                WHERE id = :id
                AND OwnerID = :owner";

        $query = $database->prepare($sql);

        $query->execute([
            ':id' => $id,
            ':owner' => $user_id
        ]);
    }

    public static function showImage($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        $user_id = Session::get('user_id');

        $sql = "SELECT name
                FROM files
                WHERE id = :id
                AND OwnerID = :owner";

        $query = $database->prepare($sql);

        $query->execute([
            ':id' => $id,
            ':owner' => $user_id
        ]);

        $file = $query->fetch();

        if(!$file)
        {
            die('Datei nicht gefunden oder keine Berechtigung');
        }

        $file_path = dirname(dirname(__DIR__)) . '/userpictures/' . $user_id . '/' . $file->name;

        if(!file_exists($file_path))
        {
            die('Datei existiert nicht');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $mime = $finfo->file($file_path);

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($file_path));

        readfile($file_path);
        exit;
    }

    public static function downloadImage($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $user_id = Session::get('user_id');

        $sql = "SELECT name, downloads
                FROM files
                WHERE id = :id
                AND OwnerID = :owner";

        $query = $database->prepare($sql);

        $query->execute([
            ':id' => $id,
            ':owner' => $user_id
        ]);

        $file = $query->fetch();

        if (!$file)
        {
            die('Datei nicht gefunden oder keine Berechtigung');
        }

        $file_path = dirname(dirname(__DIR__)) . '/userpictures/' . $user_id . '/' . $file->name;

        if (!file_exists($file_path))
        {
            die('Datei existiert nicht');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file_path);

        $sql = "UPDATE files
                SET downloads = downloads + 1
                WHERE id = :id
                AND OwnerID = :owner";

        $query = $database->prepare($sql);

        $query->execute([
            ':id' => $id,
            ':owner' => $user_id
        ]);

        // HTTP Header senden
        header('Content-Type: ' . $mime);

        // attachment = Datei herunterladen statt anzeigen
        header('Content-Disposition: attachment; filename="' . $file->name . '"');

        header('Content-Length: ' . filesize($file_path));

        // Datei ausgeben
        readfile($file_path);

        exit;
    }

    public static function shareImage($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $user_id = Session::get('user_id');

        $hash = bin2hex(random_bytes(32));

        $sql = "UPDATE files
                SET Shared = 1,
                share_hash = :hash
                WHERE id = :id
                AND OwnerID = :owner";

        $query = $database->prepare($sql);

        $query->execute([
            ':hash' => $hash,
            ':id' => $id,
            ':owner' => $user_id
        ]);

    }

    public static function showSharedImage($hash)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT name, OwnerID
                FROM files
                WHERE share_hash = :hash
                AND Shared = 1";

        $query = $database->prepare($sql);

        $query->execute([
            ':hash' => $hash
        ]);

        $file = $query->fetch();

        if (!$file)
        {
            die('Bild nicht gefunden');
        }

        $file_path = dirname(dirname(__DIR__)) . '/userpictures/' . $file->OwnerID . '/' . $file->name;

        if (!file_exists($file_path))
        {
            die('Datei existiert nicht');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file_path);

        header('Content-Type: ' . $mime);

        readfile($file_path);

        exit;
    }

    public static function unShareImage($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $user_id = Session::get('user_id');

        $sql = "UPDATE files
                SET Shared = 0,
                    share_hash = NULL
                WHERE id = :id
                AND OwnerID = :owner";

        $query = $database->prepare($sql);

        $query->execute([
            ':id' => $id,
            ':owner' => $user_id
        ]);
    }


}