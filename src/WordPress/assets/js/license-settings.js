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
        $button.prop('disabled', true);
        if ($button.hasClass('activate')) {
            $button.text(getValue('i18n').activateMsg);
            response = await activate();
        } else {
            $button.text(getValue('i18n').deactivateMsg);
            response = await deactivate();
        }
        if (!response.success) {
            return addNotice(response?.error?.message);
        }
        $('.pc-license-settings').replaceWith(response.data.html);
        return addNotice(response.data.message);
    } catch (error) {
        return addNotice(error.message);
    } finally {
        $button.prop('disabled', false);
        $button.text(text);
    }
}

const addNotice = message => {
    const $message = $(message);
    $message.on('click', '.pc-close-notice', () => {
        $message.remove();
    });
    $('.pc-notices').append($message);
}

$(document.body).on('click', '.paidcommunities-license-btn', handleButtonClick);