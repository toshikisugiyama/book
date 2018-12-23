<?php

namespace MyApp\Model;

class Book extends \MyApp\Model{
  public function add($values) {
    $stmt = $this->db->prepare("insert into books (title, reason, image, contributor_id, create_date, update_date) values(:title, :reason, :image, :contributor_id, now(), now())");
    $res = $stmt->execute([
      ':title' => $values['title'],
      ':reason' => $values['reason'],
      ':image' => $values['image'],
      ':contributor_id' => $values['contributor_id']
    ]);
    // var_dump($values);
    // exit;
    if ($res === false) {
      throw new \Exception('エラー');
    }
  }

  // public function findAll() {
  //   $stmt = $this->db->query("select * from books order by id desc");
  //   $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
  //   return $stmt->fetchAll();
  // }
  public function findAll() {
    $stmt = $this->db->query("select * from books
            left outer join users
            on books.contributor_id = users.id
            order by books.id desc");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  public function find() {
    $sql = "select * from books where id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([intval($_GET['id'])]);
    $res = $stmt->fetch($this->db::FETCH_ASSOC);
    // var_dump($res);
    // exit;
    if ($res === false) {
      echo "エラー";
      exit;
      throw new \Exception('エラー');
    } else {
      return $res;
    }
  }

  public function edit($values) {
    $sql = "update books set title = :title, image = :image, reason = :reason, update_date = now() where id = :id";
    $stmt = $this->db->prepare($sql);
    // var_dump($values);
    // exit;
    $res = $stmt->execute([
      ':title' => $values['title'],
      ':image' => $values['image'],
      ':reason' => $values['reason'],
      ':id' => intval($_GET['id']),
    ]);

    if ($res === false) {
      throw new \Exception('エラー');
    } else {
      return $res;
    }
  }

  public function delete() {
    $sql = "delete from books where id = :id";
    $stmt = $this->db->prepare($sql);
    // var_dump($_GET['id']);
    // exit;
    $res = $stmt->execute([
      ':id' => $_GET['id']
    ]);
    // var_dump($_GET['id']);
    // exit;
    if ($res === false) {
      throw new \Exception('エラー');
    } else {
      header('Location: ' . '/');
    }
  }

  public function page() {
    $sql = "select b.id, b.title, b.reason, b.image, b.contributor_id, b.create_date, b.update_date, u.id as user_id, u.name, u.profile_image, u.email, u.password, u.create_date, u.update_date
            from books as b
            left outer join users as u
            on b.contributor_id = u.id
            where b.id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $res = $stmt->fetch($this->db::FETCH_ASSOC);
    // var_dump($res);
    // exit;
    return $res;
  }

  public function show() {
    $sql = "select b.id, b.title, b.reason, b.image, b.contributor_id, b.create_date, b.update_date, u.id as user_id, u.name, u.profile_image, u.email, u.password, u.create_date, u.update_date
            from books as b
            left outer join users as u
            on b.contributor_id = u.id
            order by b.id desc";
    $stmt = $this->db->query($sql);
    $res = $stmt->fetchAll($this->db::FETCH_ASSOC);
    // var_dump($res);
    // exit;
    return $res;
  }
}