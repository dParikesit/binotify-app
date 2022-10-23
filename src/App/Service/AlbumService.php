<?php
namespace App\Service;
use \PDO;

class AlbumService extends Service{
    public function __construct() {
        parent::__construct();
    }

    public function create(string $judul, string $penyanyi, int $total_duration, string $image_path, string $tanggal_terbit, string $genre) {
        try {
            $sql = "INSERT INTO albums (judul, penyanyi, total_duration, image_path, tanggal_terbit, genre) VALUES (:judul, :penyanyi, :total_duration, :image_path, :tanggal_terbit, :genre)";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':judul', $judul, PDO::PARAM_STR);
            $statement->bindParam(':penyanyi', $penyanyi, PDO::PARAM_STR);
            $statement->bindParam(':total_duration', $total_duration, PDO::PARAM_INT);
            $statement->bindParam(':image_path', $image_path, PDO::PARAM_STR);
            $statement->bindParam(':tanggal_terbit', $tanggal_terbit, PDO::PARAM_STR);
            $statement->bindParam(':genre', $genre, PDO::PARAM_STR);
            $statement->execute();

            return array("Status code" => 201,"Message"=>"Successfully Created");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function delete($album_id) {
        try {
            $sql = "DELETE FROM albums WHERE album_id = :album_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_STRING);
            $statement->execute();
            return array("Status code" => 200,"Message"=>"Successfully Deleted");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function update($album_id, string $judul, string $penyanyi, int $total_duration, string $image_path, string $tanggal_terbit, string $genre) {
        try {
            $sql = "UPDATE albums SET judul = :judul, penyanyi = :penyanyi, image_path = :image_path, tanggal_terbit = :tanggal_terbit, genre = :genre WHERE album_id = :album_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_STRING);
            $statement->bindParam(':judul', $judul, PDO::PARAM_STR);
            $statement->bindParam(':penyanyi', $penyanyi, PDO::PARAM_STR);
            $statement->bindParam(':image_path', $image_path, PDO::PARAM_STR);
            $statement->bindParam(':tanggal_terbit', $tanggal_terbit, PDO::PARAM_STR);
            $statement->bindParam(':genre', $genre, PDO::PARAM_STR);
            $statement->execute();

            return array("Status code" => 200,"Message"=>"Successfully Updated");
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function readAll() {
        try {
            $sql = "SELECT * FROM albums ORDER BY judul ASC";
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }

    public function getAlbumById($album_id) {
        try {
            $sql = "SELECT * FROM albums WHERE album_id = :album_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_STRING);
            $statement->execute();
            $result = $statement->fetch();

            $sql = "SELECT * FROM songs WHERE album_id = :album_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_STRING);
            $statement->execute();
            $result2 = $statement->fetch();

            return array("Status code" => 200,"Message"=>"Successfully Read","Data"=>$result,"Songs"=>$result2);
        } catch (PDOException $e) {
            return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
        }
    }
}

?>