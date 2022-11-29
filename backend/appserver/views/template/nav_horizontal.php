<?php
$c = Config::singleton();
?>
<div id="myMenu">
    <nav
        class="navbar navbar-toggleable-md navbar-inverse fixed-top navbar navbar-expand-sm <?php echo $c->get("pclass") ?> navbar-dark text-white">
        <a class="navbar-brand" href="?">Inicio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">

            <ul class='nav nav-pills'>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle text-white' data-toggle='dropdown' href='#'>client</a>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item' href='?c=client&a=viewCreate'>Nuevo registro</a>
                        <a class='dropdown-item' href='?c=client'>Listar registros</a>
                    </div>
                </li>

                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle text-white' data-toggle='dropdown' href='#'>copy</a>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item' href='?c=copy&a=viewCreate'>Nuevo registro</a>
                        <a class='dropdown-item' href='?c=copy'>Listar registros</a>
                    </div>
                </li>

                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle text-white' data-toggle='dropdown' href='#'>film</a>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item' href='?c=film&a=viewCreate'>Nuevo registro</a>
                        <a class='dropdown-item' href='?c=film'>Listar registros</a>
                    </div>
                </li>

                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle text-white' data-toggle='dropdown' href='#'>rent</a>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item' href='?c=rent&a=viewCreate'>Nuevo registro</a>
                        <a class='dropdown-item' href='?c=rent'>Listar registros</a>
                    </div>
                </li>
            </ul>

        </div>
    </nav>
</div>