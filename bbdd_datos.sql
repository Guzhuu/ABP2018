

/*TODOS LOS USUARIOS TIENEN DE CONTRASEÑA 12345*/
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('72180857A', '11', 'CESAR', ' HEREDIA MANIAS', 'Hombre', '827ccb0eea8a706c4c34a16891f84e7b', '0', false, false);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('08722995S', 22, 'RICARDO', 'BENAVENTENGUAL', 'Hombre', '827ccb0eea8a706c4c34a16891f84e7b', '12', false, false);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('93407187R', 33, 'INES', 'ZABALETA FUENTE', 'Mujer', '827ccb0eea8a706c4c34a16891f84e7b', '12', false, false);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('78380290Q', 44, 'JULIA', 'MORATO MEDIAVILLA', 'Mujer', '827ccb0eea8a706c4c34a16891f84e7b', '65', false, false);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('20865489G', 55, 'SOFIA', 'CABANES UGALDE', 'Mujer', '827ccb0eea8a706c4c34a16891f84e7b', '0', false, false);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('57768016C', 66, 'JOAN', 'OLIVE OLIVERAS', 'Hombre', '827ccb0eea8a706c4c34a16891f84e7b', '44', false, false);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('02793268X', 77, 'SOFIA', 'BARREDA LASHERAS', 'Mujer', '827ccb0eea8a706c4c34a16891f84e7b', '80', false, true);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('67721782F', 88, 'JOSE MIGUEL', 'OLMO ARMENTEROS', 'Hombre', '827ccb0eea8a706c4c34a16891f84e7b', '90', false, true);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('53495571D', 24, 'IVAN', 'ROCAMORA NOTARIO', 'Hombre', '827ccb0eea8a706c4c34a16891f84e7b', '900', false, true);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('99185554D', 25, 'JOSE', 'ESTRUCH PADIN', 'Hombre', '827ccb0eea8a706c4c34a16891f84e7b', '90', false, true);
INSERT INTO Deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_Socio, rolAdmin, rolEntrenador)
VALUES ('12345678A', 17, 'PEDRO', 'CUESTA MORALES', 'Hombre', '827ccb0eea8a706c4c34a16891f84e7b', '90', false, false);


INSERT INTO Pareja (codPareja, DNI_Capitan, DNI_Companhero)
VALUES ('72180857A08722995S', '72180857A', '08722995S');
INSERT INTO Pareja (codPareja, DNI_Capitan, DNI_Companhero)
VALUES ('72180857A93407187R', '72180857A', '93407187R');
INSERT INTO Pareja (codPareja, DNI_Capitan, DNI_Companhero)
VALUES ('12345678A78380290Q', '12345678A', '78380290Q');
INSERT INTO Pareja (codPareja, DNI_Capitan, DNI_Companhero)
VALUES ('99185554D53495571D', '99185554D', '53495571D');
INSERT INTO Pareja (codPareja, DNI_Capitan, DNI_Companhero)
VALUES ('53495571D99185554D', '53495571D', '99185554D');
INSERT INTO Pareja (codPareja, DNI_Capitan, DNI_Companhero)
VALUES ('20865489G12345678A', '20865489G', '12345678A');
INSERT INTO Pareja (codPareja, DNI_Capitan, DNI_Companhero)
VALUES ('02793268X57768016C', '02793268X', '57768016C');
INSERT INTO Pareja (codPareja, DNI_Capitan, DNI_Companhero)
VALUES ('67721782F08722995S', '67721782F', '08722995S');
INSERT INTO Pareja (codPareja, DNI_Capitan, DNI_Companhero)
VALUES ('000000000111111111', '000000000', '111111111');
INSERT INTO Pareja (codPareja, DNI_Capitan, DNI_Companhero)
VALUES ('11111111120865489G', '111111111', '20865489G');


INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2018-11-23 10:00:00', '2018-11-23 11:30:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2018-11-24 04:30:00', '2018-04-24 13:00:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2018-04-24 13:00:00', '2018-04-24 14:30:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2018-04-24 14:30:00', '2018-04-24 16:00:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2019-11-24 16:00:00', '2019-11-24 17:30:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2019-11-23 10:00:00', '2019-11-23 11:30:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2019-11-24 04:30:00', '2019-04-24 13:00:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2019-04-24 13:00:00', '2019-04-24 14:30:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2019-04-24 14:30:00', '2019-04-24 16:00:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2018-11-24 16:00:00', '2018-11-24 17:30:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2019-11-24 8:30:00', '2019-11-24 10:00:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2019-11-24 8:30:00', '2019-11-24 10:00:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2019-01-16 8:30:00', '2019-01-16 10:00:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2019-01-17 8:30:00', '2019-01-17 10:00:00');
INSERT INTO Horario (`HoraInicio`, `HoraFin`)
VALUES ('2019-01-29 8:30:00', '2019-01-29 10:00:00');


INSERT INTO Pista (codigoPista, nombre)
VALUES(1,'PistaFrancia');
INSERT INTO Pista (codigoPista, nombre)
VALUES(2,'PistaSuiza');
INSERT INTO Pista (codigoPista, nombre)
VALUES(3,'PistaItalia');
INSERT INTO Pista (codigoPista, nombre)
VALUES(4,'PistaSuecia');
INSERT INTO Pista (codigoPista, nombre)
VALUES(5,'PistaMarruecos');
INSERT INTO Pista (codigoPista, nombre)
VALUES(6,'PistaArgentina');
INSERT INTO Pista (codigoPista, nombre)
VALUES(7,'PistaBrasil');
INSERT INTO Pista (codigoPista, nombre)
VALUES(8,'PistaRusia');

INSERT INTO Partido (Partido, codigoHorario, codigoPista)
VALUES(1,1, 1);
INSERT INTO Partido (Partido, codigoHorario, codigoPista)
VALUES(2,2, 4);
INSERT INTO Partido (Partido, codigoHorario, codigoPista)
VALUES(3,6, 5);
INSERT INTO Partido (Partido, codigoHorario, codigoPista)
VALUES(4,6, 7);
INSERT INTO Partido (Partido, codigoHorario, codigoPista)
VALUES(5,6, 5);
INSERT INTO Partido (Partido, codigoHorario, codigoPista)
VALUES(6,3, 3);
INSERT INTO Partido (Partido, codigoHorario, codigoPista)
VALUES(7,3, 2);
INSERT INTO Partido (Partido, codigoHorario, codigoPista)
VALUES(8,3, 1);


INSERT INTO Campeonato (Campeonato, FechaInicio, FechaFinal, Nombre)
VALUES(1, '2018-11-10 09:00:00','2019-12-10 10:00:00', 'GADIS');
INSERT INTO Campeonato (Campeonato, FechaInicio, FechaFinal, Nombre)
VALUES(2, '2018-11-11 09:00:00','2019-12-11 10:00:00', 'NAVIDAD');
INSERT INTO Campeonato (Campeonato, FechaInicio, FechaFinal, Nombre)
VALUES(3, '2018-11-12 09:00:00','2019-12-12 10:00:00', 'PRIMAVERA');
INSERT INTO Campeonato (Campeonato, FechaInicio, FechaFinal, Nombre)
VALUES(4, '2018-11-13 09:00:00','2018-12-13 10:00:00', 'OTOÑO');
INSERT INTO Campeonato (Campeonato, FechaInicio, FechaFinal, Nombre)
VALUES(5, '2018-11-14 09:00:00','2018-12-14 10:00:00', 'INVIERNO');
INSERT INTO Campeonato (Campeonato, FechaInicio, FechaFinal, Nombre)
VALUES(6, '2018-11-15 09:00:00','2019-12-15 10:00:00', 'JUBILADOS');
INSERT INTO Campeonato (Campeonato, FechaInicio, FechaFinal, Nombre)
VALUES(7, '2018-11-16 09:00:00','2019-12-16 10:00:00', 'ESEI');
INSERT INTO Campeonato (Campeonato, FechaInicio, FechaFinal, Nombre)
VALUES(8, '2018-11-17 09:00:00','2018-12-17 10:00:00', 'FCETOU');
INSERT INTO Campeonato (Campeonato, FechaInicio, FechaFinal, Nombre)
VALUES(9, '2018-11-18 09:00:00','2018-12-18 10:00:00', 'OURENSE');
INSERT INTO Campeonato (Campeonato, FechaInicio, FechaFinal, Nombre)
VALUES(10, '2018-11-19 09:00:00','2019-12-19 10:00:00', 'HULIO');

INSERT INTO Categoria (Nivel, Sexo)
VALUES('1', 'M');
INSERT INTO Categoria (Nivel, Sexo)
VALUES('1', 'F');
INSERT INTO Categoria (Nivel, Sexo)
VALUES('1', 'MX');
INSERT INTO Categoria (Nivel, Sexo)
VALUES('2', 'M');
INSERT INTO Categoria (Nivel, Sexo)
VALUES('2', 'F');
INSERT INTO Categoria (Nivel, Sexo)
VALUES('2', 'MX');
INSERT INTO Categoria (Nivel, Sexo)
VALUES('3', 'M');
INSERT INTO Categoria (Nivel, Sexo)
VALUES('3', 'F');
INSERT INTO Categoria (Nivel, Sexo)
VALUES('3', 'MX');

 
INSERT INTO Campeonato_consta_de_categorias (Campeonato_Campeonato, Categoria_Categoria)
VALUES(1, 1);
INSERT INTO Campeonato_consta_de_categorias (Campeonato_Campeonato, Categoria_Categoria)
VALUES(1, 2);
INSERT INTO Campeonato_consta_de_categorias (Campeonato_Campeonato, Categoria_Categoria)
VALUES(1, 3);
INSERT INTO Campeonato_consta_de_categorias (Campeonato_Campeonato, Categoria_Categoria)
VALUES(2, 1);
INSERT INTO Campeonato_consta_de_categorias (Campeonato_Campeonato, Categoria_Categoria)
VALUES(2, 3);
INSERT INTO Campeonato_consta_de_categorias (Campeonato_Campeonato, Categoria_Categoria)
VALUES(4, 6);
INSERT INTO Campeonato_consta_de_categorias (Campeonato_Campeonato, Categoria_Categoria)
VALUES(5, 1);
INSERT INTO Campeonato_consta_de_categorias (Campeonato_Campeonato, Categoria_Categoria)
VALUES(5, 2);


INSERT INTO pareja_pertenece_categoria (Pareja_codPareja , Categoria_Categoria)
VALUES ('72180857A08722995S', '1');
INSERT INTO pareja_pertenece_categoria (Pareja_codPareja , Categoria_Categoria)
VALUES ('72180857A93407187R', '1');
INSERT INTO pareja_pertenece_categoria (Pareja_codPareja , Categoria_Categoria)
VALUES ('12345678A78380290Q', '1');
INSERT INTO pareja_pertenece_categoria (Pareja_codPareja , Categoria_Categoria)
VALUES ('99185554D53495571D', '1');
INSERT INTO pareja_pertenece_categoria (Pareja_codPareja , Categoria_Categoria)
VALUES ('53495571D99185554D', '1');
INSERT INTO pareja_pertenece_categoria (Pareja_codPareja , Categoria_Categoria)
VALUES ('20865489G12345678A', '1');
INSERT INTO pareja_pertenece_categoria (Pareja_codPareja , Categoria_Categoria)
VALUES ('02793268X57768016C', '1');
INSERT INTO pareja_pertenece_categoria (Pareja_codPareja , Categoria_Categoria)
VALUES ('67721782F08722995S', '1');
INSERT INTO pareja_pertenece_categoria (Pareja_codPareja , Categoria_Categoria)
VALUES ('000000000111111111', '1');
INSERT INTO pareja_pertenece_categoria (Pareja_codPareja , Categoria_Categoria)
VALUES ('11111111120865489G', '1');

INSERT INTO Pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias , ParejaPerteneceCategoria)
VALUES ('1', '1');
INSERT INTO pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias , ParejaPerteneceCategoria)
VALUES ('1', '2');
INSERT INTO pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias , ParejaPerteneceCategoria)
VALUES ('1', '3');
INSERT INTO pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias , ParejaPerteneceCategoria)
VALUES ('1', '4');
INSERT INTO pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias , ParejaPerteneceCategoria)
VALUES ('1', '5');
INSERT INTO pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias , ParejaPerteneceCategoria)
VALUES ('1', '6');
INSERT INTO pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias , ParejaPerteneceCategoria)
VALUES ('1', '7');
INSERT INTO pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias , ParejaPerteneceCategoria)
VALUES ('1', '8');
INSERT INTO pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias , ParejaPerteneceCategoria)
VALUES ('1', '9');
INSERT INTO pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias , ParejaPerteneceCategoria)
VALUES ('1', '10');


INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES ('4','4');
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES ('1','3');
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES ('2','5');
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES ('3','7');
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES ('4','8');
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES ('5','1');
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES ('6','4');
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES ('7','6');
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES ('8','4');
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES ('1','4');
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES (12,2);
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES (13, 3);
INSERT INTO Pista_tiene_horario (Horario_Horario,Pista_codigoPista) 
VALUES (14,5);

INSERT INTO Reserva (Reserva, codigoPistayHorario, DNI_Deportista)
VALUES (1, 1, '72180857A');
INSERT INTO Reserva (Reserva, codigoPistayHorario, DNI_Deportista)
VALUES ('2', '2', '08722995S');
INSERT INTO Reserva (Reserva, codigoPistayHorario, DNI_Deportista)
VALUES ('3', '3', '93407187R');
INSERT INTO Reserva (Reserva, codigoPistayHorario, DNI_Deportista)
VALUES ('4', '4','78380290Q');
INSERT INTO Reserva (Reserva, codigoPistayHorario, DNI_Deportista)
VALUES ('5', '5', '20865489G');
INSERT INTO Reserva (Reserva, codigoPistayHorario, DNI_Deportista)
VALUES ('6', '6', '57768016C');
INSERT INTO Reserva (Reserva, codigoPistayHorario, DNI_Deportista)
VALUES ('7', '7', '02793268X');
INSERT INTO Reserva (Reserva, codigoPistayHorario, DNI_Deportista)
VALUES ('8', '8', '67721782F');
INSERT INTO Reserva (Reserva, codigoPistayHorario, DNI_Deportista)
VALUES ('9', '9', '53495571D');
INSERT INTO Reserva (Reserva, codigoPistayHorario, DNI_Deportista)
VALUES ('10', '10', '99185554D');

INSERT INTO Grupo(nombre,CampeonatoCategoria,ParejaCategoria)
VALUES ('B', '2', '2');
INSERT INTO Grupo(nombre,CampeonatoCategoria,ParejaCategoria)
VALUES ('C', '4', '3');
INSERT INTO Grupo(nombre,CampeonatoCategoria,ParejaCategoria)
VALUES ('D', '4', '4');
INSERT INTO Grupo(nombre,CampeonatoCategoria,ParejaCategoria)
VALUES ('E', '5', '5');
INSERT INTO Grupo(nombre,CampeonatoCategoria,ParejaCategoria)
VALUES ('F', '6','6');
INSERT INTO Grupo(nombre,CampeonatoCategoria,ParejaCategoria)
VALUES ('G', '7', '7');
INSERT INTO Grupo(nombre,CampeonatoCategoria,ParejaCategoria)
VALUES ('H', '8', '8');

INSERT INTO Enfrentamiento (Enfrentamiento, nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
VALUES ('1', 'C', '4', '72180857A08722995S', '72180857A93407187R', '6-1', '3-6', '6-2');
INSERT INTO Enfrentamiento (Enfrentamiento, nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
VALUES ('2', 'C', '4', '12345678A78380290Q', '99185554D53495571D','6-1', '0-6', '6-2');
INSERT INTO Enfrentamiento (Enfrentamiento, nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
VALUES ('3', 'D', '4', '53495571D99185554D','20865489G12345678A','6-1', '3-6', '6-0');
INSERT INTO Enfrentamiento (Enfrentamiento, nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
VALUES ('4', 'D', '4', '02793268X57768016C','67721782F08722995S','6-1', '3-6', '6-4');
INSERT INTO Enfrentamiento (Enfrentamiento, nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
VALUES ('5', 'C', '4', '53495571D99185554D','72180857A93407187R','6-3', '1-6', '6-3');
INSERT INTO Enfrentamiento (Enfrentamiento, nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
VALUES ('6', 'C', '4', '99185554D53495571D','67721782F08722995S','6-0', '0-6', '6-2');
INSERT INTO Enfrentamiento (Enfrentamiento, nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
VALUES ('7', 'C', '4', '02793268X57768016C','20865489G12345678A','6-1', '3-6', '0-6');
INSERT INTO Enfrentamiento (Enfrentamiento, nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
VALUES ('8', 'C', '4', '12345678A78380290Q','20865489G12345678A','6-1', '2-6', '6-0');
INSERT INTO Enfrentamiento (Enfrentamiento, nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
VALUES ('9', 'D', '4', '53495571D99185554D','12345678A78380290Q','4-6', '3-6', '6-1');
INSERT INTO Enfrentamiento (Enfrentamiento, nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
VALUES ('10', 'D', '4', '67721782F08722995S','12345678A78380290Q','6-4', '1-6', '6-3');




INSERT INTO Deportista_juega_partido (DNI_Deportista1, DNI_Deportista2,
DNI_Deportista3,DNI_Deportista4,Partido_Partido)
VALUES ('72180857A','08722995S','93407187R','78380290Q','1');
INSERT INTO Deportista_juega_partido (DNI_Deportista1, DNI_Deportista2,
DNI_Deportista3,DNI_Deportista4,Partido_Partido) 
VALUES ('02793268X','72180857A','57768016C','78380290Q','2');
INSERT INTO Deportista_juega_partido (DNI_Deportista1, DNI_Deportista2,
DNI_Deportista3,DNI_Deportista4,Partido_Partido) 
VALUES ('57768016C','02793268X','72180857A','78380290Q','3');
INSERT INTO Deportista_juega_partido (DNI_Deportista1, DNI_Deportista2,
DNI_Deportista3,DNI_Deportista4,Partido_Partido) 
VALUES ('93407187R','57768016C','02793268X','72180857A','4');
INSERT INTO Deportista_juega_partido (DNI_Deportista1, DNI_Deportista2,
DNI_Deportista3,DNI_Deportista4,Partido_Partido) 
VALUES ('67721782F','93407187R','02793268X','57768016C','5');
INSERT INTO Deportista_juega_partido (DNI_Deportista1, DNI_Deportista2,
DNI_Deportista3,DNI_Deportista4,Partido_Partido) 
VALUES ('93407187R','72180857A','78380290Q','67721782F','6');
INSERT INTO Deportista_juega_partido (DNI_Deportista1, DNI_Deportista2,
DNI_Deportista3,DNI_Deportista4,Partido_Partido) 
VALUES ('57768016C','78380290Q','08722995S','53495571D','7');
INSERT INTO Deportista_juega_partido (DNI_Deportista1, DNI_Deportista2,
DNI_Deportista3,DNI_Deportista4,Partido_Partido)
VALUES ('93407187R','57768016C','12345678A','53495571D','8');

INSERT INTO Escuela (codigoEscuela,nombreEscuela)
VALUES ('1','Escuela EI');
INSERT INTO Escuela (codigoEscuela,nombreEscuela)
VALUES ('2','ESEI');
INSERT INTO Escuela (codigoEscuela,nombreEscuela)
VALUES ('3','Padel Ourense');
INSERT INTO Escuela (codigoEscuela,nombreEscuela)
VALUES ('4','Pedales Ourense');
INSERT INTO Escuela (codigoEscuela,nombreEscuela)
VALUES ('5','AWGP PADEL');
INSERT INTO Escuela (codigoEscuela,nombreEscuela)
VALUES ('6','JUVIPADEL escuelas');
INSERT INTO Escuela (codigoEscuela,nombreEscuela)
VALUES ('7','EASE');
INSERT INTO Escuela (codigoEscuela,nombreEscuela)
VALUES ('8','ESEA');
INSERT INTO Escuela (codigoEscuela,nombreEscuela)
VALUES ('9','ENEAESEA');
INSERT INTO Escuela (codigoEscuela,nombreEscuela)
VALUES ('10','La familia');

INSERT INTO Clase (Reserva_Reserva,codigoEscuela, Entrenador, Curso)
VALUES ('1','6', '99185554D', 'Tacticas secretas');
INSERT INTO Clase (Reserva_Reserva,codigoEscuela, Entrenador, Curso)
VALUES ('2','5', '02793268X', 'Resistencia');
INSERT INTO Clase (Reserva_Reserva,codigoEscuela, Entrenador, Curso)
VALUES ('3','4', '67721782F', 'Resistencia');
INSERT INTO Clase (Reserva_Reserva,codigoEscuela, Entrenador, Curso)
VALUES ('4','3', '53495571D', 'Resistencia');
INSERT INTO Clase (Reserva_Reserva,codigoEscuela, Entrenador, Curso)
VALUES ('5','2', '99185554D', 'Resistencia');
INSERT INTO Clase (Reserva_Reserva,codigoEscuela, Entrenador, Curso)
VALUES ('6','1', '99185554D', 'Boleas');
INSERT INTO Clase (Reserva_Reserva,codigoEscuela, Entrenador, Curso)
VALUES ('7','1', '67721782F', 'Boleas');

INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('1','02793268X');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('1','08722995S');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('1','111111111');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('1','12345678A');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('2','20865489G');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('2','111111111');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('2','57768016C');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('2','67721782F');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('3','72180857A');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('3','78380290Q');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('3','93407187R');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('3','99185554D');
INSERT INTO Deportista_inscrito_clase(Clase, DNI_Deportista)
VALUES ('3','111111111');