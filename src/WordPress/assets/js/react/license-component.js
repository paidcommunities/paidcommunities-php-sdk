import {useState, useCallback} from '@wordpress/element';
import {Button} from '@wordpress/components';
import {activate, deactivate} from '@paidcommunities/wordpress-api';
import swal from 'sweetalert';
import classnames from 'classnames';

export default function LicenseComponent() {
    const [licenseKey, setLicenseKey] = useState('');
    const [processing, setProcessing] = useState(false);
    const {license, i18n, nonce, slug} = paidcommunitiesLicenseParams;

    const onChange = event => setLicenseKey(event.target.value);

    const onActivate = useCallback(async () => {
        setProcessing(true);
        try {
            const data = {
                nonce,
                license_key: licenseKey
            };
            const response = await activate(slug, data);
            if (!response.success) {
                addNotice(response.error, 'error');
            } else {
                addNotice(response.data.notice, 'success');
            }
        } catch (error) {
            addNotice(error, 'error');
        } finally {
            setProcessing(false);
        }
    }, [licenseKey]);

    const onDeactivate = useCallback(async () => {
        setProcessing(true);
        try {
            const response = await deactivate(slug, {nonce});
            if (!response.success) {
                addNotice(response.error, 'error');
            } else {
                addNotice(response.data.notice, 'success');
            }
        } catch (error) {
            addNotice(error, 'error');
        } finally {
            setProcessing(false);
        }
    }, []);

    return (
        <div className="PaidCommunitiesLicense-settings">
            <div className="PaidCommunitiesGrid-root">
                <div className="PaidCommunitiesGrid-item">
                    <div className="PaidCommunitiesStack-root LicenseKeyOptionGroup">
                        <label className="PaidCommunitiesLabel-root">{i18n.licenseKey}</label>
                        <div className={classnames('PaidCommunitiesInputBase-root', {
                            'LicenseRegistered': license.registered
                        })}>
                            {license.registered &&
                                <input className="PaidComunitiesInput-text LicenseKey"
                                       type={'text'}
                                       disabled
                                       value={license.license_key}/>
                            }
                            {!license.registered &&
                                <input
                                    className="PaidComunitiesInput-text LicenseKey"
                                    value={licenseKey}
                                    onChange={onChange}
                                />
                            }
                        </div>
                        {license.registered &&
                            <Button
                                variant={'primary'}
                                text={i18n.deactivateLicense}
                                isBusy={processing}
                                disabled={processing}
                                onClick={onDeactivate}>
                            </Button>
                        }
                        {!license.registered &&
                            <Button
                                variant={'primary'}
                                text={i18n.activateLicense}
                                isBusy={processing}
                                disabled={processing}
                                onClick={onActivate}/>
                        }
                    </div>
                </div>
            </div>
        </div>
    )
}

const addNotice = (notice, type) => {
    swal(paidcommunitiesLicenseParams.i18n[notice.code], notice.message, type);
}