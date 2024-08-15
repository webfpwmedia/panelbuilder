<?php 

namespace FigoliQuinn\StatesIndustries\PanelSequences;

use FigoliQuinn\BetterCustomPostTypes\BetterCustomTaxonomy;

if (!defined('ABSPATH')) exit;

class PanelSequenceTaxonomy extends BetterCustomTaxonomy 
{
    const NAME = 'wood_type';
    const POST_TYPE = PanelSequenceCPT::SLUG;
    const LABEL = 'Wood Type';

    public function __construct()
    {
        $this->name = self::NAME;
        $this->post_type = [self::POST_TYPE];
        $this->label = self::LABEL;
        $this->show_admin_column = true;
        $this->hierarchical = true;

        parent::__construct();
    }
}