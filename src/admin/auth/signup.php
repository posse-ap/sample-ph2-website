<?php
session_start();
$token = isset($_GET['token']) ? $_GET['token'] : null;
$email = isset($_GET['email']) ? $_GET['email'] : null;

if (is_null($token) || is_null($email)) {
  # Errorページに送る
  header('Location: /');
}

if(isset($_SESSION["id"])) {
  header('Location: /admin/index.php');
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE ユーザー登録</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="./../assets/styles/common.css">
  <link rel="stylesheet" href="./../admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <header>
    <div>posse</div>
  </header>
  <div class="wrapper">
    <main>
      <div class="container">
        <h1 class="mb-4">ユーザー登録</h1>
          <div class="mb-3">
            <label for="name" class="form-label">名前</label>
            <input type="text" name="name" id="name" class="form-control">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" class="email form-control" value="<?= $email ?>" id="email" disabled>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password" id="password" class="form-control">
          </div>
          <div class="mb-3">
            <label for="password_confirm" class="form-label">パスワード(確認)</label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
          </div>
          <input type="hidden" name="token" id="token" value="<?= $token ?>">
          <button type="submit" disabled class="btn submit" onclick="signup()" >登録</button>
      </div>
    </main>
  </div>
  <script>
    const submitButton = document.querySelector('.btn.submit')
    const inputDoms = Array.from(document.querySelectorAll('.form-control'))
    const password = document.querySelector('#password')
    const passwordConfirm = document.querySelector('#password_confirm')
    inputDoms.forEach(inpuDom => {
      inpuDom.addEventListener('input', event => {
        const isFilled = inputDoms.filter(d => d.value).length === inputDoms.length
        const isPasswordMatch = password.value === passwordConfirm.value
        submitButton.disabled = !(isFilled && isPasswordMatch)
      })
    })
    const signup = async () => {
      const res = await fetch(`/services/signup.php`, { 
        method: 'PATCH',
        body : JSON.stringify({ 
          name : document.querySelector('#name').value,
          email : document.querySelector('#email').value,
          password : document.querySelector('#password').value,
          password_confirm : document.querySelector('#password_confirm').value,
          token : document.querySelector('#token').value,
        }),
        headers:{
          'Accept': 'application/json, */*',
          "Content-Type": "application/x-www-form-urlencoded"
        },
      });
      const json = await res.json()
      if (res.status === 200) {
        alert(json["message"])
        location.href = '/admin/index.php'
      } else {
        alert(json["error"]["message"])
      }
    }
  </script>
</body>

</html>
