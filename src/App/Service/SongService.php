<?php
namespace App\Service;
use \PDO;

class SongService extends Service{
    public function __construct() {
        parent::__construct();
    }

    public function create(string $judul, string $penyanyi, string $tanggal_terbit, string $genre, string $duration, string $audio_path, string $image_path) {
        try {
            $sql = "INSERT INTO songs (judul, penyanyi, tanggal_terbit, genre, duration, audio_path, image_path) VALUES (:judul, :penyanyi, :tanggal_terbit, :genre, :duration, :audio_path, :image_path)";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':judul', $judul, PDO::PARAM_STR);
            $statement->bindParam(':penyanyi', $penyanyi, PDO::PARAM_STR);
            $statement->bindParam(':tanggal_terbit', $tanggal_terbit, PDO::PARAM_STR);
            $statement->bindParam(':genre', $genre, PDO::PARAM_STR);
            $statement->bindParam(':duration', $duration, PDO::PARAM_INT);
            $statement->bindParam(':audio_path', $audio_path, PDO::PARAM_STR);
            $statement->bindParam(':image_path', $image_path, PDO::PARAM_STR);
            $statement->execute();

            return "Successfully Created";
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function delete($song_id) {
        try {
            $sql = "DELETE FROM songs WHERE song_id = :song_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':song_id', $song_id, PDO::PARAM_STRING);
            $statement->execute();

            return "Successfully Deleted";
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function update($song_id, string $judul, string $penyanyi, string $tanggal_terbit, string $genre, $duration, string $audio_path, string $image_path) {
        try {
            $sql = "UPDATE songs SET judul=:judul, penyanyi=:penyanyi, tanggal_terbit=:tanggal_terbit, genre=:genre, audio_path=:audio_path, image_path=:image_path WHERE song_id = :song_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':song_id', $song_id, PDO::PARAM_STRING);
            $statement->bindParam(':judul', $judul, PDO::PARAM_STR);
            $statement->bindParam(':penyanyi', $penyanyi, PDO::PARAM_STR);
            $statement->bindParam(':tanggal_terbit', $tanggal_terbit, PDO::PARAM_STR);
            $statement->bindParam(':genre', $genre, PDO::PARAM_STR);
            $statement->bindParam(':audio_path', $audio_path, PDO::PARAM_STR);
            $statement->bindParam(':image_path', $image_path, PDO::PARAM_STR);
            $statement->execute();

            return "Successfully Updated";
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();        
        }
    }

    public function updateSongToAlbum($song_id, $album_id, $total_duration) {
        try {
            $sql = "UPDATE songs SET album_id=:album_id, total_duration:=total_duration WHERE song_id = :song_id AND penyanyi = (SELECT penyanyi FROM albums WHERE album_id = :album_id)";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':song_id', $song_id, PDO::PARAM_STRING);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_STRING);
            $statement->bindParam(':total_duration', $total_duration, PDO::PARAM_INT);
            $statement->execute();

            return "Successfully Updated";
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function deleteSongFromAlbum($song_id) {
        try {
            $sql = "UPDATE songs SET album_id=:null WHERE song_id = :song_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':song_id', $song_id, PDO::PARAM_STRING);
            $statement->execute();

            return "Successfully Deleted Song from Album";
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function readAll() {
        try {
            $sql = "SELECT * FROM songs ORDER BY judul asc";
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();

            return $result;
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function getSongById($song_id) {
        try {
            $sql = "SELECT * FROM songs WHERE song_id = :song_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':song_id', $song_id, PDO::PARAM_STRING);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function getSongByAlbumId($album_id) {
        try {
            $sql = "SELECT * FROM songs WHERE album_id = :album_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_STRING);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function getSongByParam($param, $tahun, $genre, $page, $maxdata) {
        try {
            //$sql = "SELECT * FROM songs WHERE Judul = :Parameter OR Penyanyi = :Parameter OR DATE_PART('year', Tanggal_terbit::date) = :Tahun LIMIT :Maxdata OFFSET :Mindata";
            // $sql = "SELECT * FROM songs WHERE Judul = :Parameter OR Penyanyi = :Parameter OR DATE_PART('year', Tanggal_terbit::date) = :Tahun LIMIT :Maxdata OFFSET :Mindata";
            $sql = "SELECT * FROM songs WHERE (Judul = :Parameter OR Penyanyi = :Parameter OR DATE_PART('year', Tanggal_terbit::date) = :Tahun) AND (Genre = :Genre OR :Genre IS NULL) LIMIT :Maxdata OFFSET :Mindata";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':Parameter', $param, PDO::PARAM_STR);
            $statement->bindParam(':Tahun', $tahun, PDO::PARAM_INT);
            $statement->bindParam(':Genre', $genre, PDO::PARAM_INT);
            $statement->bindParam(':Mindata', $page, PDO::PARAM_INT);
            $statement->bindParam(':Maxdata', $maxdata, PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetchAll();

            return $result;
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function getSongByParamAndGenre($param, $genre, $ordering, $page, $maxdata) {
        try {
            $sql = "SELECT * FROM songs WHERE (Judul = :Parameter OR Penyanyi = :Parameter OR DATE_PART('year', Tanggal_terbit::date) = :Tahun) AND (Genre = :Genre OR :Genre IS NULL) LIMIT :Maxdata OFFSET :Mindata";

            $statement = $this->db->prepare($sql);
            $statement->bindParam(':Parameter', $param, PDO::PARAM_INT);
            $statement->bindParam(':Tahun', $tahun, PDO::PARAM_INT);
            $statement->bindParam(':Genre', $genre, PDO::PARAM_INT);
            $statement->bindParam(':Mindata', $page, PDO::PARAM_STR);
            $statement->bindParam(':Maxdata', $maxdata, PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetchAll();

            return $result;
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }

    public function getSong() {
        try {
            $sql = "SELECT * FROM songs ORDER BY Tanggal_terbit DESC, Judul ASC LIMIT 10";

            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();

            return $result;
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        }
    }
}

?>