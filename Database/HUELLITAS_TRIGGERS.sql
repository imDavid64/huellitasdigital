-- ==========================================
-- Orden de creacion de tablas para la base de datos HUELLITAS
-- 1 HUELLITAS_TABLAS.sql
-- 2 HUELLITAS_FUNCIONES.sql
-- 3 HUELLITAS_TRIGGERS.sql
-- 4 HUELLITAS_PROCEDIMIENTOS.sql
-- 5 HUELLITAS_VISTAS.sql
-- 6 HUELLITAS_PRUEBAS.sql
-- ==========================================

-- ==========================================
-- NOMBRE: HUELLITAS_ANTES_INSERTAR_USUARIO_TR
-- DESCRIPCIÓN: Trigger para encriptar contraseña automáticamente al insertar usuario
-- ==========================================
DELIMITER //
CREATE TRIGGER HUELLITAS_ANTES_INSERTAR_USUARIO_TR
BEFORE INSERT ON HUELLITAS_USUARIOS_TB
FOR EACH ROW
BEGIN
    DECLARE V_SALT VARCHAR(100);
    
    -- Generar salt único para cada usuario
    SET V_SALT = HUELLITAS_GENERAR_SALT_FN();
    SET NEW.USUARIO_SALT = V_SALT;
    
    -- Encriptar contraseña
    IF NEW.USUARIO_CONTRASENNA IS NOT NULL THEN
        SET NEW.USUARIO_CONTRASENNA_ENCRIPTADA = HUELLITAS_ENCRIPTAR_CONTRASENNA_FN(
            NEW.USUARIO_CONTRASENNA, 
            V_SALT
        );
        -- Limpiar contraseña en texto plano (opcional por seguridad)
        SET NEW.USUARIO_CONTRASENNA = NULL;
    END IF;
END//
DELIMITER ;
/

-- ==========================================
-- NOMBRE: HUELLITAS_ANTES_ACTUALIZAR_USUARIO_TR
-- DESCRIPCIÓN: Trigger para encriptar contraseña automáticamente al actualizar usuario
-- ==========================================
DELIMITER //
CREATE TRIGGER HUELLITAS_ANTES_ACTUALIZAR_USUARIO_TR
BEFORE UPDATE ON HUELLITAS_USUARIOS_TB
FOR EACH ROW
BEGIN
    -- Si se está asignando una nueva contraseña (no nula)
    IF NEW.USUARIO_CONTRASENNA IS NOT NULL THEN
        -- Generar nuevo salt
        SET NEW.USUARIO_SALT = HUELLITAS_GENERAR_SALT_FN();
        
        -- Encriptar nueva contraseña
        SET NEW.USUARIO_CONTRASENNA_ENCRIPTADA = HUELLITAS_ENCRIPTAR_CONTRASENNA_FN(
            NEW.USUARIO_CONTRASENNA, 
            NEW.USUARIO_SALT
        );
        
        -- Limpiar contraseña en texto plano
        SET NEW.USUARIO_CONTRASENNA = NULL;
    END IF;
END//
DELIMITER ;
/
-- ==========================================
-- NOMBRE: HUELLITAS_ANTES_INSERTAR_TARJETA_TR
-- DESCRIPCIÓN: Trigger para encriptar automáticamente datos de tarjeta al insertar
-- ==========================================
DELIMITER //
CREATE TRIGGER HUELLITAS_ANTES_INSERTAR_TARJETA_TR
BEFORE INSERT ON HUELLITAS_TARJETAS_TB
FOR EACH ROW
BEGIN
    -- SOLO ENCRIPTACIÓN, SIN VALIDACIONES DE FECHA
    IF NEW.NUMERO_TARJETA_ENCRIPTADO IS NOT NULL THEN
        SET NEW.NUMERO_TARJETA_ENCRIPTADO = HUELLITAS_ENCRIPTAR_DATO_FN(
            NEW.NUMERO_TARJETA_ENCRIPTADO, 'CLAVE_NUMERO_TARJETA'
        );
    END IF;
    
    IF NEW.CVV_ENCRIPTADO IS NOT NULL THEN
        SET NEW.CVV_ENCRIPTADO = HUELLITAS_ENCRIPTAR_DATO_FN(
            NEW.CVV_ENCRIPTADO, 'CLAVE_CVV'
        );
    END IF;
    
    IF NEW.ULTIMOS_CUATRO_DIGITOS IS NULL AND NEW.NUMERO_TARJETA_ENCRIPTADO IS NOT NULL THEN
        SET NEW.ULTIMOS_CUATRO_DIGITOS = RIGHT(NEW.NUMERO_TARJETA_ENCRIPTADO, 4);
    END IF;
END// 
DELIMITER ;
/

-- ==========================================
-- NOMBRE: HUELLITAS_ANTES_ACTUALIZAR_TARJETA_TR
-- DESCRIPCIÓN: Trigger para encriptar automáticamente datos de tarjeta al actualizar
-- ==========================================
DELIMITER //
CREATE TRIGGER HUELLITAS_ANTES_ACTUALIZAR_TARJETA_TR
BEFORE UPDATE ON HUELLITAS_TARJETAS_TB
FOR EACH ROW
BEGIN
    -- SOLO ENCRIPTACIÓN, SIN VALIDACIONES DE FECHA
    IF NEW.NUMERO_TARJETA_ENCRIPTADO != OLD.NUMERO_TARJETA_ENCRIPTADO THEN
        SET NEW.NUMERO_TARJETA_ENCRIPTADO = HUELLITAS_ENCRIPTAR_DATO_FN(
            NEW.NUMERO_TARJETA_ENCRIPTADO, 'CLAVE_NUMERO_TARJETA'
        );
        SET NEW.ULTIMOS_CUATRO_DIGITOS = RIGHT(NEW.NUMERO_TARJETA_ENCRIPTADO, 4);
    END IF;
    
    IF NEW.CVV_ENCRIPTADO != OLD.CVV_ENCRIPTADO THEN
        SET NEW.CVV_ENCRIPTADO = HUELLITAS_ENCRIPTAR_DATO_FN(
            NEW.CVV_ENCRIPTADO, 'CLAVE_CVV'
        );
    END IF;
END//
DELIMITER ;
