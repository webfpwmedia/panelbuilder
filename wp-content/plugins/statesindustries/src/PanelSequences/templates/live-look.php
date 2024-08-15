<?php 

use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequenceCPT;

$panels = (new PanelSequenceCPT)->query()->withAcfFields([PanelSequenceCPT::PANELS_FIELD_KEY])->get();

?>

<div class="live-look-panels">
    <div class="panels">
        <?php foreach ( $panels as $panel ): ?>
            <div class="panel">
            <?php get_template_part( 'templates/content/panel-sequence-full', null, [ 'sequence' => $panel, 'hide_content' => true ] ); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>