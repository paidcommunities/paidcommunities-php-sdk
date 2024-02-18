<div class="pc-license-settings">
    <div class="pc-license-settings__header">
        <h2><?php esc_html_e( $this->options->getSettingsTitle() ) ?></h2>
    </div>
    <div class="pc-grid-sm-6">
        <div class="pc-paper">
            <div class="pc-row">
                <div class="pc-grid">
                    <div class="pc-stack">
                        <label class="pc-label"><?php esc_html_e( 'License Key', 'paidcommunities' ) ?>:</label>
                        <span class="pc-ml-2"><?php echo $license->getLicenseKey() ?></span>
                    </div>
                </div>
                <div class="pc-grid">
                    <div class="pc-stack">
                        <label class="pc-label"><?php esc_html_e( 'Status', 'paidcommunities' ) ?>:</label>
                        <span class="pc-ml-2 pc-status-<?php echo esc_attr( $license->getStatus() ) ?>"><?php echo strtoupper( $license->getStatus() ) ?></span>
                    </div>
                </div>
                <div class="pc-grid">
                    <div class="pc-stack">
                        <label class="pc-label"><?php esc_html_e( 'Domain', 'paidcommunities' ) ?>:</label>
                        <span class="pc-ml-2"><?php echo $license->getDomain() ?></span>
                    </div>
                </div>
                <div class="pc-grid">
                    <div class="pc-stack">
                        <label class="pc-label"><?php esc_html_e( 'Domain ID', 'paidcommunities' ) ?>:</label>
                        <span class="pc-ml-2"><?php echo $license->getDomainId() ?></span>
                    </div>
                </div>
                <div class="pc-grid">
                    <div class="pc-stack">
                        <label class="pc-label"><?php esc_html_e( 'Last Update Check', 'paidcommunities' ) ?>:</label>
                        <span class="pc-ml-2"><?php echo $license->getLastCheck() ?></span>
                    </div>
                </div>
                <div class="pc-grid">
                    <button class="btn button-secondary paidcommunities-license-btn deactivate"><?php esc_html_e( 'Deactivate Site', 'paidcommunities' ); ?></button>
                </div>

                <div class="pc-notices"></div>
            </div>
        </div>
    </div>
