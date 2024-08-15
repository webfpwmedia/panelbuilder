<?php

/**
 * Main template part for displaying post content, if not more more specific template part
 * @package FQ_Bones_Theme_Parent
 */

require_once WP_PLUGIN_DIR . '/swatchlibrary/vendor/autoload.php'; 
use FigoliQuinn\SwatchLibrary\CustomPostType\WoodSpecies;
use FigoliQuinn\SwatchLibrary\CustomPostType\SwatchLibraryCPT;

$familyValue = get_field( SwatchLibraryCPT::FAMILY_FIELD_KEY );
$family = WoodSpecies::getFamilyName( $familyValue );

$speciesValue = get_field( SwatchLibraryCPT::SPECIES_FIELD_KEY );
$species = WoodSpecies::getSpeciesName( $familyValue, $speciesValue );

?>


<article class="entry">
    <div class="image"><?php the_post_thumbnail(); ?></div>
    <div class="description">
        <div class="meta">
            <div class="family"><?php echo $family; ?></div>
            <div class="species"><?php echo $species; ?></div>
        </div>
        <?php the_content(); ?>

        <p class="back">
            <a href="<?php echo get_post_type_archive_link( SwatchLibraryCPT::SLUG ); ?>">Back to Veneer Library</a>
        </p>
    </div>
</article><!-- .entry -->
