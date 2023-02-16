<?php 

class FotoDAO{
    private $conn;

    public function __construct($conn) {
        if (!$conn instanceof mysqli) { //Comprueba si $conn es un objeto de la clase mysqli
            return false;
        }
        $this->conn = $conn;
    }

    public function getFotosAnuncio($idAnuncio){
        $query = "SELECT * FROM fotografias WHERE id_anuncio = ?";
        if(!$result = $this->conn->query($query)){
            die("Error al ejecutar la QUERY" . $this->conn->error);
        }
        $array_fotos = array();
        while($foto = $result->fetch_object('Foto')){
            $array_fotos[] = $foto;
        }
        return $array_fotos;
        
    }

    public function insertarFoto($id_anuncio, $foto, $principal){
        $query = "INSERT INTO fotografias (id_anuncio, foto, principal) VALUES (?, ?, ?)";
        if(!$stmt = $this->conn->prepare($query)){
            die("Error al preparar la sentencia " . $this->conn->error);
        }
        
        $stmt->bind_param('isi', $id_anuncio, $foto, $principal);
        $stmt->execute();
    }

    public function actualzarFoto(Foto $f){
        $query = "UPDATE fotografias SET id_anuncio = ?, foto = ?, principal = ? WHERE id_anuncio = ?";
        if (!$stmt = $this->conn->prepare($query)) {
            die("Error al ejecutar la QUERY" . $this->conn->error);
        }
        $idAnuncio = $f->getId_anuncio();
        $foto = $f->getFoto();
        $principal = $f->getPrincipal();

        $stmt->bind_param('isi', $idAnuncio, $foto, $principal);
        $stmt->execute();
    }
}
