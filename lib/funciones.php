<?php
// Abrir session.
session_start();

// Función para conectarse a la base de datos.
function conectar()
{
    // Datos para la base de datos.
    $host = "localhost";
    $basededatos = "kantrades";
    $usuariodb = "root";
    $clavedb = "";

    // Creando la conexión.
    $conn = mysqli_connect($host, $usuariodb, $clavedb, $basededatos);

    // Si no se crea la conexión se envía un error.
    if (!$conn) {
        throw new Exception('Error de conexión: ' . mysqli_connect_error());
    } else {
        // Si se establece entonces devuelve la conexión.
        return $conn;
    }
}

// Para hacer autenticacion login del usuario
function autenticarUser($email, $password)
{
    // Verificar si hay campo vacio.
    if (empty($email) || empty($password)) {
        $errors[] = "Hay campos vacios.";
    }

    // Lanza alerta si hay erro en el array de $errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        return false;
    } else {
        // Si no hay errores, los datos del formulario son válidos.

        //Consulta
        $sql = "SELECT * FROM usuarios WHERE email='$email'";

        //Verificar si el usuario existe o no
        if ($row = sqlSELECT($sql)->fetch_assoc()) {
            $password_hash = $row['password'];

            // Verifica la contraseña
            if (password_verify($password, $password_hash)) {
                $_SESSION['usuario'] = $row;
                $_SESSION['validarEstado'] = true;
                // echo "<script>window.location.href = 'pag/principal.php';</script>";
                // echo "<script> location.replace('pag/principal.php'); </script>";
                echo 'Correcto';
                exit; // Es importante poner exit después del header para asegurarnos de que el script no siga ejecutándose
            } else {
                echo '<div class="alert alert-warning" role="alert">Password Incorrecto!</div>';
            }
        } else {
            echo '<div class="alert alert-warning" role="alert">El usuario no existe!</div>';
        }
    }
}

// Para realizar consulta, recordar que para while hace falta meterlo a un atributo, luego meter a mysqli_fetch_assoc($result)
// De vuelve el resultado de la consulta
function sqlSELECT($sql)
{
    try {
        //conexion
        $conn = conectar();

        //Ejecutar
        $result = $conn->query($sql);

        // Devolver el resultado
        return $result;

    } catch (Exception $e) {

        echo "Hay un fallo en la consulta: " . $e->getMessage();
    } finally {
        // Cerrar la conexión y liberar recursos
        $conn->close();
    }
}

// Sirve para las actualizacones de UPDATE
// Duelve true o false
function sqlUPDATE($sql)
{
    try {
        // Establecer conexión
        $conn = conectar();

        // Ejecutar consulta de actualización
        if ($conn->query($sql)) {
            // Verificar el número de filas afectadas
            if ($conn->affected_rows > 0) {
                // Si la actualización fue exitosa y se afectaron filas, retorna true
                return true;
            } else {
                // Si la actualización fue exitosa pero no se afectaron filas, retorna false
                return false;
            }
        } else {
            // Si la actualización falló, retorna false
            return false;
        }
    } catch (Exception $e) {
        // Lanzar error si falla
        echo "Error al actualizar registro: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $conn->close();
    }
}

// Sirve para las actualizaciones de INSET
// Duelve true o false
function sqlINSERT($sql)
{
    try {
        // Establecer conexión
        $conn = conectar();

        // Ejecutar consulta de inserción
        if ($conn->query($sql)) {
            // Verificar el número de filas afectadas
            if ($conn->affected_rows > 0) {
                // Si la inserción fue exitosa y se afectaron filas, retorna true
                return true;
            } else {
                // Si la inserción fue exitosa pero no se afectaron filas, retorna false
                return false;
            }
        } else {
            // Si la inserción falló, retorna false
            return false;
        }
    } catch (Exception $e) {
        // Lanzar error si falla
        echo "Error al insertar registro: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $conn->close();
    }
}


// Sirve para las eliminar una columna
// Duelve true o false
function sqlDELETE($sql)
{
    try {
        // Establecer conexión
        $conn = conectar();

        // Ejecutar consulta de eliminación
        if ($conn->query($sql)) {
            // Verificar el número de filas afectadas
            if ($conn->affected_rows > 0) {
                // Si la eliminación fue exitosa y se afectaron filas, retorna true
                return true;
            } else {
                // Si la eliminación fue exitosa pero no se afectaron filas, retorna false
                return false;
            }
        } else {
            // Si la eliminación falló, retorna false
            return false;
        }
    } catch (Exception $e) {
        // Lanzar error si falla
        echo "Error al eliminar registro: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $conn->close();
    }
}




?>