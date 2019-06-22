<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="description" content="<?= htmlchars($settingGeneral->site_description) ?>" />
  <meta name="keywords" content="<?= htmlchars($settingGeneral->site_keywords) ?>" />

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

<body class="hold-transition login-page">

  <?= (isset($content)) ? $content : null ?>

  <script src="<?= base_url("assets/js/plugins.js?v=" . APP_VERSION) ?>"></script>
  <script src="<?= base_url("assets/js/core.js?v=" . APP_VERSION) ?>"></script>

  <?php if (isset($settingRecaptcha->site_key) &&
            isset($settingRecaptcha->secret_key)): ?>
  <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=id" async defer></script>
  <?php endif; ?>

  <?php if (isset($settingOauth->api_key)): ?>
  <script src="https://cdn.rawgit.com/oauth-io/oauth-js/c5af4519/dist/oauth.js"></script>
  <script>
    $(function () {
      SimpleAuth.OauthInit("<?= base_url("oauth") ?>", "<?= $settingOauth->api_key ?>");
    })
  </script>
  <?php endif; ?>

</body>

</html>