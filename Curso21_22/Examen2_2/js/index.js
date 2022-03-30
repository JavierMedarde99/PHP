function comprobar_sin_aula(grupos,aula_vacia)
{
    var obj=document.getElementById("grupo");
    var selectedOption = obj.options[obj.selectedIndex];
  
    if(grupos.includes(parseInt(selectedOption.value)))
    {
        document.getElementById("aula").value=aula_vacia;
    }
    document.getElementById("error_form_anadir").innerHTML="";
}

function comprobar_anadir(grupos,aula_vacia)
{
    var obj1=document.getElementById("grupo");
    var selectedOption1 = obj1.options[obj1.selectedIndex];
    var obj2=document.getElementById("aula");
    var selectedOption2 = obj2.options[obj2.selectedIndex];
    
    if(!grupos.includes(parseInt(selectedOption1.value)) && parseInt(selectedOption2.value)==aula_vacia )
    {
        document.getElementById("error_form_anadir").innerHTML="Error: No le has asignado a un grupo un aula.";
    }
    else
    {
        var boton=document.getElementById("btnComprobarAula");
        boton.value=selectedOption1.text;
        boton.click();
    }
}

function cargar_valores_submit(grupo)
{
    document.getElementById("grupo_cambio").value=grupo;
    var obj=document.getElementById("select_confirmar");
    var selectedOption = obj.options[obj.selectedIndex];
    document.getElementById("aula_cambio").value=selectedOption.value;
    document.getElementById("btnCambiarAula").click();
}

function montar_modal_confirmar_aula(id_grupo,grupo,dia,hora)
{
        var contenido="<h2 class='centrar'>Cambio de Aula a "+grupo+" el "+dia+" a "+hora+"º hora</h2>";
        contenido+="<p class='centrar'>"+document.getElementById("div_confirmar").innerHTML+"</p>";
        contenido+="<p class='centrar'><button onclick='cerrar_modal_general();'>Cancelar</button> <button onclick='cargar_valores_submit("+id_grupo+")'>Continuar</button></p>";
        abrir_modal_general(contenido);
}