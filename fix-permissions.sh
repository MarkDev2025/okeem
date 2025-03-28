
# Script pour corriger les permissions sur database et storage (Laravel)
# À lancer depuis la racine du projet : ./fix-permissions.sh

echo "🔧 Correction des permissions sur le backend Laravel..."

TARGET_DIR="./okeem-admin"

sudo chown -R $USER:$USER $TARGET_DIR/database
sudo chown -R $USER:$USER $TARGET_DIR/storage
sudo chmod -R u+rwX $TARGET_DIR/database
sudo chmod -R u+rwX $TARGET_DIR/storage

echo "✅ Permissions corrigées. Vous pouvez maintenant supprimer ou modifier les fichiers."