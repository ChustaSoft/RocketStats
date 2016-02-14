<?php
require_once 'controllers/ControladorEstadisticas.php';
require_once 'controllers/ControladorJugadores.php';

class CargadorVistas{
	
	private $controlador;

	public function main($contenido="", $menu='<div id="mainMenu"><ul><li><a href="index.php?action=1">Validar</a></li></ul></div>'){
			
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
		$contenido = $this->load_template("views/templates/login_form.html");
		return $this->main($contenido);
	}
	
	/*
	 * Valida si el usuario introducido existe y es correcto
	 */
	public function validateUser(){
		$contenido;
		$menu;
		
		if(isset($_POST["loginSubmit"])){
			$userName = $_POST["nombre"];
			$userPassword = $_POST["password"];
			
			$this->controlador = new ControladorJugadores();
			$user = $this->controlador->validarJugador($userName, $userPassword);
				
			if($user->getId() > 0){
				$user->setContra("");
				$menu = $this->load_template("views/templates/menu_bar.html");
				$contenido = "Bienvenido";
				$_SESSION["sessionUserName"] = $_POST["nombre"];
				$_SESSION["sessionUserId"] = $user->getId();
				
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
		
		return $this->validateForm();
	}
	
	public function setJugadoresView(){
		$nuevoUsuarioContenido = $this->load_template("views/templates/jugador_nuevo.html");
		$tablaEstadisticasContenido = $this->load_template("views/templates/jugadores_view.html");
		$menu = $this->load_template("views/templates/menu_bar.html");
		
		return $this->main($nuevoUsuarioContenido . $tablaEstadisticasContenido, $menu);		
	}
	
	public function setEstadisticasView(){
		$filtrosEstadisticas = $this->load_template("views/templates/estadisticas_filtros.html");
		$nuevoPartidoContenido = $this->load_template("views/templates/form_nuevo_partido.html");
		$tablaEstadisticasContenido = $this->load_template("views/templates/estadisticas_view.html");
		$menu = $this->load_template("views/templates/menu_bar.html");
	
		return $this->main($filtrosEstadisticas . $nuevoPartidoContenido . $tablaEstadisticasContenido, $menu);
	}
		
}

?>