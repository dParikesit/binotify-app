<?php
namespace App\Service;
use \PDO;
use App\Utils\{HTTPException, Response};

class AlbumService extends Service{
    public function __construct() {
        parent::__construct();
    }

    public function create(string $judul, string $penyanyi, string $image_path, string $tanggal_terbit, string $genre) {
        try {
            $sql = "INSERT INTO albums (judul, penyanyi, total_duration, image_path, tanggal_terbit, genre) VALUES (:judul, :penyanyi, 0, :image_path, :tanggal_terbit, :genre)";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':judul', $judul, PDO::PARAM_STR);
            $statement->bindParam(':penyanyi', $penyanyi, PDO::PARAM_STR);
            $statement->bindParam(':image_path', $image_path, PDO::PARAM_STR);
            $statement->bindParam(':tanggal_terbit', $tanggal_terbit, PDO::PARAM_STR);
            $statement->bindParam(':genre', $genre, PDO::PARAM_STR);
            $statement->execute();

            return "Successfully Created";
        } catch (PDOException $e) {
            $error_code = ($e->getCode() == 23000) ? 400 : 500;
            $res = new HTTPException($e->getMessage(), $error_code);
            $e->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function delete($album_id) {
        try {
            $sql = "DELETE FROM albums WHERE album_id = :album_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_STRING);
            $statement->execute();
            return "Successfully Deleted";
        } catch (PDOException $e) {
            $res = new HTTPException($e->getMessage(), 400);
            $e->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function update($album_id, string $judul, string $penyanyi, int $total_duration, string $image_path, string $tanggal_terbit, string $genre) {
        try {
            $sql = "UPDATE albums SET judul = :judul, penyanyi = :penyanyi, total_duration= :total_duration ,image_path = :image_path, tanggal_terbit = :tanggal_terbit, genre = :genre WHERE album_id = :album_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_STRING);
            $statement->bindParam(':judul', $judul, PDO::PARAM_STR);
            $statement->bindParam(':penyanyi', $penyanyi, PDO::PARAM_STR);
            $statement->bindParam(':total_duration', $total_duration, PDO::PARAM_INT);
            $statement->bindParam(':image_path', $image_path, PDO::PARAM_STR);
            $statement->bindParam(':tanggal_terbit', $tanggal_terbit, PDO::PARAM_STR);
            $statement->bindParam(':genre', $genre, PDO::PARAM_STR);
            $statement->execute();

            return "Successfully Updated";
        } catch (PDOException $e) {
            $res = new HTTPException($e->getMessage(), 400);
            $e->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function readAll() {
        try {
            $sql = "SELECT * FROM albums ORDER BY judul ASC";
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();

            return $result;
        } catch (PDOException $e) {
            $res = new HTTPException($e->getMessage(), 400);
            $e->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }

    public function getAlbumById($album_id) {
        try {
            $sql = "SELECT * FROM albums WHERE album_id = :album_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch();

            $sql = "SELECT * FROM songs WHERE album_id = :album_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':album_id', $album_id, PDO::PARAM_INT);
            $statement->execute();
            $result2 = $statement->fetch();

            $res = array(
                "album" => $result,
                "song" => $result2
            );

            return $res;
        } catch (PDOException $e) {
            $res = new HTTPException($e->getMessage(), 400);
            $e->sendJSON();
        } catch (HTTPException $e) {
            $e->sendJSON();
        }
    }
}

?>