<?php
require_once(dirname(__FILE__) . '/../db/pdo.php');
require(dirname(__FILE__) . '/../response/create_response.php');

$raw = file_get_contents('php://input');
$data = (array)json_decode($raw);

$pdo = Database::get();
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":email", $data["email"]);
$stmt->execute();
$user = $stmt->fetch();

if (!$user || !password_verify($data['password'], $user["password"])) {
  $message = [
    "error" => [
      "message" => "認証情報が正しくありません"
    ]
  ];
  create_response(401, $message);
  exit;
}

session_start();
$_SESSION['id'] = $user["id"];
$_SESSION['name'] = $user["name"];
$message = [
  "message" => "ログインに成功しました"
];
create_response(200, $message);
