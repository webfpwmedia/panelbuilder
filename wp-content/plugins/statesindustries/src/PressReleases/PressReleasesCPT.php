<?php 

namespace FigoliQuinn\StatesIndustries\PressReleases;

use FigoliQuinn\BetterCustomPostTypes\BetterCustomPostType;

if (!defined('ABSPATH')) exit;

class PressReleasesCPT extends BetterCustomPostType
{
    const SLUG = 'press_release';
    const NAME = 'Press Release';

    public function __construct( ?int $id = null ) 
    {
        $this->slug = SELF::SLUG;
        $this->name = SELF::NAME;
        $this->menu_icon = 'dashicons-megaphone';
        $this->show_in_rest = true;
        $this->custom_url = 'press-releases';

        if ( ! empty( $id ) ) {
            $this->id = $id;
        }

        parent::__construct();
        $this->wp_hooks();
    }

    protected function wp_hooks()
    {
        add_action( 'fq_above_loop', [ $this, 'add_archive_title'] );
    }

    public function add_archive_title()
    {
        if ( is_post_type_archive( SELF::SLUG ) ) {
            $title =  'Press Releases';
            echo '<div class="archive-title"><h1 class="title">' . $title . '</h1></div>';
        }
    }
}