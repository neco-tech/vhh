<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>log</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="static/style.css">
</head>
<body>
<div class="wrap-large">
  <h1 class="hide">log</h1>

  <section class="log">
    <h2>アクセスログ</h2>

    <div>
      <pre><?php echo htmlspecialchars($access_log); ?></pre>
    </div>
  </section>

  <section class="log">
    <h2>エラーログ</h2>

    <div>
      <pre><?php echo htmlspecialchars($error_log); ?></pre>
    </div>
  </section>
</div>
</body>
</html>
