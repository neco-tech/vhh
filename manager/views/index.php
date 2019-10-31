<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>vhh Manager</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="static/style.css">
</head>
<body>
<div class="wrap">
  <h1>vhh Manager</h1>
  <?php if(is_my_env()): ?>
  <form action="./" method="post" class="add-form">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="token" value="<?php echo el($_SESSION, 'token'); ?>">

    <table>
      <tbody>
        <tr class="required">
          <th>サイト名</th>
          <td><input type="text" name="name" placeholder="テスト"></td>
        </tr>
        <tr class="required">
          <th>ディレクトリ名</th>
          <td><input type="text" name="slug" placeholder="test"></td>
        </tr>
        <tr class="required">
          <th>ポート番号</th>
          <td><input type="text" name="port" value="<?php echo get_next_port(); ?>" placeholder="600XX"></td>
        </tr>
        <tr>
          <th>概要</th>
          <td><textarea name="description"></textarea>
        </tr>
        <tr>
          <th></th>
          <td><button type="submit">作成</button></td>
        </tr>
      </tbody>
    </table>
  </form>
  <?php endif; ?>

  <div class="quick-filter">
    <input type="text" id="quick-filter" placeholder="Quick Filter">
  </div>

  <table class="sites">
    <tbody>
      <?php foreach(get_sites() as $site): ?>
      <tr data-search-string="<?php echo htmlspecialchars($site['port'].' '.$site['slug'].' '.$site['description']); ?>">
        <td>[<?php echo $site['port']; ?>]</td>
        <td>
          <a href="http://<?php echo str_replace('60000', $site['port'], $_SERVER["HTTP_HOST"]); ?>" target="_blank"><?php echo $site['name']; ?></a>
          <span>(<?php echo $site['slug']; ?>)</span>
          <?php if($site['description']): ?>
          <p><?php echo nl2br(htmlspecialchars($site['description'])); ?></p>
          <?php endif; ?>
        </td>
        <?php if(is_my_env()): ?>
        <td>
          <form action="./" method="post">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="token" value="<?php echo el($_SESSION, 'token'); ?>">
            <input type="hidden" name="port" value="<?php echo $site['port']; ?>">
            <button type="submit" class="delete" onclick="return confirm('<?php echo $site['name']; ?> を削除しますか？');">削除</button>
          </form>
        </td>
        <?php endif; ?>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script src="static/jquery-3.4.1.min.js"></script>
<script src="static/script.js"></script>
</body>
</html>
