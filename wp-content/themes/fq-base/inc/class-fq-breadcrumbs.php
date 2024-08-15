<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'FQ_Breadcrumbs' ) ) {

    class FQ_Breadcrumbs 
    {
        protected $menu_name = '';
        protected $nav_menu_items = [];
        protected $breadcrumbs = [
            'home' => [ 'order' => 0 , 'title' => 'Home' ],
            'root' => [ 'order' => 0 ],
            'parent' => [ 'order' => 0 ],
            'current' => [ 'order' => 0 ],
        ];

        public function __construct( string $menu_name )
        {
            $this->menu_name = $menu_name;
            $this->breadcrumbs = [
                'home'    => [ 'order' => 0, 'title' => '<i class="far fa-house"></i>', 'url' => get_site_url() ],
                'root'    => [ 'order' => 1, 'title' => '', 'url' => '' ],
                'parent'  => [ 'order' => 2, 'title' => '', 'url' => '' ],
                'current' => [ 'order' => 3, 'title' => '', 'url' => '' ],
            ];

            ob_start();
            include( get_stylesheet_directory() . '/static/svgs/logo-mark.svg' );
            $logo = ob_get_contents();
            ob_end_clean();

            $this->breadcrumbs['home']['title'] = $logo;
            $this->nav_menu_items = wp_get_nav_menu_items( $this->menu_name );
            $this->get_current_nav_item();
            $this->get_parent_nav_item();
            $this->get_root_nav_item();
        }

        public function should_show(): bool 
        {
            return ! is_front_page() && ! empty( $this->breadcrumbs['current']['title'] );
        }

        public function get_breadcrumbs(): array 
        {
            $crumbs = $this->breadcrumbs;

            usort( $crumbs, function ( $a, $b ) {
                if ( $a['order'] == $b['order'] ) {
                    return 0;
                }
                return ( $a['order'] < $b['order'] ) ? -1 : 1;
            });

            return $crumbs;
        }

        protected function get_current_nav_item(): void
        {
            $crumb = $this->get_nav_item_by_prop( 'object_id', get_queried_object_id() );

            if ( empty( $crumb ) ) {
                return;
            }

            $this->breadcrumbs['current']['id'] = $crumb['id'];
            $this->breadcrumbs['current']['parent'] = $crumb['parent'];
            $this->breadcrumbs['current']['title'] = $crumb['title'];
            $this->breadcrumbs['current']['url'] = $crumb['url'];
        }

        protected function get_parent_nav_item(): void
        {
            if ( empty( $this->breadcrumbs['current']['parent'] ) ) {
                return;
            }

            $crumb = $this->get_nav_item_by_prop( 'ID', $this->breadcrumbs['current']['parent'] );
            $this->breadcrumbs['parent']['id'] = $crumb['id'];
            $this->breadcrumbs['parent']['parent'] = $crumb['parent'];
            $this->breadcrumbs['parent']['title'] = $crumb['title'];
            $this->breadcrumbs['parent']['url'] = $crumb['url'];
        }

        protected function get_root_nav_item(): void
        {
            if ( empty( $this->breadcrumbs['parent']['parent'] ) ) {
                return;
            }

            $crumb = $this->get_nav_item_by_prop( 'ID', $this->breadcrumbs['parent']['parent'] );
            $this->breadcrumbs['root']['id'] = $crumb['id'];
            $this->breadcrumbs['root']['parent'] = $crumb['parent'];
            $this->breadcrumbs['root']['title'] = $crumb['title'];
            $this->breadcrumbs['root']['url'] = $crumb['url'];
        }

        protected function get_nav_item_by_prop(string $property, string $id)
        {
            foreach ( $this->nav_menu_items as $item ) {
                if ( $item->{ $property } == $id ) {
                    return [
                        'id'     => $item->ID,
                        'parent' => $item->menu_item_parent,
                        'title'  => $item->title,
                        'url'    => $item->url,
                    ];
                }
            }
        }

    }
}

