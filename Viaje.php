
<?php
include_once('Empresa.php');
include_once('Responsable.php');
class Viaje
{

    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa;
    private $rnumeroempleado;
    private $vimporte;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idviaje = "";
        $this->vdestino = "";
        $this->vcantmaxpasajeros = "";
        $this->idempresa =  new Empresa();
        $this->rnumeroempleado = new Responsable();
        $this->vimporte = "";
    }

    public function cargar($idviaje, $vdestino, $vcantmaxpasajeros, $idempresa, $rnumeroempleado, $vimporte)
    {
        $this->idviaje = $idviaje;
        $this->vdestino = $vdestino;
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
        $this->idempresa =  $idempresa;
        $this->rnumeroempleado = $rnumeroempleado;
        $this->vimporte = $vimporte;
    }

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }
    public function setidviaje($idviaje)
    {
        $this->idviaje = $idviaje;
    }

    public function setvdestino($vdestino)
    {
        $this->vdestino = $vdestino;
    }

    public function setvcantmaxpasajeros($vcantmaxpasajeros)
    {
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
    }

    public function setidempresa($idempresa)
    {
        $this->idempresa = $idempresa;
    }

    public function setrnumeroempleado($rnumeroempleado)
    {
        $this->rnumeroempleado = $rnumeroempleado;
    }

    public function setvimporte($vimporte)
    {
        $this->vimporte = $vimporte;
    }

    //get

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
    public function getidviaje()
    {
        return  $this->idviaje;
    }

    public function getvdestino()
    {
        return $this->vdestino;
    }

    public function getvcantmaxpasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    public function getidempresa()
    {
        return $this->idempresa;
    }

    public function getrnumeroempleado()
    {
        return $this->rnumeroempleado;
    }

    public function getvimporte()
    {
        return $this->vimporte;
    }

    public function __toString()
    {
        return "\n Id Viaje: " . $this->getidviaje() . "\n Destino: " . $this->getvdestino() . "\n Cantidad maxima pasajeros: " . $this->getvcantmaxpasajeros() . "\n Id de Empresa: " .  $this->getidempresa()->getidEmpresa() . "\n Nro Empleado: " . $this->getrnumeroempleado()->getrnumeroempleado() . "\n Importe: " . $this->getvimporte() . "\n";
    }


    public function Buscar($idviaje)
    {
        $base = new BaseDatos();
        $consultaViaje = "Select * from viaje where idviaje=" . $idviaje;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                if ($row2 = $base->Registro()) {
                    $this->setidviaje($idviaje);
                    $this->setvdestino($row2['vdestino']);
                    $this->setvcantmaxpasajeros($row2['vcantmaxpasajeros']);

                    $objetoEmpresa = new Empresa();
                    $objetoEmpresa->Buscar($row2['idempresa']);
                    $this->setidempresa($objetoEmpresa);
                    // $this->setrnumeroempleado($row2['rnumeroempleado']);
                    $objResponsable = new Responsable();
                    $objResponsable->Buscar($row2['rnumeroempleado']);
                    $this->setrnumeroempleado($objResponsable);
                    $this->setvimporte($row2['vimporte']);
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
        $arregloViaje = null;
        $base = new BaseDatos();
        $consultaViaje = "Select * from viaje ";
        if ($condicion != "") {
            $consultaViaje = $consultaViaje . ' where ' . $condicion;
        }
        $consultaViaje .= " order by idviaje";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                $arregloViaje = array();
                while ($row2 = $base->Registro()) {
                    $idviaje = $row2['idviaje'];
                    $vdestino = $row2['vdestino'];
                    $vcantmaxpasajeros = $row2['vcantmaxpasajeros'];
                    $idempresa = new Empresa();
                    $idempresa->Buscar($row2['idempresa']);
                    $rnumeroempleado = new Responsable();
                    $rnumeroempleado->Buscar($row2['rnumeroempleado']);
                    $vimporte = $row2['vimporte'];

                    $viaje = new viaje();
                    $viaje->cargar($idviaje, $vdestino, $vcantmaxpasajeros, $idempresa, $rnumeroempleado, $vimporte);
                    array_push($arregloViaje, $viaje);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloViaje;
    }


    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) 
			VALUES ('" . $this->getvdestino() . "','" . $this->getvcantmaxpasajeros() . "','" . $this->getidempresa()->getidEmpresa() . "','" . $this->getrnumeroempleado()->getrnumeroempleado() . "','" . $this->getvimporte() . "')";

        if ($base->Iniciar()) {

            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setidviaje($id);
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
        $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getvdestino() . "',vcantmaxpasajeros='" . $this->getvcantmaxpasajeros() .
            "',idempresa='" . $this->getidempresa()->getidEmpresa() . "',rnumeroempleado='" . $this->getrnumeroempleado()->getrnumeroempleado() . "',vimporte='" . $this->getvimporte() . "' WHERE idviaje=" . $this->getidviaje();
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
            $consultaBorra = "DELETE FROM viaje WHERE idviaje=" . $this->getidviaje();
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