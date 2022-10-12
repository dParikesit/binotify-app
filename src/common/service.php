<?php

class NoteService
{
  private $DB_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ];

  /**
   * Make a connection to the resource.
   */
  public function __construct()
  {
    $this->db = new PDO("pgsql:host={$_ENV['POSTGRES_HOST']};dbname={$_ENV['POSTGRES_DB']}", $_ENV['POSTGRES_USER'], $_ENV['POSTGRES_PASSWORD'], $this->DB_OPTIONS);
    return "Successfully Connected";
  }

  /**
   * Close connection to the resource.
   */
  public function __destruct()
  {
    $this->db = null;
  }

  /**
   * Get all user.
   */
  public function get_users()
  {
    try {
      $sql = "SELECT username, fullname FROM users WHERE role='user' ORDER BY created_at DESC";

      $statement = $this->db->prepare($sql);
      $statement->execute();

      return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return "Error: [all] {$e->getMessage()}";
    }
  }

  /**
   * Get all user.
   * @param string $username
   */
  public function get_user(string $username)
  {
    try {
      $sql = "SELECT id, username, fullname, hashed_pass, role FROM users WHERE username = :username";

      $statement = $this->db->prepare($sql);
      $statement->bindParam(':username', $username, PDO::PARAM_STR);
      $statement->execute();

      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return "Error: [all] {$e->getMessage()}";
    }
  }

  /**
   * Get all user.
   * @param string $id
   */
  public function get_user_by_id(string $id)
  {
    try {
      $sql = "SELECT id, fullname, hashed_pass, role FROM users WHERE id = :id LIMIT 1";

      $statement = $this->db->prepare($sql);
      $statement->bindParam(':id', $id, PDO::PARAM_STR);
      $statement->execute();

      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return "Error: [all] {$e->getMessage()}";
    }
  }

  /**
   * Create user.
   * @param string $username
   * @param string $fullname
   * @param string $hashed_pass
   */
  public function create_user(string $username, string $fullname, string $hashed_pass)
  {
    try {
      $sql = "INSERT INTO users (username, fullname, hashed_pass) VALUES (:username, :fullname, :hashed_pass)";

      $statement = $this->db->prepare($sql);
      $statement->bindParam(':username', $username, PDO::PARAM_STR);
      $statement->bindParam(':fullname', $fullname, PDO::PARAM_STR);
      $statement->bindParam(':hashed_pass', $hashed_pass, PDO::PARAM_STR);
      $statement->execute();

      return array("Status code" => 201,"Message"=>"Successfully Created");
    } catch (PDOException $e) {
      return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
    }
  }

  /**
   * Reset password.
   * @param int $id
   * @param string $password
   */
  public function reset_password(int $id, string $hashed_pass)
  {
    try {
      $sql = "UPDATE users SET hashed_pass=:hashed_pass WHERE id=:id";

      $statement = $this->db->prepare($sql);
      $statement->bindParam(':id', $id, PDO::PARAM_STR);
      $statement->bindParam(':hashed_pass', $hashed_pass, PDO::PARAM_STR);
      $statement->execute();

      return array("Status code" => 202,"Message"=>"Successfully Changed");
    } catch (PDOException $e) {
      return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
    }
  }

  /**
   * Create note.
   * @param int $user_id
   * @param string $title
   * @param string $content
   */
  public function create_note(int $user_id, string $title, string $content)
  {
    try {
      $sql = "INSERT INTO notes (title, content, user_id) VALUES (:title, :content, :user_id)";

      $statement = $this->db->prepare($sql);
      $statement->bindParam(':title', $title, PDO::PARAM_STR);
      $statement->bindParam(':content', $content, PDO::PARAM_STR);
      $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $statement->execute();

      return array("Status code" => 201,"Message"=>"Successfully Created");
    } catch (PDOException $e) {
      return array("Status code" => 400,"Message"=>"Error: [all] {$e->getMessage()}");
    }
  }

  /**
   * Get all note by id.
   * @param int $user_id
   */
  public function get_notes(int $user_id)
  {
    try {
      $sql = "SELECT id, title, created_at FROM notes WHERE user_id=:user_id ORDER BY created_at DESC" ;

      $statement = $this->db->prepare($sql);
      $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $statement->execute();

      return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return "Error: [all] {$e->getMessage()}";
    }
  }

  /**
   * Get a note by id.
   * @param int $id
   */
  public function get_note(int $id)
  {
    try {
      $sql = "SELECT id, title, content, created_at FROM notes WHERE id=:id LIMIT 1" ;

      $statement = $this->db->prepare($sql);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();

      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return "Error: [all] {$e->getMessage()}";
    }
  }

  /////////////////////////////////////////////////////////////////////////////



  /**
   * Get a listing of the resource.
   */
  public function all()
  {
    try {
      $sql = "SELECT id, title, note, color FROM notes";

      $statement = $this->db->prepare($sql);
      $statement->execute();

      return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return "Error: [all] {$e->getMessage()}";
    }
  }

  /**
   * Get the specified resource.
   *
   * @param int $id
   */
  public function get(int $id)
  {
    try {
      $sql = "SELECT id, title, note, color FROM notes WHERE id = :id";

      $statement = $this->db->prepare($sql);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();

      return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return "Error: [get] {$e->getMessage()}";
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param array $item
   */
  public function save(array $item)
  {
    try {
      $sql = "INSERT INTO notes (title, note, color) VALUES (:title, :note, :color)";

      $statement = $this->db->prepare($sql);
      $statement->bindParam('title', $item['title'], PDO::PARAM_STR);
      $statement->bindParam('note', $item['note'], PDO::PARAM_STR);
      $statement->bindParam('color', $item['color'], PDO::PARAM_STR);
      $statement->execute();

      return "Successfully created";
    } catch (PDOException $e) {
      return "Error: [save] {$e->getMessage()}";
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param array $item
   */
  public function update(array $item)
  {
    try {
      $sql = "UPDATE notes SET id = :id, title = :title, note = :note, color = :color WHERE id = :id";

      $statement = $this->db->prepare($sql);
      $statement->bindParam('id', $item['id'], PDO::PARAM_INT);
      $statement->bindParam('title', $item['title'], PDO::PARAM_STR);
      $statement->bindParam('note', $item['note'], PDO::PARAM_STR);
      $statement->bindParam('color', $item['color'], PDO::PARAM_STR);
      $statement->execute();

      return "Successfully updated";
    } catch (PDOException $e) {
      return "Error: [update] {$e->getMessage()}";
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   */
  public function remove(int $id)
  {
    try {
      $sql = "DELETE FROM notes WHERE id = :id";

      $statement = $this->db->prepare($sql);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();

      return "Successfully deleted";
    } catch (PDOException $e) {
      return "Error: [remove] {$e->getMessage()}";
    }
  }
}