<?php
require('../db/pdo.php');

$pdo = Database::get();
$pdo->beginTransaction();
try {
  $sql = "DELETE FROM choices WHERE question_id = :question_id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(":question_id", $_REQUEST["id"]);
  $stmt->execute();

  $sql = "DELETE FROM questions WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(":id", $_REQUEST["id"]);
  $stmt->execute();
  $pdo->commit();
  header("HTTP/1.1 204 OK");
} catch(Error $e) {
  $pdo->rollBack();
  header("HTTP/1.1 500 OK");
}

header("Content-Type: application/json; charset=utf-8");
