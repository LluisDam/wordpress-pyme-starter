<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header">
    <div class="container">
        <div class="header-inner">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
                <?php bloginfo( 'name' ); ?>
                <span class="kit-badge">&#9733; Kit Digital</span>
            </a>

            <nav id="site-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'pyme-starter' ); ?>">
                <?php wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => '',
                    'container'      => false,
                    'fallback_cb'    => function() { ?>
                        <ul>
                            <li><a href="#services"><?php esc_html_e( 'Servicios', 'pyme-starter' ); ?></a></li>
                            <li><a href="#kit-digital">Kit Digital</a></li>
                            <li><a href="#contact"><?php esc_html_e( 'Contacto', 'pyme-starter' ); ?></a></li>
                        </ul>
                    <?php },
                ) ); ?>
            </nav>

            <a href="#contact" class="btn btn-primary" style="font-size:.875rem;padding:.5rem 1.25rem;">
                <?php esc_html_e( 'Solicitar Kit Digital', 'pyme-starter' ); ?>
            </a>
        </div>
    </div>
</header>
