<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>html</title>
        <link href="{$RESOURCES}lib/bootstrap-star-rating/css/star-rating.min.css" rel="stylesheet">
        <link href="{$RESOURCES}lib/bootstrap-star-rating/themes/krajee-fas/theme.css" rel="stylesheet">
        <link rel="stylesheet" href="{$RESOURCES}/css/html.css">


</head>

<body>


        <div class="container">

                <div class="vacio"></div>
                <div class="container_menu">
                        <a href=""> <img src="resources/img/arrow-left.svg" width="15px" height="15px"> Regresar</a>
                        <br />
                        <br />
                        <div class="container_label_img">
                                <img src="resources/img/play-solid.svg" width="15px" height="15px">
                                <label>Actualiza tus datos</label>
                        </div>
                        <br />
                        <br />
                </div>


                <div class="contain_main">
                        <div class="container_left">

                                <div class="container_imagen_left"><img src="resources/img/Grupo698.png"></div>

                        </div>

                        <form class="form">

                                <input class="input" type="text" name="razon social" placeholder="Razón social" id="">



                                <div class="container_form">
                                        <input class="input" type="text" name="Empresa" placeholder="Nombre Empresa"
                                                id="">
                                        <input class="input" type="text" name="Nit" placeholder="NIT" id="">
                                </div>

                                <div class="container_form">
                                        <input class="input" type="text" name="telefono"
                                                placeholder="Número de Telefono" id="">
                                        <input class="input" type="text" name="celular" placeholder="Número de Celular"
                                                id="">
                                </div>


                                <div class="container_form">
                                        <select class="select" name="cantidad empleados"
                                                placeholder="Cantidad de Empleados" id="">
                                                <option hidden selected value="">Cantidad de Empleados</option>
                                                <option value="ggg">Menos de 10 Empleados</option>
                                                <option value="hhhhhh">Menos de 50 Empleados</option>
                                                <option value="bbbbbb">Menos de 250 Empleados</option>
                                                <option value="ffff">Más de 250 Empleados</option>
                                        </select>
                                        <select class="select" name="Numero celular" id="">
                                                <option hidden selected value="">Ciudad</option>
                                                <option value="">Bucaramanga/Santander</option>
                                                <option value="">Bucaramanga/Santander</option>
                                                <option value="">Bucaramanga/Santander</option>
                                                <option value="">Bucaramanga/Santander</option>
                                                <option value="">Bucaramanga/Santander</option>
                                                <option value="">Bucaramanga/Santander</option>
                                        </select>

                                </div>

                                <input class="input" type="text" name="sector economico" placeholder="Sector Economico"
                                        id="">

                        </form>

                        <div class="container_righ">

                                <div class="label"><label>Ingresa tu logo de Empresa</label></div>
                                <div class="div_round">
                                        <img src="resources/img/user-solid.svg" width="50%" height="50%"
                                                style="margin:0 auto;">
                                        <div class="circle"><img src="resources/img/image-solid.svg" width="50%"
                                                        height="50%" style="margin:0 auto;"></div>
                                </div>

                        </div>
                </div>


                <div class="boton">
                        <button class="btn" type="submit">Continuar</button>
                </div>

                <div class="foot">
                        <label>Esto es un producto creado por:</label>
                        <img src="resources/img/Grupo658.svg">
                </div>



        </div>
</body>
<!--<footer class="footer"><label></label><img src="resources/img/Grupo658.svg"></footer>-->

</html>