<?php
/**
 * The main loop file
 * @package FQ_Bones_Theme
 */

require_once WP_PLUGIN_DIR . '/swatchlibrary/vendor/autoload.php';
use \FigoliQuinn\SwatchLibrary\CustomPostType\SwatchLibraryCPT;
use FigoliQuinn\SwatchLibrary\CustomPostType\WoodSpecies;

$swatches = (new SwatchLibraryCPT())->filter( sanitize_text_field( $_REQUEST['family' ] ) );
?>


<div class="page-articles">

    <h1>Veneer Library</h1>

    <header class="swatch-filters">
        <div>
            <label>Filter by Family</label>
            <select name="family" class="swatch-filters-family">
                <option value="">All</option>
                <?php foreach ( WoodSpecies::getFamilies() as $value => $label ): ?>
                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                <?php endforeach; ?> 
            </select>
        </div>
    </header>
    
    <div class="swatch-container grid-wrapper">
        <?php if ( ! empty( $swatches ) ) : ?>
            <?php foreach ( $swatches as $swatch ): ?>
                <?php get_template_part( 'templates/content/swatch-excerpt', null, [ 'swatch' => $swatch ] ); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <p id="swatch-no-results">No results found.</p>

</div>
<?php wp_reset_postdata(); ?>
