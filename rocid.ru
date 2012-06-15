 server {
        server_name  vk.rocid.ru;
        server_name www2.rocid.ru;

        server_name api.rocid.ru www.api.rocid.ru;
        server_name m.rocid.ru www.m.rocid.ru;
        server_name beta.rocid.ru www.beta.rocid.ru;
        server_name rocid.ru www.rocid.ru;

        root /home/projects/rocid/www;

        charset utf-8;

        location / {
            index  index.php;
            try_files $uri $uri/ @yii;

        }


        location /files/photo/ {
        error_page 404 /files/photo/404.php;
        }

        # redirect server error pages to the static page /50x.html
        #
        error_page   500 502 503 504  /50x.html;
        location = /50x.html {
            root   /home/projects/rocid/www;
        }



        # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
        #
        location ~ \.php$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            fastcgi_param  PATH_INFO $fastcgi_script_name;
            include        /etc/nginx/fastcgi_params;
        }
        location @yii {
            fastcgi_pass 127.0.0.1:9000;
            include fastcgi_params;
            fastcgi_param  SCRIPT_NAME      /index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root/index.php;
            fastcgi_param  QUERY_STRING     $args;
        }


        # deny access to .htaccess files, if Apache's document root
        # concurs with nginx's one
        #
        location ~ /\.ht {
            deny  all;
        }
}
