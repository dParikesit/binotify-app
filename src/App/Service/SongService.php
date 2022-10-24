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

            return array("Status code" => 201,"Message"=>"Successfully Created");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function delete($song_id) {
        try {
            $sql = "DELETE FROM songs WHERE song_id = :song_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':song_id', $song_id, PDO::PARAM_STRING);
            $statement->execute();

            return array("Status code" => 201,"Message"=>"Successfully Deleted");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function update($song_id, string $judul, string $penyanyi, string $tanggal_terbit, string $genre, string $audio_path, string $image_path) {
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

            return array("Status code" => 201,"Message"=>"Successfully Updated");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function updateSongToAlbum($song_id, $album_id) {
        try {
            $sql = "UPDATE songs SET album_id=:album_id WHERE song_id = :song_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':song_id', $song_id, PDO::PARAM_STRING);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_STRING);
            $statement->execute();

            return array("Status code" => 201,"Message"=>"Successfully Updated Song to Album");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function deleteSongFromAlbum($song_id) {
        try {
            $sql = "UPDATE songs SET album_id=:null WHERE song_id = :song_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':song_id', $song_id, PDO::PARAM_STRING);
            $statement->execute();

            return array("Status code" => 201,"Message"=>"Successfully Deleted Song from Album");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function readAll() {
        try {
            $sql = "SELECT * FROM songs ORDER BY judul asc";
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function getSongById($song_id) {
        try {
            $sql = "SELECT * FROM songs WHERE song_id = :song_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':song_id', $song_id, PDO::PARAM_STRING);
            $statement->execute();
            $result = $statement->fetch();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function getSongByAlbumId($album_id) {
        try {
            $sql = "SELECT * FROM songs WHERE album_id = :album_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_STRING);
            $statement->execute();
            $result = $statement->fetch();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function getSongByParam($param, $ordering, $page, $maxdata) {
        try {
            //$sql = "SELECT * FROM songs WHERE Judul = :Parameter OR Penyanyi = :Parameter OR DATE_PART('year', Tanggal_terbit::date) = :Tahun LIMIT :Maxdata OFFSET :Mindata";
            $sql = "SELECT * FROM songs WHERE Judul = :Parameter OR Penyanyi = :Parameter OR DATE_PART('year', Tanggal_terbit::date) = :Tahun LIMIT :Maxdata OFFSET :Mindata";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':Parameter', $param, PDO::PARAM_STR);
            $statement->bindParam(':Tahun', $tahun, PDO::PARAM_INT);
            $statement->bindParam(':Mindata', $page, PDO::PARAM_INT);
            $statement->bindParam(':Maxdata', $maxdata, PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetchAll();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function getSongByParamAndGenre($param, $genre, $ordering, $page, $maxdata) {
        try {
            $sql = "SELECT * FROM songs WHERE (Judul = :Parameter OR Penyanyi = :Parameter OR DATE_PART('year', Tanggal_terbit::date) = :Tahun) AND Genre = :Genre LIMIT :Maxdata OFFSET :Mindata";

            $statement = $this->db->prepare($sql);
            $statement->bindParam(':Parameter', $param, PDO::PARAM_INT);
            $statement->bindParam(':Tahun', $tahun, PDO::PARAM_INT);
            $statement->bindParam(':Genre', $genre, PDO::PARAM_INT);
            $statement->bindParam(':Mindata', $page, PDO::PARAM_STR);
            $statement->bindParam(':Maxdata', $maxdata, PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetchAll();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function getSong() {
        try {
            $sql = "SELECT * FROM songs ORDER BY Tanggal_terbit DESC, Judul ASC LIMIT 10";

            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }
}

?>