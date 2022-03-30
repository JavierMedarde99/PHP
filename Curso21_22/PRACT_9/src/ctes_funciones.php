<?php
    
    define("IMAGEN_DEFECTO","no_imagen.jpg");
    
    define("SERVIDOR_BD","localhost");
    define("USUARIO_BD","jose");
    define("CLAVE_BD","josefa");
    define("NOMBRE_BD","bd_videoclub");
    


    function error_page($title,$body)
    {
        $html='<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html.='<title>'.$title.'</title></head>';
        $html.='<body>'.$body.'</body></html>';
        return $html;
    }

    function repetido($conexion, $tabla, $columna, $valor_colum,$primary_key=null,$valor_pk=null)
    {
        if(isset($primary_key))
            $consulta="select ".$columna." from ".$tabla." where ".$columna."='".$valor_colum."' and ".$primary_key."<>'".$valor_pk."'";
        else 
            $consulta="select ".$columna." from ".$tabla." where ".$columna."='".$valor_colum."'";
        
        $resultado=mysqli_query($conexion, $consulta);
        if($resultado)
        {
            $respuesta=mysqli_num_rows($resultado)>0;
            mysqli_free_result($resultado);
        }
        else
            $respuesta["error"]="Imposible realizar la consulta. Nº".mysqli_errno($conexion)." : ".mysqli_error($conexion);

        return $respuesta;
    }

    function LetraNIF($dni) 
    {  
         return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1); 
    } 
    
    function dni_bien_escrito($texto)
    {
        $dni=strtoupper($texto);
        return strlen($dni)==9 && is_numeric(substr($dni,0,8)) && substr($dni,-1)>="A" && substr($dni,-1)<="Z"; 
    
    }
    
    function dni_valido($dni)
    {
        return LetraNIF(substr($dni,0,8))==strtoupper(substr($dni,-1));
    }

?>
