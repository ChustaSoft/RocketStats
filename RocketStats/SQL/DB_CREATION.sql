CREATE USER chustasoft@'localhost' INDETIFIED BY 'chustaK4';
GRANT ALL ON rocketstat.* TO chustasoft@'localhost' INDETIFIED BY 'chustaK4';

CREATE TABLE jugadores(
	id INT(3) PRIMARY KEY AUTO_INCREMENT,
	codigo VARCHAR(25),
	nombre VARCHAR(100),
	contra VARCHAR(100) DEFAULT null
)ENGINE=INNODB DEFAULT CHARSET UTF8;

CREATE TABLE estadisticas(
	id INT(7) PRIMARY KEY AUTO_INCREMENT,
	mvp BOOLEAN,
	puntaje INT(5),
	goles INT(2),
	asistencias INT(2),
	salvadas INT(2),
	tiros INT(2)
)ENGINE=INNODB DEFAULT CHARSET UTF8;

CREATE TABLE tipos_partido(
	id INT(3) PRIMARY KEY AUTO_INCREMENT,
	descripcion VARCHAR(25)
)ENGINE=INNODB DEFAULT CHARSET UTF8;

CREATE TABLE partidos(
	id INT(5) PRIMARY KEY AUTO_INCREMENT,
	tipo INT(3),
	victoria BOOLEAN
)ENGINE=INNODB DEFAULT CHARSET UTF8;

CREATE TABLE estadisticas_partido_jugador(
	id INT(12) PRIMARY KEY AUTO_INCREMENT,
	id_partido INT(5),
	id_jugador INT(3),
	id_estadistica INT(7)
)ENGINE=INNODB DEFAULT CHARSET UTF8;

ALTER TABLE partidos ADD FOREIGN KEY (tipo) REFERENCES tipos_partido(id);
ALTER TABLE estadisticas_partido_jugador ADD FOREIGN KEY (id_partido) REFERENCES partidos(id);
ALTER TABLE estadisticas_partido_jugador ADD FOREIGN KEY (id_jugador) REFERENCES jugadores(id);
ALTER TABLE estadisticas_partido_jugador ADD FOREIGN KEY (id_estadistica) REFERENCES estadisticas(id);

--Auditoria para las estadisticas
ALTER TABLE estadisticas_partido_jugador ADD COLUMN auditoriaJugador INT(3);
ALTER TABLE estadisticas_partido_jugador ADD COLUMN auditoriaJugadorFecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE estadisticas_partido_jugador ADD FOREIGN KEY (auditoriaJugador) REFERENCES jugadores(id);