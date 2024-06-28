<?php

include_once('Empresa.php');
include_once('Pasajero.php');
include_once('Responsable.php');
include_once('Viaje.php');
include_once('BaseDatos.php');
include_once('modulos.php');

$obj_Responsable = new Responsable();
$obj_Empresa = new Empresa();
$obj_Viaje = new Viaje();
$obj_Pasajero =  new Pasajero();
/*
$obj_Viaje->cargar(null, "", , ,,);
$respuesta=$obj_Viaje->insertar();	
$obj_Pasajero->cargar("","", "",, $obj_Viaje->getidviaje());
$respuesta=$obj_Pasajero->insertar();	
*/
$salir = false;
while($salir == false)
switch (menu()) {
	case 1:
		//Llamos a la funcion que se encarga de cargar una empresa
		cargarYlistarEmpresa($obj_Empresa);
		break;
	case 2:
		//LLamamos a la funcion encargada de cargar responsables
		cargarResponsable($obj_Responsable);
		break;
	case 3:
		
		$hayEmpresa = empresaExiste($obj_Empresa);
		$hayResponsable = responsableExiste($obj_Responsable);
		
		if($hayEmpresa == false){
			echo "Tenes que crear una empresa antes de cargar un viaje... \n";
			cargarYlistarEmpresa($obj_Empresa);
		}

		if($hayResponsable == false){
			echo "Tenes que crear un responsable antes de cargar un viaje... \n";
			cargarResponsable($obj_Responsable);
		}
		//Llamamos ala funcion que cargara los viajes
		cargarViaje($obj_Viaje, $obj_Empresa, $obj_Responsable);
		break;
	case 4:

		$hayViaje = viajeExiste($obj_Viaje);
		if($hayViaje == false){
			echo "Tenes que crear un viaje antes de cargar un pasajero... \n";
			cargarViaje($obj_Viaje, $obj_Empresa, $obj_Responsable);
		}
		//Llamamos a la funcion cargar pasajero
		cargarPasajero($obj_Viaje, $obj_Pasajero);
		break;
	case 5:
		//Llamamos a la funcion que se encarga de Modificar/Eliminar una Empresa 
		//y los viajes si es que esta empresa tiene alguno asignado
		modificarEliminarEmpresa($obj_Empresa, $obj_Viaje);
		break;
	case 6:
		//Llamamos la funcion que nos permitira Modificar y/o eliminar viajes
		modificarEliminarViaje($obj_Viaje, $obj_Empresa, $obj_Pasajero, $obj_Responsable);
		break;
	case 7:
		$salir = true;
	default:
		echo "Ingreso la opcion incorrecta.";
		break;
}
