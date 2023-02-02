<?php

namespace PaidCommunities\WordPress\Html;

class Notice {

	private static function start() {
		ob_start();
	}

	private static function end() {
		return ob_get_clean();
	}

	public static function renderError( $message ) {
		return self::renderNotice( $message, 'error' );
	}

	public static function renderSuccess( $message ) {
		return self::renderNotice( $message, 'success' );
	}

	public static function renderNotice( $message, $type ) {
		self::start();
		?>
        <div class="pc-admin-notice <?php echo $type ?>-notice">
            <div class="notice-icon">
				<?php self::icon( $type ) ?>
            </div>
            <div class="notice-message <?php echo $type ?>-message">
				<?php echo $message ?>
            </div>
            <div class="notice-actions">
                <div class="close-notice-icon pc-close-notice">
                    <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                    </svg>
                </div>
            </div>
        </div>
		<?php
		return self::end();
	}

	private static function icon( $type ) {
		if ( $type === 'success' ) {
			SuccessIcon::render();
		} elseif ( $type === 'error' ) {
			ErrorIcon::render();
		}
	}

}