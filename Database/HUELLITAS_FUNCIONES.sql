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
-- ==========================================
-- NOMBRE: HUELLITAS_GENERAR_SALT_FN
-- DESCRIPCIÓN: Función para generar un salt único para encriptación
-- ==========================================
DROP FUNCTION IF EXISTS HUELLITAS_GENERAR_SALT_FN;
DELIMITER //
CREATE FUNCTION HUELLITAS_GENERAR_SALT_FN()
RETURNS VARCHAR(100)
DETERMINISTIC
BEGIN
    DECLARE salt_generado VARCHAR(100);
    SET salt_generado = SUBSTRING(MD5(RAND()), 1, 16);
    RETURN salt_generado;
END//
DELIMITER ;


-- ==========================================
-- NOMBRE: HUELLITAS_ENCRIPTAR_CONTRASENNA_FN
-- DESCRIPCIÓN: Función para encriptar contraseñas con salt usando AES
-- ==========================================
DROP FUNCTION IF EXISTS HUELLITAS_ENCRIPTAR_CONTRASENNA_FN;
DELIMITER //
CREATE FUNCTION HUELLITAS_ENCRIPTAR_CONTRASENNA_FN(
    P_CONTRASENNA_PLANA VARCHAR(255),
    P_SALT VARCHAR(100)
)
RETURNS VARCHAR(500)
DETERMINISTIC
BEGIN
    DECLARE V_CLAVE_ENCRIPTACION VARCHAR(64);
    DECLARE V_CONTRASENNA_CON_SALT VARCHAR(355);
    DECLARE V_CONTRASENNA_ENCRIPTADA VARCHAR(500);
    
    -- Combinar contraseña + salt
    SET V_CONTRASENNA_CON_SALT = CONCAT(P_CONTRASENNA_PLANA, P_SALT);
    
    -- Obtener clave de encriptación
    SELECT CLAVE_ENCRIPTACION INTO V_CLAVE_ENCRIPTACION
    FROM huellitas_claves_encriptacion_tb 
    WHERE NOMBRE_CLAVE = 'CLAVE_CONTRASENNA' AND ESTA_ACTIVA = TRUE
    LIMIT 1;
    
    -- Encriptar
    IF V_CLAVE_ENCRIPTACION IS NOT NULL THEN
        SET V_CONTRASENNA_ENCRIPTADA = HEX(AES_ENCRYPT(V_CONTRASENNA_CON_SALT, V_CLAVE_ENCRIPTACION));
    ELSE
        SET V_CONTRASENNA_ENCRIPTADA = NULL;
    END IF;
    
    RETURN V_CONTRASENNA_ENCRIPTADA;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_VERIFICAR_CONTRASENNA_FN
-- DESCRIPCIÓN: Función para verificar si una contraseña coincide con la almacenada
-- ==========================================
DROP FUNCTION IF EXISTS HUELLITAS_VERIFICAR_CONTRASENNA_FN;
DELIMITER //
CREATE FUNCTION HUELLITAS_VERIFICAR_CONTRASENNA_FN(
    P_USUARIO_ID INT,
    P_CONTRASENNA_INTENTO VARCHAR(255)
)
RETURNS BOOLEAN
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE V_CONTRASENNA_ENCRIPTADA VARCHAR(500);
    DECLARE V_SALT VARCHAR(100);
    DECLARE V_CLAVE_ENCRIPTACION VARCHAR(64);
    DECLARE V_CONTRASENNA_DESENCRIPTADA VARCHAR(355);
    DECLARE V_CONTRASENNA_INTENTO_CON_SALT VARCHAR(355);
    
    -- Obtener contraseña encriptada y salt del usuario
    SELECT USUARIO_CONTRASENNA_ENCRIPTADA, USUARIO_SALT 
    INTO V_CONTRASENNA_ENCRIPTADA, V_SALT
    FROM huellitas_usuarios_tb 
    WHERE ID_USUARIO_PK = P_USUARIO_ID;
    
    -- Obtener clave de encriptación
    SELECT CLAVE_ENCRIPTACION INTO V_CLAVE_ENCRIPTACION
    FROM huellitas_claves_encriptacion_tb 
    WHERE NOMBRE_CLAVE = 'CLAVE_CONTRASENNA' AND ESTA_ACTIVA = TRUE
    LIMIT 1;
    
    -- Verificar que todos los datos existan
    IF V_CONTRASENNA_ENCRIPTADA IS NULL OR V_SALT IS NULL OR V_CLAVE_ENCRIPTACION IS NULL THEN
        RETURN FALSE;
    END IF;
    
    -- Combinar intento + salt
    SET V_CONTRASENNA_INTENTO_CON_SALT = CONCAT(P_CONTRASENNA_INTENTO, V_SALT);
    
    -- Desencriptar contraseña almacenada
    SET V_CONTRASENNA_DESENCRIPTADA = AES_DECRYPT(UNHEX(V_CONTRASENNA_ENCRIPTADA), V_CLAVE_ENCRIPTACION);
    
    -- Comparar
    IF V_CONTRASENNA_INTENTO_CON_SALT = V_CONTRASENNA_DESENCRIPTADA THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_GENERAR_CLAVE_AES_FN
-- DESCRIPCIÓN: Función para generar claves AES de 64 caracteres
-- ==========================================
DROP FUNCTION IF EXISTS HUELLITAS_GENERAR_CLAVE_AES_FN;
DELIMITER //
CREATE FUNCTION HUELLITAS_GENERAR_CLAVE_AES_FN()
RETURNS VARCHAR(64)
DETERMINISTIC
BEGIN
    RETURN UPPER(SUBSTRING(SHA2(RAND(), 256), 1, 64));
END//
DELIMITER ;


-- ==========================================
-- NOMBRE: HUELLITAS_ENCRIPTAR_DATO_FN
-- DESCRIPCIÓN: Función para encriptar datos usando AES con clave específica
-- ==========================================
DROP FUNCTION IF EXISTS HUELLITAS_ENCRIPTAR_DATO_FN;
DELIMITER //
CREATE FUNCTION HUELLITAS_ENCRIPTAR_DATO_FN(
    P_TEXTO_PLANO TEXT,
    P_NOMBRE_CLAVE VARCHAR(100)
)
RETURNS TEXT
DETERMINISTIC
BEGIN
    DECLARE V_CLAVE_ENCRIPTACION VARCHAR(64);
    DECLARE V_TEXTO_ENCRIPTADO TEXT;
    
    -- Obtener clave
    SELECT CLAVE_ENCRIPTACION INTO V_CLAVE_ENCRIPTACION
    FROM huellitas_claves_encriptacion_tb 
    WHERE NOMBRE_CLAVE = P_NOMBRE_CLAVE AND ESTA_ACTIVA = TRUE
    LIMIT 1;
    
    -- Validar clave
    IF V_CLAVE_ENCRIPTACION IS NULL THEN
        RETURN NULL;
    END IF;
    
    -- Encriptar
    SET V_TEXTO_ENCRIPTADO = HEX(AES_ENCRYPT(P_TEXTO_PLANO, V_CLAVE_ENCRIPTACION));
    RETURN V_TEXTO_ENCRIPTADO;
END//
DELIMITER ;


-- ==========================================
-- NOMBRE: HUELLITAS_DESENCRIPTAR_DATO_FN
-- DESCRIPCIÓN: Función para desencriptar datos usando AES con clave específica
-- ==========================================
DROP FUNCTION IF EXISTS HUELLITAS_DESENCRIPTAR_DATO_FN;
DELIMITER //
CREATE FUNCTION HUELLITAS_DESENCRIPTAR_DATO_FN(
    P_TEXTO_ENCRIPTADO TEXT,
    P_NOMBRE_CLAVE VARCHAR(100)
)
RETURNS TEXT
DETERMINISTIC
BEGIN
    DECLARE V_CLAVE_ENCRIPTACION VARCHAR(64);
    DECLARE V_TEXTO_DESENCRIPTADO TEXT;
    
    -- Obtener clave
    SELECT CLAVE_ENCRIPTACION INTO V_CLAVE_ENCRIPTACION
    FROM huellitas_claves_encriptacion_tb 
    WHERE NOMBRE_CLAVE = P_NOMBRE_CLAVE AND ESTA_ACTIVA = TRUE
    LIMIT 1;
    
    -- Validar clave
    IF V_CLAVE_ENCRIPTACION IS NULL THEN
        RETURN NULL;
    END IF;
    
    -- Desencriptar
    SET V_TEXTO_DESENCRIPTADO = AES_DECRYPT(UNHEX(P_TEXTO_ENCRIPTADO), V_CLAVE_ENCRIPTACION);
    RETURN V_TEXTO_DESENCRIPTADO;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_CALCULAR_PRECIO_CON_DESCUENTO_FN
-- DESCRIPCIÓN: Función para calcular el precio final de un producto aplicando descuentos activos
-- ==========================================
DROP FUNCTION IF EXISTS HUELLITAS_CALCULAR_PRECIO_CON_DESCUENTO_FN;
DELIMITER //
CREATE FUNCTION HUELLITAS_CALCULAR_PRECIO_CON_DESCUENTO_FN(
    P_ID_PRODUCTO_FK INT,
    P_PRECIO_ORIGINAL DECIMAL(10,2)
)
RETURNS DECIMAL(10,2)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE V_PORCENTAJE_DESCUENTO DECIMAL(5,2);
    DECLARE V_PRECIO_FINAL DECIMAL(10,2);
    
    -- OBTENER DESCUENTO ACTIVO MÁS RECIENTE (VÁLIDO SI FECHA_FIN >= HOY)
    SELECT PORCENTAJE_DESCUENTO INTO V_PORCENTAJE_DESCUENTO
    FROM huellitas_descuentos_tb 
    WHERE ID_PRODUCTO_FK = P_ID_PRODUCTO_FK
    AND ID_ESTADO_FK = 1
    AND FECHA_FIN >= CURDATE()  -- DESCUENTO VIGENTE
    ORDER BY FECHA_CREACION DESC
    LIMIT 1;
    
    -- CALCULAR PRECIO FINAL
    IF V_PORCENTAJE_DESCUENTO IS NOT NULL THEN
        SET V_PRECIO_FINAL = P_PRECIO_ORIGINAL * (1 - (V_PORCENTAJE_DESCUENTO / 100));
    ELSE
        SET V_PRECIO_FINAL = P_PRECIO_ORIGINAL;
    END IF;
    
    RETURN V_PRECIO_FINAL;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: FN_GENERAR_CODIGO_GLOBAL_HUELLITAS
-- DESCRIPCIÓN: Función que genera un código único global combinando fecha + secuencia incremental
-- ==========================================
DROP FUNCTION IF EXISTS GENERAR_CODIGO_GLOBAL_HUELLITAS_FN;
DELIMITER //
CREATE FUNCTION GENERAR_CODIGO_GLOBAL_HUELLITAS_FN()
RETURNS VARCHAR(30)
DETERMINISTIC
BEGIN
    DECLARE v_codigo VARCHAR(30);
    DECLARE v_id INT;

    -- Insertar un nuevo registro en la tabla maestra
    INSERT INTO HUELLITAS_CODIGOS_GENERALES_TB (CODIGO_UNICO)
    VALUES ('TEMP');

    SET v_id = LAST_INSERT_ID();

    -- Generar código basado en fecha y ID incremental
    SET v_codigo = CONCAT(
        DATE_FORMAT(NOW(), '%Y%m%d'),
        LPAD(v_id, 4, '0')
    );

    -- Actualizar el valor real del código en la tabla maestra
    UPDATE HUELLITAS_CODIGOS_GENERALES_TB
    SET CODIGO_UNICO = v_codigo
    WHERE ID_CODIGO_PK = v_id;

    RETURN v_codigo;
END //
DELIMITER ;

-- ==========================================
-- NOMBRE: FN_GENERAR_CODIGO_GLOBAL_HUELLITAS
-- DESCRIPCIÓN: Función exclusivamente para generar códigos de mascotas
-- ==========================================
DROP FUNCTION IF EXISTS GENERAR_CODIGO_MASCOTA_FN;
DELIMITER //
CREATE FUNCTION GENERAR_CODIGO_MASCOTA_FN()
RETURNS VARCHAR(30)
DETERMINISTIC
BEGIN
    DECLARE v_codigo VARCHAR(30);
    DECLARE v_id INT;

    -- Crear un registro temporal para obtener el consecutivo único
    INSERT INTO HUELLITAS_CODIGOS_MASCOTA_TB (CODIGO_UNICO)
    VALUES ('TEMP');

    SET v_id = LAST_INSERT_ID();

    -- Generar código: MASC + fecha + consecutivo de 4 dígitos
    SET v_codigo = CONCAT(
        'PET-',
        DATE_FORMAT(NOW(), '%Y%m%d'),
        '-',
        LPAD(v_id, 4, '0')
    );

    -- Actualizar código definitivo
    UPDATE HUELLITAS_CODIGOS_MASCOTA_TB
    SET CODIGO_UNICO = v_codigo
    WHERE ID_CODIGO_PK = v_id;

    RETURN v_codigo;
END //
DELIMITER ;

-- ==========================================
-- NOMBRE: GENERAR_CODIGO_HISTORIAL_FN
-- DESCRIPCIÓN: Función exclusivamente para generar códigos de historiales medicos
-- ==========================================
DROP FUNCTION IF EXISTS GENERAR_CODIGO_HISTORIAL_FN;
DELIMITER //
CREATE FUNCTION GENERAR_CODIGO_HISTORIAL_FN()
RETURNS VARCHAR(30)
DETERMINISTIC
BEGIN
    DECLARE v_codigo VARCHAR(30);
    DECLARE v_id INT;

    -- Registrar temporal para obtener consecutivo
    INSERT INTO HUELLITAS_CODIGOS_GENERALES_TB (CODIGO_UNICO)
    VALUES ('TEMP');

    SET v_id = LAST_INSERT_ID();

    -- Formato: HIS-20251201-0001
    SET v_codigo = CONCAT(
        'HIS-',
        DATE_FORMAT(NOW(), '%Y%m%d'),
        '-',
        LPAD(v_id, 4, '0')
    );

    -- Actualizar el registro temporal
    UPDATE HUELLITAS_CODIGOS_GENERALES_TB
    SET CODIGO_UNICO = v_codigo
    WHERE ID_CODIGO_PK = v_id;

    RETURN v_codigo;
END //
DELIMITER ;





