<?php
//INCLUIMOS LA CONEXION
include_once('conexiones.php');
/**
 * 
 */
class DigiExpedientesModelo
{

	public function mdlLogueo($username, $clave)
	{

		// Verificar estados de usuario (Clave vencida, si existe, si tiene acceso al modulo, etc.)
		$logueo = Conexiones::conDDLocal()->prepare("EXEC LOGEO $username ,$clave ,NULL,NULL");

		$logueo->execute();

		return $logueo->fetchAll();

		$logueo->close();
	}

	public function mdlConsultaDatosContibu($idadhere)
	{
		$idadhere2 = base64_decode($idadhere);
		// Verificar estados de usuario (Clave vencida, si existe, si tiene acceso al modulo, etc.)
		$ConsultaTH = Conexiones::conDDLocal()->prepare("SELECT a.IdTh
										,a.Th
										,c.Contribuyente
										,d.NroDni
										,b.Partida
										,d.Activo
								FROM HabilitacionesComerciales.dbo.Solicitud a
								inner join HabilitacionesComerciales.dbo.FormularioSolicitud b on b.IdFormulario=a.IdFormulario
								inner join SeguridadWEB.dbo.Contribuyentes c on c.Id=b.IdContribuyente
								inner join SeguridadWEB.dbo.ContribuyentesIdentidad d on d.IdContribuyente=c.Id 
								where a.IdTh=$idadhere2 AND
								and d.Activo=1
								GROUP BY
									a.IdTh
									,a.Th
									,c.Contribuyente
									,d.NroDni
									,b.Partida
									,d.Activo");
		//EXEC ConsultaTH $consulta
		$ConsultaTH->execute();

		return $ConsultaTH->fetchAll();

		$ConsultaTH->close();
	}

	public function ConectarFTP()
	{

		define("SERVER", "192.168.0.2");
		// define("SERVER", "127.0.0.1");
		define("PORT", 21);
		define("USER", 'webdig');
		define("PASSWORD", 'muni1234');
		define("PASV", true);

		$id_ftp = ftp_connect(SERVER, PORT);
		ftp_login($id_ftp, USER, PASSWORD);
		ftp_pasv($id_ftp, PASV);
		return $id_ftp;
	}
	public function mdlAltaArchivo(
		$idAdherente,
		$idRequisito,
		$titulo,
		$dominio,
		$descripcion,
		$rutaTemp,
		$extencion,
		$Usuario,
		$codUsu,
		$Vdesde,
		$Vhasta,
		$Agencia,
		$idAgencia,
		$NombreArchivo
	) {
		$id_ftp = DigiExpedientesModelo::ConectarFTP();

		$detalle = "ALTA REQUISITO REMIS";
		$detalle2 = "DIRECCION DE TRANSPORTE";
		$src = "ftp://webdig:muni1234@192.168.0.2/Transporte/";
		$anio = date("Y", strtotime($Vdesde));
		$periodoAnio = date("Y", strtotime($Vdesde));
		$periodoMes = date("m", strtotime($Vdesde));
		$periodo = "$periodoAnio$periodoMes";
		$FechaCreacion = date("Y-m-d", strtotime($Vdesde));
		$ValidoHasta = date("Y-m-d", strtotime($Vhasta));

		$true = true;
		$false = false;

		$src2 = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/$periodo/$dominio/";

		$InsertImgExp = Conexiones::conDDLocal()->prepare("EXEC InsertarDocumentoDigitalizadoRemises ?,?,?,?,?,?,?,?,?,?");


		$InsertImgExp->bindParam(1, $idAdherente);
		$InsertImgExp->bindParam(2, $NombreArchivo);
		$InsertImgExp->bindParam(3, $dominio);
		$InsertImgExp->bindParam(4, $descripcion);
		$InsertImgExp->bindParam(5, $src2);
		$InsertImgExp->bindParam(6, $NombreArchivo);
		$InsertImgExp->bindParam(7, $extencion);
		$InsertImgExp->bindParam(8, $idRequisito);
		$InsertImgExp->bindParam(9, $FechaCreacion);
		$InsertImgExp->bindParam(10, $ValidoHasta);

		if ($InsertImgExp->execute()) {


			$rutaCrearAgencia = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/";
			$rutaCrearAnio = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/";
			$rutaCrearPeriodo = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/$periodo/";
			$rutaCrearDominio = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/$periodo/$dominio/";
			$ExisteArchivo = "Transporte/$Agencia/$anio/$periodo/$dominio/" . $NombreArchivo;
			$archivo1 = "Transporte/$Agencia/$anio/$periodo/$dominio/" . $NombreArchivo;

			if (!is_dir($rutaCrearAgencia)) {
				//si no existe la agencia, la crea + año + periodo + dominio + sube archivo
				$crearAgencia = mkdir($rutaCrearAgencia, 0777);
				if (!is_dir($rutaCrearAnio)) {
					$crearAnio = mkdir($rutaCrearAnio, 0777);
					if (!is_dir($rutaCrearPeriodo)) {
						$crearPeriodo = mkdir($rutaCrearPeriodo, 0777);
						if (!is_dir($rutaCrearDominio)) {
							$crearDominio = mkdir($rutaCrearDominio, 0777);
							if (!file_exists($ExisteArchivo)) {
								ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
							}
						}
					}
				}
			} else {
				if (!is_dir($rutaCrearAnio)) {
					//si existe la agencia pero no el año
					$rutaCrearDesdeAño = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/$periodo/$dominio/";

					$crearAnio = mkdir($rutaCrearDesdeAño);
					ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
				} else {
					if (!is_dir($rutaCrearPeriodo)) {
						//si existe el año pero no el periodo
						$rutaCrearDesdePeriodo = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/$periodo/$dominio/";

						$crearPeriodo = mkdir($rutaCrearDesdePeriodo);
						ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
					} else {
						if (!is_dir($rutaCrearDominio)) {
							$crearDominio = mkdir($rutaCrearDominio);
							if (!file_exists($ExisteArchivo)) {
								ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
							}
						} else {
							ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
						}
					}
				}
			}

			if (!is_dir($rutaCrearAgencia)) {
				$crearAgencia = mkdir($rutaCrearDominio, 0777);
			} else {
				ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
			}
			ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);

			ftp_quit($id_ftp);

			$insertAuditoria = Conexiones::conDDLocal()->prepare("EXEC	AuditoriaUsuario ?,?,?,?,?,?,?,?,?");

			$insertAuditoria->bindParam(1, $codUsu);
			$insertAuditoria->bindParam(2, $Usuario);
			$insertAuditoria->bindParam(3, $detalle);
			$insertAuditoria->bindParam(4, $idAdherente);
			$insertAuditoria->bindParam(5, $titulo);
			$insertAuditoria->bindParam(6, $detalle2);
			$insertAuditoria->bindParam(7, $descripcion);
			$insertAuditoria->bindParam(8, $src2);
			$insertAuditoria->bindParam(9, $NombreArchivo);


			if ($insertAuditoria->execute()) {
				return "ok";
			} else {
				return "error";
				// return die(print_r(sqlsrv_errors(), true));
			}
		} else {
			return "error2";
			// die(print_r(sqlsrv_errors(), true));
		}
	}

	public function mdlAltaArchivoMasivo(
		$idAdherente,
		$idRequisito,
		$titulo,
		$dominio,
		$descripcion,
		$rutaTemp,
		$extencion,
		$Usuario,
		$codUsu,
		$Vdesde,
		$Vhasta,
		$Agencia,
		$idAgencia,
		$NombreArchivo
	) {
		$id_ftp = DigiExpedientesModelo::ConectarFTP();

		$detalle = "ALTA REQUISITO REMIS";
		$detalle2 = "DIRECCION DE TRANSPORTE";
		$src = "ftp://webdig:muni1234@192.168.0.2/Transporte/";
		$anio = date("Y", strtotime($Vdesde));
		$periodoAnio = date("Y", strtotime($Vdesde));
		$periodoMes = date("m", strtotime($Vdesde));
		$periodo = "$periodoAnio$periodoMes";
		$FechaCreacion = date("Y-m-d", strtotime($Vdesde));
		$ValidoHasta = date("Y-m-d", strtotime($Vhasta));

		$true = true;
		$false = false;

		$src2 = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/$periodo/$dominio/";

		$InsertImgExp = Conexiones::conDDLocal()->prepare("EXEC InsertarDocumentoDigitalizadoRemises ?,?,?,?,?,?,?,?,?,?");


		$InsertImgExp->bindParam(1, $idAdherente);
		$InsertImgExp->bindParam(2, $NombreArchivo);
		$InsertImgExp->bindParam(3, $dominio);
		$InsertImgExp->bindParam(4, $descripcion);
		$InsertImgExp->bindParam(5, $src2);
		$InsertImgExp->bindParam(6, $NombreArchivo);
		$InsertImgExp->bindParam(7, $extencion);
		$InsertImgExp->bindParam(8, $idRequisito);
		$InsertImgExp->bindParam(9, $FechaCreacion);
		$InsertImgExp->bindParam(10, $ValidoHasta);

		if ($InsertImgExp->execute()) {


			$rutaCrearAgencia = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/";
			$rutaCrearAnio = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/";
			$rutaCrearPeriodo = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/$periodo/";
			$rutaCrearDominio = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/$periodo/$dominio/";
			$ExisteArchivo = "Transporte/$Agencia/$anio/$periodo/$dominio/" . $NombreArchivo;
			$archivo1 = "Transporte/$Agencia/$anio/$periodo/$dominio/" . $NombreArchivo;

			if (!is_dir($rutaCrearAgencia)) {
				//si no existe la agencia, la crea + año + periodo + dominio + sube archivo
				$crearAgencia = mkdir($rutaCrearAgencia, 0777);
				if (!is_dir($rutaCrearAnio)) {
					$crearAnio = mkdir($rutaCrearAnio, 0777);
					if (!is_dir($rutaCrearPeriodo)) {
						$crearPeriodo = mkdir($rutaCrearPeriodo, 0777);
						if (!is_dir($rutaCrearDominio)) {
							$crearDominio = mkdir($rutaCrearDominio, 0777);
							if (!file_exists($ExisteArchivo)) {
								ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
							}
						}
					}
				}
			} else {
				if (!is_dir($rutaCrearAnio)) {
					//si existe la agencia pero no el año
					$rutaCrearDesdeAño = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/$periodo/$dominio/";

					$crearAnio = mkdir($rutaCrearDesdeAño);
					ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
				} else {
					if (!is_dir($rutaCrearPeriodo)) {
						//si existe el año pero no el periodo
						$rutaCrearDesdePeriodo = "ftp://webdig:muni1234@192.168.0.2/Transporte/$Agencia/$anio/$periodo/$dominio/";

						$crearPeriodo = mkdir($rutaCrearDesdePeriodo);
						ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
					} else {
						if (!is_dir($rutaCrearDominio)) {
							$crearDominio = mkdir($rutaCrearDominio);
							if (!file_exists($ExisteArchivo)) {
								ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
							}
						} else {
							ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
						}
					}
				}
			}

			if (!is_dir($rutaCrearAgencia)) {
				$crearAgencia = mkdir($rutaCrearDominio, 0777);
			} else {
				ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);
			}
			ftp_put($id_ftp, $archivo1, $rutaTemp, FTP_BINARY);

			ftp_quit($id_ftp);

			$insertAuditoria = Conexiones::conDDLocal()->prepare("EXEC	AuditoriaUsuario ?,?,?,?,?,?,?,?,?");

			$insertAuditoria->bindParam(1, $codUsu);
			$insertAuditoria->bindParam(2, $Usuario);
			$insertAuditoria->bindParam(3, $detalle);
			$insertAuditoria->bindParam(4, $idAdherente);
			$insertAuditoria->bindParam(5, $titulo);
			$insertAuditoria->bindParam(6, $detalle2);
			$insertAuditoria->bindParam(7, $descripcion);
			$insertAuditoria->bindParam(8, $src2);
			$insertAuditoria->bindParam(9, $NombreArchivo);


			if ($insertAuditoria->execute()) {
				return "ok";
			} else {
				return "error insert auditoria";
				// return die(print_r(sqlsrv_errors(), true));
			}
		} else {
			return "error insert imagen";
			// die(print_r(sqlsrv_errors(), true));
		}
	}

	public function mdlBajaArchivo($idDocumento, $idAdherente, $dominio, $Usuario, $codUsu, $Agencia, $anio, $periodo, $NombreArchivo)
	{
		$ConsultaDocDig = Conexiones::conDDLocal()->prepare("SELECT [IdDocumentosDigitalizados]
				,[idAdherente]
				,[idRubro]
				,[idRequisitosTramites]
				,[idArea]
				,[idExpediente]
				,[idExpedienteAntiguo]
				,[IdTH]
				,[titulo]
				,[detalle]
				,[Descripcion]
				,[src]
				,[archivo]
				,[extension]
				,[fechaCreacion]
				,[fechaValidoHasta]
				,[Activo]
				,[SegExpediente]
			FROM [MunicipalidadDigital].[dbo].[DocumentosDigitalizados]
			WHERE
		[IdDocumentosDigitalizados]=$idDocumento");
		//EXEC ConsultaTH $consulta


		if ($ConsultaDocDig->execute()) {

			$detalle = "BAJA EXPEDIENTE";
			$detalle2 = "DIRECCION DE TRANSPORTE";
			foreach ($ConsultaDocDig->fetchAll() as $key => $fila) {
				$idAdherente = $fila[1];
				$titulo = $fila[10];
				$descripcion = $fila[12];
				$src = $fila[13];
				$archivo = $fila[14];
			}
			$insertAuditoria = Conexiones::conDDLocal()->prepare("EXEC	AuditoriaUsuario ?,?,?,?,?,?,?,?,?");

			$insertAuditoria->bindParam(1, $codUsu);
			$insertAuditoria->bindParam(2, $Usuario);
			$insertAuditoria->bindParam(3, $detalle);
			$insertAuditoria->bindParam(4, $idAdherente);
			$insertAuditoria->bindParam(5, $titulo);
			$insertAuditoria->bindParam(6, $detalle2);
			$insertAuditoria->bindParam(7, $descripcion);
			$insertAuditoria->bindParam(8, $src);
			$insertAuditoria->bindParam(9, $NombreArchivo);

			if ($insertAuditoria->execute()) {
				$rutaEliminar = "Transporte/$Agencia/$anio/$periodo/$dominio/".$NombreArchivo;
				$id_ftp = DigiExpedientesModelo::ConectarFTP();
				$EliminarDocDig = Conexiones::conDDLocal()->prepare("
				DELETE FROM DocumentosDigitalizados
				WHERE IdDocumentosDigitalizados=$idDocumento");
				if ($EliminarDocDig->execute()) {
					if (ftp_delete($id_ftp, $rutaEliminar)) {
						return "ok";
					} else {
						return "errorFtp";
						die(print_r(sqlsrv_errors(), true));
					}
				} else {
					return "error baja archivo";
				}
			}
		} else {
			echo "no se encontraron datos para eliminar";
		}
	}
}

class ModeloAgencias
{
	public function listarAgencias()
	{
		$conT = Conexiones::conDDLocal()->prepare("SELECT idagen, agencia FROM dbo.Transporte_ListarAgencias() ORDER BY agencia");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			return $arreglo;
			$conT->close();
		}
	}
}


class ModeloDominios
{
	public function MdlMostrarDominios($id_agencia)
	{
		$id_agencia = $_POST['id_agencia'];
		$conT = Conexiones::conDDLocal()->prepare("SELECT idadhe, dominio FROM dbo.Transporte_ListarDominios($id_agencia) ORDER BY dominio");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			return $arreglo;
			$conT->close();
		}
	}
}


class ModeloChoferes
{
	public function MdlMostrarChoferes($dominio)
	{
		$dominio = $_POST['dominio'];
		$conT = Conexiones::conDDLocal()->prepare("SELECT idadhere, dni, cuim, chofer, clase, fechavto FROM dbo.Transporte_ListarChoferes('$dominio')");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			// return $arreglo;
			// $conT->close();
		}
		if ($arreglo != "") {
			return $arreglo;
			$conT->close();
		} else {
			$mensaje = "NO SE ENCONTRARON REGISTROS";
			return $mensaje;
			$conT->close();
		}
	}
}

class ModeloTitularVehiculo
{
	public function MdlMostrarDatosTitularVehiculo($dominio)
	{
		$conT = Conexiones::conDDLocal()->prepare("SELECT TOP(1) idadhere, dominio, propietario, dni, cuim, barrio, calle, altura, direccion, año, marca, tipovehi, motorvehi FROM [dbo].[DatosTitular]('$dominio')");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			// return $arreglo;
			// $conT->close();
		}
		if ($arreglo != "") {
			return $arreglo;
			$conT->close();
		} else {
			$mensaje = "NO SE ENCONTRARON REGISTROS";
			return $mensaje;
			$conT->close();
		}
	}
}

class ModeloDatosChofer
{
	public function MdlMostrarDatosChofer($id_adherente)
	{
		$conT = Conexiones::conDDLocal()->prepare("SELECT * FROM [dbo].[Transporte_DatosChofer]('$id_adherente')");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			// return $arreglo;
			// $conT->close();
		}
		if ($arreglo != "") {
			return $arreglo;
			$conT->close();
		} else {
			$mensaje = "NO SE ENCONTRARON REGISTROS";
			return $mensaje;
			$conT->close();
		}
	}

	public function MdlMostrarIdAdherente($expediente, $Dc, $Do)
	{
		$conT = Conexiones::conDDLocal()->prepare("SELECT MAX([idadhe]) AS idadhe FROM [Transito].[dbo].[VistaLosAdherentes] WHERE 
		dni = $Dc AND dominio = '$Do' AND numexpte = '$expediente'");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
		}
		if ($arreglo != "") {
			return $arreglo;
			$conT->close();
		} else {
			$mensaje = "NO SE ENCONTRARON REGISTROS";
			return $mensaje;
			$conT->close();
		}
	}
}

class ModeloRequisitos
{
	public function MdlMostrarRequisitos($id_tramite, $id_rubro, $id_adherente, $dominio)
	{
		$conDDLocal = Conexiones::conDDLocal()->prepare("SELECT * FROM [MunicipalidadDigital].[dbo].[FN_RequisitosTramitesAdherentes] (
			$id_tramite
		   ,$id_rubro
		   ,$id_adherente
		   ,'$dominio')");
		$conDDLocal->execute();

		$arreglo = array();
		if ($consulta = $conDDLocal->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			return $arreglo;
			$conT->close();
		}
	}
}

class ModeloPeriodos
{
	public function MdlMostrarPeriodos($dominio)
	{
		$conDDLocal = Conexiones::conDDLocal()->prepare("SELECT DISTINCT * FROM [MunicipalidadDigital].[dbo].[mostrarPeriodos]('$dominio')");

		$conDDLocal->execute();

		$arreglo = array();
		if ($consulta = $conDDLocal->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			return $arreglo;
			$conT->close();
		}
	}
}


class ModeloAgencia
{
	public function MostrarAgencia()
	{
		$id_agencia = $_REQUEST['Iag'];
		$conT = Conexiones::conDDLocal()->prepare("SELECT idagen, agencia FROM dbo.VerAgencia($id_agencia) ORDER BY agencia");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			return $arreglo;
			$conT->close();
		}
	}
}



class ModeloHistorialChoferes
{
	public function MostrarHistorialDominio()
	{
		$dominio = $_REQUEST['Do'];

		$conT = Conexiones::conDDLocal()->prepare("SELECT * FROM [MunicipalidadDigital].[dbo].[HistoricoDominio]('$dominio')");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			return $arreglo;
			$conT->close();
		}
	}

	public function MostrarPeriodosDominio()
	{
		$dominio = $_REQUEST['Do'];
		$idAgencia = $_REQUEST['Iag'];

		// $conT = Conexiones::conDDLocal()->prepare("SELECT DISTINCT FechaDesde, FechaHasta FROM [MunicipalidadDigital].[dbo].[HistoricoDominio]('$dominio')");
		// $conT->execute();

		$conT = Conexiones::conDDLocal()->prepare("SELECT * FROM [MunicipalidadDigital].[dbo].[PeriodosDeDominio]('$dominio', '$idAgencia')");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			return $arreglo;
			$conT->close();
		}
	}

	public function MdlHistoDominio()
	{
		$dominio = $_REQUEST['dominio'];

		$conT = Conexiones::conDDLocal()->prepare("SELECT * FROM [MunicipalidadDigital].[dbo].[FiltroDominio]('$dominio')");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			return $arreglo;
			$conT->close();
		}
	}
}

class ModeloRequisitosFiltrados
{
	public function MdlRequisitosFiltrados()
	{
		$Fdesde = $_REQUEST['Vd'];
		$Fhasta = $_REQUEST['Vh'];
		$dominio = $_REQUEST['Do'];
		$id_adherente = $_REQUEST['Ia'];
		$id_tramite = 8;
		$id_rubro = 0;

		$conT = Conexiones::conDDLocal()->prepare("SELECT * FROM [MunicipalidadDigital].[dbo].[Transporte_FiltrarRequisitos]($id_tramite, $id_rubro,$id_adherente, '$dominio', '$Fdesde', '$Fhasta')");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			return $arreglo;
			$conT->close();
		}
	}

	public function GetFechas()
	{
		$idAdherente = $_REQUEST['Ia'];
		$dominio = $_REQUEST['Do'];

		$conT = Conexiones::conDDLocal()->prepare("SELECT * FROM [MunicipalidadDigital].[dbo].[getFECHA]($idAdherente,'$dominio')");
		$conT->execute();

		$arreglo = array();
		if ($consulta = $conT->fetchAll()) {
			foreach ($consulta as $fila) {
				$arreglo[] = $fila;
			}
			return $arreglo;
			$conT->close();
		}
	}
}
