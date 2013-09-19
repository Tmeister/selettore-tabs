<?php
/*
    Section: Selettore Tabs
    Author: Enrique Chavez
    Author URI: http://enriquechavez.co
    Description: Selettore Tabs is a must-have section. Built using the latest DMS improvements, you can navigate through the content in an easy way using a beatiful transition effect. No more Custom Post Types; edit the content right in the page thanks to the DMS' live editing.
    Class Name: TmSelettoreTabs
    Demo: http://dms.tmeister.net/selettore-tabs
    Version: 1.1
    Loading: active
*/

class TmSelettoreTabs extends PageLinesSection {

    var $section_name      = 'Selettore Tabs';
    var $section_version   = '1.1';
    var $section_key ;
    var $chavezShop;

    function section_persistent()
    {
        $this->section_key = strtolower( str_replace(' ', '_', $this->section_name) );
        $this->verify_license();
        add_filter('pl_sorted_settings_array', array(&$this, 'add_global_panel'));
    }

    function verify_license(){
        if( !class_exists( 'chavezShopVerifier' ) ) {
            include( dirname( __FILE__ ) . '/inc/chavezshop_verifier.php' );
        }
        $this->chavezShop = new chavezShopVerifier( $this->section_name, $this->section_version, $this->opt('selettore_tabs_license_key') );
    }

    function add_global_panel($settings){
        $valid = "";
        if( get_option( $this->section_key."_activated" ) ){
            $valid = ( $this->chavezShop->check_license() ) ? ' - Your license is valid' : ' - Your license is invalid';
        }

        if( !isset( $settings['eChavez'] ) ){
            $settings['eChavez'] = array(
                'name' => 'Enrique Chavez Shop',
                'icon' => 'icon-shopping-cart',
                'opts' => array()
            );
        }

        $collapser_opts = array(
            'key'   => 'selettore_tabs_license_key',
            'type'  => 'text',
            'title' => '<i class="icon-shopping-cart"></i> ' . __('Selettore Tabs License Key', 'selettore') . $valid,
            'label' => __('License Key', 'selettore'),
            'help'  => __('The section is fully functional whitout a key license, this license is used only get access to autoupdates within your admin.', 'selettore')

        );

        array_push($settings['eChavez']['opts'], $collapser_opts);
        return $settings;

    }

    function section_scripts(){
        wp_enqueue_script('script-name', $this->base_url.'/selettore-tabs.js', array('jquery'), $this->section_version, true );
    }


    function section_head() {
    ?>
        <script>
            jQuery(document).ready(function($) {

                jQuery('.tab<?php echo $this->meta['clone']?>').selettoreTabs();
            });
        </script>

        <style type="text/css">
            .tab<?php echo $this->meta['clone']?> .tab-label{
                background:  <?php echo pl_hashify($this->opt('tab_bg_color'))?>;
                color: <?php echo pl_hashify($this->opt('tab_text_color')); ?>;
            }

            .tab<?php echo $this->meta['clone']?> .tab-label.current{
                background:  <?php echo pl_hashify($this->opt('tab_bg_color_hover'))?> !important;
                color: <?php echo pl_hashify($this->opt('tab_text_color_hover'))?> !important;
            }

            .tab<?php echo $this->meta['clone']?> .tabs-selector .triangle{
                border-left-color: <?php echo pl_hashify($this->opt('tab_bg_color_hover'))?> !important;
            }

            .tab<?php echo $this->meta['clone']?> .tabs-selector .tab-wrapper{
                border-bottom: 1px solid <?php echo pl_hashify($this->opt('tab_border_color'))?> !important;
            }
            .tab<?php echo $this->meta['clone']?> .tabs-selector .tab-wrapper:last-child{
                border-bottom: 0 !important;
            }


        </style>
    <?php
    }

    function before_section_template( $location = '' ) {

	}

   	function section_template() {
        if( !$this->opt('stabs_count') ){
            echo setup_section_notify($this, __('Please start adding some content.', 'selettore-tabs'));
            return;
        }
    ?>

        <div class="row selettore tab<?php echo $this->meta['clone'];?> ">
            <div class="span3">
                <div class="tabs-selector">
                    <?php for ($i=0; $i < $this->opt('stabs_count'); $i++): ?>

                    <div class="tab-wrapper" data-index="<?php echo $i ?>">
                        <div class="tab-label <?php echo $i == 0 ? 'current' : '' ?>">
                            <div class="tab-icon"><i class="icon-<?php echo $this->opt('stab_icon'.$i) ? $this->opt('stab_icon'.$i) : 'move' ?>"></i></div>
                            <span class="tab-title" data-sync="stab_icon_label<?php echo $i ?>">
                                <?php echo $this->opt('stab_icon_label'.$i) ? $this->opt('stab_icon_label'.$i) : 'Insert your label' ?>
                            </span>
                            <div class="tab-pointer"><div class="triangle"></div></div>
                        </div>
                        <div class="tab-contents <?php echo (!$this->opt( 'stab_custom_page'.$i ) ) ? 'preformats' : '' ?>">
                            <?php if ($this->opt( 'stab_custom_page'.$i ) ): ?>
                                <?php
                                    $page_data = get_page( $this->opt( 'stab_custom_page'.$i ) );
                                    echo apply_filters('the_content', $page_data->post_content);
                                ?>
                            <?php else: ?>
                                <h1 data-sync="<?php echo 'stab_c_head' .$i ?>">
                                    <?php echo $this->opt('stab_c_head'.$i) ? $this->opt('stab_c_head'.$i) : 'Insert the head title' ?>
                                </h1>
                                <h5 data-sync="<?php echo 'stab_c_subhead' .$i ?>">
                                   <?php echo $this->opt('stab_c_subhead'.$i) ? $this->opt('stab_c_subhead'.$i) : 'Insert subhead' ?>
                                </h5>
                                <div class="media">
                                    <?php $media = $this->opt('stab_c_media'.$i) ? $this->opt('stab_c_media'.$i) : 'http://dms.tmeister.net/selettore-tabs/wp-content/uploads/sites/3/2013/08/sample.png' ?>
                                    <img src="<?php echo $media ?>" alt="" data-sync="<?php echo 'stab_c_media' .$i ?>">
                                </div>
                                <div class="stab-details" data-sync="<?php echo 'stab_c_text' .$i ?>">
                                    <?php echo $this->opt('stab_c_text'.$i) ? $this->opt('stab_c_text'.$i) : '<p>Please add some content, this field accepts HTML, this is a sample link <a href="http://pagelines.com">PageLines</a></p>'?>
                                </div>
                            <?php endif ?>

                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="span9">
                <div class="tabs-container"></div>
            </div>
            <div class="clear"></div>
        </div>

    <?php
   	}

	function after_section_template($clone = null){}

	function section_foot(){}

	function welcome(){

		ob_start();

		?><div style="font-size:12px;line-height:14px;color:#444;"><p><?php _e('You can have some custom text here.','nb-section');?></p></div><?php

		return ob_get_clean();
	}

	function section_opts(){
        $opts = array(
            array(
                'key' => 'stab_multi',
                'type' => 'multi',
                'title' => 'Selettore Tabs Configuration',
                'opts' => array(
                    array(
                        'key' => 'stabs_count',
                        'type' => 'count_select',
                        'count_start' => 1,
                        'count_number' => 20,
                        'label' => __( 'How many tabs do you want to show?', 'selettore-tabs')
                    ),
                    array(
                        'key' => 'tab_bg_color',
                        'type' => 'color',
                        'label' => __('Tabs background color', 'selettore-tabs'),
                        'default' => '#ffffff'
                    ),
                    array(
                        'key' => 'tab_text_color',
                        'type' => 'color',
                        'label' => __('Tabs text color', 'selettore-tabs'),
                        'default' => '#5c5c5c'
                    ),
                    array(
                        'key' => 'tab_bg_color_hover',
                        'type' => 'color',
                        'label' => __('Selected tab background color', 'selettore-tabs'),
                        'default' => '#10b9b9'
                    ),
                    array(
                        'key' => 'tab_text_color_hover',
                        'type' => 'color',
                        'label' => __('Selected tab text color', 'selettore-tabs'),
                        'default' => '#ffffff'
                    ),
                    array(
                        'key' => 'tab_border_color',
                        'type' => 'color',
                        'label' => __('Selected tab border color', 'selettore-tabs'),
                        'default' => '#eeeeee'
                    )
                )
            ),
        );
        $opts = $this->create_tabs_settings($opts);
		return $opts;
	}

    function create_tabs_settings($opts){
        $loopCount = (  $this->opt('stabs_count') ) ? $this->opt('stabs_count') : false;
        $tabHelp = "<h6 style='padding-bottom:5px; margin-bottom:5px; border-bottom:1px solid #ccc'>". __('Left tabs settings' ,'selettore-tabs') . "</h6>";

        $contentHelp = "<h6 style='padding-bottom:5px; margin-bottom:5px; border-bottom:1px solid #ccc'>". __('Tab content settings' ,'selettore-tabs') . "</h6>";

        $newSetup = __('Select how many tabs you want to display in the left panel.' ,'selettore-tabs');

        if(!$loopCount){
            $box = array(
                'key' => 'stab_h3',
                'type' => 'template',
                'template' => $newSetup,
                'title' => __('Demo Content', 'selettore-tabs')
            );
            array_push($opts, $box);
        }

        $available_pages = $this->get_pages_to_show();

        for ($i=0; $i < $loopCount; $i++) {
            $box = array(
                'key' => 'stab_single'.$i,
                'type' =>  'multi',
                'title' => 'Selettore Tab ' . ($i+1) .' settings',
                'label' => 'Settings',
                'opts' => array(
                    array(
                        'key' => 'stab_h1_'.$i,
                        'type' => 'template',
                        'template' => $tabHelp
                    ),
                    array(
                        'key' => 'stab_icon' .$i,
                        'type' => 'select_icon',
                        'label' => 'Tab icon',
                        'default' => 'move'
                    ),
                    array(
                        'key' => 'stab_icon_label' .$i,
                        'type' => 'text',
                        'label' => 'Tab label',
                    ),
                    array(
                        'key' => 'stab_h2_'.$i,
                        'type' => 'template',
                        'template' => $contentHelp
                    ),
                    array(
                        'key' => 'stab_c_head' .$i,
                        'type' => 'text',
                        'label' => 'Content head',
                    ),
                    array(
                        'key' => 'stab_c_subhead' .$i,
                        'type' => 'text',
                        'label' => 'Content subhead',
                    ),
                     array(
                        'key' => 'stab_c_media' .$i,
                        'type' => 'image_upload',
                        'label' => 'Content media',
                    ),
                     array(
                        'key' => 'stab_c_text' .$i,
                        'type' => 'textarea',
                        'label' => 'Content text',
                    ),
                     array(
                        'key' => 'stab_custom_page'.$i,
                        'type' => 'select',
                        'label' => __('Select a page for content', 'selettore-tabs'),
                        'opts' => $available_pages
                    )
                )
            );

            array_push($opts, $box);

        }
        return $opts;
    }

    function get_pages_to_show(){
        $pages = get_pages();
        $out = array();
        foreach ($pages as $page) {
            $out[$page->ID] = array('name' => $page->post_title);
        }
        return $out;
    }
}

