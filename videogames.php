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
            include_once "processvideogameslist.php";
            include_once "deletevideogame.php";
            // Bypass de datos para desarrollo sin BD
            if (isset($_GET['bypass']) && $_GET['bypass'] == '1') {
                $countVideogames = $countVideogames ?? 0;
                $sumVideogames = $sumVideogames ?? 0;
                $lastAdquisition = $lastAdquisition ?? '';
                if (!isset($resultsVideogames)) { $resultsVideogames = null; }
                // Defaults de paginación
                $currentPage = $currentPage ?? 1;
                $totalPages = $totalPages ?? 1;
                $next = $next ?? 1;
                $prev = $prev ?? 1;
            }
        ?>
        <div x-data="{ sidebarOpen: false }" class="d-flex" style="height:100vh; background-color:#e5e7eb;">
            <div :class="sidebarOpen ? 'd-block' : 'd-none'" @click="sidebarOpen = false" class="position-fixed top-0 start-0 w-100 h-100" style="z-index:20; background-color:rgba(0,0,0,0.5);"></div>
        
            <div :class="sidebarOpen ? 'translate-x-0' : 'translate-x-100'" class="position-fixed top-0 start-0 h-100 overflow-auto bg-dark text-white p-3" style="width:256px; z-index:30; transition: transform 0.3s ease-out;">
                <div class="d-flex align-items-center justify-content-center mt-4">
                    <div class="d-flex align-items-center">
                        <svg style="width:48px;height:48px;" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z" fill="#4C51BF" stroke="#4C51BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z" fill="white"></path>
                        </svg>
                        
                        <span class="ms-2 h3 fw-semibold text-white">Inventario</span>
                    </div>
                </div>
                <?php $_SESSION['highlight'] = VIDEOGAMES; 
                $_SESSION['urlform'] = $forms[VIDEOGAMES][0];
                $_SESSION['tagform'] = $forms[VIDEOGAMES][1];
                include_once "navside.php"; ?>                
            </div>
            <div class="d-flex flex-column flex-grow-1 overflow-hidden" style="margin-left:256px;">
                <?php 
                $_SESSION['nosearch'] = 1;
                include_once "header.php"; ?>
                <main class="flex-grow-1 overflow-x-hidden overflow-y-auto" style="background-color:#e5e7eb;">
                    <div class="container" style="padding-left:1.5rem;padding-right:1.5rem;padding-top:2rem;padding-bottom:2rem;margin-left:auto;margin-right:auto;">
                        <h3 style="font-size:1.875rem;line-height:2.25rem;font-weight:500;color:#374151;margin:0;">Inventario</h3>
        
                        <div class="mt-4">
                            <div class="row g-4">
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="d-flex align-items-center bg-white shadow-sm" style="padding-left:1.25rem;padding-right:1.25rem;padding-top:1.5rem;padding-bottom:1.5rem;border-radius:0.375rem;">
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
        
                                        <div class="ms-3">
                                            <h4 class="h4 fw-semibold mb-1" style="color:#374151;"><?php echo $countVideogames; ?></h4>
                                            <div class="text-muted">Total videojuegos</div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="d-flex align-items-center bg-white shadow-sm" style="padding-left:1.25rem;padding-right:1.25rem;padding-top:1.5rem;padding-bottom:1.5rem;border-radius:0.375rem;">
                                        <div class="p-3 rounded-circle me-3" style="background-color:#ea580c; opacity:0.75;">
                                            <svg class="text-white" style="width:32px;height:32px;" viewBox="0 0 28 28" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.19999 1.4C3.4268 1.4 2.79999 2.02681 2.79999 2.8C2.79999 3.57319 3.4268 4.2 4.19999 4.2H5.9069L6.33468 5.91114C6.33917 5.93092 6.34409 5.95055 6.34941 5.97001L8.24953 13.5705L6.99992 14.8201C5.23602 16.584 6.48528 19.6 8.97981 19.6H21C21.7731 19.6 22.4 18.9732 22.4 18.2C22.4 17.4268 21.7731 16.8 21 16.8H8.97983L10.3798 15.4H19.6C20.1303 15.4 20.615 15.1004 20.8521 14.6261L25.0521 6.22609C25.2691 5.79212 25.246 5.27673 24.991 4.86398C24.7357 4.45123 24.2852 4.2 23.8 4.2H8.79308L8.35818 2.46044C8.20238 1.83722 7.64241 1.4 6.99999 1.4H4.19999Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M22.4 23.1C22.4 24.2598 21.4598 25.2 20.3 25.2C19.1403 25.2 18.2 24.2598 18.2 23.1C18.2 21.9402 19.1403 21 20.3 21C21.4598 21 22.4 21.9402 22.4 23.1Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M9.1 25.2C10.2598 25.2 11.2 24.2598 11.2 23.1C11.2 21.9402 10.2598 21 9.1 21C7.9402 21 7 21.9402 7 23.1C7 24.2598 7.9402 25.2 9.1 25.2Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </div>
        
                                        <div class="ms-3">
                                            <h4 class="h4 fw-semibold mb-1" style="color:#374151;"><?php echo $sumVideogames;?></h4>
                                            <div class="text-muted">Gasto total</div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="d-flex align-items-center bg-white shadow-sm" style="padding-left:1.25rem;padding-right:1.25rem;padding-top:1.5rem;padding-bottom:1.5rem;border-radius:0.375rem;">
                                        <div class="p-3 rounded-circle me-3" style="background-color:#db2777; opacity:0.75;">
                                            <svg class="text-white" style="width:32px;height:32px;" viewBox="0 0 28 28" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.99998 11.2H21L22.4 23.8H5.59998L6.99998 11.2Z" fill="currentColor"
                                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round"></path>
                                                <path
                                                    d="M9.79999 8.4C9.79999 6.08041 11.6804 4.2 14 4.2C16.3196 4.2 18.2 6.08041 18.2 8.4V12.6C18.2 14.9197 16.3196 16.8 14 16.8C11.6804 16.8 9.79999 14.9197 9.79999 12.6V8.4Z"
                                                    stroke="currentColor" stroke-width="2"></path>
                                            </svg>
                                        </div>
        
                                        <div class="ms-3">
                                            <h4 class="h4 fw-semibold mb-1" style="color:#374151;"><?php echo $lastAdquisition; ?></h4>
                                            <div class="text-muted">Última adquisición</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="mt-8">
        
                        </div>
        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" style="margin:0;">
                                <thead>
                                    <tr>
                                        <th style="padding:0.75rem 1.5rem;font-size:0.75rem;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;color:#6b7280;background-color:#F9FAFB;border-bottom:1px solid #e5e7eb;text-align:left;">Nombre</th>
                                        <th style="padding:0.75rem 1.5rem;font-size:0.75rem;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;color:#6b7280;background-color:#F9FAFB;border-bottom:1px solid #e5e7eb;text-align:left;">Precio</th>
                                        <th style="padding:0.75rem 1.5rem;font-size:0.75rem;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;color:#6b7280;background-color:#F9FAFB;border-bottom:1px solid #e5e7eb;text-align:left;">Fecha Adquisición</th>
                                        <th style="padding:0.75rem 1.5rem;background-color:#F9FAFB;border-bottom:1px solid #e5e7eb;"></th>
                                        <th style="padding:0.75rem 1.5rem;background-color:#F9FAFB;border-bottom:1px solid #e5e7eb;"></th>
                                        <th style="padding:0.75rem 1.5rem;background-color:#F9FAFB;border-bottom:1px solid #e5e7eb;"></th>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    <?php if ($resultsVideogames) { while ($row = $resultsVideogames->fetch_assoc()) {?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="rounded-circle" style="width:40px;height:40px;object-fit:cover;"
                                                        src="getimages.php?image=<?php echo $row['image'];?>&type=<?php echo VIDEOGAMES;?>"
                                                        alt="<?php echo $row['videogamename'];?>" title="<?php echo $row['videogamename'];?>">
                                                </div>
                                                <div class="ms-3">
                                                    <div class="fw-medium"><?php echo $row['videogamename'];?></div>
                                                    <div class="text-muted small"><?php echo $row['maker'];?></div>
                                                </div>
                                            </div>
                                        </td>
        
                                        <td><?php echo $row['price'];?></td>
        
                                        <td><?php echo date('d-m-Y',strtotime($row['dateadquisition']));?></td>
                                        <td class="text-end">
                                            <a href="./viewvideogame.php?videogame=<?php echo $row['id']; ?>" class="link-primary">Ver</a>  
                                        </td>
                                        <td class="text-end">
                                            <a href="./formvideogame.php?videogame=<?php echo $row['id']; ?>" class="link-primary">Editar</a>
                                        </td>
                                        <td class="text-end">
                                            <a href="./videogames.php?delete=<?php echo $row['id']; ?>&csrf_token=<?php echo $_SESSION['csrf_token']; ?>" class="link-danger" id="delete">Borrar</a>
                                        </td>                                                    
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                            <?php include_once "pagination.php" ?>              
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