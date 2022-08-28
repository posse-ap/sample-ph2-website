<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE ユーザー招待</title>
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
  <?php include(dirname(__FILE__) . '/../../components/admin/header.php'); ?>
  <div class="wrapper">
    <?php include(dirname(__FILE__) . '/../../components/admin/sidebar.php'); ?>
    <main>
      <div class="container">
        <h1 class="mb-4">ユーザー招待</h1>
        <input type="email" name="email" class="email">
        <button type="submit" class="btn submit" disabled onclick="invitation()" >送信</button>
      </div>
    </main>
  </div>
  <script>
    const EMAIL_REGEX = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
    const submitButton = document.querySelector('.btn.submit')
    const emailInput = document.querySelector('.email')
    emailInput.oninput = (event) => {
      submitButton.disabled = !EMAIL_REGEX.test(event.target.value)
    }
    const invitation = async () => {
      const res = await fetch(`/services/create_user.php`, { 
        method: 'POST',
        body : JSON.stringify({ email : emailInput.value }),
        headers:{
          'Accept': 'application/json, */*',
          "Content-Type": "application/x-www-form-urlencoded"
        },
      });
      const json = await res.json()
      console.log('json', json)
      if (res.status === 201) {
        alert('ユーザー招待に成功しました')
        emailInput.value = ''
      } else {
        alert(json["error"]["message"])
      }
    }
  </script>
</body>

</html>
