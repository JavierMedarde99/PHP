<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría SW </title>
</head>
<body>
    <?php
        function consumir_servicios_REST($url,$metodo,$datos=null)
        {
            $llamada=curl_init();
            curl_setopt($llamada,CURLOPT_URL,$url);
            curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
            if(isset($datos))
                curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
            $respuesta=curl_exec($llamada);
            curl_close($llamada);
            return json_decode($respuesta);
        }



        define('DIR_SERV','http://localhost/Proyectos/Curso21_22/Servicios_Web/Teor_SW/servicios_rest_teor');

        $url=DIR_SERV."/saludo";

        $llamada=curl_init();  
        curl_setopt($llamada,CURLOPT_URL,$url);
        curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,"GET");
        $respuesta=curl_exec($llamada);
        curl_close($llamada);

        $obj=json_decode($respuesta);

        if(!$obj)
            die("<p>Error consumiendo el servicio web: ".$url."</p>".$respuesta);

        echo "<p>".$obj->msj."</p>";
        echo "<hr/>";

        $datosPost["saludos1"]="Hola Redouan";
        $datosPost["saludos2"]="Hola Laura";
        $url=DIR_SERV."/nuevo_saludo";
        /*$llamada=curl_init();
        curl_setopt($llamada,CURLOPT_URL,$url);
        curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datosPost));
        $respuesta=curl_exec($llamada);
        curl_close($llamada);

        $obj=json_decode($respuesta);*/
        $obj=consumir_servicios_REST($url,"POST",$datosPost);

        if(!$obj)
            die("<p>Error consumiendo el servicio web: ".$url."</p>".$respuesta);

        echo "<p>".$obj->msj."</p>";
        echo "<hr/>";

        $url=DIR_SERV."/borrar_saludo/5";
        $obj=consumir_servicios_REST($url,"DELETE");
        if(!$obj)
            die("<p>Error consumiendo el servicio web: ".$url."</p>".$respuesta);

        echo "<p>".$obj->msj."</p>";
        echo "<hr/>";

        $url=DIR_SERV."/modificar_saludo/3/".urlencode('Hola Ángel');
        $obj=consumir_servicios_REST($url,"PUT");
        if(!$obj)
            die("<p>Error consumiendo el servicio web: ".$url."</p>".$respuesta);

        echo "<p>".$obj->msj."</p>";
        echo "<hr/>";

        $url=DIR_SERV."/modificar_saludo/8";
        $datosPut["nuevo_valor"]="Hola Raquel";

        $obj=consumir_servicios_REST($url,"PUT",$datosPut);
        if(!$obj)
            die("<p>Error consumiendo el servicio web: ".$url."</p>".$respuesta);

        echo "<p>".$obj->msj."</p>";
        echo "<hr/>";
    ?>
</body>
</html>