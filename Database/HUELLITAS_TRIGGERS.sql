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

-- ==========================================
-- NOMBRE: HUELLITAS_VALIDAR_TARJETA_TR
-- DESCRIPCIÓN: Trigger para Validar Fechas de Tarjetas (integridad lógica)
-- ==========================================
DELIMITER //
CREATE TRIGGER HUELLITAS_VALIDAR_TARJETA_TR
BEFORE INSERT ON HUELLITAS_TARJETAS_TB
FOR EACH ROW
BEGIN
    IF NEW.FECHA_VENCIMIENTO < CURDATE() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = '❌ No se puede registrar una tarjeta vencida.';
    END IF;
END//
DELIMITER ;


-- ==========================================
-- NOMBRE: HUELLITAS_DISMINUIR_STOCK_TR
-- DESCRIPCIÓN: Trigger para Control de Stock Automático
-- ==========================================
DELIMITER //
CREATE TRIGGER HUELLITAS_DISMINUIR_STOCK_TR
AFTER INSERT ON HUELLITAS_DETALLE_FACTURA_TB
FOR EACH ROW
BEGIN
    UPDATE HUELLITAS_PRODUCTOS_TB
    SET PRODUCTO_STOCK = PRODUCTO_STOCK - NEW.CANTIDAD
    WHERE ID_PRODUCTO_PK = NEW.ID_PRODUCTO_FK;

    IF (SELECT PRODUCTO_STOCK FROM HUELLITAS_PRODUCTOS_TB WHERE ID_PRODUCTO_PK = NEW.ID_PRODUCTO_FK) < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = '⚠️ El stock del producto no puede ser negativo.';
    END IF;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_ALERTA_BAJO_STOCK_TR
-- DESCRIPCIÓN: Envía notificaciones a todos los administradores cuando un producto tiene bajo stock.
-- ==========================================
DELIMITER //
CREATE TRIGGER HUELLITAS_ALERTA_BAJO_STOCK_TR
AFTER UPDATE ON HUELLITAS_PRODUCTOS_TB
FOR EACH ROW
BEGIN
    -- Notificar solo cuando el stock cayó por debajo o igual a 5
    -- y antes estaba por encima (evita notificaciones repetidas).
    IF NEW.PRODUCTO_STOCK <= 5
       AND (OLD.PRODUCTO_STOCK IS NULL OR OLD.PRODUCTO_STOCK > 5) THEN

        INSERT INTO HUELLITAS_NOTIFICACIONES_TB
        (
            ID_USUARIO_FK,
            ID_ESTADO_FK,
            TITULO_NOTIFICACION,
            MENSAJE_NOTIFICACION,
            TIPO_NOTIFICACION,
            PRIORIDAD,
            URL_REDIRECCION
        )
        SELECT
            u.ID_USUARIO_PK,
            1, -- Activa
            CONCAT('Stock bajo: ', NEW.PRODUCTO_NOMBRE),
            CONCAT('El producto "', NEW.PRODUCTO_NOMBRE, '" tiene solo ',
                   NEW.PRODUCTO_STOCK, ' unidades en inventario.'),
            'SISTEMA',
            'ALTA',
            CONCAT('/huellitasdigital/app/controllers/admin/productController.php?action=edit&id=', NEW.ID_PRODUCTO_PK)
        FROM HUELLITAS_USUARIOS_TB u
        JOIN HUELLITAS_ROL_USUARIO_TB r
              ON r.ID_ROL_USUARIO_PK = u.ID_ROL_USUARIO_FK
        WHERE r.DESCRIPCION_ROL_USUARIO = 'Administrador';
    END IF;
END//
DELIMITER ;

-- ==========================================
-- NOMBRE: HUELLITAS_ALERTA_BAJO_STOCK_INS_TR
-- DESCRIPCIÓN: Envía notificaciones a todos los administradores cuando se agregar un producto con bajo stock.
-- ==========================================
DELIMITER //
CREATE TRIGGER HUELLITAS_ALERTA_BAJO_STOCK_INS_TR
AFTER INSERT ON HUELLITAS_PRODUCTOS_TB
FOR EACH ROW
BEGIN
    IF NEW.PRODUCTO_STOCK <= 5 THEN
        INSERT INTO HUELLITAS_NOTIFICACIONES_TB
        (
            ID_USUARIO_FK, ID_ESTADO_FK, TITULO_NOTIFICACION, MENSAJE_NOTIFICACION,
            TIPO_NOTIFICACION, PRIORIDAD, URL_REDIRECCION
        )
        SELECT
            u.ID_USUARIO_PK, 1,
            CONCAT('Stock bajo: ', NEW.PRODUCTO_NOMBRE),
            CONCAT('El producto "', NEW.PRODUCTO_NOMBRE, '" tiene solo ',
                   NEW.PRODUCTO_STOCK, ' unidades en inventario.'),
            'SISTEMA', 'ALTA',
            CONCAT('/huellitasdigital/app/controllers/admin/productController.php?action=edit&id=', NEW.ID_PRODUCTO_PK)
        FROM HUELLITAS_USUARIOS_TB u
        JOIN HUELLITAS_ROL_USUARIO_TB r
              ON r.ID_ROL_USUARIO_PK = u.ID_ROL_USUARIO_FK
        WHERE r.DESCRIPCION_ROL_USUARIO = 'Administrador';
    END IF;
END//
DELIMITER ;




-- ==========================================
-- NOMBRE: HUELLITAS_VALIDAR_COMENTARIO_TR
-- DESCRIPCIÓN: Trigger para Validar Comentarios de Productos
-- ==========================================
/*
DELIMITER //
CREATE TRIGGER HUELLITAS_VALIDAR_COMENTARIO_TR
BEFORE INSERT ON HUELLITAS_PRODUCTOS_COMENTARIOS_TB
FOR EACH ROW
BEGIN
    DECLARE V_EXISTE_COMPRA INT;

    SELECT COUNT(*) INTO V_EXISTE_COMPRA
    FROM HUELLITAS_DETALLE_FACTURA_TB DF
    INNER JOIN HUELLITAS_FACTURACIONES_TB F ON DF.ID_FACTURA_FK = F.ID_FACTURA_PK
    WHERE DF.ID_PRODUCTO_FK = NEW.ID_PRODUCTO_FK
      AND F.ID_USUARIO_FK = NEW.ID_USUARIO_FK;

    IF V_EXISTE_COMPRA = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = '❌ Solo los clientes que hayan comprado el producto pueden comentar.';
    END IF;
END//
DELIMITER ;
*/


