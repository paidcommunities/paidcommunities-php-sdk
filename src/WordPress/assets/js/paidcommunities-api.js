import $ from 'jquery';

const activate = async (slug, data) => {
    const queries = new URLSearchParams({
        action: `activate_${slug}`
    });
    return new Promise((resolve) => {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl + '?' + queries.toString(),
            data
        }).done(response => {
            return resolve(response);
        }).fail((jqXHR) => {
            return resolve({});
        })
    });
}

const deactivate = async (slug, data) => {
    const queries = new URLSearchParams({
        action: `deactivate_${slug}`
    });
    return new Promise((resolve) => {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl + '?' + queries.toString(),
            data
        }).done(response => {
            return resolve(response);
        }).fail((jqXHR) => {
            return resolve({});
        })
    })
}

export {
    activate,
    deactivate
}