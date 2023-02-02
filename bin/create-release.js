require('dotenv').config();
const {Octokit} = require('octokit');

const octokit = new Octokit({
    auth: process.env.GITHUB_TOKEN
});

const owner = process.env.GITHUB_OWNER;
const repo = process.env.GITHUB_REPOSITORY;
const tag = process.env.GITHUB_TAG;

octokit.request(`POST /repos/{owner}/{repo}/releases`, {
    owner: owner,
    repo: repo,
    tag_name: tag,
    target_commitish: 'master',
    name: 'v1.0.0',
    body: 'Description of the release',
    draft: false,
}).then(response => {
    // use the response to upload the file
    octokit.request(`POST /repos/{owner}/{repo}/releases/{release_id}/assets{?name,label}`, {
        owner: owner,
        repo: repo,
        release_id: response.id,
        name: '',
        label: '',
        data: '@/build/release-asset.zip',
        headers: {
            'Content-Type': 'application/zip'
        }
    }).then(response => {

    }).catch(error => {
        console.log(error);
    })
}).catch(error => {
    console.log(error);
})