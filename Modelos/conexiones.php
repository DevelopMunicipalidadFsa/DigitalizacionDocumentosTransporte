<?php
    class Conexiones{
    	// CONEXIÓN A LA BASE DE DATOS CON FUNCION DE MunicipalidadDigita
		public function conDDLocal(){
			$user = 'emilianog';
			$pass = '250398Mc';

			// $user = 'AplDigitalizacion';
			// $pass = 'Zr280534';

			// $conDDLocal = new PDO('sqlsrv:Server=localhost; Database=MunicipalidadDigital;', $user, $pass);
			$conDDLocal = new PDO('sqlsrv:Server=192.168.0.4; Database=MunicipalidadDigital;', $user, $pass);
			$conDDLocal -> exec('set names utf8');
			return $conDDLocal;
		}

		public function conTLocal(){
			// $conexion=new PDO("sqlsrv:Server=localhost;Database=Transito", "sa", '1234');
			$conexion=new PDO("sqlsrv:Server=192.168.0.4;Database=Transito", "emilianog", '250398Mc');
			$conexion->exec('set names utf8');
	
			return $conexion;
		}

		// CONEXIÓN A LA BASE DE DATOS CON FUNCION DE municipio
		public function conMLocal(){
			// $user = 'racosta';
			// $pass = '38577190Ra';

			$user = 'emilianog';
			$pass = '250398Mc';

			// $conMLocal = new PDO('sqlsrv:Server=localhost; Database=municipio;', $user, $pass);
			$conMLocal = new PDO('sqlsrv:Server=192.168.0.4; Database=municipio;', $user, $pass);
			$conMLocal -> exec('set names utf8');
			return $conMLocal;
		}
    }
	 
	$serverNameMLocal = "192.168.0.4";
	$connectionInfoMLocal = array("Database"=>"MunicipalidadDigital", "UID"=>"emilianog", "PWD"=>'250398Mc ', "CharacterSet"=>"UTF-8");
	$conDDLocal = sqlsrv_connect($serverNameMLocal, $connectionInfoMLocal);

	