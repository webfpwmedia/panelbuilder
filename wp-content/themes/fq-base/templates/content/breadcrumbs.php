<?php $fqbreadcrumbs = new FQ_Breadcrumbs('main-nav'); ?>
<?php $crumbs = $fqbreadcrumbs->get_breadcrumbs(); ?>

<?php if ( $fqbreadcrumbs->should_show() ): ?>
    <div id="main-breadcrumbs" class="breadcrumbs">
        <div class="inner">

            <?php foreach ( $crumbs as $index => $crumb ): ?>
                <?php if ( ! empty( $crumb['title'] ) ): ?>
                    <div class="crumb<?php if ( $index == 0 ): ?> home<?php endif; ?>">
                        <?php if ( ! empty( $crumb['url'] && $crumb['url'] != get_the_permalink() ) ): ?>
                            <a href="<?php echo $crumb['url']; ?>">
                                <?php echo $crumb['title']; ?>            
                            </a>
                        <?php else: ?>
                            <?php echo $crumb['title']; ?>
                        <?php endif; ?>
                    </div>
                    <?php if ( $index < count( $crumbs ) - 1 ): ?>
                        <div class="separator">/</div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
