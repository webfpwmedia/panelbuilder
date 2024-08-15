<?php
/**
 * The template for displaying the header content.
 * @package FQ_Bones_Theme
 */
?>

<section class="page-header-announcement">

    <?php get_template_part( 'templates/components/banner' ); ?>

</section>

<div class="page-header-content">

    <div class="branding">
        <a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php get_template_part( 'templates/brand/logo', 'lockup' ); ?>
        </a>
    </div>

    <div class="nav-rows">
        <div class="secondary">
            <?php get_search_form(); ?>
            <?php
                if ( function_exists( 'fquser_render_user_menu' ) ) {
                    fquser_render_user_menu();
                }
            ?>
        </div>

        <?php get_template_part( 'templates/nav/toggle' ); ?>
        <div class="primary">
            <?php get_template_part( 'templates/nav/primary' ); ?>
            <div class="mobile">
                <?php get_search_form(); ?>
                <?php
                    if ( function_exists( 'fquser_render_user_menu' ) ) {
                        fquser_render_user_menu();
                    }
                ?>
            </div>
        </div>
    </div>

</div>
