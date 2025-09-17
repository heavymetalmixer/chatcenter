<?php
class modeloCatalogos {

    static public function modeloCompanies($paisCompany) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM companies WHERE paisCompany = :paisCompany");
        $stmt -> bindParam(":paisCompany", $paisCompany, PDO::PARAM_STR);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloMarcaTyping($marca) {

        if ($marca==1) {

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM marcas ORDER BY RAND() LIMIT 5");
        }
        elseif ($marca==2) {

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM marcas ORDER BY marca");
        }
        else {

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM marcas WHERE marca REGEXP :marca ORDER BY RAND() LIMIT 5");
            $stmt -> bindParam(":marca", $marca, PDO::PARAM_STR);
        }

        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloMarcas($idCompany, $companies) {

        if ($companies==null) {

            $stmt = Conexion::conectarHorus()->prepare("SELECT marcas.* FROM marcas, marcascompanies WHERE marcascompanies.idCompany = :idCompany AND marcascompanies.idMarca = marcas.idMarca GROUP BY marcas.idMarca ORDER BY marcas.marca");
            $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
        }
        else {

            $stmt = Conexion::conectarHorus()->prepare("SELECT marcas.* FROM marcas, marcascompanies WHERE marcascompanies.idCompany IN ($companies) AND marcascompanies.idMarca = marcas.idMarca GROUP BY marcas.idMarca ORDER BY marcas.marca");
        }

        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloCreaMarca($marca) {

        $stmt = Conexion::conectarHorus()->prepare("INSERT INTO marcas (marca) VALUES (:marca)");
        $stmt -> bindParam(":marca", $marca, PDO::PARAM_STR);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    static public function modeloLineas($idMarca, $idCompany, $companies) {

        if ($idCompany==null) {

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM lineas WHERE idMarca = :idMarca ORDER BY linea");
            $stmt -> bindParam(":idMarca", $idMarca, PDO::PARAM_INT);
        }
        else {

            if ($companies==null) {

                $stmt = Conexion::conectarHorus()->prepare("SELECT lineas.* FROM lineas, lineascompanies WHERE lineas.idMarca = :idMarca AND lineascompanies.idLinea = lineas.idLinea AND lineascompanies.idCompany = :idCompany GROUP BY lineas.idLinea ORDER BY lineas.linea");
                $stmt -> bindParam(":idMarca", $idMarca, PDO::PARAM_INT);
                $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
            }
            else {

                $stmt = Conexion::conectarHorus()->prepare("SELECT lineas.* FROM lineas, lineascompanies WHERE lineas.idMarca = :idMarca AND lineascompanies.idLinea = lineas.idLinea AND lineascompanies.idCompany IN ($companies) GROUP BY lineas.idLinea ORDER BY lineas.linea");
                $stmt -> bindParam(":idMarca", $idMarca, PDO::PARAM_INT);
            }
        }

        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloCreaLinea($marca, $nombreLinea, $tipoLinea) {

        $stmt = Conexion::conectarHorus()->prepare("INSERT INTO lineas (idMarca, linea, tipo) VALUES (:idMarca, :linea, :tipo)");
        $stmt -> bindParam(":idMarca", $marca, PDO::PARAM_INT);
        $stmt -> bindParam(":linea", $nombreLinea, PDO::PARAM_STR);
        $stmt -> bindParam(":tipo", $tipoLinea, PDO::PARAM_STR);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    static public function modeloModelos($idLinea, $idCompany, $companies) {

        if ($companies==null) {

            $stmt = Conexion::conectarHorus()->prepare("SELECT modelos.* FROM modelos, modeloscompanies WHERE modelos.idLinea = :idLinea AND modeloscompanies.idModelo = modelos.idModelo AND modeloscompanies.idCompany = :idCompany GROUP BY modelos.idModelo ORDER BY modelos.modelo");
            $stmt -> bindParam(":idLinea", $idLinea, PDO::PARAM_INT);
            $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
        }
        else {

            $stmt = Conexion::conectarHorus()->prepare("SELECT modelos.* FROM modelos, modeloscompanies WHERE modelos.idLinea = :idLinea AND modeloscompanies.idModelo = modelos.idModelo AND modeloscompanies.idCompany IN ($companies) GROUP BY modelos.idModelo ORDER BY modelos.modelo");
            $stmt -> bindParam(":idLinea", $idLinea, PDO::PARAM_INT);
        }

        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloVersionesListas($marca, $linea, $modelo, $idCompany, $version, $companies) {

        if ($version!=null) {

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM versiones WHERE idVersion = :idVersion");
            $stmt -> bindParam(":idVersion", $version, PDO::PARAM_INT);

            $stmt -> execute();

            $result = $stmt -> fetchAll();

            $stmt = null;
            return $result;
        }
        else {

            if ($companies==null) {

                $stmt = Conexion::conectarHorus()->prepare("SELECT versiones.* FROM marcas, lineas, modelos, versiones, versionescompanies WHERE marcas.idMarca = :marca AND lineas.idLinea = :linea AND modelos.idModelo = :modelo AND versiones.marca = marcas.marca AND versiones.linea = lineas.linea AND versiones.modelo = modelos.modelo AND versionescompanies.idCompany = :idCompany AND versionescompanies.idVersion = versiones.idVersion GROUP BY versiones.idVersion ORDER BY versiones.motor");

                $stmt -> bindParam(":marca", $marca, PDO::PARAM_INT);
                $stmt -> bindParam(":linea", $linea, PDO::PARAM_INT);
                $stmt -> bindParam(":modelo", $modelo, PDO::PARAM_INT);
                $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
            }
            else {

                $stmt = Conexion::conectarHorus()->prepare("SELECT versiones.* FROM marcas, lineas, modelos, versiones, versionescompanies WHERE marcas.idMarca = :marca AND lineas.idLinea = :linea AND modelos.idModelo = :modelo AND versiones.marca = marcas.marca AND versiones.linea = lineas.linea AND versiones.modelo = modelos.modelo AND versionescompanies.idCompany IN ($companies) AND versionescompanies.idVersion = versiones.idVersion GROUP BY versiones.idVersion ORDER BY versiones.motor");
                $stmt -> bindParam(":marca", $marca, PDO::PARAM_INT);
                $stmt -> bindParam(":linea", $linea, PDO::PARAM_INT);
                $stmt -> bindParam(":modelo", $modelo, PDO::PARAM_INT);
            }

            $stmt -> execute();

            $result = $stmt -> fetchAll();

            $stmt = null;
            return $result;
        }
    }

    //Función que busca vehículo con términos de búsqueda
    static public function modeloVersionTyping($version, $idCompany, $companies) {

        if ($version==1) {

            if ($companies==null) {

                $stmt = Conexion::conectarHorus()->prepare("SELECT versiones.* FROM versiones, versionescompanies WHERE versionescompanies.idCompany = :idCompany AND versiones.idVersion = versionescompanies.idVersion GROUP BY versiones.idVersion ORDER BY RAND() LIMIT 3");
            }
            else {

                $stmt = Conexion::conectarHorus()->prepare("SELECT versiones.* FROM versiones, versionescompanies WHERE versionescompanies.idCompany IN ($companies) AND versiones.idVersion = versionescompanies.idVersion GROUP BY versiones.idVersion ORDER BY RAND() LIMIT 3");
            }
        }
        else {

            $query = explode(" ", $version);

            if ($companies==null) {

                $sentencia = "SELECT versiones.* FROM versiones, versionescompanies WHERE versionescompanies.idCompany = :idCompany AND versiones.idVersion = versionescompanies.idVersion";
            }
            else {

                $sentencia = "SELECT versiones.* FROM versiones, versionescompanies WHERE versionescompanies.idCompany IN ($companies) AND versiones.idVersion = versionescompanies.idVersion";
            }

            foreach ($query as $key => $value) {

                if (strlen($value)==4) {

                    $hoy = date('Y')+1;

                    if (is_numeric($value) AND $value<=$hoy AND $value>=1950) {

                        $sentencia .= " AND inicioVigencia <='".$value."-01-01' AND (finVigencia IS NULL OR finVigencia >='".$value."-12-31')";
                    }
                    else {

                        $sentencia .= " AND CONCAT_WS(' ', marca, linea, modelo, version, motor) LIKE '%".$value."%'";
                    }
                }
                else {

                    $sentencia .= " AND CONCAT_WS(' ', marca, linea, modelo, version, motor) LIKE '%".$value."%'";
                }
            }

            $sentencia .= " GROUP BY versiones.idVersion ORDER BY RAND() LIMIT 3";
            $stmt = Conexion::conectarHorus()->prepare($sentencia);
        }

        if ($companies==null) {

            $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
        }

        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    //Verifica asociaciones de conjuntos con vehiculo
    static public function modeloAsociacionesVersion($idVersion) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT partesassy.idConjunto FROM versionassy, partesassy WHERE versionassy.idVersion = :idVersion AND partesassy.idAsociacion = versionassy.idAsociacion GROUP BY partesassy.idConjunto");
        $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    //Ingresa relacion de conjuntos con vehiculo
    static public function modeloCreaAssyVersion($idConjunto, $idVersion) {

        $stmt = Conexion::conectarHorus()->prepare("INSERT INTO versionconjuntos (idVersion, idConjunto) VALUES (:idVersion, :idConjunto)");
        $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
        $stmt -> bindParam(":idConjunto", $idConjunto, PDO::PARAM_INT);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    //Verifica asociaciones de conjuntos con vehiculo
    static public function modeloNOAsociadosVersion($idVersion) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT idConjunto FROM versionconjuntos WHERE idVersion = :idVersion");
        $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    //Elimina relacion de conjuntos NO asociados con vehiculo
    static public function modeloEliminaAssyVersion($idConjunto, $idVersion) {

        $stmt = Conexion::conectarHorus()->prepare("DELETE FROM versionconjuntos WHERE idVersion = :idVersion AND idConjunto = :idConjunto");
        $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
        $stmt -> bindParam(":idConjunto", $idConjunto, PDO::PARAM_INT);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    //Valida asociacion con vehiculo
    static public function modeloValidaAsociacionVersion($idAsociacion, $idVersion) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM versionassy WHERE idVersion = :idVersion AND idAsociacion = :idAsociacion");
        $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
        $stmt -> bindParam(":idAsociacion", $idAsociacion, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    //Ingresa asociacion con vehiculo
    static public function modeloIngresoAsociacionVersion($idAsociacion, $idVersion) {

        $stmt = Conexion::conectarHorus()->prepare("INSERT INTO versionassy (idVersion, idAsociacion) VALUES (:idVersion, :idAsociacion)");
        $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
        $stmt -> bindParam(":idAsociacion", $idAsociacion, PDO::PARAM_INT);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    //Elimina asociacion con vehiculo
    static public function modeloEliminaAsociacionVersion($idAsociacion, $idVersion) {

        $stmt = Conexion::conectarHorus()->prepare("DELETE FROM versionassy WHERE idVersion = :idVersion AND idAsociacion = :idAsociacion");
        $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
        $stmt -> bindParam(":idAsociacion", $idAsociacion, PDO::PARAM_INT);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    static public function modeloColoresModelos($version, $idColor, $color) {

        if ($idColor!=null) {

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM colores WHERE idColor = :idColor");
            $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);

            $stmt -> execute();

            $result = $stmt -> fetchAll();

            $stmt = null;
            return $result;
        }
        else {

            if ($color=="all") {

                $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM colores WHERE idVersion = :idVersion ORDER BY color");
                $stmt -> bindParam(":idVersion", $version, PDO::PARAM_INT);

                $stmt -> execute();

                $result = $stmt -> fetchAll();

                $stmt = null;
                return $result;
            }
            else {

                $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM colores WHERE idVersion = :idVersion AND color = :color");
                $stmt -> bindParam(":idVersion", $version, PDO::PARAM_INT);
                $stmt -> bindParam(":color", $color, PDO::PARAM_STR);

                $stmt -> execute();

                $result = $stmt -> fetchAll();

                $stmt = null;
                return $result;
            }
        }
    }

    //Busca Colores de version
    static public function modeloColorTyping($version, $color) {

        if ($color=='null') {

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM colores WHERE idVersion = :idVersion ORDER BY color LIMIT 2");
            $stmt -> bindParam(":idVersion", $version, PDO::PARAM_INT);
        }
        else {

            $sentencia = "SELECT * FROM colores WHERE idVersion = :idVersion AND color LIKE '%".$color."%' ORDER BY color LIMIT 2";
            $stmt = Conexion::conectarHorus()->prepare($sentencia);
            $stmt -> bindParam(":idVersion", $version, PDO::PARAM_INT);
        }

        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloValidaAsociacionColor($idAsociacion, $idColor) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM colorassy WHERE idColor = :idColor AND idAsociacion = :idAsociacion");
        $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);
        $stmt -> bindParam(":idAsociacion", $idAsociacion, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    //Ingresa asociacion color con vehiculo
    static public function modeloIngresoAsociacionColor($idAsociacion, $idColor) {

        $stmt = Conexion::conectarHorus()->prepare("INSERT INTO colorassy (idColor, idAsociacion) VALUES (:idColor, :idAsociacion)");
        $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);
        $stmt -> bindParam(":idAsociacion", $idAsociacion, PDO::PARAM_INT);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    //Elimina asociacion color con vehiculo
    static public function modeloEliminaAsociacionColor($idAsociacion, $idColor) {

        $stmt = Conexion::conectarHorus()->prepare("DELETE FROM colorassy WHERE idColor = :idColor AND idAsociacion = :idAsociacion");
        $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);
        $stmt -> bindParam(":idAsociacion", $idAsociacion, PDO::PARAM_INT);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    static public function modeloVehCompatible($idVersionVehiculoCompatible, $partNoCompatibleVeh) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT versionassy.* FROM partes, partesassy, versionassy WHERE partes.MfgPartNo = :MfgPartNo AND partesassy.idPart = partes.idPart AND partesassy.idAsociacion = versionassy.idAsociacion AND versionassy.idVersion = :idVersion");

        $stmt -> bindParam(":idVersion", $idVersionVehiculoCompatible, PDO::PARAM_INT);
        $stmt -> bindParam(":MfgPartNo", $partNoCompatibleVeh, PDO::PARAM_STR);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloColorCompatible($idColorVehiculoCompatible, $partNoCompatibleVeh) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT colorassy.* FROM partes, partesassy, colorassy WHERE partes.MfgPartNo = :MfgPartNo AND partesassy.idPart = partes.idPart AND partesassy.idAsociacion = colorassy.idAsociacion AND colorassy.idColor = :idColor");

        $stmt -> bindParam(":idColor", $idColorVehiculoCompatible, PDO::PARAM_INT);
        $stmt -> bindParam(":MfgPartNo", $partNoCompatibleVeh, PDO::PARAM_STR);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloConjuntosModelos($version, $color) {

        if($version==null){

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM conjuntos");
            $stmt -> execute();

            $result = $stmt -> fetchAll();

            $stmt = null;
            return $result;
        }
        else {

            if ($color=="all") {

                $stmt = Conexion::conectarHorus()->prepare("SELECT conjuntos.*, versionconjuntos.idVersion FROM versionconjuntos, conjuntos WHERE versionconjuntos.idVersion = :idVersion AND versionconjuntos.idConjunto = conjuntos.idConjunto GROUP BY conjuntos.idConjunto");
                $stmt -> bindParam(":idVersion", $version, PDO::PARAM_INT);

                $stmt -> execute();

                $result = $stmt -> fetchAll();

                $stmt = null;
                return $result;
            }
            else {

                $stmt = Conexion::conectarHorus()->prepare("SELECT conjuntos.*, versionconjuntos.idVersion FROM versionconjuntos, conjuntos, colorassy, partesassy WHERE versionconjuntos.idVersion = :idVersion AND versionconjuntos.idConjunto = conjuntos.idConjunto AND colorassy.idColor = :idColor AND partesassy.idAsociacion = colorassy.idAsociacion AND partesassy.idConjunto = conjuntos.idConjunto GROUP BY conjuntos.idConjunto");

                $stmt -> bindParam(":idVersion", $version, PDO::PARAM_INT);
                $stmt -> bindParam(":idColor", $color, PDO::PARAM_STR);
                $stmt -> execute();

                $result = $stmt -> fetchAll();

                $stmt = null;
                return $result;
            }
        }
    }

    static public function modeloModelosConjuntos($idConjunto) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM versionconjuntos, versiones WHERE versionconjuntos.idConjunto = :idConjunto AND versionconjuntos.idVersion = versiones.idVersion");
        $stmt -> bindParam(":idConjunto", $idConjunto, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloConteoModelosConjuntos($idConjunto) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT COUNT(*) FROM versionconjuntos WHERE idConjunto = :idConjunto");
        $stmt -> bindParam(":idConjunto", $idConjunto, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloCrearConjunto($nombreConjuntoCrear, $nameAssyCreate, $originalNameAssyCreate) {

        $stmt = Conexion::conectarHorus()->prepare("INSERT INTO conjuntos (assyLangOrigin, assyLangEnglish, assyLangEspanol) VALUES (:assyLangOrigin, :assyLangEnglish, :assyLangEspanol)");
        $stmt -> bindParam(":assyLangOrigin", $originalNameAssyCreate, PDO::PARAM_STR);
        $stmt -> bindParam(":assyLangEnglish", $nameAssyCreate, PDO::PARAM_STR);
        $stmt -> bindParam(":assyLangEspanol", $nombreConjuntoCrear, PDO::PARAM_STR);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }


    static public function modeloConjuntoDetalle($idConjunto) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partesassy, partes WHERE partesassy.idConjunto = :idConjunto AND partes.idPart = partesassy.idPart ORDER BY partesassy.BOMConjunto");
        $stmt -> bindParam(":idConjunto", $idConjunto, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloParteAssyDetalle($idAsociacion) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partesassy, partes WHERE partesassy.idAsociacion = :idAsociacion AND partes.idPart = partesassy.idPart");
        $stmt -> bindParam(":idAsociacion", $idAsociacion, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloListaConjuntos($partNo, $idVersion, $idColor) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT partesassy.*, conjuntos.* FROM partes, partesassy, versionassy, colorassy, conjuntos WHERE partes.PartNo = :PartNo AND partes.idPart = partesassy.idPart AND partesassy.idAsociacion = versionassy.idAsociacion AND versionassy.idVersion = :idVersion AND partesassy.idAsociacion = colorassy.idAsociacion AND colorassy.idColor = :idColor AND conjuntos.idConjunto = partesassy.idConjunto GROUP BY partesassy.idAsociacion, conjuntos.idConjunto");

        $stmt -> bindParam(":PartNo", $partNo, PDO::PARAM_STR);
        $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
        $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloActualizaCoordenadas($idAsociacion, $figBOM, $posX, $posY, $auxBOMs) {

        $stmt = Conexion::conectarHorus()->prepare("UPDATE partesassy SET typeBOM = :typeBOM, PosX = :PosX, PosY = :PosY, auxBOMs = :auxBOMs WHERE idAsociacion = :idAsociacion");
        $stmt -> bindParam(":typeBOM", $figBOM, PDO::PARAM_STR);
        $stmt -> bindParam(":PosX", $posX, PDO::PARAM_STR);
        $stmt -> bindParam(":PosY", $posY, PDO::PARAM_STR);
        $stmt -> bindParam(":auxBOMs", $auxBOMs, PDO::PARAM_STR);
        $stmt -> bindParam(":idAsociacion", $idAsociacion, PDO::PARAM_INT);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    static public function modeloEliminaParteAssy($idAsociacion) {

        $stmt = Conexion::conectarHorus()->prepare("DELETE FROM partesassy WHERE idAsociacion = :idAsociacion");
        $stmt -> bindParam(":idAsociacion", $idAsociacion, PDO::PARAM_INT);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    static public function modeloActualizaParteAssy($idAsociacionActualiza, $BOMConjunto, $varianteBOM, $cantBOM, $notasBOM) {

        $stmt = Conexion::conectarHorus()->prepare("UPDATE partesassy SET BOMConjunto = :BOMConjunto, variant = :variant, cantPartsConjunto = :cantPartsConjunto, remarksBOM = :remarksBOM WHERE idAsociacion = :idAsociacion");

        $stmt -> bindParam(":BOMConjunto", $BOMConjunto, PDO::PARAM_STR);
        $stmt -> bindParam(":variant", $varianteBOM, PDO::PARAM_STR);
        $stmt -> bindParam(":cantPartsConjunto", $cantBOM, PDO::PARAM_INT);
        $stmt -> bindParam(":remarksBOM", $notasBOM, PDO::PARAM_STR);
        $stmt -> bindParam(":idAsociacion", $idAsociacionActualiza, PDO::PARAM_INT);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }

    static public function modeloCargaPartesAssy($idConjunto, $BOM, $variante, $idPart, $cant, $notas) {

        $stmt = Conexion::conectarHorus()->prepare("INSERT INTO partesassy (idPart, BOMConjunto, variant, idConjunto, cantPartsConjunto, remarksBOM) VALUES (:idPart, :BOMConjunto, :variant, :idConjunto, :cantPartsConjunto, :remarksBOM)");

        $stmt -> bindParam(":idPart", $idPart, PDO::PARAM_INT);
        $stmt -> bindParam(":BOMConjunto", $BOM, PDO::PARAM_STR);
        $stmt -> bindParam(":variant", $variante, PDO::PARAM_STR);
        $stmt -> bindParam(":idConjunto", $idConjunto, PDO::PARAM_INT);
        $stmt -> bindParam(":cantPartsConjunto", $cant, PDO::PARAM_INT);
        $stmt -> bindParam(":remarksBOM", $notas, PDO::PARAM_STR);

        if ($stmt -> execute()) {

            $stmt = null;
            return true;
        }
        else {

            $stmt = null;
            return false;
        }
    }


    //Función filtra resultados de búsqueda de repuestos
    static public function modeloResultadoPartes($categoria, $subcategoria, $busqueda, $idConjunto, $idVersion, $idColor, $idCompany, $companies) {

        if ($idConjunto=="all" AND $idVersion!=null AND $idColor!=null OR $idConjunto=="all" AND $idVersion!=0 AND $idColor!=0) {

            if ($companies==null) {

                if ($idColor=="all") {

                    $stmt = Conexion::conectarHorus()->prepare("SELECT partes.*, partesassy.*, partestienda.* FROM partesassy, versionassy, partes, sustitutos, partestienda WHERE partestienda.idCompany = :idCompany AND partestienda.idPart = partesassy.idPart AND versionassy.idVersion = :idVersion AND versionassy.idAsociacion = partesassy.idAsociacion AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) GROUP BY partes.idPart, partesassy.idAsociacion, partestienda.idPartesTienda LIMIT 50");
                }
                else {

                    $stmt = Conexion::conectarHorus()->prepare("SELECT partes.*, partesassy.*, partestienda.* FROM partesassy, versionassy, colorassy, partes, sustitutos, partestienda WHERE partestienda.idCompany = :idCompany AND partestienda.idPart = partesassy.idPart AND versionassy.idVersion = :idVersion AND colorassy.idColor = :idColor AND versionassy.idAsociacion = partesassy.idAsociacion AND colorassy.idAsociacion = partesassy.idAsociacion AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) GROUP BY partes.idPart, partesassy.idAsociacion, partestienda.idPartesTienda LIMIT 50");

                    $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);
                }

                $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
                $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
            }
            else {

                if ($idColor=="all") {

                    $stmt = Conexion::conectarHorus()->prepare("SELECT partes.*, partesassy.*, partestienda.*, companies.idCompany, companies.nombrePublico FROM partesassy, versionassy, partes, sustitutos, partestienda, companies WHERE partestienda.idCompany IN ($companies) AND companies.idCompany = partestienda.idCompany AND partestienda.idPart = partesassy.idPart AND versionassy.idVersion = :idVersion AND versionassy.idAsociacion = partesassy.idAsociacion AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) GROUP BY partes.idPart, partesassy.idAsociacion, partestienda.idPartesTienda, companies.idCompany LIMIT 50");
                }
                else {

                    $stmt = Conexion::conectarHorus()->prepare("SELECT partes.*, partesassy.*, partestienda.*, companies.idCompany, companies.nombrePublico FROM partesassy, versionassy, colorassy, partes, sustitutos, partestienda, companies WHERE partestienda.idCompany IN ($companies) AND companies.idCompany = partestienda.idCompany AND partestienda.idPart = partesassy.idPart AND versionassy.idVersion = :idVersion AND colorassy.idColor = :idColor AND versionassy.idAsociacion = partesassy.idAsociacion AND colorassy.idAsociacion = partesassy.idAsociacion AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) GROUP BY partes.idPart, partesassy.idAsociacion, partestienda.idPartesTienda, companies.idCompany LIMIT 50");

                    $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);
                }

                $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
            }
        }

        //Consulta de resultados de partes con datos del vehículo
        elseif ($idConjunto!=null AND $idVersion!=null AND $idColor!=null OR $idConjunto!=null AND $idVersion!=0 AND $idColor!=0) {

            if ($companies==null) {

                if ($idColor=="all") {

                    $stmt = Conexion::conectarHorus()->prepare("SELECT partes.*, partesassy.*, partestienda.* FROM partesassy, versionassy, partes, sustitutos, partestienda WHERE partestienda.idCompany = :idCompany AND partesassy.idConjunto = :idConjunto AND partestienda.idPart = partesassy.idPart AND versionassy.idVersion = :idVersion AND versionassy.idAsociacion = partesassy.idAsociacion AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) GROUP BY partes.idPart, partesassy.idAsociacion, partestienda.idPartesTienda ORDER BY partesassy.BOMConjunto");
                }
                else {

                    $stmt = Conexion::conectarHorus()->prepare("SELECT partes.*, partesassy.*, partestienda.* FROM partesassy, versionassy, colorassy, partes, sustitutos, partestienda WHERE partestienda.idCompany = :idCompany AND partesassy.idConjunto = :idConjunto AND partestienda.idPart = partesassy.idPart AND versionassy.idVersion = :idVersion AND colorassy.idColor = :idColor AND versionassy.idAsociacion = partesassy.idAsociacion AND colorassy.idAsociacion = partesassy.idAsociacion AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) GROUP BY partes.idPart, partesassy.idAsociacion, partestienda.idPartesTienda ORDER BY partesassy.BOMConjunto");

                    $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);
                }

                $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
                $stmt -> bindParam(":idConjunto", $idConjunto, PDO::PARAM_INT);
                $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
            }
            else {

                if ($idColor=="all") {

                    $stmt = Conexion::conectarHorus()->prepare("SELECT partes.*, partesassy.*, partestienda.*, companies.idCompany, companies.nombrePublico FROM partesassy, versionassy, partes, sustitutos, partestienda, companies WHERE partestienda.idCompany IN ($companies) AND companies.idCompany = partestienda.idCompany AND partesassy.idConjunto = :idConjunto AND partestienda.idPart = partesassy.idPart AND versionassy.idVersion = :idVersion AND versionassy.idAsociacion = partesassy.idAsociacion AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) GROUP BY partes.idPart, partesassy.idAsociacion, partestienda.idPartesTienda, companies.idCompany ORDER BY partesassy.BOMConjunto");
                }
                else {

                    $stmt = Conexion::conectarHorus()->prepare("SELECT partes.*, partesassy.*, partestienda.*, companies.idCompany, companies.nombrePublico FROM partesassy, versionassy, colorassy, partes, sustitutos, partestienda, companies WHERE partestienda.idCompany IN ($companies) AND companies.idCompany = partestienda.idCompany AND partesassy.idConjunto = :idConjunto AND partestienda.idPart = partesassy.idPart AND versionassy.idVersion = :idVersion AND colorassy.idColor = :idColor AND versionassy.idAsociacion = partesassy.idAsociacion AND colorassy.idAsociacion = partesassy.idAsociacion AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) GROUP BY partes.idPart, partesassy.idAsociacion, partestienda.idPartesTienda, companies.idCompany ORDER BY partesassy.BOMConjunto");

                    $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);
                }

                $stmt -> bindParam(":idConjunto", $idConjunto, PDO::PARAM_INT);
                $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
            }
        }

        //Consulta de resultados con términos de búsqueda
        elseif ($busqueda!="null") {

            if ($idVersion!=0 AND $idColor!=0) {

                if ($companies==null) {

                    if ($idColor=="all") {

                        $sentencia = "SELECT partes.*, partesassy.*, partestienda.* FROM partesassy, versionassy, partes, sustitutos, partestienda WHERE partestienda.idCompany = :idCompany AND partestienda.idPart = partesassy.idPart AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) AND versionassy.idVersion = :idVersion AND versionassy.idAsociacion = partesassy.idAsociacion";
                    }
                    else {

                        $sentencia = "SELECT partes.*, partesassy.*, partestienda.* FROM partesassy, versionassy, colorassy, partes, sustitutos, partestienda WHERE partestienda.idCompany = :idCompany AND partestienda.idPart = partesassy.idPart AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) AND versionassy.idVersion = :idVersion AND colorassy.idColor = :idColor AND versionassy.idAsociacion = partesassy.idAsociacion AND colorassy.idAsociacion = partesassy.idAsociacion";
                    }
                }
                else {

                    if ($idColor=="all") {

                        $sentencia = "SELECT partes.*, partesassy.*, partestienda.*, companies.idCompany, companies.nombrePublico FROM partesassy, versionassy, partes, sustitutos, partestienda, companies WHERE partestienda.idCompany IN ($companies) AND companies.idCompany = partestienda.idCompany AND partestienda.idPart = partesassy.idPart AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) AND versionassy.idVersion = :idVersion AND versionassy.idAsociacion = partesassy.idAsociacion";
                    }
                    else {

                        $sentencia = "SELECT partes.*, partesassy.*, partestienda.*, companies.idCompany, companies.nombrePublico FROM partesassy, versionassy, colorassy, partes, sustitutos, partestienda, companies WHERE partestienda.idCompany IN ($companies) AND companies.idCompany = partestienda.idCompany AND partestienda.idPart = partesassy.idPart AND (partestienda.idPart = partes.idPart AND partesassy.idPart = partes.idPart OR sustitutos.idPart = partestienda.idPart AND partes.idPart = sustitutos.idPart AND sustitutos.idPartOrigen = partesassy.idPart) AND versionassy.idVersion = :idVersion AND colorassy.idColor = :idColor AND versionassy.idAsociacion = partesassy.idAsociacion AND colorassy.idAsociacion = partesassy.idAsociacion";
                    }
                }

                $busqueda = explode(" ", $busqueda);

                foreach ($busqueda as $key => $value) {

                    if (mb_strtolower($value)=="de" OR mb_strtolower($value)=="con" OR mb_strtolower($value)=="y" OR mb_strtolower($value)=="sin" OR mb_strtolower($value)=="o" OR mb_strtolower($value)=="en" OR mb_strtolower($value)=="para" OR mb_strtolower($value)=="por") {
                        //
                    }
                    else {

                        $sentencia .= " AND CONCAT_WS(' ', partes.PartNo, partes.MfgPartNo, partes.marcaParte, partes.descLangEspanol, partes.partKeywords, partestienda.SKU, partestienda.marcaParteTienda) LIKE '%".$value."%'";
                    }
                }

                if ($companies==null) {

                    $sentencia .= "GROUP BY partes.idPart, partesassy.idAsociacion, partestienda.idPartesTienda";

                    $stmt = Conexion::conectarHorus()->prepare($sentencia);
                    $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
                    $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);

                    if ($idColor!="all") {

                        $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);
                    }
                }
                else {

                    $sentencia .= "GROUP BY partes.idPart, partesassy.idAsociacion, partestienda.idPartesTienda, companies.idCompany";
                    $stmt = Conexion::conectarHorus()->prepare($sentencia);
                    $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);

                    if ($idColor!="all") {

                        $stmt -> bindParam(":idColor", $idColor, PDO::PARAM_INT);
                    }
                }
            }
            else {

                if ($companies==null) {

                    $sentencia = "SELECT * FROM partes, partestienda WHERE partestienda.idCompany = :idCompany AND partestienda.idPart = partes.idPart";
                }
                else {

                    $sentencia = "SELECT partes.*, partestienda.*, companies.idCompany, companies.nombrePublico FROM partes, partestienda, companies WHERE partestienda.idCompany IN ($companies) AND companies.idCompany = partestienda.idCompany AND partestienda.idPart = partes.idPart";
                }

                $busqueda = explode(" ", $busqueda);

                foreach ($busqueda as $key => $value) {

                    if($value=="DE" OR $value=="de" OR $value=="De" OR $value=="CON" OR $value=="con" OR $value=="Con" OR $value=="Y" OR $value=="y" OR $value=="SIN" OR $value=="sin" OR $value=="Sin" OR $value=="O" OR $value=="o" OR $value=="EN" OR $value=="en" OR $value=="En" OR $value=="PARA" OR $value=="para" OR $value=="Para") {

                    }
                    else {

                        $sentencia .= " AND CONCAT_WS(' ', partes.PartNo, partes.MfgPartNo, partes.marcaParte, partes.descLangEspanol, partes.partKeywords, partestienda.SKU, partestienda.marcaParteTienda) LIKE '%".$value."%'";
                    }
                }

                if ($companies==null) {

                    $sentencia .= "GROUP BY partes.PartNo, partestienda.idPartesTienda";
                    $stmt = Conexion::conectarHorus()->prepare($sentencia);
                    $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
                }
                else {

                    $sentencia .= "GROUP BY partes.PartNo, partestienda.idPartesTienda, companies.idCompany";
                    $stmt = Conexion::conectarHorus()->prepare($sentencia);
                }
            }
        }
        else {

            if ($companies==null) {

                $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partes, partestienda WHERE partestienda.idCompany = :idCompany AND partestienda.recomendadoTienda = 1  AND partestienda.idPart = partes.idPart GROUP BY partes.idPart, partestienda.idPartesTienda ORDER BY RAND() LIMIT 3");
                $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
            }
            else {

                $stmt = Conexion::conectarHorus()->prepare("SELECT partes.*, partestienda.*, companies.idCompany, companies.nombrePublico FROM partes, partestienda, companies WHERE partestienda.idCompany IN ($companies) AND companies.idCompany = partestienda.idCompany AND partestienda.recomendadoTienda = 1 AND partestienda.idPart = partes.idPart GROUP BY partes.idPart, partestienda.idPartesTienda, companies.idCompany ORDER BY RAND() LIMIT 3");
            }
        }

        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloDetalleParte($partNo, $idPart) {

        if ($partNo==null) {

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partes WHERE idPart = :idPart");
            $stmt -> bindParam(":idPart", $idPart, PDO::PARAM_INT);
        }
        else {

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partes WHERE PartNo = :partNo");
            $stmt -> bindParam(":partNo", $partNo, PDO::PARAM_STR);
        }

        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloPriceDetail($idPartesTienda) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM preciostienda WHERE idPartesTienda = :idPartesTienda");
        $stmt -> bindParam(":idPartesTienda", $idPartesTienda, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloPartesRecomendadosEcommerce($idCompany, $companies) {

        if ($companies==null) {

            $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partestienda WHERE idCompany = :idCompany AND recomendadoTienda = 1  ORDER BY RAND() LIMIT 8");
            $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
        }
        else {

            $stmt = Conexion::conectarHorus()->prepare("SELECT partestienda.*, companies.idCompany, companies.nombrePublico FROM partestienda, companies WHERE partestienda.idCompany IN ($companies) AND companies.idCompany = partestienda.idCompany AND recomendadoTienda = 1 GROUP BY partestienda.idPartesTienda, companies.idCompany ORDER BY RAND() LIMIT 8");
        }

        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloParteTienda($idNo) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT partestienda.*, companies.idCompany, companies.nombrePublico FROM partestienda, companies WHERE partestienda.idPartesTienda = :idPartesTienda AND companies.idCompany = partestienda.idCompany GROUP BY partestienda.idPartesTienda, companies.idCompany");
        $stmt -> bindParam(":idPartesTienda", $idNo, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloModelosAplica($partNo) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT versiones.* FROM partes, partesassy, versiones, sustitutos, versionassy WHERE partes.MfgPartNo = :partNo AND versionassy.idAsociacion = partesassy.idAsociacion AND versionassy.idVersion = versiones.idVersion AND (partesassy.idPart = partes.idPart OR sustitutos.idPart = partes.idPart AND partesassy.idPart = partes.idPart) GROUP BY versiones.idVersion");
        $stmt -> bindParam(":partNo", $partNo, PDO::PARAM_STR);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloVINVersionModelo($VINModelo) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM vin WHERE VIN = :vin");
        $stmt -> bindParam(":vin", $VINModelo, PDO::PARAM_STR);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloVINGrupos($idCompany, $WMI, $codigoModelo, $serie) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT gruposvin.* FROM gruposvin, versionescompanies WHERE versionescompanies.idCompany = :idCompany AND gruposvin.idVersion = versionescompanies.idVersion AND gruposvin.WMI = :wmi AND gruposvin.codigoModelo = :codigoModelo AND gruposvin.serieInicio <= :serie AND (gruposvin.serieFin >= :serie OR  gruposvin.serieFin IS NULL) GROUP by gruposvin.idGrupoVIN");

        $stmt -> bindParam(":wmi", $WMI, PDO::PARAM_STR);
        $stmt -> bindParam(":codigoModelo", $codigoModelo, PDO::PARAM_STR);
        $stmt -> bindParam(":serie", $serie, PDO::PARAM_STR);
        $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    /*Revisar desde aqui

    static public function modeloSustitutosEcommerce($PartNo, $idCompany) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM sustitutos, partes, partestienda WHERE sustitutos.partNoOrigen = :PartNo AND partestienda.idCompany = :idCompany AND partestienda.PartNo = sustitutos.partNoSustituto AND partes.PartNo = sustitutos.partNoSustituto GROUP BY partes.PartNo");
        $stmt -> bindParam(":PartNo", $PartNo, PDO::PARAM_STR);
        $stmt -> bindParam(":idCompany", $idCompany, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloFichaParte($idConjunto, $idVersion, $bom) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partesassy, partes WHERE partesassy.BOMConjunto = :BOMConjunto AND partesassy.idConjunto = :idConjunto AND partesassy.idVersion = :idVersion AND partesassy.PartNo = partes.PartNo");
        $stmt -> bindParam(":BOMConjunto", $bom, PDO::PARAM_INT);
        $stmt -> bindParam(":idConjunto", $idConjunto, PDO::PARAM_INT);
        $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloPartesSustitutos($partNo) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partes WHERE partes.MfgPartNo = :partNo");
        $stmt -> bindParam(":partNo", $partNo, PDO::PARAM_STR);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloSustitutos($partNo) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM sustitutos WHERE partNoOrigen = :partNo");
        $stmt -> bindParam(":partNo", $partNo, PDO::PARAM_STR);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloCambiosIngenieria($partNo) {

        $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM cambiosingenieria, partes WHERE cambiosingenieria.PartNoOld = :partNo AND cambiosingenieria.PartNoNew = partes.PartNo");
        $stmt -> bindParam(":partNo", $partNo, PDO::PARAM_STR);
        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }

    static public function modeloPartesBusq($criterio, $descr, $partNoFabricante, $partNoDistribuidor, $idVersion) {

        switch ($criterio) {

            case 'dealer':

                $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partes, partesassy WHERE partesassy.PartNoDealer = :partNo AND partesassy.idVersion = :idVersion AND partesassy.PartNo = partes.PartNo");
                $stmt -> bindParam(":partNo", $partNoDistribuidor, PDO::PARAM_STR);
                $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);

            break;

            case 'fabricante':

                $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partes, partesassy WHERE partes.MfgPartNo = :partNo AND partesassy.idVersion = :idVersion AND partesassy.PartNo = partes.PartNo");
                $stmt -> bindParam(":partNo", $partNoFabricante, PDO::PARAM_STR);
                $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);

            break;

            default:

                $descripcion = '%'.$descr.'%';
                $stmt = Conexion::conectarHorus()->prepare("SELECT * FROM partes, partesassy WHERE partes.descLangEspanol LIKE :descr AND partesassy.idVersion = :idVersion AND partesassy.PartNo = partes.PartNo");
                $stmt -> bindParam(":descr", $descripcion, PDO::PARAM_STR);
                $stmt -> bindParam(":idVersion", $idVersion, PDO::PARAM_INT);

            break;
        }

        $stmt -> execute();

        $result = $stmt -> fetchAll();

        $stmt = null;
        return $result;
    }
    */
}
