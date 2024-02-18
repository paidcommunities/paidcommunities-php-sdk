<form class="PaidCommunitiesLicense-settings">
    <div class="PaidCommunitiesGrid-root">
        <div class="PaidCommunitiesGrid-item">
            <div class="PaidCommunitiesStack-root">
                <label class="PaidCommunitiesLabel-root"><?php esc_html_e( 'License Key', 'paidcommunities' ) ?></label>
                <div <?php if ( $license->isRegistered() ){ ?>class="LicenseRegistered"<?php } ?>>
					<?php if ( $license->isRegistered() ): ?>
                        <input name="license_key" class="PaidComunitiesInput-text LicenseKey" type="text" disabled value="<?php echo esc_attr( $license->getLicenseKey() ) ?>"/>
					<?php else: ?>
                        <input name="license_key" class="PaidComunitiesInput-text LicenseKey"/>
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
</form>