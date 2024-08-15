<?php
/**
 * The main loop file
 * @package FQ_Bones_Theme
 */

require_once WP_PLUGIN_DIR . '/statesindustries/vendor/autoload.php';

use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequenceCPT;
use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequenceTaxonomy;

$sequences = (new PanelSequenceCPT())->filter( sanitize_text_field( $_REQUEST['wood_type' ] ) );

?>


<div class="page-articles">

    <h1>Panel Sequences</h1>

    <div class="content">
        <aside class="sidebar">
            <div class="inner">
                <h3 class="title">Filter By Wood Type</h3>
                <nav>
                    <?php foreach ( get_terms( PanelSequenceTaxonomy::NAME, ['hide_empty' => true] ) as $term ): ?>
                        <div class="nav-filter" data-slug="<?php echo $term->slug; ?>"><?php echo $term->name; ?></div>
                    <?php endforeach; ?>
                    <div class="nav-filter" data-slug="all">Show All</div>
                </nav>
            </div>
        </aside>

        <section class="sequences">
            <div class="panel-sequence-container grid">
                <?php foreach ( (new PanelSequenceCPT)->query()->get() as $sequence ): ?>
                    <?php get_template_part( 'templates/content/sequence-excerpt', null, [ 'sequence' => $sequence ] ); ?>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    

</div>
<?php wp_reset_postdata(); ?>
