
Alias /bufkit "/opt/bufkit_warehouse/htdocs"

<Directory "/opt">
    Options +FollowSymLinks
    AllowOverride None
    Require all granted
</Directory>

<Directory "/opt/bufkit_warehouse/htdocs">
  Options Indexes MultiViews
  AllowOverride None
  Require all granted
  <FilesMatch \.html$>
    ProxyErrorOverride On
    SetHandler "proxy:unix:/run/php-fpm/www.sock|fcgi://localhost"
  </FilesMatch>

</Directory>
