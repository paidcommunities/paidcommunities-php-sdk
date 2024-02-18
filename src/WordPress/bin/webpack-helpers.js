const isDev = () => {
    return getEnv() === 'development';
}

const getEnv = () => {
    return process.env.NODE_ENV || 'development';
}

wcDepMap = {
    '@paidcommunities/wordpress-api': ['paidcommunities', 'wp', 'api']
}

wcHandleMap = {
    '@paidcommunities/wordpress-api': 'paidcommunities-wordpress-api',
}

const requestToHandle = (request) => {
    if (wcHandleMap[request]) {
        return wcHandleMap[request];
    }
}

const requestToExternal = (request) => {
    if (wcDepMap[request]) {
        return wcDepMap[request];
    }
}

module.exports = {
    getEnv,
    isDev,
    requestToHandle,
    requestToExternal
}