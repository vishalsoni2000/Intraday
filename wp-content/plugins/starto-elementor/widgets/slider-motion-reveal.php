<?php
namespace StartoElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Blog Posts
 *
 * Elementor widget for blog posts
 *
 * @since 1.0.0
 */
class Starto_Slider_Motion_Reveal extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'starto-slider-motion-reveal';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Motion Reveal Slider', 'starto-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-slides';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'starto-theme-widgets-category' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'tweenmax', 'starto-elementor' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'starto-elementor' ),
			]
		);
		
		$this->add_control(
			'slides',
			[
				'label' => __( 'Slides', 'starto-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'slide_image',
						'label' => __( 'Image', 'starto-elementor' ),
						'type' => Controls_Manager::MEDIA,
						'label_block' => true,
					],
					[
						'name' => 'slide_title',
						'label' => __( 'Title', 'starto-elementor' ),
						'type' => Controls_Manager::TEXT,
						'default' => __( 'Title' , 'starto-elementor' ),
					],
					[
						'name' => 'slide_description',
						'label' => __( 'Description', 'starto-elementor' ),
						'type' => Controls_Manager::WYSIWYG,
					],
					[
						'name' => 'slide_button_title',
						'label' => __( 'Button Title', 'starto-elementor' ),
						'type' => Controls_Manager::TEXT,
						'default' => __( 'View Project' , 'starto-elementor' ),
					],
					[
						'name' => 'slide_button_link',
						'label' => __( 'Button Link URL', 'starto-elementor' ),
						'type' => Controls_Manager::URL,
						'default' => [
					        'url' => '',
					        'is_external' => '',
					     ],
						'show_external' => true,
					],
				],
				'title_field' => '{{{ slide_title }}}',
			]
		);
		
		$this->add_responsive_control(
		    'height',
		    [
		        'label' => __( 'Height (in px)', 'starto-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 700,
		        ],
		        'range' => [
		            'px' => [
		                'min' => 5,
		                'max' => 2000,
		                'step' => 5,
		            ]
		        ],
		        'size_units' => [ 'px' ],
		        'selectors' => [
		            '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow .slide' => 'height: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);
		
		$this->add_responsive_control(
		    'imag_width',
		    [
		        'label' => __( 'Image Width (in px)', 'starto-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 350,
		        ],
		        'range' => [
		            'px' => [
		                'min' => 5,
		                'max' => 1350,
		                'step' => 5,
		            ]
		        ],
		        'size_units' => [ 'px' ],
		        'selectors' => [
		            '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow .slide-img-wrap' => 'width: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);
		
		$this->add_control(
		    'previous_title',
		    [
		        'label' => __( 'Previous Button Title', 'starto-elementor' ),
		        'type' => Controls_Manager::TEXT,
		        'default' => 'previous',
		    ]
		);
		
		$this->add_control(
		    'next_title',
		    [
		        'label' => __( 'Next Button Title', 'starto-elementor' ),
		        'type' => Controls_Manager::TEXT,
		        'default' => 'next',
		    ]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_title_style',
			array(
				'label'      => esc_html__( 'Title', 'starto-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'title_color',
		    [
		        'label' => __( 'Title Color', 'starto-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow .slide-title' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'starto-elementor' ),
				'selector' => '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow h3.slide-title',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_preview_title_style',
			array(
				'label'      => esc_html__( 'Preview Title', 'starto-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'preview_title_color',
		    [
		        'label' => __( 'Preview Title Color', 'starto-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow .preview-title' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'preview_title_typography',
				'label' => __( 'Preview Title Typography', 'starto-elementor' ),
				'selector' => '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow h3.preview-title',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_style',
			array(
				'label'      => esc_html__( 'Content', 'starto-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'description_color',
		    [
		        'label' => __( 'Description Color', 'starto-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow .preview-content' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label' => __( 'Description Typography', 'starto-elementor' ),
				'selector' => '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow .preview .preview-content',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_navigation_style',
			array(
				'label'      => esc_html__( 'Navigation', 'starto-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'navigation_color',
		    [
		        'label' => __( 'Navigation Color', 'starto-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow nav .slidenav-item' => 'color: {{VALUE}}',
		            '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow .icon' => 'fill: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'navigation_typography',
				'label' => __( 'Navigation Typography', 'starto-elementor' ),
				'selector' => '{{WRAPPER}} .motion-reveal-slider-wrapper.slideshow .slidenav-item',
			]
		);
		
		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		include(STARTO_ELEMENTOR_PATH.'templates/slider-motion-reveal/index.php');
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		return '';
	}
}
