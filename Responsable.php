

<?php


class Responsable
{

    private $rnumeroempleado;
    private $rnumerolicencia;
    private $rnombre;
    private $rapellido;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->rnumeroempleado = "";
        $this->rnumerolicencia = "";
        $this->rnombre = "";
        $this->rapellido = "";
    }

    public function cargar($rnumeroempleado, $rnumerolicencia, $rnombre, $rapellido)
    {
        $this->rnumeroempleado = $rnumeroempleado;
        $this->rnumerolicencia = $rnumerolicencia;
        $this->rnombre = $rnombre;
        $this->rapellido = $rapellido;
    }

    public function setmensajeoperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function setrnumeroempleado($rnumeroempleado)
    {
        $this->rnumeroempleado = $rnumeroempleado;
    }

    public function setrnumerolicencia($rnumerolicencia)
    {
        $this->rnumerolicencia = $rnumerolicencia;
    }

    public function setrnombre($rnombre)
    {
        $this->rnombre = $rnombre;
    }

    public function setrapellido($rapellido)
    {
        $this->rapellido = $rapellido;
    }

    //get

    public function getmensajeoperacion()
    {
        return $this->mensajeOperacion;
    }
    public function getrnumeroempleado()
    {
        return $this->rnumeroempleado;
    }

    public function getrnumerolicencia()
    {
        return $this->rnumerolicencia;
    }

    public function getrnombre()
    {
        return  $this->rnombre;
    }

    public function getrapellido()
    {
        return $this->rapellido;
    }

    public function __toString()
    {
        return "\n Numero empleado: " . $this->getrnumeroempleado() . "\n Numero licencia: " . $this->getrnumerolicencia() . "\n Nombre: " . $this->getrnombre() . "\n Apellido: " . $this->getrapellido() . "\n";
    }


    public function Buscar($rnumeroempleado)
    {
        $base = new BaseDatos();
        $consultaResponsable = "Select * from responsable where rnumeroempleado=" . $rnumeroempleado;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                if ($row2 = $base->Registro()) {
                    $this->setrnumeroempleado($rnumeroempleado);
                    $this->setrnumerolicencia($row2['rnumerolicencia']);
                    $this->setrnombre($row2['rnombre']);
                    $this->setrapellido($row2['rapellido']);
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
        $arregloResponsable = null;
        $base = new BaseDatos();
        $consultaResponsable = "Select * from responsable ";
        if ($condicion != "") {
            $consultaResponsable = $consultaResponsable . ' where ' . $condicion;
        }
        $consultaResponsable .= " order by rnumeroempleado";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                $arregloResponsable = array();
                while ($row2 = $base->Registro()) {

                    $rnumeroempleado = $row2['rnumeroempleado'];
                    $rnumerolicencia = $row2['rnumerolicencia'];
                    $rnombre = $row2['rnombre'];
                    $rapellido = $row2['rapellido'];
                    
                    $responsable = new Responsable();
                    $responsable->cargar($rnumeroempleado, $rnumerolicencia, $rnombre, $rapellido);
                    array_push($arregloResponsable, $responsable);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloResponsable;
    }

    //modificar 

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO responsable(rnumerolicencia, rnombre, rapellido) 
			VALUES ('" . $this->getrnumerolicencia() . "','" . $this->getrnombre() . "','" . $this->getrapellido() . "')";

        if ($base->Iniciar()) {

            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setrnumeroempleado($id);
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
        $consultaModifica = "UPDATE responsable SET nombre='" . $this->getrnombre() . "',apellido='" . $this->getrapellido() .
            "' WHERE rnumeroempleado=" . $this->getrnumeroempleado();
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
            $consultaBorra = "DELETE FROM responsable WHERE rnumeroempleado=" . $this->getrnumeroempleado();
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