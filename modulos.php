<?php
function menu()
{
    echo "\n==== ¿Que desea hacer? ==== \n";
    echo " 1. Cargar una empresa. \n";
    echo " 2. Cargar un responsable. \n";
    echo " 3. Cargar un viaje. \n";
    echo " 4. Cargar un pasajero. \n";
    echo " 5. Modificar/Eliminar empresa. \n";
    echo " 6. Modificar/Eliminar viaje. \n";
    echo " 7. Salir de la aplicacion. \n";
    $opcion = trim(fgets(STDIN));
    return $opcion;
}
//Cargamos una empresa y luego listamos sus atributos recorriendo la base de datos
function cargarYlistarEmpresa($obj_Empresa)
{
    echo "Ingrese nombre de la empresa: ";
    $nombreEmpresa = trim(fgets(STDIN));
    echo "Ingrese direccion de la empresa: ";
    $direccionEmpresa = trim(fgets(STDIN));
    $obj_Empresa->cargar(null, $nombreEmpresa, $direccionEmpresa);
    $respuesta = $obj_Empresa->insertar();

    if ($respuesta == true) {
        echo "\nOP INSERCION;  La empresa fue ingresado en la BD";
        $colEmpresa = $obj_Empresa->listar("");
        foreach ($colEmpresa as $unaEmpresa) {

            echo $unaEmpresa;
            echo "------------------------------------------------------- \n";
        }
    } else {
        echo $obj_Empresa->getmensajeoperacion();
    }
}


function modificarEliminarEmpresa($obj_Empresa, $obj_Viaje)
{
    $colEmpresa = $obj_Empresa->listar("");
    foreach ($colEmpresa as $unaEmpresa) {
        echo $unaEmpresa;
        echo "------------------------------------------------------- \n";
    }

    echo "seleccione el id de la empresa a la cual desea modificar/eliminar: ";
    $idEmpresa = trim(fgets(STDIN));

    foreach ($colEmpresa as $unaEmpresa) {
        if ($unaEmpresa->getidEmpresa() == $idEmpresa) {

            $unaEmpresa->setidEmpresa($idEmpresa);
            $direccionActual = $unaEmpresa->geteDireccion();
            $nombreActual = $unaEmpresa->geteNombre();

            echo "Que desea hacer: \n";
            echo "1: Modificar Nombre. \n";
            echo "2: Modificar Direccion. \n";
            echo "3: Eliminar Empresa. \n";
            $opcion = trim(fgets(STDIN));
            switch ($opcion) {
                case 1:
                    echo "Ingrese el nuevo nombre de la empresa: \n";
                    $nombreEmpresa = trim(fgets(STDIN));
                    $unaEmpresa->seteNombre($nombreEmpresa);
                    $unaEmpresa->seteDireccion($direccionActual);
                    $unaEmpresa->modificar();
                    echo "El nombre de la empresa se cambio con exito. \n";
                    break;
                case 2:
                    echo "Ingrese la nueva direccion de la empresa \n";
                    $direccionEmpresa = trim(fgets(STDIN));
                    $unaEmpresa->seteDireccion($direccionEmpresa);
                    $unaEmpresa->seteNombre($nombreActual);
                    $unaEmpresa->modificar();
                    echo "La direccion de la empresa se cambio con exito. \n";
                case 3:
                    $arrViajes = $obj_Viaje->listar("idEmpresa=" . $idEmpresa);
                    if (count($arrViajes) >= 1) {
                        echo "La empresa tiene viajes, desea eliminarla ?";
                        $respuesta = trim(fgets(STDIN));
                        if ($respuesta == "S") {
                            echo "Se va a borrar la empresa";
                            $unaEmpresa->Eliminar($unaEmpresa);
                        } else {
                            echo "no se va a borrar la empresa";
                        }
                    }
                    $unaEmpresa->Eliminar($unaEmpresa);
                    echo "Se elimino la empresa.";




                    break;
                default:
                    echo "Ninguna opcion ingresada es correcta";
            }
        }
    }
}

function modificarEliminarViaje($obj_Viaje, $obj_Empresa, $obj_Pasajero, $obj_Responsable)
{
    $colViajes = $obj_Viaje->listar("");
    foreach ($colViajes as $unViaje) {
        echo $unViaje;
    }

    echo "Ingrese el id, del viaje que desea, modificar/eliminar: ";
    $idviaje = trim(fgets(STDIN));

    foreach ($colViajes as $unViaje) {
        if ($unViaje->getidviaje() == $idviaje) {
            $unViaje->setidviaje($idviaje);
            $destinoActual = $unViaje->getvdestino();
            $cantmaxpasajerosActual = $unViaje->getvcantmaxpasajeros();
            $idempresaActual = $unViaje->getidempresa();
            $rnumeroempleadoActual = $unViaje->getrnumeroempleado();
            $importeActual = $unViaje->getvimporte();
            echo "Que tiene la emrpesa? " . $idempresaActual;
            echo "Que tiene el responsable? :" . $rnumeroempleadoActual;
            echo "¿Qué desea hacer? \n";
            echo "Opcion 1: Modificar destino. \n";
            echo "Opcion 2: Modificar cantidad maxima de pasajeros. \n ";
            echo "Opcion 3: Modificar empresa que hace el viaje. \n";
            echo "Opcion 4: Modificar el responsable del viaje. \n";
            echo "Opcion 5: Modificar el importe del viaje. \n";
            echo "Opcion 6: Eliminar el viaje. \n";
            $opcion = trim(fgets(STDIN));

            switch ($opcion) {
                case 1:
                    echo "Ingrese el nuevo destino: \n";
                    $nuevoDestino = trim(fgets(STDIN));
                    $unViaje->setvdestino($nuevoDestino);
                    $unViaje->setvcantmaxpasajeros($cantmaxpasajerosActual);
                    $unViaje->setidempresa($idempresaActual);
                    $unViaje->setrnumeroempleado($rnumeroempleadoActual);
                    $unViaje->setvimporte($importeActual);
                    $unViaje->modificar();

                    break;
                case 2:
                    echo "Ingrese la nueva cantidad maxima de pasajeros: \n";
                    $nuevaCanMaxPasajeros = trim(fgets(STDIN));
                    $unViaje->setvdestino($destinoActual);
                    $unViaje->setvcantmaxpasajeros($nuevaCanMaxPasajeros);
                    $unViaje->setidempresa($idempresaActual);
                    $unViaje->setrnumeroempleado($rnumeroempleadoActual);
                    $unViaje->setvimporte($importeActual);
                    $unViaje->modificar();
                    break;
                case 3:

                    $colEmpresa = $obj_Empresa->listar("");
                    foreach ($colEmpresa as $unaEmpresa) {
                        echo $unaEmpresa;
                    }
                    echo "Ingrese el id de la nueva empresa que hara el viaje: \n";
                    $nuevaEmpresa = trim(fgets(STDIN));
                    foreach ($colEmpresa as $unaEmpresa) {
                        if ($unaEmpresa->getidEmpresa() == $nuevaEmpresa) {
                            $empresa = $unaEmpresa;
                        }
                    }
                    $unViaje->setvdestino($destinoActual);
                    $unViaje->setvcantmaxpasajeros($cantmaxpasajerosActual);
                    $unViaje->setidempresa($empresa);
                    $unViaje->setrnumeroempleado($rnumeroempleadoActual);
                    $unViaje->setvimporte($importeActual);
                    $unViaje->modificar();
                    break;
                case 4:
                    $colResponsable = $obj_Responsable->listar("");
                    foreach ($colResponsable as $unResponsable) {
                        echo $unResponsable;
                    }
                    echo "Ingrese el numero de responsable, el cual se hara cargo del viaje. \n";
                    $nuevoResponsable = trim(fgets(STDIN));

                    foreach ($colResponsable as $unResponsable) {
                        if ($unResponsable->getrnumeroempleado() == $nuevoResponsable) {
                            $empleado = $unResponsable;
                        }
                    }
                    $unViaje->setrnumeroempleado($empleado);
                    $unViaje->setvdestino($destinoActual);
                    $unViaje->setvcantmaxpasajeros($cantmaxpasajerosActual);
                    $unViaje->setidempresa($idempresaActual);
                    $unViaje->setvimporte($importeActual);
                    $unViaje->modificar();
                    break;
                case 5:
                    echo "Ingrese el nuevo importe del viaje.\n ";
                    $nuevoImporte = trim(fgets(STDIN));
                    $unViaje->setvdestino($destinoActual);
                    $unViaje->setvcantmaxpasajeros($cantmaxpasajerosActual);
                    $unViaje->setidempresa($idempresaActual);
                    $unViaje->setrnumeroempleado($rnumeroempleadoActual);
                    $unViaje->setvimporte($nuevoImporte);
                    $unViaje->modificar();
                    break;
                case 6:
                    echo "Para eliminar el viaje primero debera eliminar todos los pasajeros correspondientes al mismo.\n ";
                    echo "Desea continuar Si/No: ";
                    $decision = trim(fgets(STDIN));
                    if ($decision == "Si") {
                        $colPasajero = $obj_Pasajero->listar("");
                        foreach ($colPasajero as $unPasajero) {
                            /*          
                            if ($unPasajero->getidviaje() == $idviaje) {
                                echo "Se elemiminaran todos los pasajeros que pertenezcan al viaje elegido: \n";
                                $unPasajero->eliminar();
                            }
                            */
                        }
                        echo "Se eliminara el viaje...";

                        if ($unViaje->getidviaje() == $idviaje)
                            $unViaje->eliminar();
                        echo "Se elimino el viaje. Nº: " . $idviaje . "\n";
                    } else {
                        echo "No se borro ninguna empresa... \n";
                    }
            }
        }
    }
}


function cargarResponsable($obj_Responsable)
{
    echo "Ingrese el numero de licencia del Responsable: ";
    $numLicencia = trim(fgets(STDIN));
    echo "Ingrese el nombre del responsable: ";
    $nombreResponsable = trim(fgets(STDIN));
    echo "Ingrese el apellido del responsable: ";
    $apellidoResponsable = trim(fgets(STDIN));
    $obj_Responsable->cargar(null, $numLicencia, $nombreResponsable, $apellidoResponsable);
    $respuesta = $obj_Responsable->insertar();

    if ($respuesta == true) {
        echo "\nOP INSERCION;  El pasajero fue ingresado en la BD";
        $colResponsable = $obj_Responsable->listar("");
        foreach ($colResponsable as $unResponsable) {

            echo $unResponsable;
            echo "-------------------------------------------------------";
        }
    } else {
        echo $obj_Responsable->getmensajeoperacion();
    }
}

function cargarViaje($obj_Viaje, $obj_Empresa, $obj_Responsable)
{
    $colEmpresa = $obj_Empresa->listar("");
    foreach ($colEmpresa as $unaEmpresa) {
        echo $unaEmpresa;
        echo "------------------------------------------------------- \n";
    }
    echo "ingresa el id de la empresa que queres cargar en el viaje: ";
    $idEmpresa = trim(fgets(STDIN));
    foreach ($colEmpresa as $unaEmpresa) {
        if ($unaEmpresa->getidEmpresa() == $idEmpresa) {
            $empresa = $unaEmpresa;
        }
    }

    $colResponsable = $obj_Responsable->listar("");
    foreach ($colResponsable as $unResponsable) {
        echo $unResponsable;
    }
    echo "Ingresa el numero de empleado del responsable de viaje: ";
    $nroResponsable = trim(fgets(STDIN));
    foreach ($colResponsable as $unResponsable) {
        if ($unResponsable->getrnumeroempleado() == $nroResponsable) {
            $responsable = $unResponsable;
        }
    }


    echo "Ingrese destino del viaje: ";
    $destino = trim(fgets(STDIN));
    echo "ingrese cantidad maxima de pasajeros: ";
    $cantMaxPasajeros = trim(fgets(STDIN));
    echo "ingrese importe del viaje: ";
    $importe = trim(fgets(STDIN));

    $obj_Viaje->cargar(null, $destino, $cantMaxPasajeros, $empresa, $responsable, $importe);
    $respuesta = $obj_Viaje->insertar();
    if ($respuesta == true) {
        echo "\nOP INSERCION;  El viaje fue ingresado en la BD";
        $colViaje = $obj_Viaje->listar("");
        foreach ($colViaje as $unViaje) {

            echo $unViaje;
            echo "-------------------------------------------------------";
        }
    } else {
        echo $obj_Viaje->getmensajeoperacion();
    }
}

function cargarPasajero($obj_Viaje, $obj_Pasajero)
{
    $colViajes = $obj_Viaje->listar("");
    foreach ($colViajes as $unViaje) {
        echo $unViaje;
    }
    echo "Seleccione el ID, del viaje en el que quiera viajar el pasajero: ";
    $idViaje = trim(fgets(STDIN));
    foreach ($colViajes as $unViaje) {
        if ($unViaje->getidviaje() == $idViaje) {
            $viaje = $unViaje;
            $cantidadPasajeros = $unViaje->getvcantmaxpasajeros();
        }
    }
    $colPasajero = $obj_Pasajero->listar("");
    $cantidad = count($colPasajero);
    if ( $cantidad < $cantidadPasajeros) {
        echo "Ingrese el numero de documento del pasajero: ";
        $numDocPasajero = trim(fgets(STDIN));
        echo "Ingrese el nombre del pasajero: ";
        $nombrePasajero = trim(fgets(STDIN));
        echo "Ingrese el apellido del pasajero: ";
        $apellidoPasajero = trim(fgets(STDIN));
        echo "Ingrese numero de telefono del pasajero: ";
        $telefonoPasajero = trim(fgets(STDIN));
        $obj_Pasajero->cargar($numDocPasajero, $nombrePasajero, $apellidoPasajero, $telefonoPasajero, $viaje);
        $respuesta = $obj_Pasajero->insertar();

        if ($respuesta == true) {
            echo "\n OP INSERCION;  El pasajero fue ingresado en la BD";
            $colPasajero = $obj_Pasajero->listar("");
            foreach ($colPasajero as $unPasajero) {

                echo $unPasajero;
                echo "-------------------------------------------------------";
            }
        } else {
            echo $obj_Pasajero->getmensajeoperacion();
        }
    }else{
        echo "Excedio la cantidad de pasajeros para este viaje";
    }
}

function empresaExiste($obj_Empresa)
{
    $hayEmpresa = false;
    $colEmpresa = $obj_Empresa->listar("");
    if (count($colEmpresa) > 0) {
        $hayEmpresa = true;
    }
    return $hayEmpresa;
}

function responsableExiste($obj_Responsable)
{
    $hayResponsable = false;
    $colResponsable = $obj_Responsable->listar("");
    if (count($colResponsable) > 0) {
        $hayResponsable = true;
    }
    return $hayResponsable;
}

function viajeExiste($obj_Viaje)
{
    $hayViaje = false;
    $colViaje = $obj_Viaje->listar("");
    if (count($colViaje) > 0) {
        $hayViaje = true;
    }
    return $hayViaje;
}
