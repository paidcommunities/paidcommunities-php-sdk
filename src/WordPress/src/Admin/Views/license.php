<div class="pc-license-settings">
    <div class="pc-license-settings__header">
        <h2><?php esc_html_e( $this->options->getSettingsTitle() ) ?></h2>
    </div>
    <div class="pc-grid-sm-6">
        <div class="pc-paper">
            <div class="pc-row">
                <div class="pc-grid">
                    <div class="pc-input-field">
                        <label><?php esc_html_e( 'License Key', 'paidcommunities' ) ?></label>
                        <span><?php echo $license->getLicenseKey() ?></span>
                    </div>
                </div>
            </div>
            <div class="pc-row">
                <div class="pc-grid">
                    <button class="btn button-secondary paidcommunities-license-btn deactivate"><?php esc_html_e( 'Deactivate Site', 'paidcommunities' ); ?></button>
                </div>
            </div>
            <div class="pc-notices"></div>
        </div>
    </div>
</div>
