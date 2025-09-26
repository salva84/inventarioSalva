<?php
require_once "database.php";
require_once "helpers.php";
require_once "session.php";
require_once "opts.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  
</head>
<body style="background: #edf2f7;" class="d-flex align-items-center justify-content-center min-vh-100">
    <?php include_once "processconsole.php"; ?>  
    <div class="card shadow-sm" style="max-width:720px;border-radius:0.5rem;">
        <img src="getimages.php?image=<?php echo $row['image'];?>&type=<?php echo CONSOLES;?>" alt="<?php echo $row['consolename'];?>" title="<?php echo $row['consolename'];?>" class="card-img-top" style="object-fit:cover;max-height:320px;">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="h5 mb-1"><?php echo $row['maker'];?> <?php echo $row['consolename'];?></h4>
                    <p class="text-muted small mb-2"><?php echo $row['comment'];?></p>
                    <small class="text-muted">Fecha adquisición: <?php echo date('d-m-Y',strtotime($row['dateadquisition']));?></small>
                </div>
                <div class="ms-3">
                    <img class="rounded-circle shadow" style="width:64px;height:64px;object-fit:cover;" src="getimages.php?image=<?php echo $profile['image'];?>&type=<?php echo PORTRAITS;?>"
                        alt="<?php echo $profile['username'];?>" title="<?php echo $profile['username'];?>">
                </div>            
            </div>
            <div class="mt-3 text-end">
                <button type="button" id="volver" class="btn btn-primary">Volver al listado</button>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        document.getElementById("volver").addEventListener("click", function() {
            window.location.href = './consoles.php';
        });
    </script>      
</body>
</html>