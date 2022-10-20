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

    public function delete($id) {
        try {
            $sql = "DELETE FROM songs WHERE id = :id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            return array("Status code" => 201,"Message"=>"Successfully Deleted");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function update($id, string $judul, string $penyanyi, string $tanggal_terbit, string $genre, string $audio_path, string $image_path) {
        try {
            $sql = "UPDATE songs SET judul=:judul, penyanyi=:penyanyi, tanggal_terbit=:tanggal_terbit, genre=:genre, audio_path=:audio_path, image_path=:image_path WHERE id = :id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
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

    public function updateSongToAlbum($id, $album_id) {
        try {
            $sql = "UPDATE songs SET album_id=:album_id WHERE id = :id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_INT);
            $statement->execute();

            return array("Status code" => 201,"Message"=>"Successfully Updated Song to Album");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function readAll() {
        try {
            $sql = "SELECT * FROM songs ORDER BY jUdul asc";
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function getSongById($id) {
        try {
            $sql = "SELECT * FROM songs WHERE id = :id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function getSongByParam($judul, $penyanyi, $tahun, $genre, $ordering, $page, $maxdata) {
        try {
            $sql = "SELECT * FROM songs WHERE Judul = :Judul OR Penyanyi = :Penyanyi OR year(Tanggal_terbit) = :Tahun ORDER BY Tanggal_terbit ASC OFFSET :MinData LIMIT :Maxdata";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':Judul', $judul, PDO::PARAM_INT);
            $statement->bindParam(':Penyanyi', $penyanyi, PDO::PARAM_INT);
            $statement->bindParam(':Tahun', $tahun, PDO::PARAM_INT);
            // $statement->bindParam(':Genre', $genre, PDO::PARAM_INT);
            // $statement->bindParam(':Ordering', $ordering, PDO::PARAM_INT);
            $statement->bindParam(':MinData', $page, PDO::PARAM_INT);
            $statement->bindParam(':Maxdata', $maxdata, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }
}

?>