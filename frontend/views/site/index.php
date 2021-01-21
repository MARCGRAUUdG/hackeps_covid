<?php

use yii\helpers\Html;

$this->title = 'Ciberseguridad Grau';



?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
<style>
    body, html {
        height: 100%;
        font-family: "Inconsolata", sans-serif;
    }

    .menu {
        display: none;
    }
</style>
<body>
<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-grayscale w3-large">

    <!-- About Container -->
    <div class="w3-container" id="about">
        <div class="w3-content" style="max-width:700px">
            <h5 class="w3-center w3-padding-64"><span class="w3-tag w3-wide">SOBRE NOSOTROS</span></h5>
            <p>Somos un proyecto joven encargado de aportar mayor seguridad a las pequeñas y grandes empresas que nos rodean. Nuestro fin es encontrar todas las vulnerabilidades de nuestros clientes para que sufrir un ataque no sea la peor de sus pesadillas.</p>
            <p>Nuestra metodología es simple, nos basamos en los dos tipos de auditorias que nos han dado más resultado profesionalmente.</p>
            <div class="w3-panel w3-leftbar w3-light-grey">
                <p><i>Cuando la informática funciona bien, va MUY bien, pero cuando falla puede llegar a ser un gran desastre</i></p>
            </div>
            <img src="/images/cybersecurity.jpeg" style="width:100%;max-width:1000px" class="w3-margin-top">
            <p><strong>Disponibilidad:</strong> cada día de 8:00 a 18:00.</p>
        </div>
    </div>

    <!-- Menu Container -->
    <div class="w3-container" id="menu">
        <div class="w3-content" style="max-width:700px">

            <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">LOS PLANES</span></h5>

            <div class="w3-row w3-center w3-card w3-padding">
                <a href="javascript:void(0)" onclick="openMenu(event, 'Eat');" id="myLink">
                    <div class="w3-col s6 tablink">Pentesting</div>
                </a>
                <a href="javascript:void(0)" onclick="openMenu(event, 'Drinks');">
                    <div class="w3-col s6 tablink">Auditoria interna</div>
                </a>
            </div>

            <div id="Eat" class="w3-container menu w3-padding-48 w3-card">
                <h5>Test de intrusión</h5>
                <p class="w3-text-grey">Durante un margen de tiempo según el cliente, aplicaremos una de las más efectivas metodologías de seguridad ofensiva: nos haremos pasar por un atacante para encontrar las vulnerabilidades posibles des del exterior.</p><br>

                <h5>Margen de tiempo según cliente</h5>
                <p class="w3-text-grey">El cliente puede escoger el tiempo de ataque a su empresa.</p><br>

                <h5>Múltiples objetivos</h5>
                <p class="w3-text-grey">El cliente puede seleccionar los servidores que quiera que hagamos el test de intrusión, sean servidores web, de correo etc.</p><br>

                <h5>Mejores herramientas</h5>
                <p class="w3-text-grey">Nuestro equipo dispone de las mejores herramientas de hacking!</p><br>
            </div>

            <div id="Drinks" class="w3-container menu w3-padding-48 w3-card">
                <h5>Auditoria interna de seguridad informática</h5>
                <p class="w3-text-grey">Disponemos de un protocolo de ciberseguridad personalizado y óptimo para la máxima seguridad. Pero también utilizamos protocolos conocidos como ISO 27000 a petición del cliente.</p><br>

                <h5>Checklist y análisis de riesgos</h5>
                <p class="w3-text-grey">Nuestro protocolo personalizado consiste en un checklist adaptado al cliente así como un análisis de riesgos que nos pueden informar sobre puntos débiles y prioridad de reparación de las vulnerabilidades.</p><br>
            </div>
        </div>
    </div>

    <!-- Contact/Area Container -->
    <div class="w3-container" id="where" style="padding-bottom:32px;">
        <div class="w3-content" style="max-width:700px">
            <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">CONTACTA CON NOSOTROS</span></h5>
            <p>Nos puedes contactar llamando al 999999999 o enviando un correo a info@ciberseguridad-grau.com</p>
        </div>
    </div>

    <!-- End page content -->
</div>

<script>
    // Tabbed Menu
    function openMenu(evt, menuName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("menu");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" w3-dark-grey", "");
        }
        document.getElementById(menuName).style.display = "block";
        evt.currentTarget.firstElementChild.className += " w3-dark-grey";
    }
    document.getElementById("myLink").click();
</script>

</body>
</html>
