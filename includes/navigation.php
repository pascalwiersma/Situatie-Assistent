<header class="bg-primary text-white">
    <div class="container mx-auto flex items-center justify-between p-4 lg:p-3">
        <!-- Logo -->
        <a href="/" class="text-2xl font-bold leading-7">Situatie Assistent</a>

        <!-- Navigation Links (Hidden on Mobile) -->
        <nav class="hidden lg:flex space-x-4">
            <a href="/csd/" class="text-white">Situaties</a>
            <?php
            if ($_SESSION['isAdmin'] == 1) {
                echo '<a href="/admin/" class="text-white">Admin</a>';
            }
            ?>
            <a href="/uitloggen.php" class="text-white">Uitloggen</a>
        </nav>

        <!-- Mobile Menu Button -->
        <button class="lg:hidden focus:outline-none" id="mobileMenuButton">
            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div class="lg:hidden fixed inset-0 bg-primary bg-opacity-75 z-50 hidden" id="mobileMenu">
        <div class="flex justify-end p-4">
            <button class="text-white focus:outline-none" id="closeMobileMenuButton">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex flex-col items-center">
            <a href="/csd/" class="text-white py-2">Situaties</a>
            <a href="/admin/" class="text-white py-2">Admin</a>
        </div>
    </div>
</header>