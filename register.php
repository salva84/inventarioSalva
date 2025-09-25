<?php
session_start(); // Iniciar sesión antes que cualquier output
ob_start(); // Iniciar buffer de salida para evitar problemas con headers
require_once "opts.php";
require_once "helpers.php";
require_once "database.php";
require_once "session.php";
if (isset($_POST['sent'])) {
  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('Location: ./error.php');
    exit();
  }
  $username = filtering($_POST['username']);
  $password = $_POST['password'];
  $repassword = $_POST['repassword'];
  $result = validateUserName($username);
  if (isset($usernameErrors[$result])) { 
    $messages['username'] = $usernameErrors[$result];
  }
  if (empty($messages['username'])) {
    $connection = createConnection($connectionData);
    $result = checkIfUserExists($connection,$username);
    if (isset($usernameErrors[$result])) $messages['username'] = $usernameErrors[$result];
  }
  $result = checkPassword($password);
  if (isset($passwordErrors[$result])) $messages['password'] = $passwordErrors[$result];
  $result = checkRepassword($password, $repassword);
  if (isset($repasswordErrors[$result])) $messages['repassword'] = $repasswordErrors[$result];
  if (empty($messages['username']) && empty($messages['password']) && empty($messages['repassword'])) {
    $result = uploadFile(PORTRAITSDIR);
    if (is_int($result) && isset($imageErrors[$result])) {
      $messages["image"] = $imageErrors[$result];
    } else {
      // Si no hay error, usar una imagen por defecto si no se subió ninguna
      if ($result === FILERROR) {
        $result = 'default.jpg'; // Imagen por defecto
      }
    }
  }
  else {
    $messages['image'] = $imageErrors[IMAGEERROR];
  }
  if (empty($messages['username']) && empty($messages['password']) && empty($messages['repassword'])
  && empty($messages['image'])) {
    $hash = encryptPassword($password);
    setUser($connection, $username, $hash, $result);
    $connection->close();
    // Redirigir al usuario al login
    header('Location: ./index.php');
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
        <div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-6">
          <div class="card shadow-sm">
            <div class="card-body p-4">
              <h1 class="h4 mb-3 text-center">Registro</h1>
              <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
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
                <div class="mb-3">
                  <label for="repassword" class="form-label">Repetir contraseña</label>
                  <input id="repassword" name="repassword" type="password" class="form-control <?php if (!empty($messages['repassword'])) echo 'is-invalid'; ?>" placeholder="••••••••">
                  <div class="invalid-feedback"><?php echo $messages['repassword']; ?></div>
                </div>
                <div class="mb-3">
                  <label for="image" class="form-label">Retrato</label>
                  <input id="image" name="image" type="file" class="form-control">
                  <div class="form-text">PNG, JPG, JPEG (MAX.1000x1000px).</div>
                  <div class="text-danger small"><?php echo $messages['image']; ?></div>
                </div>
                <input type="hidden" name="sent" value="1">
                <div class="d-flex justify-content-end align-items-center">
                  <button class="btn btn-primary" type="submit">Registro</button>
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