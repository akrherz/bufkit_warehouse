Alias /bufkit "/opt/bufkit_warehouse/htdocs"

<Directory "/opt/bufkit_warehouse/htdocs">
    Options -Indexes +MultiViews
    AllowOverride None
    Require all granted
    <FilesMatch \.html$>
        ProxyErrorOverride On
        # sigh, this is CI specific at the moment
        SetHandler "proxy:unix:/run/php/php8.3-fpm.sock|proxy:unix:/run/php-fpm/www.sock|fcgi://localhost"
    </FilesMatch>
</Directory>

# Redirect away data references
RedirectMatch 301 ^/data/(cobb_gfs|cobb_nam|nam|hrrr|rap|gfs)(.*)$ https://metfs1.agron.iastate.edu/data/bufkit/$1$2
