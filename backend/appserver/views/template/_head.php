<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?php echo $c->get("title") ?></title>
<!-- Bootstrap CSS -->
<link href="<?php echo $c->get("css") ?>bootstrap-4.1.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?php echo $c->get("css") ?>style.css" rel="stylesheet" type="text/css"/>
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="<?php echo $c->get("clibs") ?>jqueryui/external/jquery/jquery.js"></script>-->
<script src="<?php echo $c->get("clibs") ?>jquery.js"></script>
<script>
var thisUrl = "<?php echo $c->get("http") ?>";
var baseUrl = "<?php echo $c->get("http") ?>";
var controller = "<?php echo @$_REQUEST["c"] ?>";
</script>
<script src="<?php echo $c->get("css") ?>bootstrap-4.1.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $c->get("js") ?>core.js" type="text/javascript"></script>
<script src="<?php echo $c->get("js") ?>index.js" type="text/javascript"></script>