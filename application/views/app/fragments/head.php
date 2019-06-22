<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php 
    $pageTitle = isset($siteTitle) 
               ? $siteTitle . " - " . $settingGeneral->site_name 
               : $settingGeneral->site_name . " - " . $settingGeneral->site_title
    ?>
  <title><?= htmlchars($pageTitle) ?></title>
  <link rel="icon" type="image/x-icon" href="<?= base_url("assets/img/favicon.ico?v=" . APP_VERSION) ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/plugins.css?v=" . APP_VERSION) ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/core.css?v=" . APP_VERSION) ?>">
</head>