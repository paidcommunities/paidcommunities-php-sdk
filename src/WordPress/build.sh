BASE_PATH=$(pwd)

rm -rf "${BASE_PATH}/build"

mkdir -p "${BASE_PATH}/build"

# clone repository to this directory. We use github2.com so the paidcommunities ssh key is used
echo 'cloning paidcommunities-wp repository...'
git clone git@github2.com:paidcommunities/paidcommunities-wp.git

cd paidcommunities-wp

if [ -d "node_modules" ]; then
  echo "Directory exists. Running npm update..."
  npm update
else
  echo "Directory does not exist. Running npm install..."
  npm install
fi

npm run build:prod

echo 'copying dist directory to build'
cp -R dist/* "${BASE_PATH}/build"

cd "$BASE_PATH" || exit