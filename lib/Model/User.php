<?php

namespace MyApp\Model;

class User extends \MyApp\Model{
  public function create($values) {
    // var_dump($values);
    // exit;
    $stmt = $this->db->prepare("insert into users (name, profile_image, email, password, create_date, update_date) values(:name, :profile_image, :email, :password, now(), now())");
    $res = $stmt->execute([
      ':name' => $values['name'],
      ':profile_image' => $values['profile_image'],
      ':email' => $values['email'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
    // var_dump($values);
    // var_dump($res);
    // exit;
    if ($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
  }

  public function login($values) {
    // $sql = "select * from users where name=:name, email=:email, password=:password)";
    $sql = "select * from users where  email=:email";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      // ':name' => $values['name'],
      ':email' => $values['email'],
      // ':password' => $values['password']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    // var_dump($stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass'));
    // var_dump(\PDO::FETCH_CLASS);
    // exit;

    if (empty($user)) {
      throw new \MyApp\Exception\UnmatchLogIn();
    } else {
      // var_dump($values);
      // exit;
    }

    if (!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchLogIn();
    }

    return $user;
  }

  public function find() {
    $sql = "select * from users where id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([intval($_GET['id'])]);
    $res = $stmt->fetch($this->db::FETCH_ASSOC);
    // var_dump($res);
    // exit;
    if ($res === false) {
      throw new \Exception('エラー');
    } else {
      // var_dump($res);
      // exit;
      return $res;
    }
  }

  public function profile($values) {
    if (!isset($_GET['id'])) {
      // var_dump($_POST);
      // var_dump($_GET);
      // exit;
      return;
    }
    $sql = sprintf("update users set name = :name, profile_image = :profile_image, email = :email, password = :password, update_date = now() where id = %d", $_GET['id']);
    $stmt = $this->db->prepare($sql);
    $res = $stmt->execute([
      ':name' => $values['name'],
      ':profile_image' => $values['profile_image'],
      ':email' => $values['email'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
    // var_dump($this->find( ));
    // var_dump($_POST);
    // var_dump($values);
    // exit;
  }
}