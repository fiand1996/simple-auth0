<!DOCTYPE html>
<html>

<?= (isset($head)) ? $head : null ?>

<body class="hold-transition <?= $userAuth->app_layout ?> <?= $userAuth->app_theme ?> sidebar-mini onprogress">
    <div class="wrapper">

        <?= (isset($topmenu)) ? $topmenu : null ?>

        <?= (isset($leftmenu)) ? $leftmenu : null ?>

        <div class="content-wrapper">

            <?= (isset($content)) ? $content : null ?>

        </div>

        <?= (isset($footer)) ? $footer : null ?>

    </div>

    <?= (isset($script)) ? $script : null ?>

</body>

</html>