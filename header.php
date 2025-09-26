<header class="d-flex align-items-center justify-content-between bg-white" style="padding-left:1.5rem;padding-right:1.5rem;padding-top:1rem;padding-bottom:1rem;border-bottom-width:4px;border-bottom-style:solid;border-bottom-color:#4f46e5;">
    <div class="d-flex align-items-center">
        <button @click="sidebarOpen = true" class="btn btn-outline-secondary d-lg-none">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </svg>
        </button>
        <?php 
        if (isset($_SESSION['nosearch']) && $_SESSION['nosearch'] == 1) { ?>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="get" class="ms-3">
                <div class="position-relative" style="margin-left:1rem;">
                    <button class="btn btn-link position-absolute top-0 start-0 ps-0" type="submit" style="display:flex;align-items:center;height:100%;">
                        <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </button>

                    <input class="form-control ps-5" style="width:16rem;border-radius:0.375rem;" type="text"
                    id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>" placeholder="Search">                
                </div>
            </form>
        <?php } ?>
    </div>

    <div class="d-flex align-items-center">
        <div x-data="{ dropdownOpen: false }" class="position-relative">
            <button @click="dropdownOpen = ! dropdownOpen"
                class="btn p-0 border-0 bg-transparent">
                <img class="rounded-circle shadow" style="width:32px;height:32px;object-fit:cover;"
                    src="getimages.php?image=<?php echo $portrait;?>&type=<?php echo PORTRAITS;?>"
                    alt="<?php echo $profile['username'];?>" title="<?php echo $profile['username'];?>">
            </button>

            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="position-fixed top-0 start-0 z-1 w-100 h-100"
                style="display: none;"></div>

            <div x-show="dropdownOpen"
                class="position-absolute end-0 z-2 mt-2 bg-white rounded shadow"
                style="display: none; width:12rem; overflow:hidden;">
                <a href="#" class="dropdown-item px-3 py-2 d-block text-decoration-none">Profile</a>
                <a href="#" class="dropdown-item px-3 py-2 d-block text-decoration-none">Products</a>
                <a href="./logout.php" class="dropdown-item px-3 py-2 d-block text-decoration-none">Logout</a>
            </div>
        </div>
    </div>
</header>