<?php

/**
 * Add Dashboard & Settings links on the Plugin index page
 *
 * @param  array $actions      Existing links
 * @param  string $plugin_file The plugin file being processed
 * @return array               Links with Dashboard & Settings prepended
 */
function swiftpic_plugin_action_links($actions, $plugin_file) {
	// Skip plugins that aren't ours
	if ($plugin_file !== 'swiftpic/swiftpic.php') {
		return $actions;
	}

	return array_merge(array(
		'<a href="' . admin_url('options-general.php?page=swiftpic') . '">' . __('Settings', 'swiftpic') . '</a>',
		'<a href="https://swiftpic.io/" target="_blank">' . __('Documentation', 'swiftpic') . '</a>'
	), $actions);
}
add_filter('plugin_action_links', 'swiftpic_plugin_action_links', null, 2);

/**
 * Add admin menu link to Settings > SwiftPic
 *
 * @return void
 */
function swiftpic_add_admin_menu() {
	add_options_page('SwiftPic', 'SwiftPic', 'manage_options', 'swiftpic', 'swiftpic_options_page');
}
add_action('admin_menu', 'swiftpic_add_admin_menu');

/**
 * Add settings page Settings > SwiftPic
 *
 * @return void
 */
function swiftpic_settings_init() {
	register_setting('swiftpic_pluginPage', 'swiftpic_settings', 'swiftpic_sanitize');

	add_settings_section(
		'swiftpic_pluginPage_section',
		'',
		'swiftpic_settings_section_callback',
		'swiftpic_pluginPage'
	);

	add_settings_field(
		'username',
		__('Username', 'swiftpic'),
		'swiftpic_username_render',
		'swiftpic_pluginPage',
		'swiftpic_pluginPage_section'
	);

	add_settings_field(
		'swiftpic_secret_key',
		__('Secret Key', 'swiftpic'),
		'swiftpic_secret_key_render',
		'swiftpic_pluginPage',
		'swiftpic_pluginPage_section'
	);

	add_settings_field(
		'swiftpic_site_url',
		__('Site URL', 'swiftpic'),
		'swiftpic_site_url_render',
		'swiftpic_pluginPage',
		'swiftpic_pluginPage_section'
	);
}
add_action('admin_init', 'swiftpic_settings_init');

/**
 * Settings page input field
 *
 * @return void
 */
function swiftpic_username_render() {
	$options = (array) get_option('swiftpic_settings');
	$value = array_key_exists('username', $options) ? $options['username'] : '';
	?>

	<fieldset>
		<legend class="screen-reader-text"><span>Username</span></legend>
		<p>
			<input name="swiftpic_settings[username]" type="text" class="regular-text code" value="<?php echo esc_attr($value); ?>">
		</p>
	</fieldset>

	<?php
}

/**
 * Settings page input field
 *
 * @return void
 */
function swiftpic_secret_key_render() {
	$options = (array) get_option('swiftpic_settings');
	$value = array_key_exists('secret_key', $options) ? $options['secret_key'] : '';
	?>

	<fieldset>
		<legend class="screen-reader-text"><span>secret_key</span></legend>
		<p>
			<input name="swiftpic_settings[secret_key]" type="text" class="regular-text code" minlength="32" maxlength="32" value="<?php echo esc_attr($value); ?>">
		</p>
	</fieldset>

	<?php
}

/**
 * Settings page input field
 *
 * @return void
 */
function swiftpic_site_url_render() {
	$options = (array) get_option('swiftpic_settings');
	$value = array_key_exists('site_url', $options) ? $options['site_url'] : '';
	?>

	<fieldset>
		<legend class="screen-reader-text"><span>site_url</span></legend>
		<p>
			<input name="swiftpic_settings[site_url]" type="url" class="regular-text code" value="<?php echo esc_attr($value); ?>">
		</p>
	</fieldset>

	<?php
}

/**
 * Function that fills the Settings section with the desired content. The function should echo its output.
 *
 * @return void
 */
function swiftpic_settings_section_callback() {}

/**
 * Settings page
 *
 * @return void
 */
function swiftpic_options_page() {
	?>
	<div class="wrap">
		<h1>SwiftPic Settings</h1>

		<form action='options.php' method='post'>
			<?php
				settings_fields('swiftpic_pluginPage');
				do_settings_sections('swiftpic_pluginPage');
				submit_button();
			?>
		</form>
	<?php
}
