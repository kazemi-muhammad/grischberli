<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//////////////////////////////////////////////////
// init
//////////////////////////////////////////////////

$description = __( 'Advanced users can edit the CSS styles of the invoice to change the design and layout of the invoice. To build the pdf file there is a HTML code with CSS styles generated that is rendered by the DOMPDF class to a pdf file. DOMPDF renders (mostly) CSS 2.1 compilant HTML (you may refer to its documentary and examples). You can see the HTML code that is generated by your settings with sample data for an invoice at the bottom of this page.', 'woocommerce-german-market' );

// template files - init files and directories
$core_file_string		= 'woocommerce-invoice-pdf/templates/invoice-default-styles.php';
$theme_file_string		= 'yourtheme/woocommerce-invoice-pdf/invoice-default-styles.php';
$core_file				= untrailingslashit( plugin_dir_path( Woocommerce_Invoice_Pdf::$plugin_filename ) ) . DIRECTORY_SEPARATOR . 'vendors' . DIRECTORY_SEPARATOR . 'self' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'invoice-default-styles.php';
$theme_template_dir		= get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'woocommerce-invoice-pdf';
$theme_file				= $theme_template_dir  . DIRECTORY_SEPARATOR . 'invoice-default-styles.php';

// template file - move core file to template
if ( isset( $_GET[ 'gm_template_nonce' ] ) && wp_verify_nonce( $_GET[ 'gm_template_nonce' ], 'style_content_template' ) ) {
	if ( isset( $_GET['move_template'] ) && ( $_GET['move_template'] == 'invoice-default-styles' ) ) {
		if (  wp_mkdir_p( dirname( get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'woocommerce-invoice-pdf' ) ) && ! file_exists( get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'woocommerce-invoice-pdf' . DIRECTORY_SEPARATOR . 'invoice-default-styles.php' ) ) {
			  $template_file	= apply_filters( 'wp_wc_invoice_pdf_locate_template_file_invoice_content', $core_file );
			  // Copy template file
			  wp_mkdir_p( $theme_template_dir );
			  copy( $template_file, $theme_file );
			  echo '<div class="updated fade"><p>' . __( 'Template file copied to theme.', 'woocommerce-german-market' ) . '</p></div>';
		 }
					
	}

	// template file - delete theme file
	if ( isset( $_GET['delete_template'] ) && ( $_GET['delete_template'] == 'invoice-default-styles' ) ) {
		if ( file_exists( $theme_file ) ) {
			unlink( $theme_file );
			echo '<div class="updated fade"><p>' . __( 'Template file deleted from theme.', 'woocommerce-german-market' ) . '</p></div>';
		}
	}
}

// template file - output buttons and texts
if ( file_exists( $theme_file ) ) {
	$template_file_desc = __( 'This template containing the default CSS styles has been overridden by your theme and can be found in:', 'woocommerce-german-market' ) . ' <code>' . $theme_file_string . '</code>';	
	if ( is_writable( $theme_file ) ) {

		$href = add_query_arg( 'gm_template_nonce', wp_create_nonce( 'style_content_template' ) );
		$href = add_query_arg( 'delete_template', 'invoice-default-styles', $href );
		$href = remove_query_arg( 'move_template', $href );

		$template_file_desc	 = '<a href="' . $href . '" class="delete_template button" style="float: right; margin-top: -4px; margin-left: 10px;">' . __( 'Delete template file', 'woocommerce-german-market' ) . '</a>' . $template_file_desc;
	}
} else {
	$template_file_desc		= __( 'To override and edit the template that contains the default CSS styles copy <code>[file_1]</code> to your theme folder: <code>[file_2]</code>.', 'woocommerce-german-market' );
	$template_file_desc		= str_replace( array( '[file_1]', '[file_2]' ), array( $core_file_string, $theme_file_string ), $template_file_desc );
	if ( ( is_dir( get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'woocommerce-infoice-pdf' . DIRECTORY_SEPARATOR ) && is_writable( get_stylesheet_directory()  . DIRECTORY_SEPARATOR . 'woocommerce-infoice-pdf' . DIRECTORY_SEPARATOR ) ) || is_writable( get_stylesheet_directory() ) ) { 
		
		$href = add_query_arg( 'gm_template_nonce', wp_create_nonce( 'style_content_template' ) );
		$href = add_query_arg( 'move_template', 'invoice-default-styles', $href );
		$href = remove_query_arg( 'delete_template', $href );

		$template_file_desc = '<a href="' . $href . '" class="button" style="float: right; margin-top: -4px; margin-left: 10px;">' . __( 'Copy file to theme', 'woocommerce-german-market' ) . '</a>' . $template_file_desc;
	}
}

// template file - js
wc_enqueue_js("
				jQuery('a.delete_template').click(function(){
					var answer = confirm('" . esc_js( __( 'Are you sure you want to delete this template file?', 'woocommerce-german-market' ) ) . "');
					if (answer)
						return true;
					return false;
				});
			");

//////////////////////////////////////////////////
// options
//////////////////////////////////////////////////

$options	= array(	
	
				array(	'name' 		=> __( 'Test Invoice', 'woocommerce-german-market' ), 'type' => 'wp_wc_invoice_pdf_test_download_button' ),	
	
				array( 'title' => __( 'Custom CSS Styles', 'woocommerce-german-market' ), 'type' => 'title','desc' => $description, 'id' => 'wp_wc_invoice_pdf_custom_css_styles' ),
	
				array(
					'name' 		=> __( 'Inline CSS Styles', 'woocommerce-german-market' ),
					'desc_tip' 	=> __( 'Inline CSS styles are used to position footer and header elements as well as the images, see example at the bottom of this page. It is recommended to have this option activated.', 'woocommerce-german-market' ),
					'tip'  		=> __( 'Inline CSS styles are used to position footer and header elements as well as the images, see example at the bottom of this page. It is recommended to have this option activated.', 'woocommerce-german-market' ),
					'id'   		=> 'wp_wc_invoice_pdf_inline_style',
					'type' 		=> 'wgm_ui_checkbox',
					'css'  		=> 'min-width:250px;',
					'default'  	=> 1,
					),
					
				array(
					'name' 		=> __( 'Default CSS Styles', 'woocommerce-german-market' ),
					'desc_tip'	=> __( 'Default styles are placed in the HTML header <code>style</code> tag, see example at the bottom of this page. It is recommended to copy the defaults into the option field "Custom CSS styles" before you deactivate this option and edit these options in the next step', 'woocommerce-german-market' ),
					'tip'  		=> __( 'Default styles are placed in the HTML header <code>style</code> tag, see example at the bottom of this page. It is recommended to copy the defaults into the option field "Custom CSS styles" before you deactivate this option and edit these options in the next step', 'woocommerce-german-market' ),
					'id'   		=> 'wp_wc_invoice_pdf_remove_css_style',
					'type' 		=> 'wgm_ui_checkbox',
					'css'  		=> 'min-width:250px;',
					'default'  	=> 0,
					),

				array(
					'name' 		=> __( 'HTML Output', 'woocommerce-german-market' ),
					'desc_tip'	=> __( 'Enable HTML output instead of rendering PDF. Use this for debug your styles and your own template ', 'woocommerce-german-market' ),
					'tip'  		=> __( 'Enable HTML output instead of rendering PDF. Use this for debug your styles and your own template ', 'woocommerce-german-market' ),
					'id'   		=> 'wp_wc_invoice_pdf_force_html_output',
					'type' 		=> 'wgm_ui_checkbox',
					'default'  	=> 'no'
					),
					
				array(
					'name' 		=> __( 'Custom CSS Styles', 'woocommerce-german-market' ),
					'desc_tip' 	=> __( 'Your custom CSS will be included at the end of the HTML header <code>style</code> tag', 'woocommerce-german-market' ),
					'tip'  		=> __( 'Your custom CSS will be included at the end of the HTML header <code>style</code> tag', 'woocommerce-german-market' ),
					'id'   		=> 'wp_wc_invoice_pdf_custom_css',
					'type' 		=> 'wp_wc_invoice_pdf_textarea',
					'css'  		=> 'min-width: 500px; height: 300px;',
					'default'  	=> '',
					),
					
				array(
					'name' 		=> __( 'Example', 'woocommerce-german-market' ),
					'desc_tip' 	=> __( 'This is the HTML code with CSS styles including example data for an invoice. This HTML code will be rendered to obtain a pdf file', 'woocommerce-german-market' ),
					'tip'  		=> __( 'This is the HTML code with CSS styles including example data for an invoice. This HTML code will be rendered to obtain a pdf file', 'woocommerce-german-market' ),
					'type' 		=> 'wp_wc_invoice_pdf_textarea',
					'css'  		=> 'min-width: 500px; height: 300px;',
					'custom_attributes' => array( 'readonly' => 'readonly', 'return_html' => WP_WC_Invoice_Pdf_Create_Pdf::get_test_html( get_option( 'wp_wc_invoice_pdf_remove_css_style', false ), get_option( 'wp_wc_invoice_pdf_inline_style', true ) ) )
					),			
									
				array( 'type' => 'sectionend', 'id' => 'wp_wc_invoice_pdf_custom_css_styles' ),
				
				array( 'title' => __( 'Template', 'woocommerce-german-market' ), 'type' => 'title','desc' => $template_file_desc, 'id' => 'wp_wc_invoice_pdf_css_template' ),	
			
				array( 'type' => 'sectionend', 'id' => 'wp_wc_invoice_pdf_css_template' ),
	
);			
?>