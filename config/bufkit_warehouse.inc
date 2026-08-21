Alias /bufkit "/opt/bufkit_warehouse/htdocs"

<Directory "/opt/bufkit_warehouse/htdocs">
    Options Indexes MultiViews
    AllowOverride None
    Require all granted
    <FilesMatch \.html$>
        ProxyErrorOverride On
        # sigh, this is CI specific at the moment
        SetHandler "proxy:unix:/run/php/php8.3-fpm.sock|fcgi://localhost"
    </FilesMatch>
</Directory>
