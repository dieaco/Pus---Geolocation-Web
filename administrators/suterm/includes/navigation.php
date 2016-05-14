<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-ex1-collapse" aria-expanded="false">
        <span class="sr-only">Navegación</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">PUSH</a>
</div>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="navbar-ex1-collapse">
    <ul id="ulPrincipal" class="nav navbar-nav">
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php if(isset($_SESSION['username'])){echo $_SESSION['username'];} ?><span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="includes/adminLogout.php"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión</a></li>
            </ul>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Envío de mensajes<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="MiSUTERM.php"><i class="fa fa-users fa-1x"></i> Mensajes masivos</a></li>
                <li><a href="MiSUTERM2.php"><i class="fa fa-user fa-1x"></i> Mensajes personalizados</a></li>
            </ul>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Listados <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="allMessages.php"><i class="fa fa-globe fa-1x"></i> Control de mensajes masivos</a></li>
                <li><a href="readMassiveMessages.php"><span class="glyphicon glyphicon-ok"></span> Tablero de mensajes masivos</a></li>
                <li><a href="userMassiveMessages.php"><span class="glyphicon glyphicon-ok"></span> Tablero de mensajes masivos por usuario</a></li> 
            </ul>
        </li>                                                                     
    </ul>      
</div><!-- /.navbar-collapse -->