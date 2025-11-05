# 1. Image de Base : Utilise l'image PHP officielle avec Apache
# Nous choisissons la version 8.2 (ou la version que vous préférez)
FROM php:8.2-apache

# 2. Définir le répertoire de travail
WORKDIR /var/www/html

# 3. Supprimer le contenu par défaut de l'image Apache
RUN rm -rf /var/www/html/*

# 4. Copier tout votre code (index.php, style.css, etc.) dans le conteneur
COPY . /var/www/html

# 5. Créer le dossier 'uploads' et s'assurer qu'il est accessible en écriture
# C'est CRUCIAL pour que PHP puisse y déplacer les fichiers.
RUN mkdir -p /var/www/html/uploads
RUN chmod -R 777 /var/www/html/uploads

# 6. Exposer le port par défaut d'Apache (Render le gérera)
EXPOSE 80

# 7. Le conteneur démarre automatiquement Apache (inclus dans l'image de base)
# Le fichier CMD n'est pas nécessaire ici car il est déjà défini dans l'image php:8.2-apache

