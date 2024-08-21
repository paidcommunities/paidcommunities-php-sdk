<div class="PaidCommunitiesLicense-settings">
    <div class="PaidCommunitiesGrid-root">
        <div class="PaidCommunitiesGrid-item">
            <div class="PaidCommunitiesStack-root LicenseKeyOptionGroup">
                <label class="PaidCommunitiesLabel-root"><?php esc_html_e( 'License Key', 'paidcommunities' ) ?></label>
                <div class="PaidCommunitiesInputBase-root <?php if ( $license->isRegistered() ) { ?> LicenseRegistered<?php } ?>">
					<?php if ( $license->isRegistered() ): ?>
                        <input id="<?php echo esc_attr( $slug ) ?>-license_key" class="PaidCommunitiesInput-text LicenseKey" type="text" disabled value="<?php echo esc_attr( $license->getLicenseKey() ) ?>"/>
					<?php else: ?>
                        <input id="<?php echo esc_attr( $slug ) ?>-license_key" class="PaidCommunitiesInput-text LicenseKey"/>
					<?php endif ?>
                </div>
				<?php if ( $license->isRegistered() ): ?>
                    <button class="button PaidCommunitiesButton-root DeactivateLicense"><?php esc_html_e( 'Deacticate License', 'paidcommunities' ) ?></button>
				<?php else: ?>
                    <button class="button PaidCommunitiesButton-root ActivateLicense"><?php esc_html_e( 'Activate License', 'paidcommunities' ) ?></button>
				<?php endif ?>
            </div>
        </div>
    </div>
</div>