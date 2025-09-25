<?php
session_start(); // Iniciar sesión antes que cualquier output
ob_start(); // Iniciar buffer de salida para evitar problemas con headers
require_once "opts.php";
require_once "helpers.php";
require_once "database.php";
require_once "session.php";

if (isset($_POST['sent'])) {
  $username = filtering($_POST['username']);
  $password = $_POST['password'];
  $result = validateUserName($username);
  if (isset($usernameErrors[$result])) $messages['username'] = $usernameErrors[$result];
  $result = checkPassword($password);
  if (isset($passwordErrors[$result])) $messages['password'] = $passwordErrors[$result];
  $found = false;
  if (empty($messages['username']) && empty($messages['password'])) {
    $connection = createConnection($connectionData);
    $pwd_hashed = getHash($connection, $username);
    $found = checkHash($password, $pwd_hashed);
  }  
  if ($found) {
    $id = getId($connection, $username);
    $_SESSION['user'] = base64_encode($id);
    // Redirigir al usuario al listado de consolas
    header('Location: ./consoles.php');
    exit(); // Es importante llamar a exit después de una redirección
  }
  else {
    // Redirigir al usuario al listado de consolas
    header('Location: ./index.php?error=1');
    exit(); // Es importante llamar a exit después de una redirección
  }
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-sm">
            <div class="card-body p-4">
              <h1 class="h4 mb-3 text-center">Login</h1>
              <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger py-2 mb-3">¿Seguro que estás registrado? No se ha encontrado tu perfil.</div>
              <?php } ?>
              <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                  <label for="username" class="form-label">Nombre de usuario</label>
                  <input id="username" name="username" type="text" class="form-control <?php if (!empty($messages['username'])) echo 'is-invalid'; ?>" value="<?php if (!empty($_POST['username'])) echo $_POST['username'];?>" placeholder="Username">
                  <div class="invalid-feedback"><?php echo $messages['username']; ?></div>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Contraseña</label>
                  <input id="password" name="password" type="password" class="form-control <?php if (!empty($messages['password'])) echo 'is-invalid'; ?>" placeholder="••••••••">
                  <div class="invalid-feedback"><?php echo $messages['password']; ?></div>
                </div>
                <input type="hidden" name="sent" value="1">
                <div class="d-flex justify-content-between align-items-center">
                  <button class="btn btn-primary" type="submit">Login</button>
                  <a class="text-decoration-none" href="./register.php">Registro</a>
                </div>
              </form>
            </div>
          </div>
          <p class="text-center text-muted mt-3 mb-0 small">&copy;<?php echo date('Y'); ?> Antonio Corp. All rights reserved.</p>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>