#!/bin/bash
set -e

# Define paths
DEST="/home/elitearaby/public_html"
USER="elitearaby"
GROUP="elitearaby"

echo "Using Destination: $DEST"

# Ensure clean slate (except .well-known for SSL if existing)
# sudo rm -rf $DEST/*  <-- Too dangerous to auto-run. I'll just overwrite.

# Move Archive
echo "Moving archive..."
sudo mv /tmp/deploy.tar.gz $DEST/

# Extract
echo "Extracting..."
cd $DEST
sudo tar -xzf deploy.tar.gz
sudo rm deploy.tar.gz

# Move .env after extraction to ensure it's not overwritten
echo "Setting up .env..."
sudo mv /tmp/.env $DEST/.env

# Fix Permissions
echo "Fixing permissions..."
sudo chown -R $USER:$GROUP $DEST
sudo find $DEST -type f -exec chmod 644 {} \;
sudo find $DEST -type d -exec chmod 755 {} \;

# Storage Permissions
echo "Setting storage permissions..."
sudo chmod -R 775 $DEST/storage
sudo chmod -R 775 $DEST/bootstrap/cache
sudo chown -R $USER:$GROUP $DEST/storage
sudo chown -R $USER:$GROUP $DEST/bootstrap/cache

# Run Composer (as user to avoid root issues with composer)
echo "Running Composer..."
sudo -u $USER /usr/local/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader --no-interaction --working-dir=$DEST

# Clear Cache
echo "Cleaning cache..."
sudo -u $USER /usr/local/bin/php $DEST/artisan config:clear
sudo -u $USER /usr/local/bin/php $DEST/artisan cache:clear

# Run Migrations
echo "Running Migrations..."
sudo -u $USER /usr/local/bin/php $DEST/artisan migrate --force

# Symlink Storage
echo "Linking storage..."
sudo -u $USER /usr/local/bin/php $DEST/artisan storage:link

# Setup .htaccess for cPanel (Redirect to public/)
echo "Configuring .htaccess..."
cat <<EOT | sudo -u $USER tee $DEST/.htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/\$1 [L]
</IfModule>
EOT

echo "Deployment Complete!"
