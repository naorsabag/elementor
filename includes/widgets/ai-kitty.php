<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Modules\ContentSanitizer\Interfaces\Sanitizable;
use Elementor\Modules\Promotions\Controls\Promotion_Control;

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Widget_AI_Kitty extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'AI-Kitty';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'AI-Kitty', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-ai';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'AI-Kitty', 'ai' ];
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	/**
	 * Get style dependencies.
	 *
	 * Retrieve the list of style dependencies the widget requires.
	 *
	 * @since 3.24.0
	 * @access public
	 *
	 * @return array Widget style dependencies.
	 */
	public function get_style_depends(): array {
		return [ 'widget-heading' ];
	}

	public function has_widget_inner_wrapper(): bool {
		return ! Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_ai_kitty',
			[
				'label' => esc_html__( 'AI-Kitty', 'elementor' ),
			]
		);

		$this->add_control(
			'prompt',
			[
				'label' => esc_html__( 'Prompt', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your prompt', 'elementor' ),
				'default' => esc_html__( 'Add Your Instructions Here', 'elementor' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Heading', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'text_stroke',
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->add_control(
			'blend_mode',
			[
				'label' => esc_html__( 'Blend Mode', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Normal', 'elementor' ),
					'multiply' => esc_html__( 'Multiply', 'elementor' ),
					'screen' => esc_html__( 'Screen', 'elementor' ),
					'overlay' => esc_html__( 'Overlay', 'elementor' ),
					'darken' => esc_html__( 'Darken', 'elementor' ),
					'lighten' => esc_html__( 'Lighten', 'elementor' ),
					'color-dodge' => esc_html__( 'Color Dodge', 'elementor' ),
					'saturation' => esc_html__( 'Saturation', 'elementor' ),
					'color' => esc_html__( 'Color', 'elementor' ),
					'difference' => esc_html__( 'Difference', 'elementor' ),
					'exclusion' => esc_html__( 'Exclusion', 'elementor' ),
					'hue' => esc_html__( 'Hue', 'elementor' ),
					'luminosity' => esc_html__( 'Luminosity', 'elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'separator',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->start_controls_tabs( 'title_colors' );

		$this->start_controls_tab(
			'title_colors_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( '' === $settings['prompt'] ) {
			return;
		}

		$this->add_render_attribute( 'prompt', 'class', 'elementor-heading-title' );


		$this->add_render_attribute( 'prompt', 'class', 'elementor-size-default' );

		$this->add_inline_editing_attributes( 'prompt' );

		$prompt = $settings['prompt'];
		$inputWidgetId = $settings['ai-kitty-input'];
		$outputWidgetId = $settings['ai-kitty-output'];

		echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputWidget = document.querySelector("[data-id=\'' . $inputWidgetId . '\']").querySelector("input[type=\'text\']");
        console.log("Input widget:", inputWidget);
        if (!inputWidget) {
            console.warn("Input widget with data-id=\'' . $inputWidgetId . '\' not found.");
            return;
        }

        // OpenAI API settings
        const apiKey = "your-openai-api-key"; // Replace with your actual API key
        const apiUrl = "https://api.openai.com/v1/completions";
        const prompt = ' . json_encode($prompt) . ';

		const callOpenAI = (inputValue) => {
			// Call the OpenAI API
			fetch(apiUrl, {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"Authorization": `Bearer ${apiKey}`
				},
				body: JSON.stringify({
					model: "gpt-4",
					prompt: prompt,
					max_tokens: 100
				})
			})
			.then(response => {
				if (!response.ok) {
					throw new Error(`API error: ${response.statusText}`);
				}
				return response.json();
			})
			.then(data => {
				const generatedText = data.choices[0].text.trim();
				console.log("Generated response from OpenAI:", generatedText);
				// Optionally, display the response in another widget
				const outputWidget = document.querySelector("[data-id=\'' . $outputWidgetId . '\'] h, p, span");
				console.log("Output widget:", outputWidget);
				if (outputWidget) {
					outputWidget.value = generatedText;
				}
			})
			.catch(error => {
				console.error("Error calling OpenAI API:", error);
			});
		};
		let debounceTimeout;
        inputWidget.addEventListener("input", function(event) {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                const inputValue = event.target.value.trim();
                if (inputValue) {
					console.log("Input value:", inputValue);
                    callOpenAI(inputValue);
                }
            }, 500); // Adjust debounce delay as needed
        });
    });
</script>';
	}

	/**
	 * Render heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>

		<script>
			function debounce(callback, delay) {
				let timeout;
				return function (...args) {
					clearTimeout(timeout);
					timeout = setTimeout(() => {
						callback.apply(this, args);
					}, delay);
				};
			}

			console.log( 'AI-KITTY!!!!!!' );
			let container = null;
			const elementNodeListOf = document.querySelectorAll( '.elementor-widget-heading, .elementor-widget-text-editor' );
			console.log( 'Element Node List Of:', elementNodeListOf );
			elementNodeListOf
				.forEach( ( elInput ) => {
					const clickHandler = ( event ) => {

						container = window.top.elementor.getPanelView().getCurrentPageView().getOption( 'editedElementView' ).container
						console.log( `AI-KITTY!!!!!! You clicked on:`,event.target );
						event.target.removeEventListener( 'click', clickHandler, true );
						const outputWidget = elInput.getAttribute( 'data-id' );

						document.querySelectorAll( '.elementor-widget-form' )
							.forEach( ( elOutput ) => {
								console.log( `AI-KITTY!!!!!! bla`);
								const clickHandlerOut = ( eventOut ) => {
									console.log( `AI-KITTY!!!!!! You clicked on`,eventOut.target );
									eventOut.target.removeEventListener( 'click', clickHandlerOut );
									const inputWidget = elOutput.getAttribute( 'data-id' );

									// Event listener with debounce
									eventOut.target.addEventListener(
										'input',
										debounce((ev) => {
											console.log('Input value:', ev.target.value);
										}, 500)
									);

									window.top.$e.run( 'document/elements/settings', {
										container: container,
										settings: {
											'ai-kitty-input': inputWidget,
											'ai-kitty-output': outputWidget,
										},
									} );

									event.stopPropagation();

									// const instructions = prompt( 'Insert Prompt' );
									// if ( instructions ) {
									// 	console.log( `AI-KITTY!!!!!! Prompt: ${ instructions }` );
									// }
								};
								elOutput.addEventListener( 'click', clickHandlerOut, true );
							} );
						event.stopPropagation();
					};
					elInput.addEventListener( 'click', clickHandler, true );
				} );
		</script>


		<#
		print( '<h1></h1>' );
		#>
		<?php
	}
}
