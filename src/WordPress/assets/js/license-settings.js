import $ from 'jquery';

const getValue = key => paidCommunitiesLicenseParams[key] || null;

const activate = () => {
    const key = getValue('pluginName');
    const id = `#${key}_license`;
    const license = $(id).val();
    return new Promise((resolve) => {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: getValue('ajaxUrl'),
            data: {
                action: getValue('actions').activate,
                license
            }
        }).done(response => {
            return resolve(response);
        }).fail((jqXHR) => {
            return resolve(response);
        })
    });
}

const deactivate = () => {
    return new Promise((resolve) => {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: getValue('ajaxUrl'),
            data: {
                action: getValue('actions').deactivate
            }
        }).done(response => {
            return resolve(response);
        }).fail((jqXHR) => {
            return resolve(response);
        })
    })
}

const handleButtonClick = async e => {
    let response;
    let $button = $(e.currentTarget);
    let text = $button.text();
    let license = getValue('license');
    try {
        if (license.status !== 'active') {
            $button.text(getValue('i18n').activateMsg);
            response = await activate();
        } else {
            $button.text(getValue('i18n').deactivateMsg);
            response = await deactivate();
        }
        if (!response.success) {
            return addErrorMessage(response?.error?.message);
        }
        return addErrorMessage(response.data.message);
    } catch (error) {
        return addErrorMessage(error.message);
    } finally {
        $button.text(text);
    }
}

const addErrorMessage = message => {
    const $message = $(message);
    $message.on('click', '.pc-close-notice', () => {
        $message.remove();
    });
    $('.pc-notices').append($message);
}

$(document.body).on('click', '.paidcommunities-license-btn', handleButtonClick);