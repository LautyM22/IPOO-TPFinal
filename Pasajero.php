<?php
include_once('Viaje.php');
class Pasajero
{

    private $pdocumento;
    private $pnombre;
    private $papellido;
    private $ptelefono;
    private $idviaje;
    private $mensajeOperacion;


    public function __construct()
    {
        $this->pdocumento = "";
        $this->pnombre = "";
        $this->papellido = "";
        $this->ptelefono = "";
        $this->idviaje = "";
    }

    public function cargar($pdocumento, $pnombre, $papellido, $ptelefono, $idviaje)
    {
        $this->pdocumento = $pdocumento;
        $this->pnombre = $pnombre;
        $this->papellido = $papellido;
        $this->ptelefono = $ptelefono;
        $this->idviaje = $idviaje;
    }

    public function setmensajeoperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function setpdocumento($pdocumento)
    {
        $this->pdocumento = $pdocumento;
    }

    public function setpnombre($pnombre)
    {
        $this->pnombre = $pnombre;
    }

    public function setpapellido($papellido)
    {
        $this->papellido = $papellido;
    }

    public function setptelefono($ptelefono)
    {
        $this->ptelefono = $ptelefono;
    }

    public function setidviaje($idviaje)
    {
        $this->idviaje = $idviaje;
    }

    //get
    public function getmensajeoperacion()
    {
        return  $this->mensajeOperacion;
    }

    public function getpdocumento()
    {
        return $this->pdocumento;
    }

    public function getpnombre()
    {
        return $this->pnombre;
    }

    public function getpapellido()
    {
        return $this->papellido;
    }

    public function getptelefono()
    {
        return $this->ptelefono;
    }

    public function getidviaje()
    {
        return $this->idviaje;
    }

    public function __toString()
    {
        return "\n Documento: " . $this->getpdocumento() . "\n Nombre: " . $this->getpnombre() . "\n Apellido: " . $this->getpapellido() . "\n Telefono: " . $this->getptelefono() . "\n Id Viaje: " . $this->getidviaje()->getidviaje() . "\n";
    }


    public function Buscar($pdocumento)
    {
        $base = new BaseDatos();
        $consultaPasajero = "Select * from pasajero where pdocumento=" . $pdocumento;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPasajero)) {
                if ($row2 = $base->Registro()) {
                    $this->setpdocumento($pdocumento);
                    $this->setpnombre($row2['pnombre']);
                    $this->setpapellido($row2['papellido']);
                    $this->setptelefono($row2['ptelefono']);
                    $objViaje = new Viaje();
                    $objViaje->Buscar($row2['idviaje']);
                    $this->setidviaje($objViaje);
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
        $arregloPasajero = null;
        $base = new BaseDatos();
        $consultaPasajero = "Select * from pasajero ";
        if ($condicion != "") {
            $consultaPasajero = $consultaPasajero . ' where ' . $condicion;
        }
        $consultaPasajero .= " order by pdocumento";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPasajero)) {
                $arregloPasajero = array();
                while ($row2 = $base->Registro()) {

                    $pdocumento = $row2['pdocumento'];
                    $pnombre = $row2['pnombre'];
                    $papellido = $row2['papellido'];
                    $ptelefono = $row2['ptelefono'];
                    $idviaje  = new Viaje();
                    $idviaje->Buscar($row2['idviaje']);




                    $pasajero = new Pasajero();
                    $pasajero->cargar($pdocumento, $pnombre, $papellido, $ptelefono, $idviaje);
                    array_push($arregloPasajero, $pasajero);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloPasajero;
    }



    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO pasajero(pdocumento, pnombre, papellido, ptelefono, idviaje) 
			VALUES ('" . $this->getpdocumento() . "','" . $this->getpnombre() . "','" . $this->getpapellido() . "','" . $this->getptelefono() . "','" . $this->getidviaje()->getidviaje() . "')";

        if ($base->Iniciar()) {

            if ($base->Ejecutar($consultaInsertar)) {

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
        $consultaModifica = "UPDATE pasajero SET pnombre='" . $this->getpnombre() . "',papellido='" . $this->getpapellido() .
            "' WHERE pdocumento=" . $this->getpdocumento();
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
            $consultaBorra = "DELETE FROM pasajero WHERE pdocumento=" . $this->getpdocumento();
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
