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
    <div class="w-100">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <?php      
            include_once "processgenreslist.php";    
            include_once "processgenre.php";
            include_once "deletegenre.php";
        ?>
        <div x-data="{ sidebarOpen: false }" class="d-flex" style="height:100vh; background-color:#e5e7eb;">
            <div :class="sidebarOpen ? 'd-block' : 'd-none'" @click="sidebarOpen = false" class="position-fixed top-0 start-0 w-100 h-100" style="z-index:20; background-color:rgba(0,0,0,0.5);"></div>
        
            <div :class="sidebarOpen ? 'translate-x-0' : 'translate-x-100'" class="position-fixed top-0 start-0 h-100 overflow-auto bg-dark text-white p-3" style="width:256px; z-index:30; transform: translateX(-100%); transition: transform 0.3s ease-out;">
                <div class="d-flex align-items-center justify-content-center mt-4">
                    <div class="d-flex align-items-center">
                        <svg style="width:32px;height:32px;" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z" fill="#4C51BF" stroke="#4C51BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z" fill="white"></path>
                        </svg>
                        
                        <span class="ms-2 h4 fw-semibold text-white">Inventario</span>
                    </div>
                </div>
                <?php $_SESSION['highlight'] = GENRES; 
                include_once "navside.php"; ?>                
            </div>
            <div class="flex-grow-1 overflow-hidden" style="margin-left:256px;">
                <?php 
                $_SESSION['nosearch'] = 1;
                include_once "header.php"; ?>
                <main class="flex-grow-1 overflow-x-hidden overflow-y-auto" style="background-color:#e5e7eb;">
                    <div class="container px-4 py-4">
                        <h3 class="h3 text-secondary">Géneros</h3>
        
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="d-flex align-items-center px-3 py-4 bg-white rounded shadow-sm">
                                    <div class="p-3 rounded-circle me-3" style="background-color:#4f46e5; opacity:0.75;">
                                        <svg class="text-white" style="width:32px;height:32px;" viewBox="0 0 28 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.2 9.08889C18.2 11.5373 16.3196 13.5222 14 13.5222C11.6804 13.5222 9.79999 11.5373 9.79999 9.08889C9.79999 6.64043 11.6804 4.65556 14 4.65556C16.3196 4.65556 18.2 6.64043 18.2 9.08889Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M25.2 12.0444C25.2 13.6768 23.9464 15 22.4 15C20.8536 15 19.6 13.6768 19.6 12.0444C19.6 10.4121 20.8536 9.08889 22.4 9.08889C23.9464 9.08889 25.2 10.4121 25.2 12.0444Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M19.6 22.3889C19.6 19.1243 17.0927 16.4778 14 16.4778C10.9072 16.4778 8.39999 19.1243 8.39999 22.3889V26.8222H19.6V22.3889Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M8.39999 12.0444C8.39999 13.6768 7.14639 15 5.59999 15C4.05359 15 2.79999 13.6768 2.79999 12.0444C2.79999 10.4121 4.05359 9.08889 5.59999 9.08889C7.14639 9.08889 8.39999 10.4121 8.39999 12.0444Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M22.4 26.8222V22.3889C22.4 20.8312 22.0195 19.3671 21.351 18.0949C21.6863 18.0039 22.0378 17.9556 22.4 17.9556C24.7197 17.9556 26.6 19.9404 26.6 22.3889V26.8222H22.4Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M6.64896 18.0949C5.98058 19.3671 5.59999 20.8312 5.59999 22.3889V26.8222H1.39999V22.3889C1.39999 19.9404 3.2804 17.9556 5.59999 17.9556C5.96219 17.9556 6.31367 18.0039 6.64896 18.0949Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="h4 fw-semibold mb-1" style="color:#374151;"><?php echo $totalGenres; ?></h4>
                                        <div class="text-muted">Total géneros</div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="mt-8">
        
                        </div>
        
                        <div class="flex flex-col mt-8">
                            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                <div
                                    class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                                    <ul id="infinte-scroll" class="list-group" style="max-height:260px; width:320px; overflow-y:auto;">
                                            <?php while ($row = $resultsGenres->fetch_assoc()) {?>
                                                <li class="list-group-item d-flex align-items-center">
                                                    <span class="me-2 py-1">
                                                            <img class="rounded-circle" style="width:40px;height:40px;object-fit:cover;"
                                                                src="getimages.php?image=<?php echo $row['image'];?>&type=<?php echo GENRES;?>"
                                                                alt="<?php echo $row['genre'];?>" title="<?php echo $row['genre'];?>">
                                                    </span>
                                                    <span class="me-auto py-1"><?php echo $row['genre']; ?></span>
                                                    <span class="ms-3 py-1"><a href="./genres.php?delete=<?php echo $row['id'] ?>&csrf_token=<?php echo $_SESSION['csrf_token']; }?>" class="link-danger" id="delete" alt="borrar" title="borrar">Eliminar</a></span>                                            
                                                </li>
                                            <?php } 
                                            ?>
                                    </ul>
                                    <div class="pt-1">
                                        <form class="w-100 p-1" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="POST">
                                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                            <div class="row g-2 align-items-end">
                                              <div class="col-12 col-sm-6 col-md-5 col-lg-4">
                                                <label class="form-label" for="genre">Género</label>
                                                <input class="form-control <?php if (!empty($messages['genre'])) echo 'is-invalid'; ?>" id="genre" name="genre" value="<?php echo isset($_POST['genre']) ? htmlspecialchars($_POST['genre']) : (isset($row['genre']) ? $row['genre'] : "");?>" type="text" placeholder="Estrategia">
                                                <div class="invalid-feedback"><?php echo $messages['genre'] ?></div>
                                              </div>
                                              <div class="col-12 col-sm-6 col-md-5 col-lg-4">
                                                <?php include_once "imageinput.php" ?>
                                              </div>
                                              <div class="col-12 col-md-2">
                                                <button class="btn btn-primary w-100" type="submit">Añadir</button>
                                              </div>
                                            </div>                       
                                        </form>
                                    </div>
                                </div>           
                            </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>
    </div>
    <script type="application/javascript" src="./js/delete.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
