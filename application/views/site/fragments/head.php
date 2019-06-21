<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= $settingGeneral->site_description ?>">
  <meta name="keywords" content="<?= $settingGeneral->site_keywords ?>" />
  <?php 
    $pageTitle = isset($siteTitle) 
               ? $siteTitle . " - " . $settingGeneral->site_name 
               : $settingGeneral->site_name . " - " . $settingGeneral->site_title
    ?>
  <title><?= $pageTitle ?></title>
  <link rel="icon" type="image/x-icon" href="<?= base_url("assets/img/favicon.ico?v=" . APP_VERSION) ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/landing.css?v=" . APP_VERSION) ?>">
</head>