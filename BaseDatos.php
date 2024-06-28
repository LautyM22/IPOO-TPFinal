<?php
class BaseDatos {
    private string $HOSTNAME;
    private string $BASEDATOS;
    private string $USUARIO;
    private string $CLAVE;
    private $CONEXION;
    private string $QUERY;
    private $RESULT;
    private string $ERROR;

    public function __construct() {
        $this->HOSTNAME = "127.0.0.1";
        $this->BASEDATOS = "bdviajes";
        $this->USUARIO = "root";
        $this->CLAVE = "";
        $this->RESULT = null;
        $this->QUERY = '';
        $this->ERROR = '';
    }

    public function getError(): string {
        return "\n" . $this->ERROR;
    }

    public function Iniciar(): bool {
        $this->CONEXION = mysqli_connect($this->HOSTNAME, $this->USUARIO, $this->CLAVE, $this->BASEDATOS);
        if ($this->CONEXION) {
            unset($this->QUERY);
            unset($this->ERROR);
            return true;
        } else {
            $this->ERROR = mysqli_connect_errno() . ": " . mysqli_connect_error();
            return false;
        }
    }

    public function Ejecutar(string $consulta): bool {
        $this->QUERY = $consulta;
        $this->RESULT = mysqli_query($this->CONEXION, $consulta);
        if ($this->RESULT) {
            return true;
        } else {
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
            return false;
        }
    }

    public function Registro(): ?array {
        if ($this->RESULT) {
            $temp = mysqli_fetch_assoc($this->RESULT);
            if ($temp) {
                return $temp;
            } else {
                mysqli_free_result($this->RESULT);
                return null;
            }
        } else {
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
            return null;
        }
    }

    public function devuelveIDInsercion(string $consulta): ?int {
        $this->QUERY = $consulta;
        $this->RESULT = mysqli_query($this->CONEXION, $consulta);
        if ($this->RESULT) {
            return mysqli_insert_id($this->CONEXION);
        } else {
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
            return null;
        }
    }
}
?>
