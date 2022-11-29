<?php
if (@$r->status == 200) {
    ?>
    <div class="alert alert-success">
        <strong>Success!</strong> <?php echo $r->message ?>
    </div>
    <?php
} else if (@$r->status > 200) {
    ?>
    <div class="alert alert-danger">
        <strong>Danger!</strong> <?php echo $r->message ?>
    </div>
    <?php
}
?>
<div id="content-msg-js">
    <div class="row">
        <div class="col-sm-12">
            <!--
            <div class="alert alert-success">
                <strong>Success!</strong> You should <a href="#" class="alert-link">read this message</a>.
            </div>
            <div class="alert alert-info">
                <strong>Info!</strong> You should <a href="#" class="alert-link">read this message</a>.
            </div>
            <div class="alert alert-warning">
                <strong>Warning!</strong> You should <a href="#" class="alert-link">read this message</a>.
            </div>
            <div class="alert alert-danger">
                <strong>Danger!</strong> You should <a href="#" class="alert-link">read this message</a>.
            </div>
            -->
        </div>
    </div>
</div>
