<?php

namespace FigoliQuinn\StatesIndustries;

use FigoliQuinn\StatesIndustries\PressReleases\PressReleasesCPT;
use FigoliQuinn\StatesIndustries\Appointments\AppointmentsCPT;
use FigoliQuinn\StatesIndustries\LiveLook\LiveLook;
use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequenceCPT;
use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequencesApi;
use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequenceTaxonomy;

if (!defined('ABSPATH')) exit;

class StatesIndustriesPlugin 
{

    public function __construct()
    {
        new PressReleasesCPT();
        new AppointmentsCPT();
        new PanelSequenceCPT(null, true);
        new PanelSequenceTaxonomy();
        new PanelSequencesApi();
        new LiveLook;

        add_action( 'init', [ $this, 'register_scripts' ] );
    }

    public function register_scripts()
    {
        wp_register_script( 'states-industries-plugin', STATES_INDUSTRIES_PLUGIN_DIR_URI . '/assets/js/dist/statesindustries-dist.js', array( 'jquery' ), '', true );
        wp_enqueue_script( 'states-industries-plugin' );
    }
}