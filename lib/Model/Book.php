<?php

namespace MyApp\Model;

class Book extends \MyApp\Model{
  public function add($values) {
    $stmt = $this->db->prepare("insert into books (title, reason, image, create_date, update_date) values(:title, :reason, :image, now(), now())");
    $res = $stmt->execute([
      ':title' => $values['title'],
      ':reason' => $values['reason'],
      ':image' => $values['image']
    ]);
    if ($res === false) {
      throw new \Exception('エラー');
    }
  }

  public function findAll() {
    $stmt = $this->db->query("select * from books order by id");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
}