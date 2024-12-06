<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="<?php echo home_url(); ?>" class="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                <svg class="w-8 h-8 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="text-xl md:text-2xl font-bold bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent">
                    AnonTalk
                </span>
            </a>
            
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container_class' => 'hidden md:flex items-center space-x-4',
                'menu_class' => 'flex items-center space-x-4',
                'fallback_cb' => false
            ));
            ?>
            
            <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
    
    <div id="mobile-menu" class="hidden md:hidden px-4 pt-2 pb-3 space-y-1">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'mobile',
            'container' => false,
            'menu_class' => 'space-y-1',
            'fallback_cb' => false
        ));
        ?>
    </div>
</nav>