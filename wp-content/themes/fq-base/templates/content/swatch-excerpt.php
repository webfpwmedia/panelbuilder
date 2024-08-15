<?php 

require_once WP_PLUGIN_DIR . '/swatchlibrary/vendor/autoload.php'; 
use FigoliQuinn\SwatchLibrary\CustomPostType\SwatchLibraryCPT;
use FigoliQuinn\SwatchLibrary\CustomPostType\WoodSpecies;

$familyValue = $args['swatch']->acf_fields[ SwatchLibraryCPT::FAMILY_FIELD_KEY ];
$family = WoodSpecies::getFamilyName( $familyValue );

$speciesValue = $args['swatch']->acf_fields[ SwatchLibraryCPT::SPECIES_FIELD_KEY ];
$species = WoodSpecies::getSpeciesName( $familyValue, $speciesValue );

?>

<div class="swatch excerpt">
    <a href="<?php echo get_the_permalink( $args['swatch']->ID ); ?>">
        <?php echo get_the_post_thumbnail( $args['swatch']->ID ); ?>  
        <div class="meta">
            <div class="family"><?php echo $family; ?></div>
            <div class="species"><?php echo $species; ?></div>
        </div>
    </a>
</div>