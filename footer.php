<footer id="site-footer">
    <div class="container">
        <div class="footer-inner">
            <p>
                &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                &mdash; <?php esc_html_e( 'Agente Digitalizador acreditado Kit Digital', 'pyme-starter' ); ?>
            </p>
            <p>
                <?php
                $phone = get_theme_mod( 'pyme_phone', '+34 600 000 000' );
                $email = get_theme_mod( 'pyme_email', 'info@mipyme.es' );
                ?>
                <a href="tel:<?php echo esc_attr( preg_replace( '/\s/', '', $phone ) ); ?>">
                    <?php echo esc_html( $phone ); ?>
                </a>
                &nbsp;&bull;&nbsp;
                <a href="mailto:<?php echo esc_attr( $email ); ?>">
                    <?php echo esc_html( $email ); ?>
                </a>
            </p>
            <p style="font-size:.8rem;opacity:.6;">
                <?php
                printf(
                    esc_html__( 'Proyecto cofinanciado por la Unión Europea — Next Generation EU &bull; CIF: %s', 'pyme-starter' ),
                    esc_html( get_theme_mod( 'pyme_cif', 'B12345678' ) )
                );
                ?>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
