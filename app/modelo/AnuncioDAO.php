<?php

class AnuncioDAO {

    private $conn;

    public function __construct($conn) {
        if (!$conn instanceof mysqli) { //Comprueba si $conn es un objeto de la clase mysqli
            return false;
        }
        $this->conn = $conn;
    }

    public function getAnuncios() {
        $query = "SELECT * FROM anuncios ORDER BY fecha DESC";
        if (!$result = $this->conn->query($query)) {
            die("Error al ejecutar la QUERY" . $this->conn->error);
        }
        $array_anuncios = array();
        while ($anuncio = $result->fetch_object('Anuncio')) {
            $array_anuncios[] = $anuncio;
        }
        return $array_anuncios;
    }

    public function getImagenesAnuncios($idAnuncio) {
        $sql = "SELECT * FROM fotografias WHERE id_anuncio = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la SQL " . $this->conn->error);
        }
        if (!$stmt->bind_param("i", $idAnuncio)) {
            die("Error al ligar los parámetros " . $stmt->error);
        }
        if (!$stmt->execute()) {
            die("Error al ejecutar la SQL " . $stmt->error);
        }
        $result = $stmt->get_result();

        $fotos = array();
        while ($foto = $result->fetch_object('Foto')) {
            $fotos[] = $foto;
        }
        return $fotos;
    }

    public function getAnunciosIdUsuario($idUser) {
        $query = "SELECT * FROM anuncios WHERE id_usuario = ?";
        if (!$stmt = $this->conn->prepare($query)) {
            die("Error al ejecutar la QUERY" . $this->conn->error);
        }

        $stmt->bind_param('i', $idUser);
        $stmt->execute();

        $result = $stmt->get_result();
        $anuncios = array();
        while ($row = $result->fetch_assoc()) {
            $anuncio = new Anuncio();
            $anuncio->setId($row['id']);
            $anuncio->setPrecio($row['precio']);
            $anuncio->setTitulo($row['titulo']);
            $anuncio->setDescripcion($row['descripcion']);
            $anuncio->setFecha($row['fecha']);
            $anuncios[] = $anuncio;
        }
        return $anuncios;
    }

    public function getAnunciosIdAnuncio($idAnuncio) {
        $query = "SELECT * FROM anuncios WHERE id = ?";
        if (!$stmt = $this->conn->prepare($query)) {
            die("Error al ejecutar la QUERY" . $this->conn->error);
        }

        $stmt->bind_param('i', $idAnuncio);
        $stmt->execute();

        $result = $stmt->get_result();
        $anuncio = $result->fetch_object('Anuncio');

        return $anuncio;
    }

    public function getUsuarioAnuncio($idAnuncio) {
        $sql = "SELECT usuarios.*
            FROM anuncios
            INNER JOIN usuarios ON anuncios.id_usuario = usuarios.id
            WHERE anuncios.id = ?";

        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al ejecutar la QUERY" . $this->conn->error);
        }

        $stmt->bind_param("i", $idAnuncio);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuarioAnuncio = $result->fetch_object("Usuario");
        return $usuarioAnuncio;
    }

    function getFotoPrincipal() {
        $sql = "SELECT * FROM fotografias";
        if (!$result = $this->conn->query($sql)) {
            die("Error al ejecutar la SQL " . $this->conn->error);
        }
        $array_mensajes = array();
        while ($mensaje = $result->fetch_object('Foto')) {
            $array_mensajes[] = $mensaje;
        }
        return $array_mensajes;

//        while ($result->fetch()) {
//            $foto = new Foto($id, $id_anuncio, $foto, $principal);
//            $array_fotos[] = $foto;
//        }
    }

    function paginacionAnuncios($inicio) {
        // Realizar la consulta a la base de datos
        $query = "SELECT * FROM anuncios ORDER BY fecha DESC LIMIT $inicio, 8";
        if (!$result = $this->conn->query($query)) {
            die("Error al ejecutar la QUERY" . $this->conn->error);
        }

        // Almacenar los resultados de la consulta en un array
        $array_anuncios = [];
        while ($row = mysqli_fetch_array($result)) {
            $array_anuncios[] = $row;
        }

        // Devolver el array de anuncios
        return $array_anuncios;
    }

    function insertarAnuncio($precio, $titulo, $descripcion, $idUsuario) {
        $query = "INSERT INTO anuncios (precio, titulo, descripcion, id_usuario) VALUES (?, ?, ?, ?)";
        if (!$stmt = $this->conn->prepare($query)) {
            die("Error al ejecutar la QUERY" . $this->conn->error);
        }

        $stmt->bind_param('issi', $precio, $titulo, $descripcion, $idUsuario);
        $stmt->execute();

        $idAnuncio = $this->conn->insert_id;

        if (!empty($file_name)) {
            foreach ($file_name as $foto) {
                $query = "INSERT INTO fotografias (id_anuncio, foto, principal) VALUES (?, ?, ?)";
                if (!$stmt = $this->conn->prepare($query)) {
                    die("Error al ejecutar la QUERY" . $this->conn->error);
                }

                $principal = 0;
                $stmt->bind_param('iss', $idAnuncio, $foto, $principal);
                $stmt->execute();
            }
        }
        return $stmt->insert_id;
    }

}
