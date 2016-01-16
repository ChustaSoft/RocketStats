<?php
require_once 'controllers/ControladorEstadisticas.php';
require_once 'controllers/ControladorJugadores.php';

class CargadorVistas{
	
	private $controlador;

	public function main($contenido="&#8364;lit3 PC Gaming Clan - Rocket Leaghe Stats", $menu='<a href="index.php?action=1">Validar</a>'){
			
		$pagina = $this->load_template('views/templates/estructura_principal.html');
		$comodines = array("%CONTENT%" , "%MENU%");
		$texto   = array($contenido, $menu);
	
		$replacePage = str_replace($comodines, $texto, $pagina);
	
		return $replacePage;
	}
	
	/*
	 * Carga todo el template en un string 
	 */
	private function load_template($pagWeb){
		$pagina = file_get_contents($pagWeb);
		return $pagina;
	}
	
	/*
	 * Establece el formulario de validacion de usuario
	 */
	public function validateForm(){	
		$contenido= $this->load_template("views/templates/login_form.html");
		return $this->main($contenido);
	}
	
	/*
	 * Valida si el usuario introducido existe y es correcto
	 */
	public function validateUser(){
		$contenido;
		$menu;
		
		if(isset($_POST["submit"])){
			$userName = $_POST["nombre"];
			$userPassword = $_POST["password"];
			
			$this->controlador = new ControladorJugadores();
			$user = $this->controlador->validarJugador($userName, $userPassword);
				
			if($user->getId() > 0){
				$user->setContra("");
				$menu = $this->load_template("views/templates/menu_bar.html");
				$contenido = "Bienvenido";
				$_SESSION["autenticate"] = $_POST["nombre"];
				
				return $this->main($contenido, $menu);
			}
			else{
				return $this->validateForm();
			}			
		}
		else
			return $this->validateForm();
	}
	
	public function logout(){
		session_unset();
		session_destroy();
	}
	
}

?>