<?php 

use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequenceCPT;

$panels = (new PanelSequenceCPT)->query()->withAcfFields([PanelSequenceCPT::PANELS_FIELD_KEY])->get();

?>
<div class="section">
    <label for="show-panels">
        <input id="show-panels" type="checkbox" /> Show Panels
    </label>

    <div class="panel-selector-wrapper">
        <label>Panel(s)</label>
        <select id="panel-selector" multiple>
            <?php foreach ( $panels as $panel ): ?>
                <option value="<?php echo $panel->ID; ?>"><?php echo $panel->post_title; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>