<!doctype html>
<html lang="en">
<head>
	<title>Terjadi Kesalahan</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" type="image/x-icon" href="<?= config_item('base_url') ?>/assets/img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic">
  	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:400,300,700">
	<link rel="stylesheet" type="text/css" href="<?= config_item('base_url') ?>/assets/css/landing.css">
</head>
<body>
	<main role="main" class="container">
		<div class="text-center" style="padding-top:5em;">
			<h1 class="text-danger" style="font-size:120px"><?= http_response_code() ?></h1>
			<h3 class="text-danger"><?= $heading; ?></h3>
			<div class="lead"><?= $message; ?></div>
			<a class="btn btn-danger" href="javascript:void(0)" onclick="location.reload();">Muat Ulang</a>
		</div>
	</main>
</body>
</html>