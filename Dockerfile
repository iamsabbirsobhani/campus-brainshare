FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the contents of your app to the working directory
COPY . .

# Install any necessary dependencies
RUN apt-get update && apt-get install -y
# Add any additional packages here
# Install PHP dependencies using Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev

# Set ServerName directive in Apache configuration
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Update permissions to allow Apache to read files and list directories
RUN chown -R www-data:www-data /var/www/html

# Update Apache configuration to allow access to the directory and set the document root to the public directory
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf
RUN echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf
RUN echo '        Options Indexes FollowSymLinks' >> /etc/apache2/sites-available/000-default.conf
RUN echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf
RUN echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf
RUN echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Expose the port your app will be running on
EXPOSE 80

# Start the Apache web server
CMD ["apache2-foreground"]

# docker build -t campus-brainshare .

# docker tag campus-brainshare sabbirsobhani/campus-brainshare

# docker push sabbirsobhani/campus-brainshare
