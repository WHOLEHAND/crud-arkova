SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS arkova;

USE arkova;

DROP TABLE IF EXISTS auditory;
CREATE TABLE `auditory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aud_user` varchar(15) NOT NULL,
  `aud_registereddate` datetime NOT NULL,
  `aud_action` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO auditory VALUES("1","LuxFero","2024-12-02 07:41:40","El usuario [LuxFero] inició sesión como usuario");
INSERT INTO auditory VALUES("2","LuxFero","2024-12-02 07:41:40","El usuario [LuxFero] inició sesión como usuario");
INSERT INTO auditory VALUES("3","LuxFero","2024-12-02 12:41:46","El usuario [LuxFero] cerró sesión");
INSERT INTO auditory VALUES("4","LuxFero","2024-12-02 07:45:29","El usuario [LuxFero] inició sesión como usuario");
INSERT INTO auditory VALUES("5","LuxFero","2024-12-02 07:45:29","El usuario [LuxFero] inició sesión como usuario");
INSERT INTO auditory VALUES("6","LuxFero","2024-12-02 12:45:39","El usuario [LuxFero] cerró sesión");
INSERT INTO auditory VALUES("7","WHOLEHAND","2024-12-03 10:39:50","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("8","WHOLEHAND","2024-12-03 10:39:50","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("9","WHOLEHAND","2024-12-03 15:39:58","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("10","WHOLEHAND","2024-12-03 10:40:39","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("11","WHOLEHAND","2024-12-03 10:40:39","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("12","WHOLEHAND","2024-12-03 15:41:24","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("13","WHOLEHAND","2024-12-03 10:43:34","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("14","WHOLEHAND","2024-12-03 10:43:34","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("15","WHOLEHAND","2024-12-03 15:43:54","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("16","WHOLEHAND","2024-12-03 10:44:47","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("17","WHOLEHAND","2024-12-03 10:44:47","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("18","WHOLEHAND","2024-12-03 15:45:05","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("19","WHOLEHAND","2024-12-03 10:46:25","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("20","WHOLEHAND","2024-12-03 10:46:25","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("21","WHOLEHAND","2024-12-03 20:24:44","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("22","WHOLEHAND","2024-12-03 20:24:44","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("23","WHOLEHAND","2024-12-08 01:48:50","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("24","WHOLEHAND","2024-12-08 01:48:50","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("25","WHOLEHAND","2024-12-08 06:51:48","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("26","WHOLEHAND","2024-12-31 16:26:23","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("27","WHOLEHAND","2024-12-31 16:26:24","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("28","WHOLEHAND","2024-12-31 16:32:04","El usuario [WHOLEHAND] creó un nuevo reporte del tipo \'Técnico\' con el nombre \'Mantenimiento Preventivo y Correctivo en el equipo 5 de la Sala de Formación\'");
INSERT INTO auditory VALUES("29","WHOLEHAND","2024-12-31 16:34:11","El usuario [WHOLEHAND] creó un nuevo reporte del tipo \'Técnico\' con el nombre \'Reestablecimiento de conectivad en el Dpto. Comunicaciones e Información\'");
INSERT INTO auditory VALUES("30","WHOLEHAND","2024-12-31 16:39:59","El usuario [WHOLEHAND] ha realizado los siguientes cambios en el reporte \'Reestablecimiento de conectivad en el Dpto. Comunies e Información\': Nombre: pasó de \'Reestablecimiento de conectivad en el Dpto. Comuni\' a \'Reestablecimiento de conectivad en ");
INSERT INTO auditory VALUES("31","WHOLEHAND","2024-12-31 16:46:16","El usuario [WHOLEHAND] creó un nuevo reporte del tipo \'Técnico\' con el nombre \'Mantenimiento Correctivo al Antiguo equipo 5 de la Sala de Formación\'");
INSERT INTO auditory VALUES("32","WHOLEHAND","2024-12-31 16:54:32","El usuario [WHOLEHAND] creó un nuevo reporte del tipo \'Técnico\' con el nombre \'Instalación de Impresora Canon en el 2do PC de la oficina de Atención al Ciudadano\'");
INSERT INTO auditory VALUES("33","WHOLEHAND","2024-12-31 21:56:01","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("34","WHOLEHAND","2025-01-01 19:54:43","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("35","WHOLEHAND","2025-01-01 19:54:43","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("36","WHOLEHAND","2025-01-01 19:55:01","El usuario [WHOLEHAND] generó un informe de los Reportes Vigentes en formato PDF");
INSERT INTO auditory VALUES("37","WHOLEHAND","2025-01-02 00:56:10","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("38","WHOLEHAND","2025-01-01 19:58:38","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("39","WHOLEHAND","2025-01-01 19:58:38","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("40","WHOLEHAND","2025-01-01 19:59:37","El usuario [WHOLEHAND] generó un informe de los Reportes Vigentes en formato PDF");
INSERT INTO auditory VALUES("41","WHOLEHAND","2025-01-01 19:59:52","El usuario [WHOLEHAND] generó un informe de los Reportes Vigentes en formato PDF");
INSERT INTO auditory VALUES("42","WHOLEHAND","2025-01-02 01:01:08","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("43","WHOLEHAND","2025-01-06 21:10:26","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("44","WHOLEHAND","2025-01-06 21:10:26","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("45","WHOLEHAND","2025-01-07 02:10:57","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("46","WHOLEHAND","2025-01-06 21:11:03","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("47","WHOLEHAND","2025-01-06 21:11:03","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("48","WHOLEHAND","2025-01-07 02:12:32","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("49","WHOLEHAND","2025-01-06 21:26:18","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("50","WHOLEHAND","2025-01-06 21:26:18","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("51","WHOLEHAND","2025-01-07 02:26:56","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("52","WHOLEHAND","2025-01-06 21:27:20","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("53","WHOLEHAND","2025-01-06 21:27:20","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("54","WHOLEHAND","2025-01-07 02:28:58","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("55","WHOLEHAND","2025-01-06 21:29:11","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("56","WHOLEHAND","2025-01-06 21:29:11","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("57","WHOLEHAND","2025-01-07 02:31:26","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("58","WHOLEHAND","2025-01-06 21:31:39","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("59","WHOLEHAND","2025-01-06 21:31:39","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("60","WHOLEHAND","2025-01-07 02:33:35","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("61","WHOLEHAND","2025-01-06 21:33:48","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("62","WHOLEHAND","2025-01-06 21:33:48","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("63","WHOLEHAND","2025-01-07 02:38:02","El usuario [WHOLEHAND] cerró sesión");
INSERT INTO auditory VALUES("64","WHOLEHAND","2025-01-06 21:38:12","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("65","WHOLEHAND","2025-01-06 21:38:12","El usuario [WHOLEHAND] inició sesión como usuario");
INSERT INTO auditory VALUES("66","WHOLEHAND","2025-01-06 21:38:57","El usuario [WHOLEHAND] creó un nuevo reporte del tipo \'Movimiento de Bienes\' con el nombre \'Relación del Movimiento de Bienes Muebles para desincorporar monitores CRT\'");
INSERT INTO auditory VALUES("67","WHOLEHAND","2025-01-06 21:39:46","El usuario [WHOLEHAND] generó un informe de los Reportes Vigentes en formato PDF");
INSERT INTO auditory VALUES("68","WHOLEHAND","2025-01-06 21:40:19","El usuario [WHOLEHAND] archivó el reporte \'Mantenimiento Preventivo y Correctivo en el equipo 5 de la Sala de Formación\'.");
INSERT INTO auditory VALUES("69","WHOLEHAND","2025-01-06 21:40:39","El usuario [WHOLEHAND] restauró el reporte \'Mantenimiento Preventivo y Correctivo en el equipo 5 de la Sala de Formación\'.");
INSERT INTO auditory VALUES("70","WHOLEHAND","2025-01-06 21:41:30","El usuario [WHOLEHAND] generó un informe de Usuarios Activos en formato PDF");


DROP TABLE IF EXISTS report_type;
CREATE TABLE `report_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO report_type VALUES("1","Técnico");
INSERT INTO report_type VALUES("2","Movimiento de Bienes");


DROP TABLE IF EXISTS reports;
CREATE TABLE `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_report_type` int(11) NOT NULL,
  `name` varchar(90) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL,
  `state_report` int(2) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reports_types` (`id_report_type`),
  KEY `fk_user` (`id_user`),
  CONSTRAINT `fk_reports_types` FOREIGN KEY (`id_report_type`) REFERENCES `report_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO reports VALUES("1","1","Mantenimiento Preventivo y Correctivo en el equipo 5 de la Sala de Formación","Se realizó una limpieza de las memorias RAM, un cambio del disco duro y para descartar futuras averías en el sistema, se restableció el mismo mediante la clonación del mismo, con esta medida también se buscaba eliminar programas maliciosos y/o no necesarios en la máquina.","2024-10-11 14:41:00","1","1");
INSERT INTO reports VALUES("2","1","Restablecimiento de conectividad en el Dpto. Comunicaciones e Información","Se solventó avería de conectividad de red en el Departamento de Comunicaciones e Información, verificando la conexión en los switches de los Racks correspondientes para reestablecer el servicio.","2024-10-14 08:49:00","1","1");
INSERT INTO reports VALUES("3","1","Mantenimiento Correctivo al Antiguo equipo 5 de la Sala de Formación","Se realizó cambio del procesador, cambio de la pasta térmica y limpieza del disipador, además se verificó el estado del disco duro, se actualizó el cambio de nombre en el usuario de 5 a 10 según la posición que ocupa ahora en la sala y por consiguiente se le reasigno la IP necesaria.","2024-10-15 11:58:00","1","1");
INSERT INTO reports VALUES("4","1","Instalación de Impresora Canon en el 2do PC de la oficina de Atención al Ciudadano","Se realizó la instalación de una impresora marca Canon Image Class modelo LBPB030 en el 2do computador localizado en la oficina de Atención al Ciudadano, se empleó una unidad de lectura de CD-ROM de la Gerencia de Tecnología, para la instalación de Drivers.","2024-10-21 13:36:00","1","1");
INSERT INTO reports VALUES("5","2","Relación del Movimiento de Bienes Muebles para desincorporar monitores CRT","Se realizó la desincorporación de 122 monitores CRT que se encontraban entre totalmente averiados y obsoletos, los cuales ocupaban un espacio grande del depósito ubicado en el edificio módulo 1. Los mismos se trasladaron a un depósito temporal ubicado en el módulo 2.","2024-10-10 09:30:00","1","1");


DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(15) NOT NULL,
  `names` varchar(25) NOT NULL,
  `last_names` varchar(25) NOT NULL,
  `identity_card` int(10) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(250) NOT NULL,
  `level_user` int(2) NOT NULL,
  `state_user` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users VALUES("1","WHOLEHAND","Jesús Alejandro","Vielma Herrera","29837748","jesusvielma2812@gmail.com","$2y$10$zDXkTsbt24mZPJ3ZwCBD8.sS9RaC6wQAOExhNdSqSSesjCwHXRTzG","0","1");
INSERT INTO users VALUES("3","LuxFero","Maria","Mendoza","30663815","mendoza@hotmail.com","$2y$10$IrJ.7tRZ84OHoBfGhFW1KeC543.W99IAWFjEOuWg0K.xOBTXsZTNC","0","1");


SET FOREIGN_KEY_CHECKS=1;