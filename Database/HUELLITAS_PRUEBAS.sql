-- ==========================================
-- Orden de creacion de tablas para la base de datos HUELLITAS
-- 1 HUELLITAS_TABLAS.sql
-- 2 HUELLITAS_FUNCIONES.sql
-- 3 HUELLITAS_TRIGGERS.sql
-- 4 HUELLITAS_PROCEDIMIENTOS.sql
-- 5 HUELLITAS_VISTAS.sql
-- 6 HUELLITAS_PRUEBAS.sql
-- ==========================================

use HUELLITASDIGITAL;

INSERT INTO huellitas_estado_tb (ESTADO_DESCRIPCION) VALUES 
('ACTIVO'),
('INACTIVO'),
('PENDIENTE'),
('EN PREPARACIÓN'),
('COMPLETADO'),
('CANCELADO'),
('ENVIADO'),
('ENTREGADO'),
('LEÍDA'),
('EN REVISIÓN'),
('PENDIENTE DE PAGO'),
('PAGADO'),
('RECHAZADO'),
('APROBADO'),
('REEMBOLSADO');

INSERT INTO huellitas_nuevo_tb (NUEVO_DESCRIPCION) VALUES 
('ES NUEVO'),
('NO ES NUEVO');

INSERT INTO huellitas_slider_banner_tb (IMAGEN_URL, DESCRIPCION_SLIDER_BANNER, ID_ESTADO_FK)
VALUES 
('https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/sliderBanner%2F68f0083dce5df_1080x300.png?alt=media',
 'Cuidamos de tus mascotas con amor y experiencia veterinaria.', 1),

('https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/sliderBanner%2F68f0084b8f89e_1080x300%20%281%29.png?alt=media',
 'Promoción del mes: 20% de descuento en alimentos premium para perros y gatos.', 1),

('https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/sliderBanner%2F68f00858e656d_1080x300%20%282%29.png?alt=media',
 'Agenda tu cita para vacunación y chequeos veterinarios en línea.', 1);

INSERT INTO huellitas_productos_categoria_tb (ID_ESTADO_FK, DESCRIPCION_CATEGORIA) VALUES
(1, 'Medicamentos'),
(1, 'Accesorios'),
(1, 'Alimentos'),
(1, 'Cuidado para Mascota');

-- Inserciones de 10 proveedores mediante el procedimiento almacenado
CALL HUELLITAS_AGREGAR_PROVEEDOR_SP('PetSupply CR', 'Laura Hernández', 'contacto@petsupplycr.com', 1, 88871234);
CALL HUELLITAS_AGREGAR_PROVEEDOR_SP('Alimentos Mascota', 'José Gómez', 'ventas@alimentosmascota.com', 1, 87562345);
CALL HUELLITAS_AGREGAR_PROVEEDOR_SP('VetPro Distribuciones', 'Andrea Campos', 'info@vetprocr.com', 1, 84123456);
CALL HUELLITAS_AGREGAR_PROVEEDOR_SP('PetLine Costa Rica', 'Carlos Rodríguez', 'carlos@petlinecr.com', 1, 83987654);
CALL HUELLITAS_AGREGAR_PROVEEDOR_SP('NaturalPet CR', 'María Solano', 'ventas@naturalpetcr.com', 1, 87091234);
CALL HUELLITAS_AGREGAR_PROVEEDOR_SP('SuperMascotas S.A.', 'Fernando Jiménez', 'fernando@supermascotas.com', 1, 88882211);
CALL HUELLITAS_AGREGAR_PROVEEDOR_SP('HappyPets', 'Daniela Vargas', 'contacto@happypetscr.com', 1, 84213465);
CALL HUELLITAS_AGREGAR_PROVEEDOR_SP('Distribuidora AnimalCare', 'Esteban Mora', 'esteban@animalcarecr.com', 1, 87996543);
CALL HUELLITAS_AGREGAR_PROVEEDOR_SP('PetZone', 'Melissa Araya', 'melissa@petzonecr.com', 1, 83004567);
CALL HUELLITAS_AGREGAR_PROVEEDOR_SP('Mascotas del Valle', 'Ricardo López', 'ricardo@mascotasvalle.com', 1, 88213456);

-- Inserciones de Productos mediante el procedimiento almacenado

CALL HUELLITAS_AGREGAR_MARCA_SP('ProPlan', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68e8919729a9a_Purina-proplan-logo-transparente.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('NutriSource', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68ed7b37786d6_Captura%20de%20pantalla%202025-10-13%20162027.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Calox Veterinaria', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68ed7b7494362_9-compressor.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Credelio', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68ed7bb286ae4_credelio-lotilaner-logo-png_seeklogo-343513.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Balance', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68ed7bef03bff_Captura%20de%20pantalla%202025-10-13%20162322.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Toons', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68ed7c2a0a4e1_toonslogo.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Virbac', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68ed7c892fa51_Captura%20de%20pantalla%202025-10-13%20162555.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Seresto', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68eec9912ba70_Captura%20de%20pantalla%202025-10-14%20160644.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Pedigree', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68eecbe5cd685_Captura%20de%20pantalla%202025-10-14%20161659.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Purina Cat Chow', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68eecc72d3bdf_images.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Bravecto', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68eeccc166839_Captura%20de%20pantalla%202025-10-14%20162028.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Purina ONE', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68f0076a87740_images%20%281%29.png?alt=media');
CALL HUELLITAS_AGREGAR_MARCA_SP('Hills Science Diet', 1, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2Fmarcas%2F68eed87e00e51_Captura%20de%20pantalla%202025-10-14%20171019.png?alt=media');


CALL HUELLITAS_AGREGAR_PRODUCTO_SP(1, 1, 3, 1, 1, 'ProPlan Adulto Raza Pequeña 1Kg', 'Croquetas premium con proteínas de alta calidad para perros adultos de raza mediana.', 6150, 50, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68edd67ca4eaa_img-proplan-Puppy.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(2, 1, 3, 10, 1, 'Cat Chow Adultos Pollo 1.5Kg', 'Alimento completo y balanceado para gatos adultos sabor pollo.', 6300, 60, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f001b3776a4_Captura%20de%20pantalla%202025-10-15%20141848.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(3, 1, 1, 3, 1, 'Crema Cicatrizante Calox 15g', 'Pomada veterinaria que ayuda en la regeneración y cicatrización de heridas leves en la piel de mascotas.', 2500, 40, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f0053a7da12_Captura%20de%20pantalla%202025-10-15%20143351.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(4, 1, 4, 6, 2, 'Shampoo Toons 265ml', 'Shampoo suave con fragancia agradable que limpia y cuida el pelaje de perros adultos, ideal para uso frecuente.', 1775, 75, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68ede08890f8c_Captura%20de%20pantalla%202025-10-13%20232409.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(5, 1, 1, 4, 1, 'Pastilla Credelio Perros 11-22kg', 'Tableta masticable para control mensual de pulgas y garrapatas.', 14525, 45, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68edead85943a_Captura%20de%20pantalla%202025-10-14%20001332.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(6, 1, 3, 5, 2, 'Balance Adulto Pollo y Arroz 2Kg', 'Alimento seco con proteínas de pollo y cereales integrales para perros adultos.', 3500, 80, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f0007f47052_7443007533202-Basico-Perro-Adulto-Raza-mediana-Pollo-14.97kg.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(7, 1, 4, 6, 1, 'Colonia Toons 125ml', 'Colonia con aroma fresco y duradero que deja el pelaje de tu mascota con un olor agradable después del baño.', 3100, 30, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f00296027ad_Captura%20de%20pantalla%202025-10-15%20142232.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(8, 1, 3, 2, 2, 'NutriSource Raza Pequeña 1.8Kg ', 'Fórmula balanceada para cachorros con DHA y proteínas de pollo.', 10250, 70, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68ede9d81d610_Captura%20de%20pantalla%202025-10-14%20001231.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(9, 1, 1, 7, 1, 'Pastilla Endogard hasta 10Kg', 'Antibiótico de uso veterinario para infecciones respiratorias y cutáneas.', 1750, 35, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68edebac82d75_Endogard10-2600x600%20%281%29.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(10, 1, 4, 8, 1, 'Seresto Collar Antipulgas Grande', 'Collar de larga duración contra pulgas y garrapatas (8 meses de protección).', 35150, 60, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f002ce5ba8f_1-282.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(1, 1, 3, 9, 2, 'Saco Pedigree Adulto Carne y Vegetales 21Kg', 'Alimento seco para perros adultos sabor carne y vegetales.', 31000, 90, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f00399e6515_Captura%20de%20pantalla%202025-10-15%20142654.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(2, 1, 3, 12, 1, 'Purina ONE Gato Esterilizado 2Kg', 'Fórmula especializada para gatos esterilizados que ayuda al control de peso.', 12200, 55, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f00165ce2eb_Captura%20de%20pantalla%202025-10-15%20141719.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(3, 1, 1, 11, 1, 'Bravecto Tableta 20-40kg', 'Antiparasitario oral de acción prolongada (3 meses) para perros grandes.', 32000, 50, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f004e94e2d5_Captura%20de%20pantalla%202025-10-15%20143227.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(4, 1, 4, 6, 2, 'Shampoo para Cachoro Toons', 'Shampoo hipoalergénico para cachorros con fórmula suave que limpia sin irritar la piel ni los ojos.', 4325, 25, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f0047bd89bd_Dise%C3%B1o%20sin%20t%C3%ADtulo%20%282%29.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(5, 1, 3, 13, 1, 'Hills Science Diet Gato Light 1.8Kg', 'Alimento bajo en calorías para control de peso en gatos adultos.', 22030, 40, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f002261cbb2_Captura%20de%20pantalla%202025-10-15%20142046.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(9, 1, 3, 10, 1, 'Cat Chow Gatitos 500g', 'Alimento con DHA para el desarrollo del cerebro y la visión en gatitos.', 5510, 65, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f000fc639ff_Captura%20de%20pantalla%202025-10-15%20141542.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(10, 1, 3, 2, 2, 'NutriSource Senior 1.8Kg', 'Alimento balanceado para perros mayores con ingredientes de fácil digestión.', 9550, 50, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f0032ece15d_2-4-1.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(1, 1, 1, 10, 1, 'Himalaya Digyton Gotas', 'Digestivo: estimula la secreción de las enzimas proteolíticas, amilolíticas y lipolíticas, lo cual cataliza la digestión de los alimentos. Actúa como carminativo, elimina los problemas de flatulencia, cólicos y distención abdominal. Regula la peristalsis (motilidad intestinal), normalizando problemas de estreñimiento y diarreas leves. Mejora el apetito y la asimilación de alimentos en cachorros. Incrementa la tolerancia a cambios repentinos de dieta. Evita los trastornos gastrointestinales en cachorros destetados.', 6150, 50, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68e8936b1aba2_img-digyton.png?alt=media');


INSERT INTO huellitas_rol_usuario_tb (ID_ESTADO_FK, DESCRIPCION_ROL_USUARIO) VALUES 
(1, 'CLIENTE'),
(1, 'ADMINISTRADOR'),
(1, 'EMPLEADO');

INSERT INTO huellitas_direccion_provincia_tb (ID_ESTADO_FK, NOMBRE_PROVINCIA) VALUES 
(1, 'San José'),
(1, 'Alajuela'),
(1, 'Cartago'),
(1, 'Heredia'),
(1, 'Guanacaste'),
(1, 'Puntarenas'),
(1, 'Limón');

-- PROVINCIA 1: San José
INSERT INTO huellitas_direccion_canton_tb (ID_PROVINCIA_FK, ID_ESTADO_FK, NOMBRE_CANTON) VALUES
(1, 1, 'San José'),
(1, 1, 'Escazú'),
(1, 1, 'Desamparados'),
(1, 1, 'Puriscal'),
(1, 1, 'Tarrazú'),
(1, 1, 'Aserrí'),
(1, 1, 'Mora'),
(1, 1, 'Goicoechea'),
(1, 1, 'Santa Ana'),
(1, 1, 'Alajuelita'),
(1, 1, 'Vásquez de Coronado'),
(1, 1, 'Acosta'),
(1, 1, 'Tibás'),
(1, 1, 'Moravia'),
(1, 1, 'Montes de Oca'),
(1, 1, 'Turrubares'),
(1, 1, 'Dota'),
(1, 1, 'Curridabat'),
(1, 1, 'Pérez Zeledón'),
(1, 1, 'León Cortéz Castro');

-- PROVINCIA 2: Alajuela
INSERT INTO huellitas_direccion_canton_tb (ID_PROVINCIA_FK, ID_ESTADO_FK, NOMBRE_CANTON) VALUES
(2, 1, 'Alajuela'),
(2, 1, 'San Ramón'),
(2, 1, 'Grecia'),
(2, 1, 'San Mateo'),
(2, 1, 'Atenas'),
(2, 1, 'Naranjo'),
(2, 1, 'Palmares'),
(2, 1, 'Poás'),
(2, 1, 'Orotina'),
(2, 1, 'San Carlos'),
(2, 1, 'Zarcero'),
(2, 1, 'Valverde Vega'),
(2, 1, 'Upala'),
(2, 1, 'Los Chiles'),
(2, 1, 'Guatuso');

-- PROVINCIA 3: Cartago
INSERT INTO huellitas_direccion_canton_tb (ID_PROVINCIA_FK, ID_ESTADO_FK, NOMBRE_CANTON) VALUES
(3, 1, 'Cartago'),
(3, 1, 'Paraíso'),
(3, 1, 'La Unión'),
(3, 1, 'Jiménez'),
(3, 1, 'Turrialba'),
(3, 1, 'Alvarado'),
(3, 1, 'Oreamuno'),
(3, 1, 'El Guarco');

-- PROVINCIA 4: Heredia
INSERT INTO huellitas_direccion_canton_tb (ID_PROVINCIA_FK, ID_ESTADO_FK, NOMBRE_CANTON) VALUES
(4, 1, 'Heredia'),
(4, 1, 'Barva'),
(4, 1, 'Santo Domingo'),
(4, 1, 'Santa Bárbara'),
(4, 1, 'San Rafaél'),
(4, 1, 'San Isidro'),
(4, 1, 'Belén'),
(4, 1, 'Flores'),
(4, 1, 'San Pablo'),
(4, 1, 'Sarapiquí');

-- PROVINCIA 5: Guanacaste
INSERT INTO huellitas_direccion_canton_tb (ID_PROVINCIA_FK, ID_ESTADO_FK, NOMBRE_CANTON) VALUES
(5, 1, 'Liberia'),
(5, 1, 'Nicoya'),
(5, 1, 'Santa Cruz'),
(5, 1, 'Bagaces'),
(5, 1, 'Carrillo'),
(5, 1, 'Cañas'),
(5, 1, 'Abangáres'),
(5, 1, 'Tilarán'),
(5, 1, 'Nandayure'),
(5, 1, 'La Cruz'),
(5, 1, 'Hojancha');

-- PROVINCIA 6: Puntarenas
INSERT INTO huellitas_direccion_canton_tb (ID_PROVINCIA_FK, ID_ESTADO_FK, NOMBRE_CANTON) VALUES
(6, 1, 'Puntarenas'),
(6, 1, 'Esparza'),
(6, 1, 'Buenos Aires'),
(6, 1, 'Montes de Oro'),
(6, 1, 'Osa'),
(6, 1, 'Aguirre'),
(6, 1, 'Golfito'),
(6, 1, 'Coto Brus'),
(6, 1, 'Parrita'),
(6, 1, 'Corredores'),
(6, 1, 'Garabito');

-- PROVINCIA 7: Limón
INSERT INTO huellitas_direccion_canton_tb (ID_PROVINCIA_FK, ID_ESTADO_FK, NOMBRE_CANTON) VALUES
(7, 1, 'Limón'),
(7, 1, 'Pococí'),
(7, 1, 'Siquirres'),
(7, 1, 'Talamanca'),
(7, 1, 'Matina'),
(7, 1, 'Guácimo');


INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'CARMEN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'MERCED');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'HOSPITAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'CATEDRAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'ZAPOTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'SAN FRANCISCO DE DOS RÍOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'URUCA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'MATA REDONDA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'PAVAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'HATILLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '1', '1', 'SAN SEBASTIÁN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '2', '1', 'ESCAZÚ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '2', '1', 'SAN ANTONIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '2', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'DESAMPARADOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'SAN MIGUEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'SAN JUAN DE DIOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'SAN RAFAEL ARRIBA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'SAN ANTONIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'FRAILES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'PATARRÁ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'SAN CRISTÓBAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'ROSARIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'DAMAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'SAN RAFAEL ABAJO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'GRAVILIAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '3', '1', 'LOS GUIDO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '4', '1', 'SANTIAGO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '4', '1', 'MERCEDES SUR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '4', '1', 'BARBACOAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '4', '1', 'GRIFO ALTO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '4', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '4', '1', 'CANDELARITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '4', '1', 'DESAMPARADITOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '4', '1', 'SAN ANTONIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '4', '1', 'CHIRES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '5', '1', 'SAN MARCOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '5', '1', 'SAN LORENZO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '5', '1', 'SAN CARLOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '6', '1', 'ASERRI');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '6', '1', 'TARBACA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '6', '1', 'VUELTA DE JORCO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '6', '1', 'SAN GABRIEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '6', '1', 'LEGUA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '6', '1', 'MONTERREY');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '6', '1', 'SALITRILLOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '7', '1', 'COLÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '7', '1', 'GUAYABO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '7', '1', 'TABARCIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '7', '1', 'PIEDRAS NEGRAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '7', '1', 'PICAGRES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '7', '1', 'JARIS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '7', '1', 'QUITIRRISI');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '8', '1', 'GUADALUPE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '8', '1', 'SAN FRANCISCO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '8', '1', 'CALLE BLANCOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '8', '1', 'MATA DE PLÁTANO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '8', '1', 'IPÍS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '8', '1', 'RANCHO REDONDO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '8', '1', 'PURRAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '9', '1', 'SANTA ANA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '9', '1', 'SALITRAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '9', '1', 'POZOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '9', '1', 'URUCA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '9', '1', 'PIEDADES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '9', '1', 'BRASIL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '10', '1', 'ALAJUELITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '10', '1', 'SAN JOSECITO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '10', '1', 'SAN ANTONIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '10', '1', 'CONCEPCIÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '10', '1', 'SAN FELIPE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '11', '1', 'SAN ISIDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '11', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '11', '1', 'DULCE NOMBRE DE JESÚS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '11', '1', 'PATALILLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '11', '1', 'CASCAJAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '12', '1', 'SAN IGNACIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '12', '1', 'GUAITIL Villa');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '12', '1', 'PALMICHAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '12', '1', 'CANGREJAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '12', '1', 'SABANILLAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '13', '1', 'SAN JUAN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '13', '1', 'CINCO ESQUINAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '13', '1', 'ANSELMO LLORENTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '13', '1', 'LEON XIII');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '13', '1', 'COLIMA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '14', '1', 'SAN VICENTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '14', '1', 'SAN JERÓNIMO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '14', '1', 'LA TRINIDAD');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '15', '1', 'SAN PEDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '15', '1', 'SABANILLA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '15', '1', 'MERCEDES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '15', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '16', '1', 'SAN PABLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '16', '1', 'SAN PEDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '16', '1', 'SAN JUAN DE MATA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '16', '1', 'SAN LUIS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '16', '1', 'CARARA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '17', '1', 'SANTA MARÍA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '17', '1', 'JARDÍN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '17', '1', 'COPEY');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '18', '1', 'CURRIDABAT');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '18', '1', 'GRANADILLA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '18', '1', 'SÁNCHEZ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '18', '1', 'TIRRASES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'SAN ISIDRO DE EL GENERAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'EL GENERAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'DANIEL FLORES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'RIVAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'SAN PEDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'PLATANARES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'PEJIBAYE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'CAJÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'BARÚ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'RÍO NUEVO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '19', '1', 'PÁRAMO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '20', '1', 'SAN PABLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '20', '1', 'SAN ANDRÉS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '20', '1', 'LLANO BONITO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '20', '1', 'SAN ISIDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '20', '1', 'SANTA CRUZ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '20', '1', 'SAN ANTONIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'ALAJUELA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'SAN JOSÉ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'CARRIZAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'SAN ANTONIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'GUÁCIMA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'SAN ISIDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'SABANILLA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'RÍO SEGUNDO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'DESAMPARADOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'TURRÚCARES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'TAMBOR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'GARITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '21', '1', 'SARAPIQUÍ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'SAN RAMÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'SANTIAGO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'SAN JUAN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'PIEDADES NORTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'PIEDADES SUR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'SAN ISIDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'ÁNGELES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'ALFARO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'VOLIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'CONCEPCIÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'ZAPOTAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '22', '1', 'PEÑAS BLANCAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '23', '1', 'GRECIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '23', '1', 'SAN ISIDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '23', '1', 'SAN JOSÉ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '23', '1', 'SAN ROQUE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '23', '1', 'TACARES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '23', '1', 'RÍO CUARTO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '23', '1', 'PUENTE DE PIEDRA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '23', '1', 'BOLÍVAR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '24', '1', 'SAN MATEO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '24', '1', 'DESMONTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '24', '1', 'JESÚS MARÍA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '24', '1', 'LABRADOR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '25', '1', 'ATENAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '25', '1', 'JESÚS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '25', '1', 'MERCEDES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '25', '1', 'SAN ISIDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '25', '1', 'CONCEPCIÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '25', '1', 'SAN JOSE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '25', '1', 'SANTA EULALIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '25', '1', 'ESCOBAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '26', '1', 'NARANJO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '26', '1', 'SAN MIGUEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '26', '1', 'SAN JOSÉ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '26', '1', 'CIRRÍ SUR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '26', '1', 'SAN JERÓNIMO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '26', '1', 'SAN JUAN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '26', '1', 'EL ROSARIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '26', '1', 'PALMITOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '27', '1', 'PALMARES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '27', '1', 'ZARAGOZA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '27', '1', 'BUENOS AIRES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '27', '1', 'SANTIAGO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '27', '1', 'CANDELARIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '27', '1', 'ESQUÍPULAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '27', '1', 'LA GRANJA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '28', '1', 'SAN PEDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '28', '1', 'SAN JUAN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '28', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '28', '1', 'CARRILLOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '28', '1', 'SABANA REDONDA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '29', '1', 'OROTINA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '29', '1', 'EL MASTATE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '29', '1', 'HACIENDA VIEJA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '29', '1', 'COYOLAR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '29', '1', 'LA CEIBA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'QUESADA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'FLORENCIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'BUENAVISTA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'AGUAS ZARCAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'VENECIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'PITAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'LA FORTUNA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'LA TIGRA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'LA PALMERA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'VENADO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'CUTRIS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'MONTERREY');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '30', '1', 'POCOSOL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '31', '1', 'ZARCERO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '31', '1', 'LAGUNA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '31', '1', 'GUADALUPE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '31', '1', 'PALMIRA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '31', '1', 'ZAPOTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '31', '1', 'BRISAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '32', '1', 'SARCHÍ NORTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '32', '1', 'SARCHÍ SUR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '32', '1', 'TORO AMARILLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '32', '1', 'SAN PEDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '32', '1', 'RODRÍGUEZ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '33', '1', 'UPALA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '33', '1', 'AGUAS CLARAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '33', '1', 'SAN JOSÉ o PIZOTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '33', '1', 'BIJAGUA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '33', '1', 'DELICIAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '33', '1', 'DOS RÍOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '33', '1', 'YOLILLAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '33', '1', 'CANALETE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '34', '1', 'LOS CHILES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '34', '1', 'CAÑO NEGRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '34', '1', 'EL AMPARO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '34', '1', 'SAN JORGE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '35', '1', 'BUENAVISTA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '35', '1', 'COTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '35', '1', 'KATIRA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'ORIENTAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'OCCIDENTAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'CARMEN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'SAN NICOLÁS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'AGUACALIENTE o SAN FRANCISCO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'GUADALUPE o ARENILLA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'CORRALILLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'TIERRA BLANCA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'DULCE NOMBRE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'LLANO GRANDE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '36', '1', 'QUEBRADILLA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '37', '1', 'PARAÍSO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '37', '1', 'SANTIAGO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '37', '1', 'OROSI');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '37', '1', 'CACHÍ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '37', '1', 'LLANOS DE SANTA LUCÍA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '38', '1', 'TRES RÍOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '38', '1', 'SAN DIEGO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '38', '1', 'SAN JUAN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '38', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '38', '1', 'CONCEPCIÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '38', '1', 'DULCE NOMBRE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '38', '1', 'SAN RAMÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '38', '1', 'RÍO AZUL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '39', '1', 'JUAN VIÑAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '39', '1', 'TUCURRIQUE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '39', '1', 'PEJIBAYE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'TURRIALBA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'LA SUIZA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'PERALTA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'SANTA CRUZ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'SANTA TERESITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'PAVONES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'TUIS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'TAYUTIC');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'SANTA ROSA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'TRES EQUIS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'LA ISABEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '40', '1', 'CHIRRIPÓ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '41', '1', 'PACAYAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '41', '1', 'CERVANTES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '41', '1', 'CAPELLADES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '42', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '42', '1', 'COT');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '42', '1', 'POTRERO CERRADO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '42', '1', 'CIPRESES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '42', '1', 'SANTA ROSA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '43', '1', 'EL TEJAR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '43', '1', 'SAN ISIDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '43', '1', 'TOBOSI');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '43', '1', 'PATIO DE AGUA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '44', '1', 'HEREDIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '44', '1', 'MERCEDES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '44', '1', 'SAN FRANCISCO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '44', '1', 'ULLOA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '44', '1', 'VARABLANCA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '45', '1', 'BARVA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '45', '1', 'SAN PEDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '45', '1', 'SAN PABLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '45', '1', 'SAN ROQUE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '45', '1', 'SANTA LUCÍA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '45', '1', 'SAN JOSÉ DE LA MONTAÑA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '46', '1', 'SAN VICENTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '46', '1', 'SAN MIGUEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '46', '1', 'PARACITO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '46', '1', 'SANTO TOMÁS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '46', '1', 'SANTA ROSA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '46', '1', 'TURES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '46', '1', 'PARÁ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '47', '1', 'SANTA BÁRBARA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '47', '1', 'SAN PEDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '47', '1', 'SAN JUAN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '47', '1', 'JESÚS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '47', '1', 'SANTO DOMINGO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '47', '1', 'PURABÁ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '48', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '48', '1', 'SAN JOSECITO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '48', '1', 'SANTIAGO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '48', '1', 'ÁNGELES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '48', '1', 'CONCEPCIÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '49', '1', 'SAN ISIDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '49', '1', 'SAN JOSÉ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '49', '1', 'CONCEPCIÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '49', '1', 'SAN FRANCISCO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '50', '1', 'SAN ANTONIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '50', '1', 'LA RIBERA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '50', '1', 'LA ASUNCIÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '51', '1', 'SAN JOAQUÍN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '51', '1', 'BARRANTES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '51', '1', 'LLORENTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '52', '1', 'SAN PABLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '53', '1', 'PUERTO VIEJO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '53', '1', 'LA VIRGEN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '53', '1', 'LAS HORQUETAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '53', '1', 'LLANURAS DEL GASPAR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '53', '1', 'CUREÑA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '54', '1', 'LIBERIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '54', '1', 'CAÑAS DULCES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '54', '1', 'MAYORGA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '54', '1', 'NACASCOLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '54', '1', 'CURUBANDÉ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '55', '1', 'NICOYA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '55', '1', 'MANSIÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '55', '1', 'SAN ANTONIO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '55', '1', 'QUEBRADA HONDA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '55', '1', 'SÁMARA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '55', '1', 'NOSARA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '55', '1', 'BELÉN DE NOSARITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '56', '1', 'SANTA CRUZ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '56', '1', 'BOLSÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '56', '1', 'VEINTISIETE DE ABRIL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '56', '1', 'TEMPATE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '56', '1', 'CARTAGENA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '56', '1', 'CUAJINIQUIL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '56', '1', 'DIRIÁ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '56', '1', 'CABO VELAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '56', '1', 'TAMARINDO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '57', '1', 'BAGACES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '57', '1', 'LA FORTUNA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '57', '1', 'MOGOTE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '57', '1', 'RÍO NARANJO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '58', '1', 'FILADELFIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '58', '1', 'PALMIRA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '58', '1', 'SARDINAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '58', '1', 'BELÉN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '59', '1', 'CAÑAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '59', '1', 'PALMIRA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '59', '1', 'SAN MIGUEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '59', '1', 'BEBEDERO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '59', '1', 'POROZAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '60', '1', 'LAS JUNTAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '60', '1', 'SIERRA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '60', '1', 'SAN JUAN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '60', '1', 'COLORADO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '61', '1', 'TILARÁN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '61', '1', 'QUEBRADA GRANDE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '61', '1', 'TRONADORA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '61', '1', 'SANTA ROSA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '61', '1', 'LÍBANO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '61', '1', 'TIERRAS MORENAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '61', '1', 'ARENAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '62', '1', 'CARMONA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '62', '1', 'SANTA RITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '62', '1', 'ZAPOTAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '62', '1', 'SAN PABLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '62', '1', 'PORVENIR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '62', '1', 'BEJUCO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '63', '1', 'LA CRUZ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '63', '1', 'SANTA CECILIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '63', '1', 'LA GARITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '63', '1', 'SANTA ELENA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '64', '1', 'HOJANCHA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '64', '1', 'MONTE ROMO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '64', '1', 'PUERTO CARRILLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '64', '1', 'HUACAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'PUNTARENAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'PITAHAYA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'CHOMES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'LEPANTO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'PAQUERA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'MANZANILLO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'GUACIMAL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'BARRANCA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'MONTE VERDE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'CÓBANO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'CHACARITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'CHIRA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'ACAPULCO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'EL ROBLE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '65', '1', 'ARANCIBIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '66', '1', 'ESPÍRITU SANTO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '66', '1', 'SAN JUAN GRANDE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '66', '1', 'MACACONA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '66', '1', 'SAN RAFAEL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '66', '1', 'SAN JERÓNIMO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '66', '1', 'CALDERA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '67', '1', 'BUENOS AIRES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '67', '1', 'VOLCÁN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '67', '1', 'POTRERO GRANDE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '67', '1', 'BORUCA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '67', '1', 'PILAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '67', '1', 'COLINAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '67', '1', 'CHÁNGUENA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '67', '1', 'BIOLLEY');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '67', '1', 'BRUNKA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '68', '1', 'MIRAMAR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '68', '1', 'LA UNIÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '68', '1', 'SAN ISIDRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '69', '1', 'PUERTO CORTÉS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '69', '1', 'PALMAR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '69', '1', 'SIERPE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '69', '1', 'BAHÍA BALLENA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '69', '1', 'PIEDRAS BLANCAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '69', '1', 'BAHÍA DRAKE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '70', '1', 'QUEPOS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '70', '1', 'SAVEGRE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '70', '1', 'NARANJITO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '71', '1', 'GOLFITO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '71', '1', 'PUERTO JIMÉNEZ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '71', '1', 'GUAYCARÁ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '71', '1', 'PAVÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '72', '1', 'SAN VITO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '72', '1', 'SABALITO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '72', '1', 'AGUABUENA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '72', '1', 'LIMONCITO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '72', '1', 'PITTIER');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '72', '1', 'GUTIERREZ BRAUN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '73', '1', 'PARRITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '74', '1', 'CORREDOR');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '74', '1', 'LA CUESTA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '74', '1', 'CANOAS');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '74', '1', 'LAUREL');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '75', '1', 'JACÓ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '75', '1', 'TÁRCOLES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '76', '1', 'LIMÓN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '76', '1', 'VALLE LA ESTRELLA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '76', '1', 'MATAMA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '77', '1', 'GUÁPILES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '77', '1', 'JIMÉNEZ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '77', '1', 'RITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '77', '1', 'ROXANA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '77', '1', 'CARIARI');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '77', '1', 'COLORADO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '77', '1', 'LA COLONIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '78', '1', 'SIQUIRRES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '78', '1', 'PACUARITO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '78', '1', 'FLORIDA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '78', '1', 'GERMANIA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '78', '1', 'EL CAIRO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '78', '1', 'ALEGRÍA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '79', '1', 'BRATSI');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '79', '1', 'SIXAOLA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '79', '1', 'CAHUITA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '79', '1', 'TELIRE');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '80', '1', 'MATINA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '80', '1', 'BATÁN');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '80', '1', 'CARRANDI');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '81', '1', 'GUÁCIMO');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '81', '1', 'MERCEDES');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '81', '1', 'POCORA');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '81', '1', 'RÍO JIMÉNEZ');
INSERT INTO huellitas_direccion_distrito_tb (ID_CANTON_FK, ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES ( '81', '1', 'DUACARÍ');

INSERT INTO huellitas_direccion_tb (ID_ESTADO_FK, ID_DIRECCION_PROVINCIA_FK, ID_DIRECCION_CANTON_FK, ID_DIRECCION_DISTRITO_FK, DIRECCION_SENNAS) VALUES 
(1, 1, 1, 1, 'AVENIDA CENTRAL, CALLE 25, CASA 456');

INSERT INTO huellitas_telefono_contacto_tb (ID_ESTADO_FK, TELEFONO_CONTACTO) VALUES 
(1, 88889999);


-- Crear claves de encriptación
INSERT INTO huellitas_claves_encriptacion_tb (NOMBRE_CLAVE, CLAVE_ENCRIPTACION) VALUES 
('CLAVE_NUMERO_TARJETA', HUELLITAS_GENERAR_CLAVE_AES_FN()),
('CLAVE_CVV', HUELLITAS_GENERAR_CLAVE_AES_FN()),
('CLAVE_CONTRASENNA', HUELLITAS_GENERAR_CLAVE_AES_FN());


INSERT INTO huellitas_usuarios_tb (
    ID_ESTADO_FK, 
    ID_ROL_USUARIO_FK, 
    ID_DIRECCION_FK, 
    ID_TELEFONO_CONTACTO_FK,
    USUARIO_NOMBRE, 
    USUARIO_CORREO, 
    USUARIO_CONTRASENNA,
    USUARIO_IDENTIFICACION
) VALUES (
    1,  -- ACTIVO
    1,  -- CLIENTE
    1,  -- DIRECCIÓN
    1,  -- TELÉFONO
    'MARÍA FERNANDA LÓPEZ GARCÍA',
    'maria.lopez@email.com',
    'ClaveSegura2024!',
    123456789
);

-- Usuario Admin
INSERT INTO huellitas_usuarios_tb (
    ID_ESTADO_FK, 
    ID_ROL_USUARIO_FK, 
    ID_DIRECCION_FK, 
    ID_TELEFONO_CONTACTO_FK,
    USUARIO_NOMBRE, 
    USUARIO_CORREO, 
    USUARIO_CONTRASENNA,
    USUARIO_IDENTIFICACION
) VALUES (
    1,  -- ACTIVO
    2,  -- ADMINITRADOR
    1,  -- DIRECCIÓN
    1,  -- TELÉFONO
    'José Admin Rojas Gonzales',
    'jose.gonzales@email.com',
    'ClaveSegura2024!',
    987654321
);

-- Usuario Empleado
INSERT INTO huellitas_usuarios_tb (
    ID_ESTADO_FK, 
    ID_ROL_USUARIO_FK, 
    ID_DIRECCION_FK, 
    ID_TELEFONO_CONTACTO_FK,
    USUARIO_NOMBRE, 
    USUARIO_CORREO, 
    USUARIO_CONTRASENNA,
    USUARIO_IDENTIFICACION
) VALUES (
    1,  -- ACTIVO
    3,  -- EMPLEADO
    1,  -- DIRECCIÓN
    1,  -- TELÉFONO
    'Carlos Empleado Morales',
    'carlos.morales@email.com',
    'ClaveSegura2024!',
    132435465
);

INSERT INTO huellitas_tarjetas_tb (
    ID_USUARIO_FK,
    TIPO_TARJETA,
    MARCA_TARJETA,
    NOMBRE_TITULAR,
    NUMERO_TARJETA_ENCRIPTADO,
    ULTIMOS_CUATRO_DIGITOS,
    FECHA_VENCIMIENTO,
    CVV_ENCRIPTADO,
    ES_PREDETERMINADO,
    IP_REGISTRO
) VALUES (
    1,  -- ID del usuario recién insertado
    'CREDITO',
    'VISA',
    'MARIA FERNANDA LOPEZ',
    '4111111111111111',  -- Se encriptará automáticamente
    '1111',
    '2027-05-20',
    '123',               -- Se encriptará automáticamente
    TRUE,
    '192.168.1.100'
);

INSERT INTO huellitas_clientes_tb (
    ID_ESTADO_FK,
    ID_DIRECCION_FK,
    ID_TELEFONO_CONTACTO_FK,
    CLIENTE_NOMBRE,
    CLIENTE_CORREO,
    CLIENTE_IDENTIFICACION,
    CLIENTE_OBSERVACIONES,
    ID_USUARIO_VINCULADO_FK
)
VALUES (
    1,
    1,
    1,
    'Carlos Rodríguez Mora', 
    'carlos.rodriguez@gmail.com',
    '115690789',
    'Cliente frecuente, solicita recordatorio de citas cada mes.',
    NULL 
);

INSERT INTO huellitas_servicios_tb (
    ID_ESTADO_FK,
    NOMBRE_SERVICIO,
    DESCRIPCION_SERVICIO,
    IMAGEN_URL
) VALUES
(1, 'Consulta', 'Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.', "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/servicios%2F68f91d5b0709e_img-consulta.png?alt=media&token=c8144374-aa6d-4b50-baba-89f10652b479"),
(1, 'Vacunas', 'Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.', "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/servicios%2F68f91dfd692a7_img-vacuna.png?alt=media&token=8d8fe76f-5dfc-4926-bfeb-02a1cd02c0c2"),
(1, 'Desparacitación', 'Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.', "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/servicios%2F68f91e07eb087_img-desparacitacion.png?alt=media&token=43fa0b6c-421c-4106-9365-fbb30fcad268"),
(1, 'Exámenes de Laboratorio', 'Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.', "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/servicios%2F68f91e161cf91_img-exam-lab.png?alt=media&token=299df542-f700-49cc-a43d-c0aaf41bae18"),
(1, 'Ultrasonido', 'Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.', "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/servicios%2F68f91e30230ce_img-ultrasonido.png?alt=media&token=fea30436-5cb2-4045-9f9d-c6742e304a74"),
(1, 'Cirugía Menor', 'Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.', "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/servicios%2F68f91e237aeff_img-cirugia-menor.png?alt=media&token=d659e534-f24e-4f01-bcca-af050b846be0"),
(1, 'Limpieza Dental', 'Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.', "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/servicios%2F68f91e3bc8851_img-limpieza-dental.png?alt=media&token=e1c70054-f63d-4ff2-b2e4-d26ab63260f8"),
(1, 'Tramite de Explotación', 'Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at. Lorem ipsum dolor sit amet vitae, fringilla iaculis ante. Fusce a euismod est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.', "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/servicios%2F68f935519594a_img-exportacion.png?alt=media&token=bb150eac-b3ce-40ad-82e1-bf47f02361a0");


INSERT INTO huellitas_productos_comentarios_tb 
(ID_PRODUCTO_FK, ID_USUARIO_FK, ID_ESTADO_FK, COMENTARIO_TEXTO, CALIFICACION_TIPO)
VALUES
(1, 1, 1, 'Excelente calidad, mi mascota lo ama.', '5'),
(2, 2, 1, 'Llegó rápido y bien empacado.', '4'),
(3, 1, 1, 'No le gustó mucho el sabor, pero el servicio fue bueno.', '3'),
(4, 2, 1, 'Producto muy útil, justo lo que necesitaba.', '5'),
(5, 1, 2, 'El empaque vino dañado.', '2'),
(6, 2, 1, 'Mi perro está feliz con este juguete.', '5'),
(7, 1, 1, 'Calidad aceptable por el precio.', '3'),
(8, 2, 1, 'El envío fue más rápido de lo esperado.', '4'),
(9, 1, 2, 'El tamaño no coincidía con la descripción.', '2'),
(10, 2, 1, 'Excelente producto, muy recomendado.', '5'),
(11, 1, 1, 'Mi gato se adaptó muy bien a este alimento.', '4'),
(12, 2, 1, 'Cumple su función, nada extraordinario.', '3'),
(13, 1, 1, 'Buena relación calidad-precio.', '4'),
(14, 2, 2, 'No funcionó como esperaba.', '1'),
(15, 1, 1, 'Totalmente satisfecho con la compra.', '5'),
(3, 2, 1, 'Buen sabor según mi perro, volveré a comprar.', '4'),
(5, 1, 1, 'La textura es perfecta para mi mascota senior.', '5'),
(8, 2, 2, 'El producto venía incompleto.', '1'),
(10, 1, 1, 'Muy buen servicio al cliente, resolvieron mis dudas.', '4'),
(12, 2, 1, 'Producto fresco y en excelente estado.', '5');

INSERT INTO huellitas_mascota_especie_tb (ID_ESTADO_FK, NOMBRE_ESPECIE) VALUES
(1, 'Perro'), (1, 'Gato'), (1, 'Conejo'), (1, 'Ave'), (1, 'Reptil');

-- RAZAS DE PERROS
INSERT INTO huellitas_mascota_raza_tb (ID_ESTADO_FK, ID_MASCOTA_ESPECIE_FK, NOMBRE_RAZA)
VALUES
(1, 1, 'SRD'),
(1, 1, 'Labrador Retriever'),
(1, 1, 'Golden Retriever'),
(1, 1, 'Bulldog Francés'),
(1, 1, 'Beagle'),
(1, 1, 'Pastor Alemán'),
(1, 1, 'Poodle'),
(1, 1, 'Rottweiler'),
(1, 1, 'Boxer'),
(1, 1, 'Chihuahua'),
(1, 1, 'Doberman'),
(1, 1, 'Husky Siberiano'),
(1, 1, 'Pug'),
(1, 1, 'Cocker Spaniel'),
(1, 1, 'Dálmata'),
(1, 1, 'Border Collie'),
(1, 1, 'Shih Tzu'),
(1, 1, 'Maltés'),
(1, 1, 'Jack Russell Terrier'),
(1, 1, 'San Bernardo'),
(1, 1, 'Akita Inu'),
(1, 1, 'Shar Pei'),
(1, 1, 'Bull Terrier'),
(1, 1, 'Schnauzer'),
(1, 1, 'Gran Danés'),
(1, 1, 'Pastor Belga Malinois'),
(1, 1, 'Bichón Frisé'),
(1, 1, 'Pitbull Terrier'),
(1, 1, 'Weimaraner'),
(1, 1, 'Galgo Italiano'),
(1, 1, 'Boston Terrier'),
(1, 1, 'Basenji'),
(1, 1, 'Alaskan Malamute'),
(1, 1, 'Cavalier King Charles Spaniel'),
(1, 1, 'Galgo Español'),
(1, 1, 'Yorkshire Terrier'),
(1, 1, 'Fox Terrier'),
(1, 1, 'Whippet'),
(1, 1, 'Setter Irlandés'),
(1, 1, 'Airedale Terrier'),
(1, 1, 'Samoyedo');


-- RAZAS DE GATOS
INSERT INTO huellitas_mascota_raza_tb (ID_ESTADO_FK, ID_MASCOTA_ESPECIE_FK, NOMBRE_RAZA) VALUES
(1, 2, 'SRD'), -- Sin Raza Definida
(1, 2, 'Siamés'),
(1, 2, 'Persa'),
(1, 2, 'Bengalí'),
(1, 2, 'Maine Coon'),
(1, 2, 'British Shorthair'),
(1, 2, 'Sphynx'),
(1, 2, 'Ragdoll'),
(1, 2, 'Angora Turco'),
(1, 2, 'Bombay'),
(1, 2, 'Himalayo'),
(1, 2, 'Devon Rex'),
(1, 2, 'Manx'),
(1, 2, 'Scottish Fold'),
(1, 2, 'Noruego del Bosque'),
(1, 2, 'Abisinio'),
(1, 2, 'Azul Ruso'),
(1, 2, 'Ocicat'),
(1, 2, 'Burmés'),
(1, 2, 'Cornish Rex'),
(1, 2, 'Savannah');

-- RAZAS DE CONEJOS
INSERT INTO huellitas_mascota_raza_tb (ID_ESTADO_FK, ID_MASCOTA_ESPECIE_FK, NOMBRE_RAZA) VALUES
(1, 3, 'SRD'), -- Sin Raza Definida
(1, 3, 'Mini Lop'),
(1, 3, 'Holland Lop'),
(1, 3, 'Rex'),
(1, 3, 'Lionhead'),
(1, 3, 'Angora'),
(1, 3, 'Californiano'),
(1, 3, 'Flemish Giant'),
(1, 3, 'Dutch'),
(1, 3, 'Mini Rex'),
(1, 3, 'Polish'),
(1, 3, 'American Sable'),
(1, 3, 'English Spot');

-- RAZAS DE AVES
INSERT INTO huellitas_mascota_raza_tb (ID_ESTADO_FK, ID_MASCOTA_ESPECIE_FK, NOMBRE_RAZA) VALUES
(1, 4, 'SRD'), -- Sin Raza Definida
(1, 4, 'Perico Australiano'),
(1, 4, 'Canario'),
(1, 4, 'Cacatúa Ninfa'),
(1, 4, 'Agapornis'),
(1, 4, 'Guacamaya'),
(1, 4, 'Cacatúa Alba'),
(1, 4, 'Loro Amazónico'),
(1, 4, 'Diamante Mandarín'),
(1, 4, 'Periquito Moteado'),
(1, 4, 'Tórtola Diamante'),
(1, 4, 'Jilguero'),
(1, 4, 'Loro del Senegal');

-- RAZAS DE REPTILES
INSERT INTO huellitas_mascota_raza_tb (ID_ESTADO_FK, ID_MASCOTA_ESPECIE_FK, NOMBRE_RAZA) VALUES
(1, 5, 'SRD'), -- Sin Raza Definida
(1, 5, 'Iguana Verde'),
(1, 5, 'Dragón Barbudo'),
(1, 5, 'Gecko Leopardo'),
(1, 5, 'Serpiente del Maíz'),
(1, 5, 'Pitón Real'),
(1, 5, 'Tortuga de Orejas Rojas'),
(1, 5, 'Tortuga Rusa'),
(1, 5, 'Camaleón Yemení'),
(1, 5, 'Camaleón Pantera'),
(1, 5, 'Boa Arcoíris'),
(1, 5, 'Salamandra Tigre'),
(1, 5, 'Anolis Verde');



-- ==========================================
-- MASCOTAS ASOCIADAS A USUARIOS REGISTRADOS
-- ==========================================
INSERT INTO huellitas_mascota_tb (
    ID_ESTADO_FK, ID_MASCOTA_ESPECIE_FK, ID_MASCOTA_RAZA_FK, 
    ID_USUARIO_FK, NOMBRE_MASCOTA, FECHA_NACIMIENTO, GENERO, MASCOTA_IMAGEN_URL
) VALUES
(1, 1, 1, 1, 'Luna',    '2020-03-15', 'HEMBRA', 'https://i.imgur.com/x8C3HnV.jpg'),
(1, 1, 2, 2, 'Rocky',   '2019-07-10', 'MACHO',  'https://i.imgur.com/lKf6rVG.jpg'),
(1, 2, 5, 3, 'Mishu',   '2021-01-20', 'HEMBRA', 'https://i.imgur.com/7UpUk0X.jpg');

-- ==========================================
-- MASCOTAS REGISTRADAS POR EMPLEADOS (CLIENTES)
-- ==========================================
INSERT INTO huellitas_mascota_tb (
    ID_ESTADO_FK, ID_MASCOTA_ESPECIE_FK, ID_MASCOTA_RAZA_FK, 
    ID_CLIENTE_FK, NOMBRE_MASCOTA, FECHA_NACIMIENTO, GENERO, MASCOTA_IMAGEN_URL
) VALUES
(1, 1, 1, 1, 'Max',       '2018-06-12', 'MACHO',  'https://i.imgur.com/Ma4ZCEV.jpg'),
(1, 1, 1, 1, 'Canela',    '2020-09-23', 'HEMBRA', 'https://i.imgur.com/g2h8Svh.jpg');



-------------------------------------------------------------------------------------------------
-------------------------------------- Pruebas Encriptacion --------------------------------------------
-------------------------------------------------------------------------------------------------

-- Verificar usuario
SELECT 
    ID_USUARIO_PK,
    USUARIO_NOMBRE,
    USUARIO_CONTRASENNA,
    USUARIO_CONTRASENNA_ENCRIPTADA,
    USUARIO_SALT
FROM huellitas_usuarios_tb;

-- Verificar tarjeta
SELECT 
    ID_TARJETA_PK,
    NUMERO_TARJETA_ENCRIPTADO,
    ULTIMOS_CUATRO_DIGITOS,
    CVV_ENCRIPTADO,
    LENGTH(NUMERO_TARJETA_ENCRIPTADO) AS LONG_NUMERO,
    LENGTH(CVV_ENCRIPTADO) AS LONG_CVV
FROM huellitas_tarjetas_tb;

-- Probar desencriptación de tarjeta
SELECT
    ID_TARJETA_PK,
    NOMBRE_TITULAR,
    ULTIMOS_CUATRO_DIGITOS,
    HUELLITAS_DESENCRIPTAR_DATO_FN(NUMERO_TARJETA_ENCRIPTADO, 'CLAVE_NUMERO_TARJETA') AS NUMERO_DESENCRIPTADO,
    HUELLITAS_DESENCRIPTAR_DATO_FN(CVV_ENCRIPTADO, 'CLAVE_CVV') AS CVV_DESENCRIPTADO
FROM huellitas_tarjetas_tb;

-------------------------------------------------------------------------------------------------
-------------------------------------- Pruebas login --------------------------------------------
-------------------------------------------------------------------------------------------------
-- Probar login exitoso
CALL HUELLITAS_VALIDAR_LOGIN_SP('maria.lopez@email.com', 'ClaveSegura2024!');

-- Probar login fallido
CALL HUELLITAS_VALIDAR_LOGIN_SP('maria.lopez@email.com', 'clave_incorrecta');