
<?php

class Empresa
{

	private $idEmpresa;
	private $eNombre;
	private $eDireccion;
	private $mensajeOperacion;

	public function __construct()
	{
		$this->idEmpresa = "";
		$this->eNombre = "";
		$this->eDireccion = "";
		$this->mensajeOperacion = "";
	}

	public function cargar($idEmpresa, $eNombre, $eDireccion)
	{
		$this->idEmpresa = $idEmpresa;
		$this->eNombre = $eNombre;
		$this->eDireccion = $eDireccion;
	}

	public function setidEmpresa($idEmpresa)
	{
		$this->idEmpresa = $idEmpresa;
	}

	public function seteNombre($eNombre)
	{
		$this->eNombre = $eNombre;
	}

	public function seteDireccion($eDireccion)
	{
		$this->eDireccion = $eDireccion;
	}

	public function setmensajeOperacion($mensajeOperacion)
	{
		$this->mensajeOperacion = $mensajeOperacion;
	}


	public function getidEmpresa()
	{
		return $this->idEmpresa;
	}

	public function geteNombre()
	{
		return $this->eNombre;
	}

	public function geteDireccion()
	{
		return $this->eDireccion;
	}
	public function getmensajeOperacion()
	{
		return  $this->mensajeOperacion;
	}

	public function __toString()
	{
		return "Id: " . $this->getidEmpresa() . " Nombre: " . $this->geteNombre() . " Direccion: " . $this->geteDireccion() . "\n";
	}


	
	public function Buscar($idEmpresa)
	{
		$base = new BaseDatos();
		$consultaEmpresa = "Select * from empresa where idempresa=" . $idEmpresa;
		$resp = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaEmpresa)) {
				if ($row2 = $base->Registro()) {
					$this->setidEmpresa($idEmpresa);
					$this->seteNombre($row2['enombre']);
					$this->seteDireccion($row2['edireccion']);

					$resp = true;
				}
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}

	public function listar($condicion = "")
	{
		$arregloEmpresa = null;
		$base = new BaseDatos();
		$consultaEmpresa = "Select * from empresa ";
		if ($condicion != "") {
			$consultaEmpresa = $consultaEmpresa . ' where ' . $condicion;
		}
		$consultaEmpresa .= " order by eNombre";
		//echo $consultaPersonas;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaEmpresa)) {
				$arregloEmpresa = array();
				while ($row2 = $base->Registro()) {
					$idEmpresa = $row2['idempresa'];
					$enombre = $row2['enombre'];
					$eDireccion = $row2['edireccion'];
					$empresa = new Empresa();
					$empresa->cargar($idEmpresa, $enombre, $eDireccion);
					array_push($arregloEmpresa, $empresa);
				}
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
		return $arregloEmpresa;
	}

	

	public function insertar()
	{
		$base = new BaseDatos();
		$resp = false;
		$consultaInsertar = "INSERT INTO empresa(enombre, edireccion) 
			VALUES ('" . $this->geteNombre() . "','" . $this->geteDireccion() . "')";

		if ($base->Iniciar()) {

			if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
				$this->setidEmpresa($id);
				$resp =  true;
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}



	public function modificar()
	{
		$resp = false;
		$base = new BaseDatos();
		$consultaModifica = "UPDATE empresa SET enombre='" . $this->geteNombre() . "', edireccion='" . $this->geteDireccion() .
			"' WHERE idempresa=" . $this->getidEmpresa();
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaModifica)) {
				$resp =  true;
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}

	public function eliminar()
	{
		$base = new BaseDatos();
		$resp = false;
		if ($base->Iniciar()) {
			$consultaBorra = "DELETE FROM empresa WHERE idempresa=" . $this->getidEmpresa();
			if ($base->Ejecutar($consultaBorra)) {
				$resp =  true;
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
}

?>