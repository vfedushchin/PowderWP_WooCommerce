<?php
/**
 * WooCommerce Jetpack Country Functions
 *
 * The WooCommerce Country Jetpack Functions.
 *
 * @version  2.4.0
 * @author   Algoritmika Ltd.
 */

/**
 * wcj_get_customer_country.
 *
 * @return string
 */
if ( ! function_exists( 'wcj_get_customer_country' ) ) {
	function wcj_get_customer_country( $user_id ) {

		$user_meta = get_user_meta( $user_id );

		$billing_country  = isset( $user_meta['billing_country'][0] )  ? $user_meta['billing_country'][0]  : '';
		$shipping_country = isset( $user_meta['shipping_country'][0] ) ? $user_meta['shipping_country'][0] : '';

		$customer_country = ( '' == $billing_country ) ? $shipping_country : $billing_country;

		return $customer_country;
	}
}

/**
 * wcj_get_european_union_countries_with_vat.
 *
 * @version 2.4.0
 * @return array
 */
if ( ! function_exists( 'wcj_get_european_union_countries_with_vat' ) ) {
	function wcj_get_european_union_countries_with_vat() {
		return array(
			'AT' => 20,
			'BE' => 21,
			'BG' => 20,
			'CY' => 19,
			'CZ' => 21,
			'DE' => 19,
			'DK' => 25,
			'EE' => 20,
			'ES' => 21,
			'FI' => 24,
			'FR' => 20,
			'GB' => 20,
			'GR' => 23,
			'HU' => 27,
			'HR' => 25,
			'IE' => 23,
			'IT' => 22,
			'LT' => 21,
			'LU' => 17,
			'LV' => 21,
			'MT' => 18,
			'NL' => 21,
			'PL' => 23,
			'PT' => 23,
			'RO' => 20,//24,
			'SE' => 25,
			'SI' => 22,
			'SK' => 20,

			//'MC' => ,
			//'IM' => ,
		);
	}
}

/**
 * Get country name by country code.
 *
 * @return string on success, boolean false otherwise
 */
if ( ! function_exists( 'wcj_get_country_name_by_code' ) ) {
	function wcj_get_country_name_by_code( $country_code ) {

		$countries = wcj_get_countries();

		if ( isset( $countries[ $country_code ] ) ) return $countries[ $country_code ];

		return false;
	}
}

/**
 * Get all countries array.
 *
 * @return array
 */
if ( ! function_exists( 'wcj_get_countries' ) ) {
	function wcj_get_countries() {
		return array(
			'AF' => __( 'Afghanistan', 'woocommerce' ),
			'AX' => __( '&#197;land Islands', 'woocommerce' ),
			'AL' => __( 'Albania', 'woocommerce' ),
			'DZ' => __( 'Algeria', 'woocommerce' ),
			'AD' => __( 'Andorra', 'woocommerce' ),
			'AO' => __( 'Angola', 'woocommerce' ),
			'AI' => __( 'Anguilla', 'woocommerce' ),
			'AQ' => __( 'Antarctica', 'woocommerce' ),
			'AG' => __( 'Antigua and Barbuda', 'woocommerce' ),
			'AR' => __( 'Argentina', 'woocommerce' ),
			'AM' => __( 'Armenia', 'woocommerce' ),
			'AW' => __( 'Aruba', 'woocommerce' ),
			'AU' => __( 'Australia', 'woocommerce' ),
			'AT' => __( 'Austria', 'woocommerce' ),
			'AZ' => __( 'Azerbaijan', 'woocommerce' ),
			'BS' => __( 'Bahamas', 'woocommerce' ),
			'BH' => __( 'Bahrain', 'woocommerce' ),
			'BD' => __( 'Bangladesh', 'woocommerce' ),
			'BB' => __( 'Barbados', 'woocommerce' ),
			'BY' => __( 'Belarus', 'woocommerce' ),
			'BE' => __( 'Belgium', 'woocommerce' ),
			'PW' => __( 'Belau', 'woocommerce' ),
			'BZ' => __( 'Belize', 'woocommerce' ),
			'BJ' => __( 'Benin', 'woocommerce' ),
			'BM' => __( 'Bermuda', 'woocommerce' ),
			'BT' => __( 'Bhutan', 'woocommerce' ),
			'BO' => __( 'Bolivia', 'woocommerce' ),
			'BQ' => __( 'Bonaire, Saint Eustatius and Saba', 'woocommerce' ),
			'BA' => __( 'Bosnia and Herzegovina', 'woocommerce' ),
			'BW' => __( 'Botswana', 'woocommerce' ),
			'BV' => __( 'Bouvet Island', 'woocommerce' ),
			'BR' => __( 'Brazil', 'woocommerce' ),
			'IO' => __( 'British Indian Ocean Territory', 'woocommerce' ),
			'VG' => __( 'British Virgin Islands', 'woocommerce' ),
			'BN' => __( 'Brunei', 'woocommerce' ),
			'BG' => __( 'Bulgaria', 'woocommerce' ),
			'BF' => __( 'Burkina Faso', 'woocommerce' ),
			'BI' => __( 'Burundi', 'woocommerce' ),
			'KH' => __( 'Cambodia', 'woocommerce' ),
			'CM' => __( 'Cameroon', 'woocommerce' ),
			'CA' => __( 'Canada', 'woocommerce' ),
			'CV' => __( 'Cape Verde', 'woocommerce' ),
			'KY' => __( 'Cayman Islands', 'woocommerce' ),
			'CF' => __( 'Central African Republic', 'woocommerce' ),
			'TD' => __( 'Chad', 'woocommerce' ),
			'CL' => __( 'Chile', 'woocommerce' ),
			'CN' => __( 'China', 'woocommerce' ),
			'CX' => __( 'Christmas Island', 'woocommerce' ),
			'CC' => __( 'Cocos (Keeling) Islands', 'woocommerce' ),
			'CO' => __( 'Colombia', 'woocommerce' ),
			'KM' => __( 'Comoros', 'woocommerce' ),
			'CG' => __( 'Congo (Brazzaville)', 'woocommerce' ),
			'CD' => __( 'Congo (Kinshasa)', 'woocommerce' ),
			'CK' => __( 'Cook Islands', 'woocommerce' ),
			'CR' => __( 'Costa Rica', 'woocommerce' ),
			'HR' => __( 'Croatia', 'woocommerce' ),
			'CU' => __( 'Cuba', 'woocommerce' ),
			'CW' => __( 'Cura&Ccedil;ao', 'woocommerce' ),
			'CY' => __( 'Cyprus', 'woocommerce' ),
			'CZ' => __( 'Czech Republic', 'woocommerce' ),
			'DK' => __( 'Denmark', 'woocommerce' ),
			'DJ' => __( 'Djibouti', 'woocommerce' ),
			'DM' => __( 'Dominica', 'woocommerce' ),
			'DO' => __( 'Dominican Republic', 'woocommerce' ),
			'EC' => __( 'Ecuador', 'woocommerce' ),
			'EG' => __( 'Egypt', 'woocommerce' ),
			'SV' => __( 'El Salvador', 'woocommerce' ),
			'GQ' => __( 'Equatorial Guinea', 'woocommerce' ),
			'ER' => __( 'Eritrea', 'woocommerce' ),
			'EE' => __( 'Estonia', 'woocommerce' ),
			'ET' => __( 'Ethiopia', 'woocommerce' ),
			'FK' => __( 'Falkland Islands', 'woocommerce' ),
			'FO' => __( 'Faroe Islands', 'woocommerce' ),
			'FJ' => __( 'Fiji', 'woocommerce' ),
			'FI' => __( 'Finland', 'woocommerce' ),
			'FR' => __( 'France', 'woocommerce' ),
			'GF' => __( 'French Guiana', 'woocommerce' ),
			'PF' => __( 'French Polynesia', 'woocommerce' ),
			'TF' => __( 'French Southern Territories', 'woocommerce' ),
			'GA' => __( 'Gabon', 'woocommerce' ),
			'GM' => __( 'Gambia', 'woocommerce' ),
			'GE' => __( 'Georgia', 'woocommerce' ),
			'DE' => __( 'Germany', 'woocommerce' ),
			'GH' => __( 'Ghana', 'woocommerce' ),
			'GI' => __( 'Gibraltar', 'woocommerce' ),
			'GR' => __( 'Greece', 'woocommerce' ),
			'GL' => __( 'Greenland', 'woocommerce' ),
			'GD' => __( 'Grenada', 'woocommerce' ),
			'GP' => __( 'Guadeloupe', 'woocommerce' ),
			'GT' => __( 'Guatemala', 'woocommerce' ),
			'GG' => __( 'Guernsey', 'woocommerce' ),
			'GN' => __( 'Guinea', 'woocommerce' ),
			'GW' => __( 'Guinea-Bissau', 'woocommerce' ),
			'GY' => __( 'Guyana', 'woocommerce' ),
			'HT' => __( 'Haiti', 'woocommerce' ),
			'HM' => __( 'Heard Island and McDonald Islands', 'woocommerce' ),
			'HN' => __( 'Honduras', 'woocommerce' ),
			'HK' => __( 'Hong Kong', 'woocommerce' ),
			'HU' => __( 'Hungary', 'woocommerce' ),
			'IS' => __( 'Iceland', 'woocommerce' ),
			'IN' => __( 'India', 'woocommerce' ),
			'ID' => __( 'Indonesia', 'woocommerce' ),
			'IR' => __( 'Iran', 'woocommerce' ),
			'IQ' => __( 'Iraq', 'woocommerce' ),
			'IE' => __( 'Republic of Ireland', 'woocommerce' ),
			'IM' => __( 'Isle of Man', 'woocommerce' ),
			'IL' => __( 'Israel', 'woocommerce' ),
			'IT' => __( 'Italy', 'woocommerce' ),
			'CI' => __( 'Ivory Coast', 'woocommerce' ),
			'JM' => __( 'Jamaica', 'woocommerce' ),
			'JP' => __( 'Japan', 'woocommerce' ),
			'JE' => __( 'Jersey', 'woocommerce' ),
			'JO' => __( 'Jordan', 'woocommerce' ),
			'KZ' => __( 'Kazakhstan', 'woocommerce' ),
			'KE' => __( 'Kenya', 'woocommerce' ),
			'KI' => __( 'Kiribati', 'woocommerce' ),
			'KW' => __( 'Kuwait', 'woocommerce' ),
			'KG' => __( 'Kyrgyzstan', 'woocommerce' ),
			'LA' => __( 'Laos', 'woocommerce' ),
			'LV' => __( 'Latvia', 'woocommerce' ),
			'LB' => __( 'Lebanon', 'woocommerce' ),
			'LS' => __( 'Lesotho', 'woocommerce' ),
			'LR' => __( 'Liberia', 'woocommerce' ),
			'LY' => __( 'Libya', 'woocommerce' ),
			'LI' => __( 'Liechtenstein', 'woocommerce' ),
			'LT' => __( 'Lithuania', 'woocommerce' ),
			'LU' => __( 'Luxembourg', 'woocommerce' ),
			'MO' => __( 'Macao S.A.R., China', 'woocommerce' ),
			'MK' => __( 'Macedonia', 'woocommerce' ),
			'MG' => __( 'Madagascar', 'woocommerce' ),
			'MW' => __( 'Malawi', 'woocommerce' ),
			'MY' => __( 'Malaysia', 'woocommerce' ),
			'MV' => __( 'Maldives', 'woocommerce' ),
			'ML' => __( 'Mali', 'woocommerce' ),
			'MT' => __( 'Malta', 'woocommerce' ),
			'MH' => __( 'Marshall Islands', 'woocommerce' ),
			'MQ' => __( 'Martinique', 'woocommerce' ),
			'MR' => __( 'Mauritania', 'woocommerce' ),
			'MU' => __( 'Mauritius', 'woocommerce' ),
			'YT' => __( 'Mayotte', 'woocommerce' ),
			'MX' => __( 'Mexico', 'woocommerce' ),
			'FM' => __( 'Micronesia', 'woocommerce' ),
			'MD' => __( 'Moldova', 'woocommerce' ),
			'MC' => __( 'Monaco', 'woocommerce' ),
			'MN' => __( 'Mongolia', 'woocommerce' ),
			'ME' => __( 'Montenegro', 'woocommerce' ),
			'MS' => __( 'Montserrat', 'woocommerce' ),
			'MA' => __( 'Morocco', 'woocommerce' ),
			'MZ' => __( 'Mozambique', 'woocommerce' ),
			'MM' => __( 'Myanmar', 'woocommerce' ),
			'NA' => __( 'Namibia', 'woocommerce' ),
			'NR' => __( 'Nauru', 'woocommerce' ),
			'NP' => __( 'Nepal', 'woocommerce' ),
			'NL' => __( 'Netherlands', 'woocommerce' ),
			'AN' => __( 'Netherlands Antilles', 'woocommerce' ),
			'NC' => __( 'New Caledonia', 'woocommerce' ),
			'NZ' => __( 'New Zealand', 'woocommerce' ),
			'NI' => __( 'Nicaragua', 'woocommerce' ),
			'NE' => __( 'Niger', 'woocommerce' ),
			'NG' => __( 'Nigeria', 'woocommerce' ),
			'NU' => __( 'Niue', 'woocommerce' ),
			'NF' => __( 'Norfolk Island', 'woocommerce' ),
			'KP' => __( 'North Korea', 'woocommerce' ),
			'NO' => __( 'Norway', 'woocommerce' ),
			'OM' => __( 'Oman', 'woocommerce' ),
			'PK' => __( 'Pakistan', 'woocommerce' ),
			'PS' => __( 'Palestinian Territory', 'woocommerce' ),
			'PA' => __( 'Panama', 'woocommerce' ),
			'PG' => __( 'Papua New Guinea', 'woocommerce' ),
			'PY' => __( 'Paraguay', 'woocommerce' ),
			'PE' => __( 'Peru', 'woocommerce' ),
			'PH' => __( 'Philippines', 'woocommerce' ),
			'PN' => __( 'Pitcairn', 'woocommerce' ),
			'PL' => __( 'Poland', 'woocommerce' ),
			'PT' => __( 'Portugal', 'woocommerce' ),
			'QA' => __( 'Qatar', 'woocommerce' ),
			'RE' => __( 'Reunion', 'woocommerce' ),
			'RO' => __( 'Romania', 'woocommerce' ),
			'RU' => __( 'Russia', 'woocommerce' ),
			'RW' => __( 'Rwanda', 'woocommerce' ),
			'BL' => __( 'Saint Barth&eacute;lemy', 'woocommerce' ),
			'SH' => __( 'Saint Helena', 'woocommerce' ),
			'KN' => __( 'Saint Kitts and Nevis', 'woocommerce' ),
			'LC' => __( 'Saint Lucia', 'woocommerce' ),
			'MF' => __( 'Saint Martin (French part)', 'woocommerce' ),
			'SX' => __( 'Saint Martin (Dutch part)', 'woocommerce' ),
			'PM' => __( 'Saint Pierre and Miquelon', 'woocommerce' ),
			'VC' => __( 'Saint Vincent and the Grenadines', 'woocommerce' ),
			'SM' => __( 'San Marino', 'woocommerce' ),
			'ST' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'woocommerce' ),
			'SA' => __( 'Saudi Arabia', 'woocommerce' ),
			'SN' => __( 'Senegal', 'woocommerce' ),
			'RS' => __( 'Serbia', 'woocommerce' ),
			'SC' => __( 'Seychelles', 'woocommerce' ),
			'SL' => __( 'Sierra Leone', 'woocommerce' ),
			'SG' => __( 'Singapore', 'woocommerce' ),
			'SK' => __( 'Slovakia', 'woocommerce' ),
			'SI' => __( 'Slovenia', 'woocommerce' ),
			'SB' => __( 'Solomon Islands', 'woocommerce' ),
			'SO' => __( 'Somalia', 'woocommerce' ),
			'ZA' => __( 'South Africa', 'woocommerce' ),
			'GS' => __( 'South Georgia/Sandwich Islands', 'woocommerce' ),
			'KR' => __( 'South Korea', 'woocommerce' ),
			'SS' => __( 'South Sudan', 'woocommerce' ),
			'ES' => __( 'Spain', 'woocommerce' ),
			'LK' => __( 'Sri Lanka', 'woocommerce' ),
			'SD' => __( 'Sudan', 'woocommerce' ),
			'SR' => __( 'Suriname', 'woocommerce' ),
			'SJ' => __( 'Svalbard and Jan Mayen', 'woocommerce' ),
			'SZ' => __( 'Swaziland', 'woocommerce' ),
			'SE' => __( 'Sweden', 'woocommerce' ),
			'CH' => __( 'Switzerland', 'woocommerce' ),
			'SY' => __( 'Syria', 'woocommerce' ),
			'TW' => __( 'Taiwan', 'woocommerce' ),
			'TJ' => __( 'Tajikistan', 'woocommerce' ),
			'TZ' => __( 'Tanzania', 'woocommerce' ),
			'TH' => __( 'Thailand', 'woocommerce' ),
			'TL' => __( 'Timor-Leste', 'woocommerce' ),
			'TG' => __( 'Togo', 'woocommerce' ),
			'TK' => __( 'Tokelau', 'woocommerce' ),
			'TO' => __( 'Tonga', 'woocommerce' ),
			'TT' => __( 'Trinidad and Tobago', 'woocommerce' ),
			'TN' => __( 'Tunisia', 'woocommerce' ),
			'TR' => __( 'Turkey', 'woocommerce' ),
			'TM' => __( 'Turkmenistan', 'woocommerce' ),
			'TC' => __( 'Turks and Caicos Islands', 'woocommerce' ),
			'TV' => __( 'Tuvalu', 'woocommerce' ),
			'UG' => __( 'Uganda', 'woocommerce' ),
			'UA' => __( 'Ukraine', 'woocommerce' ),
			'AE' => __( 'United Arab Emirates', 'woocommerce' ),
			'GB' => __( 'United Kingdom (UK)', 'woocommerce' ),
			'US' => __( 'United States (US)', 'woocommerce' ),
			'UY' => __( 'Uruguay', 'woocommerce' ),
			'UZ' => __( 'Uzbekistan', 'woocommerce' ),
			'VU' => __( 'Vanuatu', 'woocommerce' ),
			'VA' => __( 'Vatican', 'woocommerce' ),
			'VE' => __( 'Venezuela', 'woocommerce' ),
			'VN' => __( 'Vietnam', 'woocommerce' ),
			'WF' => __( 'Wallis and Futuna', 'woocommerce' ),
			'EH' => __( 'Western Sahara', 'woocommerce' ),
			'WS' => __( 'Western Samoa', 'woocommerce' ),
			'YE' => __( 'Yemen', 'woocommerce' ),
			'ZM' => __( 'Zambia', 'woocommerce' ),
			'ZW' => __( 'Zimbabwe', 'woocommerce' )
		);
	}
}
