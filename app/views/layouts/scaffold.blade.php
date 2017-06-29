<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title', 'Inscripciones - Universidad del Chubut')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->        
        @include('layouts.assets')
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">Estás usando un navegador <strong>obsoleto</strong>. Por favor visita <a href="http://browsehappy.com/">actualiza tu navegador</a> para mejorar su experiencia en el sitio.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <!--<div>
            <div class="navbar navbar-header navbar-fixed-top">
              <div class="navbar-inner">
                <div class="container-fluid">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <div class="nav-collapse">
                      <a style="color: white" class="brand" href="#">Inicio</a>
                      <ul class="nav">
                          
                          <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Movimientos<b class="caret"></b></a>
                              <ul class="dropdown-menu">                          
                                  <li><a href="#"><i class="icon icon-road"></i> Mover producto/s</a></li>
                              </ul>
                          </li>
                          
                          <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Productos<b class="caret"></b></a>
                              <ul class="dropdown-menu">                                  
                                  <li><a href="#"><i class="icon icon-plus-sign"></i> Agregar Productos</a></li>
                                  <li><a href="#"><i class="icon icon-list"></i> Todos los Productos</a></li>
                                  <li><a href="#"><i class="icon icon-search"></i> Buscar un/os Producto/s</a></li>
                                  <li><a href="#"><i class="icon icon-barcode"></i> Imprimir Etiquetas</a></li>
                              </ul>
                          </li>
                          <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Listados y Filtros<b class="caret"></b></a> 
                              <ul class="dropdown-menu" role="menu">
                                  <li class="dropdown-submenu">
                                      <a tabindex="-1" href="#"><i class="icon icon-list-alt"></i> Puntos de Venta</a>
                                      <ul class="dropdown-menu">
                                          <li><a href="#"><i class="icon icon-chevron-right"></i> Stock por punto de venta</a></li>
                                          <li><a href="#"><i class="icon icon-chevron-right"></i> Listado de Prod. por punto de venta</a></li>
                                      </ul>
                                  </li>
                                  <li class="divider"></li>
                                  <li><a href="#"><i class="icon icon-share-alt"></i> Filtrado de productos</a></li>
                                  <li class="divider"></li>
                                  <li><a href="#"><i class="icon icon-share-alt"></i> Filtrado de movimientos</a></li>
                              </ul>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Opciones Básicas<b class="caret"></b></a> 
                             <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#"><i class="icon icon-share"></i> Artesanos</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#"><i class="icon icon-plus-sign"></i> Agregar Artesano</a></li>                                            
                                            <li><a href="#"><i class="icon icon-list"></i> Listado de Artesanos</a></li>
                                        </ul>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="icon icon-tag"></i> Localidades</a></li>
                                <li><a href="#"><i class="icon icon-tag"></i> Puntos de Venta</a></li>
                                <li><a href="#"><i class="icon icon-tag"></i> Rubros</a></li>
                                <li><a href="#"><i class="icon icon-tag"></i> Materia Primas</a></li>
                                <li><a href="#"><i class="icon icon-tag"></i> Técnicas</a></li>
                                <li><a href="#"><i class="icon icon-tag"></i> Interes de cultura</a></li>
                             </ul>
                          </li>                  
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios<b class="caret"></b></a> 
                             <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="icon icon-user"></i> Ingresar / Salir</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-submenu">
                                  <a tabindex="-1" href="#"><i class="icon icon-share"></i> Mas Opciones de usuarios</a>
                                  <ul class="dropdown-menu">
                                       <li><a href="#"><i class="icon icon-plus-sign"></i> Agregar usuario</a></li>
                                       <li class="divider"></li>
                                     <li><a href="#"><i class="icon icon-list"></i> Listado de usuarios</a></li>
                                  </ul>
                                </li>                        
                             </ul>
                          </li>
                      </ul>              
                  </div>
                </div>
              </div>
            </div>
        </div> -->
        <div class="container">
          <div class="row">
            <div class="col-md-12">
                @if (Session::has('message'))
                    {{ Session::get('message') }}
                @endif
                @yield('main')
            </div>
          </div>
        </div>
        <div class="footer">
            <div class="container">
                <div class="col-md-2"><a href="http://udc.edu.ar" target="_blank"><img src="{{asset('img/UDC-120-37-gray.png')}}"></a></div>
                <div class="col-md-2"><a href="http://www.chubut.gov.ar" target="_blank"><img src="{{asset('img/chubut-oficial-125-24-gray.png')}}"></a></div>
                <div class="col-md-8"> <p class="small">Creado por Universidad del Chubut. © 2014 UDC :: Derechos Reservados.<br>
                Lewis Jones 248 (9103) - Rawson, Chubut, Patagonia Argentina.</p></div>
            </div>
        </div>
    </body>
</html>
