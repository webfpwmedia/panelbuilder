<?php 
use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequenceTaxonomy;

if ( ! empty( $args ) ) {
    $sequence = $args['sequence'];
}

?>

<article class="entry sequence-excerpt">

    <a href="<?php echo get_the_permalink( $sequence->ID ); ?>">
        <?php echo get_the_post_thumbnail( $sequence->ID, 'medium' ); ?>
    </a>

    <h3 class="title">
        <a href="<?php echo get_the_permalink( $sequence->ID ); ?>">
            <?php echo get_the_title( $sequence->ID ); ?>
        </a>
    </h3>
    <?php $terms = get_the_terms( $sequence->ID, PanelSequenceTaxonomy::NAME ); ?>

    <?php if ( ! empty( $terms ) ): ?>
        <div class="terms">
            <?php foreach ( $terms as $term ): ?>
                <div class="term"><?php echo $term->name; ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</article>