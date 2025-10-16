-- ==========================================
-- Orden de creacion de tablas para la base de datos HUELLITAS
-- 1 HUELLITAS_TABLAS.sql
-- 2 HUELLITAS_FUNCIONES.sql
-- 3 HUELLITAS_TRIGGERS.sql
-- 4 HUELLITAS_PROCEDIMIENTOS.sql
-- 5 HUELLITAS_VISTAS.sql
-- 6 HUELLITAS_PRUEBAS.sql
-- ==========================================

use PROYECTO;

INSERT INTO HUELLITAS_ESTADO_TB (ESTADO_DESCRIPCION) VALUES 
('ACTIVO'),
('INACTIVO');

INSERT INTO HUELLITAS_NUEVO_TB (NUEVO_DESCRIPCION) VALUES 
('ES NUEVO'),
('NO ES NUEVO');

INSERT INTO HUELLITAS_SLIDER_BANNER_TB (IMAGEN_URL, DESCRIPCION_SLIDER_BANNER, ID_ESTADO_FK)
VALUES 
('https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/sliderBanner%2F68f0083dce5df_1080x300.png?alt=media',
 'Cuidamos de tus mascotas con amor y experiencia veterinaria.', 1),

('https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/sliderBanner%2F68f0084b8f89e_1080x300%20%281%29.png?alt=media',
 'Promoción del mes: 20% de descuento en alimentos premium para perros y gatos.', 1),

('https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/sliderBanner%2F68f00858e656d_1080x300%20%282%29.png?alt=media',
 'Agenda tu cita para vacunación y chequeos veterinarios en línea.', 1);

INSERT INTO HUELLITAS_PRODUCTOS_CATEGORIA_TB (ID_ESTADO_FK, DESCRIPCION_CATEGORIA) VALUES
(1, 'Medicamentos'),
(1, 'Accesorios'),
(1, 'Alimentos'),
(1, 'Medicamento para perro'),
(1, 'Accesorio para gato'),
(1, 'Alimento para gato'),
(1, 'Alimento para perro');

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


CALL HUELLITAS_AGREGAR_PRODUCTO_SP(1, 1, 7, 1, 1, 'ProPlan Adulto Raza Pequeña 1Kg', 'Croquetas premium con proteínas de alta calidad para perros adultos de raza mediana.', 6150, 50, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68edd67ca4eaa_img-proplan-Puppy.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(2, 1, 6, 10, 1, 'Cat Chow Adultos Pollo 1.5Kg', 'Alimento completo y balanceado para gatos adultos sabor pollo.', 6300, 60, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f001b3776a4_Captura%20de%20pantalla%202025-10-15%20141848.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(3, 1, 1, 3, 1, 'Crema Cicatrizante Calox 15g', 'Pomada veterinaria que ayuda en la regeneración y cicatrización de heridas leves en la piel de mascotas.', 2500, 40, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f0053a7da12_Captura%20de%20pantalla%202025-10-15%20143351.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(4, 1, 2, 6, 2, 'Shampoo Toons 265ml', 'Shampoo suave con fragancia agradable que limpia y cuida el pelaje de perros adultos, ideal para uso frecuente.', 1775, 75, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68ede08890f8c_Captura%20de%20pantalla%202025-10-13%20232409.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(5, 1, 4, 4, 1, 'Pastilla Credelio Perros 11-22kg', 'Tableta masticable para control mensual de pulgas y garrapatas.', 14525, 45, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68edead85943a_Captura%20de%20pantalla%202025-10-14%20001332.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(6, 1, 7, 5, 2, 'Balance Adulto Pollo y Arroz 2Kg', 'Alimento seco con proteínas de pollo y cereales integrales para perros adultos.', 3500, 80, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f0007f47052_7443007533202-Basico-Perro-Adulto-Raza-mediana-Pollo-14.97kg.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(7, 1, 5, 6, 1, 'Colonia Toons 125ml', 'Colonia con aroma fresco y duradero que deja el pelaje de tu mascota con un olor agradable después del baño.', 3100, 30, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f00296027ad_Captura%20de%20pantalla%202025-10-15%20142232.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(8, 1, 3, 2, 2, 'NutriSource Raza Pequeña 1.8Kg ', 'Fórmula balanceada para cachorros con DHA y proteínas de pollo.', 10250, 70, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68ede9d81d610_Captura%20de%20pantalla%202025-10-14%20001231.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(9, 1, 1, 7, 1, 'Pastilla Endogard hasta 10Kg', 'Antibiótico de uso veterinario para infecciones respiratorias y cutáneas.', 1750, 35, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68edebac82d75_Endogard10-2600x600%20%281%29.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(10, 1, 4, 8, 1, 'Seresto Collar Antipulgas Grande', 'Collar de larga duración contra pulgas y garrapatas (8 meses de protección).', 35150, 60, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f002ce5ba8f_1-282.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(1, 1, 3, 9, 2, 'Saco Pedigree Adulto Carne y Vegetales 21Kg', 'Alimento seco para perros adultos sabor carne y vegetales.', 31000, 90, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f00399e6515_Captura%20de%20pantalla%202025-10-15%20142654.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(2, 1, 6, 12, 1, 'Purina ONE Gato Esterilizado 2Kg', 'Fórmula especializada para gatos esterilizados que ayuda al control de peso.', 12200, 55, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f00165ce2eb_Captura%20de%20pantalla%202025-10-15%20141719.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(3, 1, 1, 11, 1, 'Bravecto Tableta 20-40kg', 'Antiparasitario oral de acción prolongada (3 meses) para perros grandes.', 32000, 50, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f004e94e2d5_Captura%20de%20pantalla%202025-10-15%20143227.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(4, 1, 2, 6, 2, 'Shampoo para Cachoro Toons', 'Shampoo hipoalergénico para cachorros con fórmula suave que limpia sin irritar la piel ni los ojos.', 4325, 25, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f0047bd89bd_Dise%C3%B1o%20sin%20t%C3%ADtulo%20%282%29.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(5, 1, 5, 13, 1, 'Hills Science Diet Gato Light 1.8Kg', 'Alimento bajo en calorías para control de peso en gatos adultos.', 22030, 40, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f002261cbb2_Captura%20de%20pantalla%202025-10-15%20142046.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(9, 1, 6, 10, 1, 'Cat Chow Gatitos 500g', 'Alimento con DHA para el desarrollo del cerebro y la visión en gatitos.', 5510, 65, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f000fc639ff_Captura%20de%20pantalla%202025-10-15%20141542.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(10, 1, 3, 2, 2, 'NutriSource Senior 1.8Kg', 'Alimento balanceado para perros mayores con ingredientes de fácil digestión.', 9550, 50, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68f0032ece15d_2-4-1.png?alt=media');
CALL HUELLITAS_AGREGAR_PRODUCTO_SP(1, 1, 1, 10, 1, 'Himalaya Digyton Gotas', 'Digestivo: estimula la secreción de las enzimas proteolíticas, amilolíticas y lipolíticas, lo cual cataliza la digestión de los alimentos. Actúa como carminativo, elimina los problemas de flatulencia, cólicos y distención abdominal. Regula la peristalsis (motilidad intestinal), normalizando problemas de estreñimiento y diarreas leves. Mejora el apetito y la asimilación de alimentos en cachorros. Incrementa la tolerancia a cambios repentinos de dieta. Evita los trastornos gastrointestinales en cachorros destetados.', 6150, 50, 'https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/productos%2F68e8936b1aba2_img-digyton.png?alt=media');


INSERT INTO HUELLITAS_ROL_USUARIO_TB (ID_ESTADO_FK, DESCRIPCION_ROL_USUARIO) VALUES 
(1, 'CLIENTE'),
(1, 'ADMINISTRADOR'),
(1, 'EMPLEADO'),
(1, 'VETERINARIO');

INSERT INTO HUELLITAS_DIRECCION_PROVINCIA_TB (ID_ESTADO_FK, NOMBRE_PROVINCIA) VALUES 
(1, 'SAN JOSÉ'),
(1, 'ALAJUELA'),
(1, 'CARTAGO'),
(1, 'HEREDIA'),
(1, 'GUANACASTE'),
(1, 'PUNTARENAS'),
(1, 'LIMÓN');

INSERT INTO HUELLITAS_DIRECCION_CANTON_TB (ID_ESTADO_FK, NOMBRE_CANTON) VALUES 
(1, 'CENTRAL'),
(1, 'ESCAZÚ'),
(1, 'DESAMPARADOS'),
(1, 'MORAVIA'),
(1, 'TIBÁS'),
(1, 'GOICOECHEA'),
(1, 'SANTA ANA');


INSERT INTO HUELLITAS_DIRECCION_DISTRITO_TB (ID_ESTADO_FK, NOMBRE_DISTRITO) VALUES 
(1, 'CARMEN'),
(1, 'MERCED'),
(1, 'HATILLO'),
(1, 'SAN FRANCISCO'),
(1, 'URUCA'),
(1, 'MATA REDONDA'),
(1, 'ZAPOTE');

INSERT INTO HUELLITAS_DIRECCION_TB (ID_ESTADO_FK, ID_DIRECCION_PROVINCIA_FK, ID_DIRECCION_CANTON_FK, ID_DIRECCION_DISTRITO_FK, DIRECCION_SENNAS) VALUES 
(1, 1, 1, 1, 'AVENIDA CENTRAL, CALLE 25, CASA 456');

INSERT INTO HUELLITAS_TELEFONO_CONTACTO_TB (ID_ESTADO_FK, TELEFONO_CONTACTO) VALUES 
(1, 88889999);


-- Crear claves de encriptación
INSERT INTO HUELLITAS_CLAVES_ENCRIPTACION_TB (NOMBRE_CLAVE, CLAVE_ENCRIPTACION) VALUES 
('CLAVE_NUMERO_TARJETA', HUELLITAS_GENERAR_CLAVE_AES_FN()),
('CLAVE_CVV', HUELLITAS_GENERAR_CLAVE_AES_FN()),
('CLAVE_CONTRASENNA', HUELLITAS_GENERAR_CLAVE_AES_FN());


INSERT INTO HUELLITAS_USUARIOS_TB (
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
INSERT INTO HUELLITAS_USUARIOS_TB (
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

INSERT INTO HUELLITAS_TARJETAS_TB (
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


INSERT INTO HUELLITAS_PRODUCTOS_COMENTARIOS_TB 
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
FROM HUELLITAS_USUARIOS_TB;

-- Verificar tarjeta
SELECT 
    ID_TARJETA_PK,
    NUMERO_TARJETA_ENCRIPTADO,
    ULTIMOS_CUATRO_DIGITOS,
    CVV_ENCRIPTADO,
    LENGTH(NUMERO_TARJETA_ENCRIPTADO) AS LONG_NUMERO,
    LENGTH(CVV_ENCRIPTADO) AS LONG_CVV
FROM HUELLITAS_TARJETAS_TB;

-- Probar desencriptación de tarjeta
SELECT
    ID_TARJETA_PK,
    NOMBRE_TITULAR,
    ULTIMOS_CUATRO_DIGITOS,
    HUELLITAS_DESENCRIPTAR_DATO_FN(NUMERO_TARJETA_ENCRIPTADO, 'CLAVE_NUMERO_TARJETA') AS NUMERO_DESENCRIPTADO,
    HUELLITAS_DESENCRIPTAR_DATO_FN(CVV_ENCRIPTADO, 'CLAVE_CVV') AS CVV_DESENCRIPTADO
FROM HUELLITAS_TARJETAS_TB;

-------------------------------------------------------------------------------------------------
-------------------------------------- Pruebas login --------------------------------------------
-------------------------------------------------------------------------------------------------
-- Probar login exitoso
CALL HUELLITAS_VALIDAR_LOGIN_SP('maria.lopez@email.com', 'ClaveSegura2024!');

-- Probar login fallido
CALL HUELLITAS_VALIDAR_LOGIN_SP('maria.lopez@email.com', 'clave_incorrecta');

-- Cambiar contraseña
CALL HUELLITAS_CAMBIAR_CONTRASENNA_SP(1, 'ClaveSegura2024!', 'NuevaClaveSuperSegura2024!');

-- Probar que la nueva contraseña funciona
CALL HUELLITAS_VALIDAR_LOGIN_SP('maria.lopez@email.com', 'NuevaClaveSuperSegura2024!');


CALL HUELLITAS_LISTAR_PRODUCTOS_ACTIVOS_SP();