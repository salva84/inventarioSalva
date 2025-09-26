<?php $highlight = $_SESSION['highlight']; ?>
<nav class="mt-0" style="margin-top:2.5rem;">
    <?php 
        // Helper closures for styles
        $baseItemStyle = 'display:flex;align-items:center;padding-left:1.5rem;padding-right:1.5rem;padding-top:0.5rem;padding-bottom:0.5rem;margin-top:1rem;text-decoration:none;border-radius:0.375rem;';
        $inactiveText = 'color:#6b7280;'; // tailwind text-gray-500
        $activeText = 'color:#f3f4f6;';   // tailwind text-gray-100
        $activeBg = 'background-color:rgba(55,65,81,0.25);'; // gray-700 @ 25%
    ?>
    <a href="./consoles.php"
       class="nav-link p-0"
       style="<?php echo $baseItemStyle; echo ($highlight == CONSOLES) ? ($activeText.$activeBg) : $inactiveText; ?>"
       onmouseover="this.style.backgroundColor='rgba(55,65,81,0.25)'; this.style.color='#f3f4f6';"
       onmouseout="<?php if ($highlight == CONSOLES) { ?>this.style.backgroundColor='rgba(55,65,81,0.25)'; this.style.color='#f3f4f6';<?php } else { ?>this.style.backgroundColor=''; this.style.color='#6b7280';<?php } ?>">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px;height:24px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
        </svg>
        <span class="ms-2" style="margin-left:0.75rem;">Consolas</span>
    </a>

    <a href="./videogames.php"
       class="nav-link p-0"
       style="<?php echo $baseItemStyle.$inactiveText; ?>"
       onmouseover="this.style.backgroundColor='rgba(55,65,81,0.25)'; this.style.color='#f3f4f6';"
       onmouseout="this.style.backgroundColor=''; this.style.color='#6b7280';">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px;height:24px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
        </svg>
        <span class="ms-2" style="margin-left:0.75rem;">Videojuegos</span>
    </a>

    <a href="./genres.php"
       class="nav-link p-0"
       style="<?php echo $baseItemStyle; echo ($highlight == GENRES) ? ($activeText.$activeBg) : $inactiveText; ?>"
       onmouseover="this.style.backgroundColor='rgba(55,65,81,0.25)'; this.style.color='#f3f4f6';"
       onmouseout="<?php if ($highlight == GENRES) { ?>this.style.backgroundColor='rgba(55,65,81,0.25)'; this.style.color='#f3f4f6';<?php } else { ?>this.style.backgroundColor=''; this.style.color='#6b7280';<?php } ?>">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px;height:24px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        <span class="ms-2" style="margin-left:0.75rem;">Generos</span>
    </a>
    <?php if ($highlight !== GENRES) { ?>
    <a href="./<?php echo $_SESSION['urlform']; ?>"
       class="nav-link p-0"
       style="<?php echo $baseItemStyle; echo ($highlight == FORM) ? ($activeText.$activeBg) : $inactiveText; ?>"
       onmouseover="this.style.backgroundColor='rgba(55,65,81,0.25)'; this.style.color='#f3f4f6';"
       onmouseout="<?php if ($highlight == FORM) { ?>this.style.backgroundColor='rgba(55,65,81,0.25)'; this.style.color='#f3f4f6';<?php } else { ?>this.style.backgroundColor=''; this.style.color='#6b7280';<?php } ?>">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px;height:24px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
        <span class="ms-2" style="margin-left:0.75rem;">Añadir <?php echo $_SESSION['tagform']; ?></span>
    </a>
    <?php } ?>
</nav>