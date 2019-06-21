<?php require_once 'init.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Instalasi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="<?= APPURL . "/install/assets/style.css"?>">
</head>

<body class="hold-transition login-page">
    <div class="login-box fragments">

        <?php require_once "app/fragments/start.php"?>
        <?php require_once "app/fragments/requirement.php"?>
        <?php require_once "app/fragments/database.php"?>
        <?php require_once "app/fragments/success.php"?>

    </div>
    <script src="<?= APPURL . "/install/assets/script.js"?>"></script>

    <script>
        $("body").on("click", ".start-btn", function () {
            $(".start-fragment").addClass("hide");
            $(".requirement-fragment").removeClass("hide");
        });
        
        $("body").on("click", ".next-btn", function () {
            $(".requirement-fragment").addClass("hide");
            $(".db-fragment").removeClass("hide");
        });


        $("body").on("submit", ".ajax-form", function () {

            $("body").addClass("onprogress");

            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: $(this).serialize(),
                error: function () {
                    console.log($(this));
                },
                complete: function () {
                    $("body").removeClass("onprogress");
                },
                success: function (resp) {
                    if (resp.status == 1) {
                        $(".db-fragment").addClass("hide");
                        $(".success-fragment").removeClass("hide");
                    } else {
                        $("#message").html(
                            '<div class="alert callout-danger"><span class="text-red">' + resp.message + '</span></div>');
                    }
                }
            });

            return false;
        });
    </script>
</body>

</html>