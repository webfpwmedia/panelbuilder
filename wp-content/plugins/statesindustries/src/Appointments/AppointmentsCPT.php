<?php 

namespace FigoliQuinn\StatesIndustries\Appointments;

use FigoliQuinn\BetterCustomPostTypes\BetterCustomPostType;

if (!defined('ABSPATH')) exit;

class AppointmentsCPT extends BetterCustomPostType
{
    const SLUG = 'appointments';
    const NAME = 'Live Look Appointment';

    public function __construct( ?int $id = null ) 
    {
        $this->slug = SELF::SLUG;
        $this->name = SELF::NAME;
        $this->menu_icon = 'dashicons-buddicons-buddypress-logo';
		$this->publicly_queryable = false;
		$this->supports = ['title'];
;
        if ( ! empty( $id ) ) {
            $this->id = $id;
        }

        parent::__construct();
    }

    public function custom_admin_column_headers(array $columns): array
    {
        $columns['appointment_time'] = 'Appointment Date/Time';

        return $columns;
    }

    public function custom_admin_column_value(string $column, int $post_id): void
    {
        switch ($column) {
            case 'appointment_time':
                $unixtimestamp = strtotime( get_field( 'appointment_time', $post_id ) );
                echo date_i18n( "l d F, Y", $unixtimestamp );
                break;
        }
    }

}