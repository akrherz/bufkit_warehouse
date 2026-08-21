Alias /bufkit "/opt/bufkit_warehouse/htdocs"

<Directory "/opt/bufkit_warehouse/htdocs">
    Options -Indexes +MultiViews
    AllowOverride None
    Require all granted

    # Rewrite any requested .html file as .php due to a legacy issue
    # with orig files being named .html but containing .php
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)\.html$ $1.php [L]

</Directory>

# Redirect away data references
RedirectMatch 301 ^/data/(cobb_gfs|cobb_nam|nam|hrrr|rap|gfs)(.*)$ https://metfs1.agron.iastate.edu/data/bufkit/$1$2
