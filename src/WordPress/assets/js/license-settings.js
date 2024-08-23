import $ from 'jquery';
import swal from 'sweetalert';
import {activate, deactivate} from '@paidcommunities/wordpress-api';

const handleButtonClick = async e => {
    e.preventDefault();
    let response;
    let $button = $(e.currentTarget);
    const props = $button.data('paidcommunities-props');
    const {name, id, nonce} = props;
    let text = $button.text();
    try {
        $button.prop('disabled', true).addClass('updating-message');
        if ($button.hasClass('ActivateLicense')) {

            $button.text(props.i18n.activateMsg);

            const data = {
                nonce,
                license_key: $(`#${id}-license_key`).val()
            }

            response = await activate(name, data);

        } else {
            $button.text(props.i18n.deactivateMsg);

            response = await deactivate(name, {nonce});
        }
        if (!response.success) {
            addNotice(response.error, 'error', props.i18n);
        } else {
            addNotice(response.data.notice, 'success', props.i18n);
            $('.PaidCommunitiesLicense-settings').replaceWith(response.data.html);
        }
    } catch (error) {
        return addNotice(error);
    } finally {
        $button.prop('disabled', false);
        $button.text(text).removeClass('updating-message');
    }
}

const addNotice = (i18n, notice, type) => {
    swal(i18n[notice.code], notice.message, type);
}

$(document.body).on('click', '.ActivateLicense', handleButtonClick);
$(document.body).on('click', '.DeactivateLicense', handleButtonClick);