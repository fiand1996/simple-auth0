<!DOCTYPE html>
<html lang="en">

<?= isset($head) ? $head : null ?>

<body data-spy="scroll" data-target="#navigation" data-offset="50">
    <div id="app" v-cloak>
        
        <?= isset($header) ? $header : null ?>


        <?= (isset($content)) ? $content : null ?>

        <?= isset($footer) ? $footer : null ?>

    </div>

    <?= isset($script) ? $script : null ?>
    
</body>

</html>