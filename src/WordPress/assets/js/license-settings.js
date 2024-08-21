import $ from 'jquery';
import swal from 'sweetalert';
import {activate, deactivate} from '@paidcommunities/wordpress-api';

const getValue = key => paidcommunitiesLicenseParams[key] || null;

const slug = getValue('slug');

const handleButtonClick = async e => {
    e.preventDefault();
    let response;
    let $button = $(e.currentTarget);
    let text = $button.text();
    let license = getValue('license');
    try {
        $button.prop('disabled', true).addClass('updating-message');
        if ($button.hasClass('ActivateLicense')) {
            $button.text(getValue('i18n').activateMsg);

            const data = {
                nonce: getValue('nonce'),
                license_key: $(`#${slug}-license_key`).val()
            }

            response = await activate(slug, data);

        } else {
            $button.text(getValue('i18n').deactivateMsg);
            const nonce = getValue('nonce');

            response = await deactivate(slug, {nonce});
        }
        if (!response.success) {
            addNotice(response.error, 'error');
        } else {
            addNotice(response.data.notice, 'success');
            $('.PaidCommunitiesLicense-settings').replaceWith(response.data.html);
        }
    } catch (error) {
        return addNotice(error);
    } finally {
        $button.prop('disabled', false);
        $button.text(text).removeClass('updating-message');
    }
}

const addNotice = (notice, type) => {
    swal(paidcommunitiesLicenseParams.i18n[notice.code], notice.message, type);
}

$(document.body).on('click', '.ActivateLicense', handleButtonClick);
$(document.body).on('click', '.DeactivateLicense', handleButtonClick);