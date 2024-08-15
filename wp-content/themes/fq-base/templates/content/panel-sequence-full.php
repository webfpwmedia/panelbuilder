<?php 
use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequenceCPT;
?>

<article class="entry panel-full" data-id="<?php echo $args['sequence']->ID; ?>">
    <div class="description">
        <a class="back" href="<?php echo get_post_type_archive_link( PanelSequenceCPT::SLUG ); ?>"><i class="far fa-chevron-left"> Back to Panels</i></a>

        <h1><?php echo apply_filters( 'the_title', get_the_title( $args['sequence']->ID ) ); ?></h1>

        <?php if ( $args['hide_content'] !== true ): ?>
            <?php echo apply_filters( 'the_content', get_the_content( null, false, $args['sequence']->ID ) ); ?>
        <?php endif; ?>
        <p class="note">Click the images to view full screen versions <i class="far fa-arrow-right"></i></p>

        <?php if ( have_rows( PanelSequenceCPT::PANELS_FIELD_KEY, $args['sequence']->ID ) ): ?>
            <?php while ( have_rows( PanelSequenceCPT::PANELS_FIELD_KEY, $args['sequence']->ID ) ): the_row(); ?>

                <div class="panel">

                    <div class="description">
                        <div class="meta">
                            <div class="number">
                                <?php the_sub_field( PanelSequenceCPT::NAME_FIELD_KEY ); ?> <span class="value">#<?php the_sub_field( PanelSequenceCPT::NUMBER_FIELD_KEY ); ?></span>
                                <button class="copy-sequence-number" title="Click to Copy" data-number="<?php the_sub_field( PanelSequenceCPT::NUMBER_FIELD_KEY ); ?>">
                                    <i class="far fa-clipboard"></i> <span class="text">Click to Copy</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="sequences">
                        <?php if ( have_rows( PanelSequenceCPT::SEQUENCES_FIELD_KEY, $args['sequence']->ID ) ): ?>
                        <?php while ( have_rows( PanelSequenceCPT::SEQUENCES_FIELD_KEY, $args['sequence']->ID ) ): the_row(); ?>
                                    <div class="sequence">
                                        <h3>Sequence of <?php the_sub_field( PanelSequenceCPT::SEQUENCE_OF_FIELD_KEY ); ?></h3>

                                        <div class="grid">
                                            <?php $images = get_sub_field( PanelSequenceCPT::IMAGES_FIELD_KEY ); ?>
                                            <?php if ( ! empty( $images ) ): ?>
                                                <?php foreach( $images as $index => $image ): ?>
                                                    <div class="sequence" data-index="<?php echo $index; ?>">
                                                        <?php if ( $image ): ?>
                                                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div> 
                                    </div>
                                
                        <?php endwhile; ?>
                        <?php endif; ?>
                    </div>

                </div>
                
            <?php endwhile; ?>
        <?php endif; ?>


    </div>

</article><!-- .entry -->

<div class="modal zoom-loupe-container" data-current="">
    <div class="bg"></div>
    <div class="content">
        <div class="inner">
            <btn id="close"><i class="far fa-times"></i> Close</btn>
            <div id="loupe" class="loupe"></div>
            <div>
                <img id="loupe-image" class="image" />
            </div>
        </div>
    </div>
</div>