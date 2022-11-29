<?php
$c = Config::singleton();
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- _head.php -->
        <?php require_once "{$c->get("views")}template/_head.php"; ?>
        <?php
        if ($csscore != "") {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo "{$c->get("css")}{$csscore}" ?>" >
            <?php
        }
        if ($css != "") {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo "{$c->get("css")}{$css}" ?>" >
            <?php
        }
        if ($jscore != "") {
            ?>
            <script src="<?php echo "{$c->get("js")}{$jscore}" ?>"></script>
            <?php
        }
        if ($js != "") {
            ?>
            <script src="<?php echo "{$c->get("js")}{$js}" ?>"></script>
            <?php
        }
        ?>
        <script>
            var baseUrl = "<?php echo $c->get('http'); ?>";
        </script>

    </head>
    <body>
        <!-- nav_horizontal.php -->
        <?php require_once "{$c->get("views")}template/nav_horizontal.php"; ?>
        <!-- header.php -->
        <?php require_once "{$c->get("views")}template/header.php"; ?>
        <!-- msg.php -->
        <?php require_once "{$c->get("views")}template/msg.php"; ?>

        <div class="container" style="margin-top:30px">
            <!-- contenido principal -->
            <?php require_once "{$main}"; ?>
            <br>
            <br>
        </div>

<!--        <div class="row">
            <div class="col-2">
                <div class="menu">

                </div>
            </div>
            <div class="col-10">
                <div class="container" style="margin-top:30px">
                     contenido principal 
                    <?php require_once "{$main}"; ?>
                    <br>
                    <br>
                </div>
            </div>
        </div>-->

        <!-- footer.php --->
        <?php require_once "{$c->get("views")}template/footer.php"; ?>
    </body>
</html>