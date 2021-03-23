<?php
session_start();
if(!isset($_SESSION['nombre']))
{
  header("Location: index.php");
}
else
{
  echo '';
}
?>
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>SistemApp</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
    <link rel="stylesheet" href="Sistemapp.css" media="screen">
    <script class="u-script" type="text/javascript" src="js/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="js/nicepage.js" defer=""></script>
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "",
		"url": "index.html",
		"logo": "images/Captura.PNG"
    }</script>
    <meta property="og:title" content="Sistemapp">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#b9dfdf">
    <link rel="canonical" href="index.html">
    <meta property="og:url" content="index.html">
  </head>
  <body data-home-page="Sistemapp.html" data-home-page-title="Sistemapp" class="u-body">
    <header class="u-clearfix u-header u-white u-header" id="sec-edd5"><div class="u-clearfix u-sheet u-sheet-1">
        <a href="#" class="u-image u-logo u-image-1" data-image-width="321" data-image-height="54">
          <img src="images/Captura.PNG" class="u-logo-image u-logo-image-1" data-image-width="279.6667">
        </a>
        <nav class="u-menu u-menu-dropdown u-offcanvas u-menu-1">
          <div class="menu-collapse" style="font-size: 1rem; letter-spacing: 0px;">
            <a class="u-button-style u-custom-left-right-menu-spacing u-custom-padding-bottom u-custom-top-bottom-menu-spacing u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="#">
              <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#menu-hamburger"></use></svg>
              <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><symbol id="menu-hamburger" viewBox="0 0 16 16" style="width: 16px; height: 16px;"><rect y="1" width="16" height="2"></rect><rect y="7" width="16" height="2"></rect><rect y="13" width="16" height="2"></rect>
</symbol>
</defs></svg>
            </a>
          </div>
          <div class="u-nav-container">
            <ul class="u-nav u-spacing-25 u-unstyled u-nav-1">
              <li class="u-nav-item"><a class="u-button-style u-nav-link" href="#" style="padding: 8px 0px;">Inicio</a></li>
              <li class="u-nav-item"><a class="u-button-style u-nav-link" href="menuUsuarios.php" style="padding: 8px 0px;">Usuarios</a></li>
              <li class="u-nav-item"><a class="u-button-style u-nav-link" href="menuGrupos.php" style="padding: 8px 0px;">Grupos</a>
              <li class="u-nav-item"><a class="u-button-style u-nav-link" href="listadoServicios.php" style="padding: 8px 0px;">Servicios</a></li>
              <li class="u-nav-item"><a class="u-button-style u-nav-link" href="panelControl.php" style="padding: 8px 0px;">Panel de control</a></li>
              <li class="u-nav-item"><a class="u-button-style u-nav-link" href="cerrarSesion.php" style="padding: 8px 0px;">Cerrar Sesión</a></li>
              </li>
            </ul>
          </div>
          <div class="u-nav-container-collapse">
            <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
              <div class="u-sidenav-overflow">
                <div class="u-menu-close"></div>
                <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2">
                  <li class="u-nav-item"><a class="u-button-style u-nav-link" href="#">Inicio</a>
                  </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="menuUsuarios.php">Usuarios</a>
                  </li><li class="u-nav-item"><a class="u-button-style u-nav-link" href="menuGrupos.php">Grupos</a></li>
                  <li class="u-nav-item"><a class="u-button-style u-nav-link" href="listadoServicios.php">Servicios</a></li>
                  <li class="u-nav-item"><a class="u-button-style u-nav-link" href="panelControl.php">Panel de control</a></li>
                  <li class="u-nav-item"><a class="u-button-style u-nav-link" href="cerrarSesion.php">Cerrar Sesión</a></li>
                </ul>
              </div>
            </div>
            <div class="u-black u-menu-overlay u-opacity u-opacity-70"></div>
          </div>
        </nav>
      </div>
    </header> 
    <section class="u-clearfix u-image u-section-1" id="sec-bceb" data-image-width="900" data-image-height="470">
      <div class="u-clearfix u-sheet u-sheet-1">
        <img src="images/logo.png" alt="" class="u-image u-image-default u-preserve-proportions u-image-1" data-image-width="200" data-image-height="200">
        <h2 class="u-align-center u-subtitle u-text u-text-1">La mejor aplicación para administrar tu sistema Linux</h2>
      </div>
    </section>
    <section class="u-clearfix u-section-2" id="carousel_7b66">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-clearfix u-expanded-width u-gutter-0 u-layout-spacing-top u-layout-wrap u-layout-wrap-1">
          <div class="u-gutter-0 u-layout">
            <div class="u-layout-row">
              <div class="u-container-style u-layout-cell u-left-cell u-size-30 u-layout-cell-1">
                <div class="u-container-layout u-container-layout-1">
                  <h5 class="u-text u-text-1">SISTEMAPP</h5>
                  <h2 class="u-text u-text-2">Gestión del sistema</h2>
                  <p class="u-text u-text-3">Un problema que puede tener la gestión del sistema ubuntu, es que para algunos usuarios no les puede resultar muy clara la interfaz a simple vista, y, por otro lado, no tienen conocimientos del uso de la terminal para llevar a cabo la gestión del sistema.<br>Con esta aplicación web, se conseguirá la vista y gestión de usuarios y grupos del sistema, información sobre los servicios y servidores instalados, y vista de algunos parámetros del sistema.
                  </p>
                </div>
              </div>
              <div class="u-align-left u-container-style u-image u-layout-cell u-right-cell u-size-30 u-image-1" data-image-width="400" data-image-height="300">
                <div class="u-container-layout u-valign-middle u-container-layout-2" src=""></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="u-clearfix u-grey-80 u-section-3" id="sec-c5d4">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-clearfix u-expanded-width u-gutter-10 u-layout-spacing-vertical u-layout-wrap u-layout-wrap-1">
          <div class="u-layout">
            <div class="u-layout-row">
              <div class="u-align-left u-container-style u-layout-cell u-left-cell u-size-20 u-size-20-md u-layout-cell-1">
                <div class="u-container-layout u-valign-middle-xs u-container-layout-1">
                  <img src="images/visualizacion.png" alt="" class="u-image u-image-default u-preserve-proportions u-image-1" data-image-width="128" data-image-height="128">
                  <h3 class="u-text u-text-palette-2-base u-text-1">Visualización</h3>
                  <p class="u-text u-text-2">Podrás ver un listado de los usuarios y grupos de tu sistema, en caso de que necesites alguna información sobre ellos.</p>
                </div>
              </div>
              <div class="u-align-left u-container-style u-layout-cell u-size-20 u-size-20-md u-layout-cell-2">
                <div class="u-container-layout u-valign-middle-xs u-container-layout-2">
                  <img src="images/47.png" alt="" class="u-image u-image-default u-preserve-proportions u-image-2" data-image-width="256" data-image-height="256">
                  <h3 class="u-text u-text-palette-2-base u-text-3">Gestión</h3>
                  <p class="u-text u-text-4">Podrás añadir o eliminar usuarios y grupos del sistema, añadir usuarios a grupos. Incluso, podrás hacer copias de seguridad en una base de datos.&nbsp;</p>
                </div>
              </div>
              <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-20 u-size-20-md u-layout-cell-3">
                <div class="u-container-layout u-valign-middle-xs u-container-layout-3">
                  <img src="images/info4.png" alt="" class="u-image u-image-default u-preserve-proportions u-image-3" data-image-width="256" data-image-height="256">
                  <h3 class="u-text u-text-palette-2-base u-text-5">Información</h3>
                  <p class="u-text u-text-6">Podrás ver información del sistema, ver el estado de los servicios e instalados en el sistema, etc.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="u-clearfix u-section-4" id="sec-1c2f">
      <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <div class="u-clearfix u-expanded-width u-gutter-0 u-layout-spacing-top u-layout-wrap u-layout-wrap-1">
          <div class="u-gutter-0 u-layout">
            <div class="u-layout-row">
              <div class="u-align-left u-container-style u-layout-cell u-left-cell u-size-30 u-layout-cell-1">
                <div class="u-container-layout u-valign-middle u-container-layout-1" src="">
                  <img class="u-expanded-width-sm u-expanded-width-xs u-image u-image-1" src="images/logo.png" data-image-width="200" data-image-height="200">
                </div>
              </div>
              <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-30 u-layout-cell-2">
                <div class="u-container-layout u-valign-bottom-md u-container-layout-2">
                  <img src="images/1q1.png" alt="" class="u-image u-image-default u-image-2" data-image-width="395" data-image-height="396">
                  <h2 class="u-text u-text-1">Información sobre Linux</h2>
                  <p class="u-text u-text-2">En caso de que quieras hacer uso de esta aplicación, debes tener un sistema Linux instalado. Para ello, te dejaremos el enlace en el botón de abajo, para que accedas a la página oficial de Ubuntu y te puedas descargar su Sistema Operativo. Ubuntu es la distribución de Linux en la que fue desarrollada la aplicación, pero puedes hacer uso de otras distribuciones de Linux como Mint, Debian, Lubuntu y demás.&nbsp;</p>
                  <a href="https://ubuntu.com/download" class="u-border-none u-btn u-button-style u-palette-1-base u-btn-1">Pulsa aquí</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    
    <footer class="u-clearfix u-footer u-palette-3-base u-footer" id="sec-f2e8"><div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-align-center u-container-style u-expanded-width-sm u-expanded-width-xs u-group u-group-1">
          <div class="u-container-layout u-container-layout-1">
            <p class="u-text u-text-1">Sistemapp - Álvaro Jenaro Rodríguez Ortiz</p>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>