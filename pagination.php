<?php 
    if (isset($totalPages) && $totalPages > 1) { 
        $currentPage = isset($currentPage) ? $currentPage : 1;
        $lastPage = ceil($currentPage/PAGESPERPAGINATION)*PAGESPERPAGINATION;
        $initPage = $lastPage - (PAGESPERPAGINATION-1);
    ?>
    <nav aria-label="Page navigation example" class="mt-3">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <?php if ($currentPage == 1) { ?>
                <span class="page-link disabled">Anterior</span>
                <?php } else { ?>
                <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $prev; ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : "";?>">Anterior</a>        
                <?php } ?>
            </li>
            <?php while ($initPage <= $lastPage) { 
                    if ($initPage > $totalPages) break;
                    if ($initPage == $currentPage) { 
                ?>
                <li class="page-item active" aria-current="page">
                    <span class="page-link"><?php echo $initPage; ?></span>
                </li>
                <?php } else { ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $initPage; ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : "";?>"><?php echo $initPage; ?></a>
                </li>
                <?php } ?>
            <?php   $initPage++; 
                    } ?>
            <li class="page-item">
            <?php if ($currentPage == $totalPages) { ?>
                <span class="page-link disabled">Siguiente</span>
            <?php } else { ?>
                <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $next; ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : "";?>">Siguiente</a>        
            <?php } ?>                                        
            </li>
        </ul>
    </nav>
<?php } ?>