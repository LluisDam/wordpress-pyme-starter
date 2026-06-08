<?php
/**
 * Main template — one-page layout for Pyme Starter
 *
 * @package PymeStarter
 */
get_header(); ?>

<!-- ============================================================
     HERO
============================================================ -->
<main id="main-content">
<section id="hero">
    <div class="container">
        <span class="hero-badge">&#9733; <?php esc_html_e( 'Agente Digitalizador Acreditado', 'pyme-starter' ); ?></span>
        <h1>
            <?php esc_html_e( 'Digitaliza tu empresa con', 'pyme-starter' ); ?><br>
            <span><?php esc_html_e( 'hasta 12.000 € del Kit Digital', 'pyme-starter' ); ?></span>
        </h1>
        <p>
            <?php esc_html_e( 'Te ayudamos a solicitar la subvención, elegir las soluciones y llevar la transformación digital de tu pyme de principio a fin.', 'pyme-starter' ); ?>
        </p>
        <div class="hero-buttons">
            <a href="#contact" class="btn btn-primary">
                <?php esc_html_e( 'Solicitar asesoramiento gratuito', 'pyme-starter' ); ?>
            </a>
            <a href="#kit-digital" class="btn btn-outline">
                <?php esc_html_e( '¿Cuánto me corresponde?', 'pyme-starter' ); ?>
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     SERVICES
============================================================ -->
<section id="services">
    <div class="container">
        <div class="section-header">
            <h2><?php esc_html_e( 'Nuestros Servicios', 'pyme-starter' ); ?></h2>
            <p><?php esc_html_e( 'Soluciones digitales homologadas para el programa Kit Digital', 'pyme-starter' ); ?></p>
        </div>
        <div class="services-grid">
            <?php
            $services = array(
                array( 'icon' => '&#127760;', 'title' => __( 'Presencia Web', 'pyme-starter' ),        'desc' => __( 'Web responsive, dominio y hosting gestionado.', 'pyme-starter' ) ),
                array( 'icon' => '&#128722;', 'title' => __( 'Comercio Electrónico', 'pyme-starter' ), 'desc' => __( 'Tienda online integrada con pasarela de pago.', 'pyme-starter' ) ),
                array( 'icon' => '&#128241;', 'title' => __( 'Redes Sociales', 'pyme-starter' ),       'desc' => __( 'Gestión de RRSS, contenidos y campañas.', 'pyme-starter' ) ),
                array( 'icon' => '&#128101;', 'title' => __( 'CRM / Clientes', 'pyme-starter' ),       'desc' => __( 'Sistema de seguimiento de clientes y ventas.', 'pyme-starter' ) ),
                array( 'icon' => '&#128202;', 'title' => __( 'Business Intelligence', 'pyme-starter' ),'desc' => __( 'Dashboards y analítica de negocio en tiempo real.', 'pyme-starter' ) ),
                array( 'icon' => '&#128274;', 'title' => __( 'Ciberseguridad', 'pyme-starter' ),       'desc' => __( 'Protección antivirus, VPN y copias de seguridad.', 'pyme-starter' ) ),
            );
            foreach ( $services as $s ) : ?>
            <div class="service-card">
                <div class="service-icon"><?php echo $s['icon']; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
                <h3><?php echo esc_html( $s['title'] ); ?></h3>
                <p><?php echo esc_html( $s['desc'] ); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     KIT DIGITAL AMOUNTS
============================================================ -->
<section id="kit-digital">
    <div class="container">
        <div class="section-header">
            <h2><?php esc_html_e( '¿Cuánto puedo recibir?', 'pyme-starter' ); ?></h2>
            <p><?php esc_html_e( 'El importe depende del tamaño de tu empresa. Consulta tu segmento.', 'pyme-starter' ); ?></p>
        </div>
        <div class="kd-grid">
            <div class="kd-card">
                <span class="kd-amount"><?php echo esc_html( get_theme_mod( 'pyme_kd_segment_i', '12.000' ) ); ?> €</span>
                <span class="kd-label"><?php esc_html_e( 'Segmento I — 10 a 49 empleados', 'pyme-starter' ); ?></span>
            </div>
            <div class="kd-card">
                <span class="kd-amount"><?php echo esc_html( get_theme_mod( 'pyme_kd_segment_ii', '6.000' ) ); ?> €</span>
                <span class="kd-label"><?php esc_html_e( 'Segmento II — 3 a 9 empleados', 'pyme-starter' ); ?></span>
            </div>
            <div class="kd-card">
                <span class="kd-amount"><?php echo esc_html( get_theme_mod( 'pyme_kd_segment_iii', '2.000' ) ); ?> €</span>
                <span class="kd-label"><?php esc_html_e( 'Segmento III — 1 a 2 empleados', 'pyme-starter' ); ?></span>
            </div>
        </div>
        <div class="kd-cta">
            <a href="#contact" class="btn">
                <?php esc_html_e( 'Quiero solicitar mi subvención', 'pyme-starter' ); ?>
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     CONTACT
============================================================ -->
<section id="contact">
    <div class="container">
        <div class="section-header">
            <h2><?php esc_html_e( 'Contacta con nosotros', 'pyme-starter' ); ?></h2>
            <p><?php esc_html_e( 'Te respondemos en menos de 24 horas con un plan personalizado.', 'pyme-starter' ); ?></p>
        </div>
        <div class="contact-wrapper">
            <div class="contact-info">
                <h3><?php esc_html_e( 'Empieza hoy', 'pyme-starter' ); ?></h3>
                <p><?php esc_html_e( 'Agenda una llamada gratuita con nuestro equipo Kit Digital. Te explicamos todo el proceso sin compromiso.', 'pyme-starter' ); ?></p>
                <div class="contact-detail">
                    <span>&#128222;</span>
                    <div><strong><?php esc_html_e( 'Teléfono', 'pyme-starter' ); ?></strong><br>
                    <?php echo esc_html( get_theme_mod( 'pyme_phone', '+34 600 000 000' ) ); ?></div>
                </div>
                <div class="contact-detail">
                    <span>&#9993;</span>
                    <div><strong><?php esc_html_e( 'Email', 'pyme-starter' ); ?></strong><br>
                    <?php echo esc_html( get_theme_mod( 'pyme_email', 'info@mipyme.es' ) ); ?></div>
                </div>
                <div class="contact-detail">
                    <span>&#128205;</span>
                    <div><strong><?php esc_html_e( 'Dirección', 'pyme-starter' ); ?></strong><br>
                    <?php echo esc_html( get_theme_mod( 'pyme_address', 'Calle Mayor 1, Madrid' ) ); ?></div>
                </div>
            </div>

            <div class="contact-form">
                <form id="pyme-contact-form" novalidate>
                    <?php wp_nonce_field( 'pyme_contact_nonce', 'pyme_nonce_field' ); ?>
                    <div class="form-group">
                        <label for="contact-name"><?php esc_html_e( 'Nombre *', 'pyme-starter' ); ?></label>
                        <input type="text" id="contact-name" name="name" required
                               placeholder="<?php esc_attr_e( 'Tu nombre y apellidos', 'pyme-starter' ); ?>">
                    </div>
                    <div class="form-group">
                        <label for="contact-email"><?php esc_html_e( 'Email *', 'pyme-starter' ); ?></label>
                        <input type="email" id="contact-email" name="email" required
                               placeholder="<?php esc_attr_e( 'tu@empresa.es', 'pyme-starter' ); ?>">
                    </div>
                    <div class="form-group">
                        <label for="contact-phone"><?php esc_html_e( 'Teléfono', 'pyme-starter' ); ?></label>
                        <input type="tel" id="contact-phone" name="phone"
                               placeholder="+34 600 000 000">
                    </div>
                    <div class="form-group">
                        <label for="contact-segment"><?php esc_html_e( 'Segmento de empresa', 'pyme-starter' ); ?></label>
                        <select id="contact-segment" name="segment">
                            <option value=""><?php esc_html_e( 'Selecciona tu segmento', 'pyme-starter' ); ?></option>
                            <option value="I"><?php esc_html_e( 'Segmento I — 10 a 49 empleados (hasta 12.000 €)', 'pyme-starter' ); ?></option>
                            <option value="II"><?php esc_html_e( 'Segmento II — 3 a 9 empleados (hasta 6.000 €)', 'pyme-starter' ); ?></option>
                            <option value="III"><?php esc_html_e( 'Segmento III — 1 a 2 empleados (hasta 2.000 €)', 'pyme-starter' ); ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contact-message"><?php esc_html_e( 'Mensaje *', 'pyme-starter' ); ?></label>
                        <textarea id="contact-message" name="message" required
                                  placeholder="<?php esc_attr_e( 'Cuéntanos brevemente qué necesitas...', 'pyme-starter' ); ?>"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">
                        <?php esc_html_e( 'Enviar solicitud', 'pyme-starter' ); ?>
                    </button>
                    <div id="form-status" class="form-status" role="alert" aria-live="polite"></div>
                </form>
            </div>
        </div>
    </div>
</section>
</main>

<?php get_footer(); ?>
