NAME="paidcommunities-php-sdk"
BASE_PATH=$(pwd)
BUILD_PATH="${BUILD_PATH}/build"
DEST_PATH="$BUILD_PATH/$Name"

echo 'Creating build directory...'
#create the build directory
rm -rf "$BUILD_PATH"

mkdir "$DEST_PATH"

#rsync files into destination path
rsync -rc --exclude-from="${BASE_PATH}/.distignore" "$BASE_PATH/" "$DEST_PATH/" --delete

# run composer install



