<?php
/**
 * Pyme Starter - Kit Digital: Theme Functions
 *
 * @package PymeStarter
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// =============================================
// THEME SETUP
// =============================================
function pyme_setup() {
    load_theme_textdomain( 'pyme-starter', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption' ) );
    add_theme_support( 'customize-selective-refresh-widgets' );
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'pyme-starter' ),
    ) );
}
add_action( 'after_setup_theme', 'pyme_setup' );

// =============================================
// ENQUEUE SCRIPTS & STYLES
// =============================================
function pyme_scripts() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
        array(), null
    );
    wp_enqueue_style(
        'pyme-style',
        get_stylesheet_uri(),
        array(), '1.0.0'
    );
    wp_enqueue_script(
        'pyme-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(), '1.0.0', true
    );
    wp_localize_script( 'pyme-main', 'pymeAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'pyme_contact_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'pyme_scripts' );

// =============================================
// CUSTOMIZER OPTIONS
// =============================================
function pyme_customizer( $wp_customize ) {

    // Panel: Business Info
    $wp_customize->add_panel( 'pyme_business', array(
        'title'    => __( 'Business Info', 'pyme-starter' ),
        'priority' => 10,
    ) );

    // Section: Contact Details
    $wp_customize->add_section( 'pyme_contact_section', array(
        'title' => __( 'Contact Details', 'pyme-starter' ),
        'panel' => 'pyme_business',
    ) );

    $fields = array(
        'pyme_phone'   => array( 'label' => __( 'Phone', 'pyme-starter' ),   'default' => '+34 600 000 000' ),
        'pyme_email'   => array( 'label' => __( 'Email', 'pyme-starter' ),   'default' => 'info@mipyme.es' ),
        'pyme_address' => array( 'label' => __( 'Address', 'pyme-starter' ), 'default' => 'Calle Mayor 1, Madrid' ),
        'pyme_cif'     => array( 'label' => __( 'CIF', 'pyme-starter' ),     'default' => 'B12345678' ),
    );

    foreach ( $fields as $key => $args ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $args['label'],
            'section' => 'pyme_contact_section',
            'type'    => 'text',
        ) );
    }

    // Section: Kit Digital
    $wp_customize->add_section( 'pyme_kitdigital_section', array(
        'title' => __( 'Kit Digital', 'pyme-starter' ),
        'panel' => 'pyme_business',
    ) );

    $kd_fields = array(
        'pyme_kd_segment_i'  => array( 'label' => __( 'Segment I (10-49 employees) €', 'pyme-starter' ),  'default' => '12.000' ),
        'pyme_kd_segment_ii' => array( 'label' => __( 'Segment II (3-9 employees) €', 'pyme-starter' ),   'default' => '6.000' ),
        'pyme_kd_segment_iii'=> array( 'label' => __( 'Segment III (1-2 employees) €', 'pyme-starter' ),  'default' => '2.000' ),
    );

    foreach ( $kd_fields as $key => $args ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $args['label'],
            'section' => 'pyme_kitdigital_section',
            'type'    => 'text',
        ) );
    }
}
add_action( 'customize_register', 'pyme_customizer' );

// =============================================
// AJAX CONTACT FORM
// =============================================
function pyme_handle_contact() {
    check_ajax_referer( 'pyme_contact_nonce', 'nonce' );

    $name    = sanitize_text_field( wp_unslash( $_POST['name']    ?? '' ) );
    $email   = sanitize_email(      wp_unslash( $_POST['email']   ?? '' ) );
    $phone   = sanitize_text_field( wp_unslash( $_POST['phone']   ?? '' ) );
    $segment = sanitize_text_field( wp_unslash( $_POST['segment'] ?? '' ) );
    $message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

    if ( empty( $name ) || ! is_email( $email ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => __( 'Por favor completa todos los campos obligatorios.', 'pyme-starter' ) ) );
    }

    $admin_email = get_option( 'admin_email' );
    $subject     = sprintf( '[Kit Digital] Solicitud de %s — Segmento %s', $name, $segment ?: 'no especificado' );
    $body        = sprintf(
        "Nombre: %s
Email: %s
Teléfono: %s
Segmento: %s

Mensaje:
%s",
        $name, $email, $phone, $segment, $message
    );
    $headers = array( 'Content-Type: text/plain; charset=UTF-8', "Reply-To: {$email}" );

    $sent = wp_mail( $admin_email, $subject, $body, $headers );

    if ( $sent ) {
        // Log the lead in a custom option (simple CRM)
        $leads   = get_option( 'pyme_leads', array() );
        $leads[] = array(
            'date'    => current_time( 'mysql' ),
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone,
            'segment' => $segment,
            'message' => $message,
        );
        update_option( 'pyme_leads', $leads );

        wp_send_json_success( array( 'message' => __( '¡Mensaje enviado! Nos pondremos en contacto contigo en 24 horas.', 'pyme-starter' ) ) );
    } else {
        wp_send_json_error( array( 'message' => __( 'Error al enviar el mensaje. Inténtalo de nuevo.', 'pyme-starter' ) ) );
    }
}
add_action( 'wp_ajax_pyme_contact',        'pyme_handle_contact' );
add_action( 'wp_ajax_nopriv_pyme_contact', 'pyme_handle_contact' );

// =============================================
// KIT DIGITAL ADMIN PAGE
// =============================================
function pyme_add_admin_menu() {
    add_menu_page(
        __( 'Kit Digital', 'pyme-starter' ),
        'Kit Digital',
        'manage_options',
        'pyme-kit-digital',
        'pyme_kit_digital_page',
        'dashicons-awards',
        30
    );
    add_submenu_page(
        'pyme-kit-digital',
        __( 'Leads', 'pyme-starter' ),
        __( 'Leads', 'pyme-starter' ),
        'manage_options',
        'pyme-leads',
        'pyme_leads_page'
    );
}
add_action( 'admin_menu', 'pyme_add_admin_menu' );

function pyme_kit_digital_page() {
    $data = pyme_get_external_data();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Panel Kit Digital', 'pyme-starter' ); ?></h1>
        <div class="notice notice-info"><p>
            <?php esc_html_e( 'Estado en tiempo real del programa Kit Digital (Red.es)', 'pyme-starter' ); ?>
        </p></div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-top:1.5rem;">
            <?php foreach ( $data['segments'] as $seg ): ?>
            <div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:1.5rem;box-shadow:0 1px 4px rgba(0,0,0,.06);">
                <h3 style="margin:0 0 .5rem;color:#1a56db;"><?php echo esc_html( $seg['label'] ); ?></h3>
                <p style="font-size:2rem;font-weight:800;color:#f97316;margin:0;"><?php echo esc_html( $seg['amount'] ); ?> €</p>
                <p style="color:#6b7280;font-size:.85rem;margin:.25rem 0 0;"><?php echo esc_html( $seg['employees'] ); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <h2 style="margin-top:2rem;"><?php esc_html_e( 'Soluciones disponibles', 'pyme-starter' ); ?></h2>
        <table class="widefat striped" style="margin-top:.75rem;">
            <thead><tr>
                <th><?php esc_html_e( 'Solución', 'pyme-starter' ); ?></th>
                <th><?php esc_html_e( 'Importe máximo', 'pyme-starter' ); ?></th>
                <th><?php esc_html_e( 'Descripción', 'pyme-starter' ); ?></th>
            </tr></thead>
            <tbody>
            <?php foreach ( $data['solutions'] as $sol ): ?>
            <tr>
                <td><strong><?php echo esc_html( $sol['name'] ); ?></strong></td>
                <td><?php echo esc_html( $sol['amount'] ); ?></td>
                <td><?php echo esc_html( $sol['description'] ); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p style="color:#6b7280;font-size:.8rem;margin-top:.5rem;">
            <?php echo esc_html( sprintf( __( 'Última actualización: %s', 'pyme-starter' ), $data['updated'] ) ); ?>
        </p>
    </div>
    <?php
}

function pyme_leads_page() {
    $leads = get_option( 'pyme_leads', array() );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Leads Kit Digital', 'pyme-starter' ); ?></h1>
        <?php if ( empty( $leads ) ): ?>
            <p><?php esc_html_e( 'Aún no hay leads registrados.', 'pyme-starter' ); ?></p>
        <?php else: ?>
        <table class="widefat striped">
            <thead><tr>
                <th>Fecha</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Segmento</th><th>Mensaje</th>
            </tr></thead>
            <tbody>
            <?php foreach ( array_reverse( $leads ) as $lead ): ?>
            <tr>
                <td><?php echo esc_html( $lead['date'] ); ?></td>
                <td><?php echo esc_html( $lead['name'] ); ?></td>
                <td><?php echo esc_html( $lead['email'] ); ?></td>
                <td><?php echo esc_html( $lead['phone'] ); ?></td>
                <td><?php echo esc_html( $lead['segment'] ); ?></td>
                <td><?php echo esc_html( wp_trim_words( $lead['message'], 12 ) ); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <?php
}

// =============================================
// EXTERNAL DATA HELPER (Kit Digital API simulation)
// =============================================
function pyme_get_external_data() {
    $cached = get_transient( 'pyme_kd_data' );
    if ( $cached ) return $cached;

    // In production: fetch from Red.es or your own REST endpoint.
    // For demo we return static data — replace wp_remote_get() result parsing here.
    $data = array(
        'segments' => array(
            array( 'label' => 'Segmento I',   'amount' => '12.000', 'employees' => '10-49 empleados' ),
            array( 'label' => 'Segmento II',  'amount' => '6.000',  'employees' => '3-9 empleados'   ),
            array( 'label' => 'Segmento III', 'amount' => '2.000',  'employees' => '1-2 empleados'   ),
        ),
        'solutions' => array(
            array( 'name' => 'Sitio web y presencia en internet', 'amount' => 'Hasta 2.000 €', 'description' => 'Dominio, hosting y web responsive' ),
            array( 'name' => 'Comercio electrónico',             'amount' => 'Hasta 2.000 €', 'description' => 'Tienda online con pasarela de pago' ),
            array( 'name' => 'Gestión de redes sociales',        'amount' => 'Hasta 2.500 €', 'description' => 'Estrategia y publicación en RRSS' ),
            array( 'name' => 'Gestión de clientes (CRM)',        'amount' => 'Hasta 4.000 €', 'description' => 'CRM para seguimiento de clientes' ),
            array( 'name' => 'Business Intelligence y analítica','amount' => 'Hasta 4.000 €', 'description' => 'Dashboards e informes de negocio' ),
            array( 'name' => 'Ciberseguridad',                   'amount' => 'Hasta 2.000 €', 'description' => 'Antivirus, VPN y gestión de accesos' ),
        ),
        'updated' => gmdate( 'Y-m-d H:i' ),
    );

    set_transient( 'pyme_kd_data', $data, HOUR_IN_SECONDS * 6 );
    return $data;
}
