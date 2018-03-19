<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

if (!class_exists('WPEP_Form')) {

    class WPEP_Form {

        /**
         * Class Constructor
         */
        public function __construct() {
            //form short code
            add_shortcode('wpep_form', array($this, 'wpep_form_html'));
            //form script & style
            add_action('wp_enqueue_scripts', array($this, 'wpep_form_script_style'));
            //submit payment
            add_action('wp_ajax_wpep_submit_payment', array($this, 'wpep_submit_payment'));
            add_action('wp_ajax_nopriv_wpep_submit_payment', array($this, 'wpep_submit_payment'));
        }

        /**
         * form view
         */
        public function wpep_form_html() {
            ob_start();
            //check if simple payment or donation
            $button_type = get_option('wpep_button_type');
            $amount = 0;
            $user_set_amount = false;
            if ($button_type == 'simple' || ($button_type == 'donation' && get_option('wpep_donation_user_amount') != 'yes')) {
                $amount = get_option('wpep_amount');
            } elseif ($button_type == 'donation' && get_option('wpep_donation_user_amount') == 'yes') {
                $user_set_amount = true;
            }

            $button_text = get_option('wpep_button_text', 'Buy');
            require_once WPEP_PLUGIN_PATH . 'includes/views/wpep-form.php';
            return ob_get_clean();
        }

        /**
         * form script & style
         */
        public function wpep_form_script_style() {
            global $post;
            //check if short code used
            if (has_shortcode($post->post_content, 'wpep_form')) {
                wp_enqueue_style('wpep-style', WPEP_PLUGIN_URL . 'assets/css/style.css');
                wp_register_script('wpep-paymentform', 'https://js.squareup.com/v2/paymentform', '', '', true);

                //get square settings
                $mode = get_option('wpep_square_mode');
                if ($mode == 'test') {
                    $application_id = get_option('wpep_test_appid');
                    $location_id = get_option('wpep_test_locationid');
                } else {
                    $application_id = get_option('wpep_live_appid');
                    $location_id = get_option('wpep_live_locationid');
                }

                if ($application_id && $location_id) {
                    wp_register_script('wpep-script', WPEP_PLUGIN_URL . 'assets/js/front.js', array('wpep-paymentform'), '', true);
                    wp_localize_script('wpep-script', 'wpep_script', array(
                        'application_id' => $application_id,
                        'location_id' => $location_id,
                        'placeholder_card_number' => __('•••• •••• •••• ••••', 'contact-form-7-square'),
                        'placeholder_card_expiration' => __('MM / YY', 'contact-form-7-square'),
                        'placeholder_card_cvv' => __('CVV', 'contact-form-7-square'),
                        'placeholder_card_postal_code' => __('Card Postal Code', 'contact-form-7-square'),
                        'payment_form_input_styles' => esc_js($this->get_input_styles()),
                        'amount_error_message' => __('Amount must be at least 1.', 'contact-form-7-square'),
                        'ajaxurl' => admin_url('admin-ajax.php')
                    ));

                    wp_enqueue_script('wpep-script');
                }
            }
        }

        /**
         * square form style
         */
        public function get_input_styles() {
            $styles = array(
                array(
                    'fontSize' => '16px',
                    'padding' => '0.7em',
                    'backgroundColor' => '#fff'
                )
            );

            return wp_json_encode($styles);
        }
		
		// Function to get the client IP address
		public function get_client_ip() {
			$ipaddress = '';
			if (isset($_SERVER['HTTP_CLIENT_IP']))
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']))
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
				$ipaddress = 'UNKNOWN';
			return $ipaddress;
		}

        /**
         * submit payment
         */
        public function wpep_submit_payment() {
            $result = array('status' => '', 'message' => '');
            $amount = $_POST['amount'];
            $card_nonce = $_POST['nonce'];

            if ($amount > 0 && $card_nonce) {
                //get square settings
                $mode = get_option('wpep_square_mode');
                if ($mode == 'test') {
                    $token = get_option('wpep_test_token');
                    $location_id = get_option('wpep_test_locationid');
                } else {
                    $token = get_option('wpep_live_token');
                    $location_id = get_option('wpep_live_locationid');
                }

                if ($token && $location_id) {

                    try {
                        $transaction_api = new \SquareConnect\Api\TransactionApi();
                        $idempotencyKey = time();

                        //check if donation 
                        $button_type = get_option('wpep_button_type');
                        $args = array(
                            'idempotency_key' => (string) $idempotencyKey,
                            'amount_money' => array(
                                'amount' => round($amount, 2) * 100,
                                'currency' => 'USD'
                            ),
                            'card_nonce' => $card_nonce,
                            'reference_id' => (string) $idempotencyKey
                        );

                        if ($button_type == 'donation') {
                            $args['note'] = 'Donation (' . get_option('wpep_donation_organization_name') . ')';
                        }

                        $transaction = $transaction_api->charge($token, $location_id, $args);

                        $transactionData = json_decode($transaction, true);

                        if (isset($transactionData['transaction']['id'])) {
							
                            $transactionId = $transactionData['transaction']['id'];
                            //send email to admin
                            $to = get_option('wpep_notification_email');
                            if ($to) {
                                $subject = 'New Payment';
                                $body = '<p>New WPEP Payment</p>
                                         <p><strong>Amount:</strong> ' . $amount . '</p>
                                         <p><strong>Transaction ID:</strong> ' . $transactionId . '</p>
                                         ';
                                $headers = array(
                                    'Content-Type: text/html; charset=UTF-8',
                                    'From: ' . get_option('blogname') . ' <' . get_option('admin_email') . '>'
                                );

                                wp_mail($to, $subject, $body, $headers);
                            }

                            $result = array('status' => 'success', 'message' => __('Payment success.', 'contact-form-7-square'));
                        }
                    } catch (Exception $ex) {
                        $errors = $ex->getResponseBody()->errors;

                        $message = '';
                        foreach ($errors as $error) {
                            $message = $error->detail;
                            if (isset($error->field))
                                $message = $error->field . ' - ' . $error->detail;
                        }
                        $result = array('status' => 'error', 'message' => $message);
                    }
                } else {
                    $result = array('status' => 'error', 'message' => __('Invalid square token or location id.', 'contact-form-7-square'));
                }
            }

            echo json_encode($result);
            wp_die();
        }

    }

}