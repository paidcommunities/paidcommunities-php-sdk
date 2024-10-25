BASE_PATH=$(pwd)

# clone repository to this directory. We use github2.com so the paidcommunities ssh key is used
echo 'cloning paidcommunities-wp repository...'
git clone git@github2.com:paidcommunities/paidcommunities-wp.git

cd paidcommunities-wp

echo 'npm install...'

npm install

npm run build:prod

rm -rf "${BASE_PATH}/build"

echo 'copying dist directory to build'
cp -R dist/* "${BASE_PATH}/build"

cd BASE_PATH

rm -rf paidcommunities-wp