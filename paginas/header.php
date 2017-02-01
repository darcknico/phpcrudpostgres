<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="CRUD con POSTGRESQL" content="">
    <meta name="Ricardo Lera" content="">

    <title>PHP CRUD POSTGRESQL</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts ICONOS -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->




</head>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Administrador</a>
            </div>
            <!-- /.navbar-header -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="<?php echo $pagina == 'inicio' ? 'active' : ''; ?>">
                            <a href="?p=inicio"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li class="<?php echo $pagina == 'clientes' ? 'active' : ''; ?>">
                            <a href="?p=clientes"><i class="fa fa-bar-chart-o fa-fw"></i> Clientes</a>
                        </li>
                        <li class="<?php echo $pagina == 'facturas' ? 'active' : ''; ?>">
                            <a href="?p=facturas"><i class="fa fa-table fa-fw"></i> Facturas</a>
                        </li>
                        <li class="<?php echo $pagina == 'productos' ? 'active' : ''; ?>">
                            <a href="?p=productos"><i class="fa fa-edit fa-fw"></i> Productos</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>


    <script src="js/jquery-3.1.1.min.js" type="text/javascript"> </script>
    <script src="js/bootstrap.min.js" type="text/javascript"> </script>