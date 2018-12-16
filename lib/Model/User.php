<?php

namespace MyApp\Model;

class User extends \MyApp\Model{
  public function create($values) {
    $stmt = $this->db->prepare("insert into users (name, email, password, create_date, update_date) values(:name, :email, :password, now(), now())");
    $res = $stmt->execute([
      ':name' => $values['name'],
      ':email' => $values['email'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
    if ($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
  }

  public function login($values) {
    $stmt = $this->db->prepare("select * from users where email=:email");
    $stmt->execute([
      ':email' => $values['email']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    if (empty($user)) {
      throw new \MyApp\Exception\UnmatchLogIn();
    }

    if (!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchLogIn();
    }

    return $user;
  }

  public function profile($values) {
    if (!isset($_POST['id'])) {
      throw new \MyApp\Exception();
    }
    $sql = sprintf("update users set name = ?, email = ?, password = ?, update_date = now() where id = %d", $_POST['id']);
    $stmt = $this->db->prepare($sql);
    $res = $stmt->execute([
      ':name' => $values['name'],
      ':email' => $values['email'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
  }
}