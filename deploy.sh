#!/bin/bash

domain="jdd.sk"

# Get current time
# Example: 2020-03-21--03-25-55
dateFormatted=$(date +'%Y-%m-%d--%H-%M-%S')
dateHashed=$(echo -n "$dateFormatted" | shasum -a 256 )

# Get just the hash
# Example: 1d532be3df3aab07d7a215a1ae8d3ef13ee85775983c3ba40105bf4a50898d9d
dateHashed=$(echo -n ${dateHashed:0:64})

# Slice first twelve chars
shortHash=$(echo -n ${dateHashed:0:12})

# Example: 2020-03-21--03-03-51---4ff084f579f3
buildDir="${dateFormatted}---${shortHash}"

# Example: 4ff084f579f3e281883f22822efc8ec9aeae2ca6d58d818ba981b83c35c2c548-4ff084f579f3
curVersion="${dateHashed}-${shortHash}"

# Install dependencies
composer install

# Create the build dir
mkdir -p ~/"${domain}"/bin/builds/"${buildDir}"

# Copy app files
cp -r ./vendor ~/"${domain}"/bin/builds/"${buildDir}"
cp -r ./www ~/"${domain}"/bin/builds/"${buildDir}"
cp -r ./config.php ~/"${domain}"/bin/builds/"${buildDir}"

# Remove existing symlink/web directory
rm -rf ~/"${domain}"/web

cd ~/"${domain}"

# Create new symlink
ln -sf ./bin/builds/"${buildDir}"/www web
