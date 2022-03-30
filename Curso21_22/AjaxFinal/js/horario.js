function obtener_vista_normal(id_usuario, nombre_usuario) {

    $.ajax({
        url: encodeURI(DIR_SERV + "/horario/" + id_usuario),
        type: "GET",
        dataType: "json"

    }).done(function (data) {

        if (data.no_auth) {

            saltar_a("index.html");
        } else if (data.horario) {

            let semana = ["", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
            let horas = ["", "8:15- 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45"];
            let output = "<h2>Horario del profesor: " + nombre_usuario + "</h2>";
            output += "<table class='table table-responsive table-striped'>";
            output += "<tr><th></th><th>" + semana[1] + "</th><th>" + semana[2] + "</th><th>" + semana[3] + "</th><th>" + semana[4] + "</th><th>" + semana[5] + "</th></tr>";
            output += "<tr>";

            for (let i = 1; i <= 7; i++) {

                output += "<th>" + horas[i] + "</th>";

                if (i == 4) {

                    output += "<td colspan = 5 >RECREO</td>";
                } else {

                    for (let j = 1; j <= 5; j++) {

                        output += "<td>";
                        let grupos_usuario = [];
                        let grupos_aula;
                        $.each(data.horario, function (key, value) {

                            if (value.dia == j && value.hora == i) {

                                grupos_usuario.push(value.grupo);
                                grupos_aula = value.aula;
                            }
                        });

                        if (grupos_usuario.length > 0) {

                            output += grupos_usuario[0];
                        }

                        if (grupos_usuario.length > 1) {

                            for (let k = 1; k < grupos_usuario.length; k++) {

                                output += "/" + grupos_usuario[k];
                            }
                        }

                        if (grupos_aula != undefined && grupos_aula != "Sin asignar o sin aula") {

                            output += "<br/>(" + grupos_aula + ")";
                        }

                        output += "</td>";
                    }
                }
                output += "</tr>";
            }
            output += "</table>";
            $("#tabla_horarios").html(output);
        } else {

            cargar_vista_error(data.error);
        }

    }).fail(function (a, b) {

        cargar_vista_error(error_ajax_jquery(a, b));
    });
}

function volver() {

    $.ajax({
        url: DIR_SERV + "/logueado",
        type: "GET",
        dataType: "json"

    }).done(function (data) {

        if (data.usuario) {

            $("#respuesta").html("");
        }
        else if (data.error) {

            cargar_vista_error(data.error);
        }
        else {

            saltar_a("index.html")
        }

    }).fail(function (a, b) {

        cargar_vista_error(error_ajax_jquery(a, b));
    });
}

function obtener_vista_admin() {

    $.ajax({
        url: encodeURI(DIR_SERV + "/usuarios"),
        type: "GET",
        dataType: "json"

    }).done(function (data) {

        if (data.no_auth) {

            saltar_a("index.html");

        } else if (data.usuarios) {

            let output = "<form id='formAdmin' onsubmit='obtener_horario_admin();event.preventDefault();'>";
            output += "<label>Seleccione el profesor</label> <select class='form-select' name='nombres' id='nombres'>";
            $.each(data.usuarios, function (key, value) {

                output += "<option value='" + value["id_usuario"] + "-" + value["nombre"] + "'>" + value["nombre"] + "</option>";
            });
            output += "</select> <button class='btn btn-primary'>Ver Horario</button>";
            output += "</form>";
            $('#vista_admin').html(output);
        }

    }).fail(function (a, b) {

        cargar_vista_error(error_ajax_jquery(a, b));
    });
}

function obtener_horario_admin() {

    var datos_profesor = $("#nombres").val().split("-");
    var id_usuario = datos_profesor[0];
    var nombre = datos_profesor[1];

    $.ajax({
        url: encodeURI(DIR_SERV + "/horario/" + id_usuario),
        type: "GET",
        dataType: "json"

    }).done(function (data) {

        if (data.no_auth) {

            saltar_a("index.html");
        } else if (data.horario) {

            let semana = ["", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
            let horas = ["", "8:15- 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45"];
            let output = "<h2>Horario del profesor: " + nombre + "</h2>";
            output += "<table class='table table-dark table-hover'>";
            output += "<tr><th></th><th>" + semana[1] + "</th><th>" + semana[2] + "</th><th>" + semana[3] + "</th><th>" + semana[4] + "</th><th>" + semana[5] + "</th></tr>";
            output += "<tr>";

            for (let i = 1; i <= 7; i++) {

                output += "<th>" + horas[i] + "</th>";

                if (i == 4) {

                    output += "<td colspan=5>RECREO</td>";
                } else {

                    for (let j = 1; j <= 5; j++) {

                        output += "<td>";

                        let grupos_usuario = [];
                        let grupos_id_usuario = [];
                        let grupos_aula;
                        let grupos_id_aula;

                        $.each(data.horario, function (key, value) {

                            if (value.dia == j && value.hora == i) {

                                grupos_usuario.push(value.grupo);
                                grupos_id_usuario.push(value.id_grupo);
                                grupos_aula = value.aula;
                                grupos_id_aula = value.id_aula;
                            }
                        });

                        if (grupos_usuario.length > 0) {

                            output += grupos_usuario[0];
                        }

                        if (grupos_usuario.length > 1) {

                            for (let k = 1; k < grupos_usuario.length; k++) {

                                output += "/" + grupos_usuario[k];
                            }
                        }

                        if (grupos_aula != undefined && grupos_aula != "Sin asignar o sin aula") {

                            output += "<br/>(" + grupos_aula + ")";
                        }
                        output += "<br/><button class='btn btn-primary' class='enlace' onclick='editar_grupos(\"" + j + "\", \"" + i + "\", \"" + id_usuario + "\", \"" + grupos_aula + "\", \"" + grupos_id_aula + "\");event.preventDefault();'>Editar</button>";
                        output += "</td>";
                    }
                }
                output += "</tr>";
            }
            output += "</table>";

            $("#tabla_horarios").html(output);
            $("#editar_horario").html("");

        } else {

            cargar_vista_error(data.error);
        }

    }).fail(function (a, b) {

        cargar_vista_error(error_ajax_jquery(a, b));
    });
}

function editar_grupos(dia, hora, id_usuario, aula, id_aula) {

    $.ajax({
        url: encodeURI(DIR_SERV + "/grupos/" + dia + "/" + hora + "/" + id_usuario),
        type: "GET",
        dataType: "json"

    }).done(function (data) {

        let semana = ["", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
        let horas = ["", "8:15- 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45"];
        let dibuja_hora = hora;
        if (hora > 4) {

            dibuja_hora--;
        }

        let output = "<h2>Editando la " + dibuja_hora + "º hora (" + horas[hora] + ") del " + semana[dia] + "</h2>";
        output += "<table id='tabla_editado' class='table table-dark table-hover'>";
        output += "<tr><th>Grupo (Aula)</th><th>Acción</th></tr>";
        $.each(data.grupos, function (key, value) {

            output += "<tr><td>" + value.grupo + " (" + aula + ")</td><td><button  class='btn btn-primary' class='enlace' onclick='borrar_grupo(\"" + dia + "\", \"" + hora + "\", \"" + id_usuario + "\", \"" + value.id_grupo + "\", \"" + aula + "\", \"" + id_aula + "\");event.preventDefault();'>Quitar</button></td></tr>";
        });
        output += "</table>";

        output += "<form onsubmit='aniadir_grupo(\"" + dia + "\", \"" + hora + "\", \"" + id_usuario + "\");event.preventDefault();'>";

        let filas_tabla = output.match(/<tr>/g);

        if (aula == "Sin asignar o sin aula" && filas_tabla.length == 1) {

            output += "<label>Grupo:</label>";
            output += "<select class='form-select' onchange='sin_aula(\"" + dia + "\", \"" + hora + "\")' name='grupos_libres' id='grupos_libres'>";
            grupos_libres(dia, hora, id_usuario);
            output += "</select>";

            output += "<label>Aula:</label><select class='form-select' name='aulas' id='aulas'>";

            if (aula == "undefined" || aula == "Sin asignar o sin aula") {

                mostrar_aulas(dia, hora);
            } else {

                output += "<option value='" + id_aula + "-" + aula + "'>" + aula + "</option>";
            }

            output += "</select>";
            output += "<button class='btn btn-primary' >Añadir</button>";

        } else if (aula != "Sin asignar o sin aula") {

            output += "<label>Grupo:</label>";
            output += "<select class='form-select' onchange='sin_aula(\"" + dia + "\", \"" + hora + "\", \"" + id_aula + "\")' name='grupos_libres' id='grupos_libres'>";
            if (filas_tabla.length == 1) {

                grupos_libres(dia, hora, id_usuario, false);
            } else {

                grupos_libres(dia, hora, id_usuario, true);
            }
            output += "</select>";

            output += "<label>Aula:</label><select class='form-select' name='aulas' id='aulas'>";

            if (aula == "undefined") {

                mostrar_aulas(dia, hora, aula);
            } else {

                output += "<option value='" + id_aula + "-" + aula + "'>" + aula + "</option>";
            }


            output += "</select>";
            output += "<button class='btn btn-primary'>Añadir</button>";

        } else {

            output += "<label>Grupo:</label><select class='form-select' disabled></select>";
            output += "<label>Aula:</label><select class='form-select' disabled></select>";
            output += "<button  class='btn btn-primary' disabled>Añadir</button>";
        }

        output += "</form><br/><div id='info_obtenida'></div>";
        $("#editar_horario").html(output);

    }).fail(function (a, b) {

        cargar_vista_error(error_ajax_jquery(a, b));
    });
}

function sin_aula(dia, hora, id_aula) {

    let valor = $("#grupos_libres").val().split("-");

    if (valor[1].startsWith('G') || valor[1].startsWith('F')) {

        $("select#aulas").html("");
        let datos = $("#grupos_libres").val().split("-");

        if (datos[1].match(/^[a-zA-Z]/)) {

            $.ajax({

                url: encodeURI(DIR_SERV + "/aulasLibres/" + dia + "/" + hora),
                type: "GET",
                dataType: "json"

            }).done(function (data) {

                let output = "<optgroup label='Libres'>";
                output += "<option value='64-Sin asignar o sin aula'>Sin asignar o sin aula</option>";
                $("select#aulas").html(output);

            }).fail(function (a, b) {

                cargar_vista_error(error_ajax_jquery(a, b));
            });
        } else {

            mostrar_aulas(dia, hora);
        }
    } else {

        if ($("#tabla_editado").children().children().eq(1).length != 0) {

            let claseEntera = $("#tabla_editado").children().children().eq(1).children().eq(0).html()

            claseEntera = claseEntera.split("(")

            let aula = claseEntera[1].substr(0, claseEntera[1].length - 1)

            let output = "<option value='" + id_aula + "-" + aula + "'>" + aula + "</option>";
            $("select#aulas").html(output);
        } else {

            mostrar_aulas(dia, hora);
        }
    }
}

function mostrar_aulas(dia, hora, aula = null, id_aula = null, fila_tabla = null) {

    $.ajax({

        url: encodeURI(DIR_SERV + "/aulasLibres/" + dia + "/" + hora),
        type: "GET",
        dataType: "json"

    }).done(function (data) {

        let output = "<optgroup label='Libres'>";

        if (aula && id_aula && fila_tabla && fila_tabla > 2) {

            output += "<option value='" + id_aula + "-" + aula + "'>" + aula + "</option>";
            $("select#aulas").html(output);
        } else {

            $.each(data.aulas_libres, function (key, value) {

                output += "<option value='" + value.id_aula + "-" + value.aula + "'>" + value.aula + "</option>";
            });

            $.ajax({

                url: encodeURI(DIR_SERV + "/aulasOcupadas/" + dia + "/" + hora),
                type: "GET",
                dataType: "json"

            }).done(function (data) {

                output += $("select#aulas").html("");
                output += "<optgroup label='Ocupadas'>";

                $.each(data.aulas_ocupadas, function (key, value) {

                    output += "<option value='" + value.id_aula + "-" + value.aula + "'>" + value.aula + "</option>";
                });



                $("select#aulas").html(output);

            }).fail(function (a, b) {

                cargar_vista_error(error_ajax_jquery(a, b));
            });
        }

    }).fail(function (a, b) {

        cargar_vista_error(error_ajax_jquery(a, b));
    });

}

function grupos_libres(dia, hora, id_usuario, asignado = null) {

    $.ajax({

        url: encodeURI(DIR_SERV + "/gruposLibres/" + dia + "/" + hora + "/" + id_usuario),
        type: "GET",
        dataType: "json"

    }).done(function (data) {
        let output = "<optgroup label='Con Aula'>";

        $.each(data.grupos, function (key, value) {

            if (value.grupo.match(/^[^a-zA-Z]/)) {

                output += "<option value='" + value.id_grupo + "-" + value.grupo + "'>" + value.grupo + "</option>";
            }
        });

        if (!asignado) {

            output += "<optgroup label='Sin Aula'>";

            $.each(data.grupos, function (key, value) {

                if (value.grupo.match(/^[a-zA-Z]/)) {

                    output += "<option value='" + value.id_grupo + "-" + value.grupo + "'>" + value.grupo + "</option>";
                }
            });
        }

        $("select#grupos_libres").html(output);

    }).fail(function (a, b) {

        cargar_vista_error(error_ajax_jquery(a, b));
    });
}

function aniadir_grupo(dia, hora, id_usuario) {

    let select_de_grupos = $("#grupos_libres").val().split("-");
    let select_de_aulas = $("#aulas").val().split("-");
    let semana = ["", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];

    $.ajax({

        url: encodeURI(DIR_SERV + "/comprobar_al_aniadir/" + dia + "/" + hora + "/" + select_de_aulas[0]),
        type: "GET",
        dataType: "json"

    }).done(function (data) {
        let i = 0
        if (data.profesor!=undefined ) {

            
            

            
            let bandera = false

             while(data.profesor[i]){

           
                if (data.profesor !== undefined) {

                    
                    if (data.profesor[i].grupo == select_de_grupos[0]) {

                        bandera = true
                        break;
                    }

                    i++
                } else {
                    break;
                }
            } ;
            
            
            if (!bandera) {

                let html_code = "<h2 class='centrar'>Confirmación Cambio de Aula del " + semana[dia] + " a " + hora + "º Hora</h2>";
                html_code += "<p class='centrar'>Has seleccionado un aula que está usada por el ";

                let profesores = [];
                let repetido = [];
                let sinrepetir=[];
                
                if (data.profesor.length == 1 && data.profesor[0]==data.profesor[1]) {

                    profesores.push(data.profesor.usuario);
                    html_code += data.profesor[0].usuario;
                } else {

                    $.each(data.profesor, function (key, value) {

                        profesores.push(value.usuario) + "-";
                        repetido.push(value.usuario)
                        sinrepetir = repetido.filter((i,e)=>{
                            return repetido.indexOf(i)==e;
                        })
                        
                        console.log(data.profesor[0].nombre_grupo)
                    });

                    for(let j=0;j<sinrepetir.length;j++){
                        html_code += "profesor " + sinrepetir[j] + ", ";
                        
                    }
                }
                
                html_code += " en el grupo "
                for(let j=0;j<sinrepetir.length;j++){
                    if(j==sinrepetir.length-1)
                    html_code+=data.profesor[j].nombre_grupo+"."
                    else
                    html_code+=data.profesor[j].nombre_grupo+","
                }
                html_code += "</p>";
                html_code += "<p class='centrar'>Para añadir este aula a " + select_de_grupos[1] + ", debes cambiarle antes el aula a " 
                for(let j=0;j<sinrepetir.length;j++){
                    if(j==sinrepetir.length-1)
                    html_code+=data.profesor[j].nombre_grupo+"."
                    else
                    html_code+=data.profesor[j].nombre_grupo+","
                }
                html_code+= "</p>";
                html_code += "<p class='centrar'><button class='btn btn-primary' onclick='cerrar_modal();'>Cancelar</button> <button class='btn btn-primary' onclick='selec_aula(\"" + dia + "\", \"" + hora + "\",\"" + profesores + "\",\"" + id_usuario + "\",\"" + data.profesor[0].nombre_grupo + "\");event.preventDefault();'>Cambiar</button></p>";

                
                let flag = false;

                for (let i = 0; i < profesores.length; i++) {

                    if (id_usuario == profesores[i]) {

                        flag = true;
                        break;
                    }
                }

                if (!flag) {

                    abrir_modal(html_code);
                } else {

                    $.ajax({
                        url: encodeURI(DIR_SERV + "/insertarGrupo/" + dia + "/" + hora + "/" + id_usuario + "/" + select_de_grupos[0] + "/" + select_de_aulas[0]),
                        type: "POST",
                        dataType: "json"

                    }).done(function (data) {

                        obtener_horario_admin();
                        editar_grupos(dia, hora, id_usuario, select_de_aulas[1], select_de_aulas[0]);

                    }).fail(function (a, b) {

                        cargar_vista_error(error_ajax_jquery(a, b));
                    });
                }

            } else {

                if (select_de_grupos[1].match(/^[^a-zA-Z]/) && select_de_aulas[0] == 64) {

                    $("#info_obtenida").html("Error: No le ha asignado un grupo a un aula");
                } else {

                    $.ajax({
                        url: encodeURI(DIR_SERV + "/insertarGrupo/" + dia + "/" + hora + "/" + id_usuario + "/" + select_de_grupos[0] + "/" + select_de_aulas[0]),
                        type: "POST",
                        dataType: "json"

                    }).done(function (data) {

                        obtener_horario_admin();
                        editar_grupos(dia, hora, id_usuario, select_de_aulas[1], select_de_aulas[0]);

                    }).fail(function (a, b) {

                        cargar_vista_error(error_ajax_jquery(a, b));
                    });
                }
            }
        } else {

            if (select_de_grupos[1].match(/^[^a-zA-Z]/) && select_de_aulas[0] == 64) {

                $("#info_obtenida").html("Error: No le ha asignado un grupo a un aula");
            } else {

                $.ajax({
                    url: encodeURI(DIR_SERV + "/insertarGrupo/" + dia + "/" + hora + "/" + id_usuario + "/" + select_de_grupos[0] + "/" + select_de_aulas[0]),
                    type: "POST",
                    dataType: "json"

                }).done(function (data) {

                    obtener_horario_admin();
                    editar_grupos(dia, hora, id_usuario, select_de_aulas[1], select_de_aulas[0]);

                }).fail(function (a, b) {

                    cargar_vista_error(error_ajax_jquery(a, b));
                });
            }
        }
    }).fail(function (a, b) {
        cargar_vista_error(error_ajax_jquery(a, b));
    });

}

function selec_aula(dia, hora, id_usuarios_antiguos, id_usuario, aula) {

    semana = ["", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
    cerrar_modal();

    let html_code = "<h2 class='centrar'> Cambio de Aula " + aula + " del " + semana[dia] + " a " + hora + "º Hora</h2>";
    html_code += "<p class='centrar'>Elija un nuevo aula libre: <select class='form-select' id='cambio_aula'>";

    $.ajax({

        url: encodeURI(DIR_SERV + "/aulasLibres/" + dia + "/" + hora),
        type: "GET",
        dataType: "json"

    }).done(function (data) {

     
        $.each(data.aulas_libres, function (key, value) {

            if (value.aula != "Sin asignar o sin aula") {

                html_code += "<option value='" + value.id_aula + "-" + value.aula + "'>" + value.aula + "</option>";
            }
        });

        $("select#cambio_aula").html(html_code);

    }).fail(function (a, b) {

        cargar_vista_error(error_ajax_jquery(a, b));

    });

    html_code += "</select> </p>";
    html_code += "<p class='centrar'><button class='btn btn-primary' onclick='cerrar_modal();'>Cancelar</button> <button class='btn btn-primary' onclick='confirmar_cambio_aula(\"" + dia + "\",\"" + hora + "\",\"" + id_usuarios_antiguos + "\",\"" + id_usuario + "\");event.preventDefault();'>Cambiar</button></p>";

    abrir_modal(html_code);
}

function confirmar_cambio_aula(dia, hora, id_usuarios_antiguos, id_usuario) {

    let select_de_grupos = $("select#grupos_libres").val().split("-");
    let select_de_aulas = $("select#aulas").val().split("-");
    let usuarios_antiguos = id_usuarios_antiguos.split(",");
    let select_de_cambio_aulas = $("select#cambio_aula").val().split("-");
   

    

    $.each(usuarios_antiguos, function (key, value) {

        
        $.ajax({

            url: encodeURI(DIR_SERV + "/actualizarAula/" + select_de_cambio_aulas[0] + "/" + dia + "/" + hora + "/" + value),
            type: "PUT",
            dataType: "json"

        }).done(function (data) {

            console.log(data.mensaje);

        }).fail(function (a, b) {

            cargar_vista_error(error_ajax_jquery(a, b));
        });
    });

    $.ajax({

        url: encodeURI(DIR_SERV + "/insertarGrupo/" + dia + "/" + hora + "/" + id_usuario + "/" + select_de_grupos[0] + "/" + select_de_aulas[0]),
        type: "POST",
        dataType: "json"

    }).done(function (data) {

        obtener_horario_admin();
        editar_grupos(hora, dia, id_usuario, select_de_aulas[1], select_de_aulas[0]);

    }).fail(function (a, b) {

        cargar_vista_error(error_ajax_jquery(a, b));
    });
    cerrar_modal();
}

function borrar_grupo(dia, hora, id_usuario, id_grupo, aula, id_aula) {

    let fila_tabla = document.getElementById("tabla_editado").rows.length;

    

    $("select#aulas").html("");
    $.ajax({

        url: encodeURI(DIR_SERV + "/borrarGrupo/" + dia + "/" + hora + "/" + id_usuario + "/" + id_grupo),
        type: "DELETE",
        dataType: "json"

    }).done(function (data) {
       
        if (aula == "Sin asignar o sin aula") {

            mostrar_aulas(dia, hora);
        } else {

            mostrar_aulas(dia, hora, aula, id_aula, fila_tabla);
        }

        obtener_horario_admin();
        editar_grupos(dia, hora, id_usuario, aula, id_aula);

    }).fail(function (a, b) {

        cargar_vista_error(error_ajax_jquery(a, b));
    });
}