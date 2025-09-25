<?php
require_once "opts.php";
require_once "helpers.php";
require_once "database.php";
require_once "session.php";
require_once "profile.php";
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background: #edf2f7;">
    <div class="w-full">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <?php       
            include_once "processvideogame.php";           
            if (!empty($_POST)) {
                $row['videogamename'] = $_POST['videogamename'];
                $row['price'] = $_POST['price'];
                $row['maker'] = $_POST['maker'];
                $row['dateadquisition'] = $_POST['dateadquisition'];
                $row['comment'] = $_POST['comment'];
            } 
        ?>
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
        
            <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <svg class="w-12 h-12" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z" fill="#4C51BF" stroke="#4C51BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z" fill="white"></path>
                        </svg>
                        
                        <span class="mx-2 text-2xl font-semibold text-white">Inventario</span>
                    </div>
                </div>        
                <?php  $_SESSION['highlight'] = FORM; 
                $_SESSION['urlform'] = $forms[VIDEOGAMES][0];
                $_SESSION['tagform'] = $forms[VIDEOGAMES][1];
                include_once "navside.php"; ?> 
            </div>
            <div class="flex flex-col flex-1 overflow-hidden">
                <?php 
                $_SESSION['nosearch'] = 0;
                include_once "header.php"; ?>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                    <div class="container py-4">
                        <h3 class="h3 text-secondary">Añadir videojuego</h3>
                        <div class="mt-8">
                        </div>
                        <div class="flex flex-col mt-8">
                            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                <div
                                    class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-300 shadow sm:rounded-lg">
                                    <form class="w-100 p-2" action="<?php echo $_SERVER["PHP_SELF"];?>?videogame=<?php echo isset($_GET['videogame']) ? $_GET['videogame']  : "";?>" enctype="multipart/form-data" method="POST">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                              <label class="form-label" for="videogamename">Nombre</label>
                                              <input class="form-control <?php if (!empty($messages['videogamename'])) echo 'is-invalid'; ?>" id="videogamename" name="videogamename" value="<?php echo isset($row['videogamename']) ? $row['videogamename'] : "";?>" type="text" placeholder="The Legend of Zelda">
                                              <div class="invalid-feedback"><?php echo $messages['videogamename'] ?></div>
                                            </div>
                                            <div class="col-md-4">
                                              <label class="form-label" for="price">Precio adquisición</label>
                                              <input class="form-control <?php if (!empty($messages['price'])) echo 'is-invalid'; ?>" id="price" name="price" type="number" min="0" max="100000" value="<?php echo isset($row['price']) ? $row['price'] : "";?>" placeholder="10">
                                              <div class="invalid-feedback"><?php echo $messages['price'] ?></div>
                                            </div>
                                            <div class="col-md-4">
                                              <label class="form-label" for="maker">Desarrollador</label>
                                              <input class="form-control <?php if (!empty($messages['maker'])) echo 'is-invalid'; ?>" id="maker" name="maker" value="<?php echo isset($row['maker']) ? $row['maker'] : "";?>" type="text" placeholder="Nintendo">
                                              <div class="invalid-feedback"><?php echo $messages['maker'] ?></div>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col-12">
                                                <?php include_once "imageinput.php"?>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="dateadquisition">Fecha adquisición</label>
                                                <input class="form-control <?php if (!empty($messages['dateadquisition'])) echo 'is-invalid'; ?>" id="dateadquisition" name="dateadquisition" value="<?php echo isset($row['dateadquisition']) ? date('Y-m-d',strtotime($row['dateadquisition'])) : "";?>" type="date" placeholder="">                                                
                                                <div class="invalid-feedback"><?php echo $messages['dateadquisition']; ?></div>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label" for="comment">Comentarios</label>
                                                <textarea class="form-control <?php if (!empty($messages['comment'])) echo 'is-invalid'; ?>" id="comment" name="comment"  placeholder="Comentarios"><?php echo isset($row['comment']) ? $row['comment'] : ""; ?></textarea>
                                                <div class="invalid-feedback"><?php echo $messages['comment']; ?></div>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="consoleid">Consola</label>
                                                <select id="consoleid" name="consoleid" class="form-select <?php if (!empty($messages['consoleid'])) echo 'is-invalid'; ?>">    
                                                    <?php foreach ($consoles as $console) { $selectedConsole = isset($_POST['consoleid']) ? intval($_POST['consoleid']) : (isset($row['consoleid']) ? intval($row['consoleid']) : null); ?>
                                                        <option value="<?php echo htmlspecialchars($console['id']);?>" <?php if ($selectedConsole !== null && $selectedConsole == $console['id']) { echo "selected"; }?>><?php echo htmlspecialchars($console['consolename']); ?></option>
                                                    <?php } ?>
                                                </select>                                               
                                                <div class="invalid-feedback"><?php echo $messages['consoleid']; ?></div>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label" for="genreid">Género</label>
                                                <select id="genreid" name="genreid" class="form-select <?php if (!empty($messages['genreid'])) echo 'is-invalid'; ?>">    
                                                    <?php foreach ($genres as $genre) { $selectedGenre = isset($_POST['genreid']) ? intval($_POST['genreid']) : (isset($row['genreid']) ? intval($row['genreid']) : null); ?>
                                                        <option value="<?php echo htmlspecialchars($genre['id']);?>" <?php if ($selectedGenre !== null && $selectedGenre == $genre['id']) { echo "selected"; }?>><?php echo htmlspecialchars($genre['genre']); ?></option>
                                                    <?php } ?>
                                                </select>  
                                                <div class="invalid-feedback"><?php echo $messages['genreid']; ?></div>                                                
                                            </div>
                                        </div>                                        
                                        <?php if (isset($row['id'])) { ?><input type="hidden" name="videogameid" value="<?php echo $row['id']; ?>"><?php } ?>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button class="btn btn-primary" type="submit">
                                            <?php if (isset($row['id'])) { ?>Actualizar<?php } else { ?>Añadir<?php } ?>
                                            </button>       
                                        </div>                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
