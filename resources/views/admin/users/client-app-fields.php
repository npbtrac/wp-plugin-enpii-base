<?php
use Collective\Html\HtmlFacade;
use Enpii_Base\App\Support\App_Const;

/** @var \Enpii_Base\App\WP\Enpii_Base_WP_Plugin $wp_plugin */
/** @var \WP_User $user */

$user_id = $user->ID;

// We want to add the trailing slash to avoid the redirect in WP webserver rule
$generate_client_app_url = esc_js( wp_app_route_wp_url( 'wp-app::users-generate-client-app' ) . '/' );

$csrf_token = esc_attr( wp_app_csrf_token() );

// We want to have an interval that works every 2 mins (120 000 miliseconds)
//  To perform the queue execution because we set timeout
//  for the queue-work endpoint to 60 seconds
$script = <<<SCRIPT
<script type="text/javascript">
	jQuery(document).ready( function() {
		var generate_client_app_url = '$generate_client_app_url';

		jQuery('#wp-app-generate-client-app').click(function(){
			jQuery.ajax({
				url: generate_client_app_url,
				method: "POST",
				data: {
					"_token": "$csrf_token",
				},
				complete: function(jq_xhr, text_status){
				 	jQuery('#wp-app-client-app-id').text(jq_xhr.responseJSON.client_id);
				 	jQuery('#wp-app-client-app-secret').text(jq_xhr.responseJSON.client_secret);
				}
			});
		});
	});
</script>
SCRIPT;

// We suppress phpcs rule here because we escape the variable already
//  the rest of the script are static text
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $script;
?>
<h3><?php echo wp_kses_post( $wp_plugin->_t( 'Client Credentials App Info' ) ); ?></h3>

<table class="form-table">
	<tr>
		<th>
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo HtmlFacade::tag( 'label', esc_html( $wp_plugin->_t( 'Client Id' ) ) );
			?>
		</th>
		<td>
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo HtmlFacade::tag(
				'strong',
				esc_html( get_user_meta( $user_id, App_Const::USER_META_CLIENT_CREDENTIALS_APP_ID, true ) ),
				[
					'id' => 'wp-app-client-app-id',
				]
			);
			?>
		</td>
	</tr>
	<tr>
		<th>
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo HtmlFacade::tag( 'label', esc_html( $wp_plugin->_t( 'Client Secret' ) ) );
			?>
		</th>
		<td>
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo HtmlFacade::tag(
				'strong',
				esc_html( get_user_meta( $user_id, App_Const::USER_META_CLIENT_CREDENTIALS_APP_SECRET, true ) ),
				[
					'id' => 'wp-app-client-app-secret',
				]
			);
			?>
		</td>
	</tr>
	<tr>
		<th></th>
		<td>
			<?php
			if ( get_current_user_id() === $user_id ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo HtmlFacade::tag(
					'button',
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html( $wp_plugin->_t( 'Generate Client App' ) ),
					[
						'id' => 'wp-app-generate-client-app',
						'type' => 'button',
						'class' => 'button',
					]
				);
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo HtmlFacade::tag(
					'p',
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html( $wp_plugin->_t( 'Note: Regenerate the Client App will cause the previous app deleted.' ) ),
					[
						'class' => 'description',
					]
				);
			}
			?>
		</td>
	</tr>
</table>

