## 설치방법

```bash
root@ubuntu:~# apt-get install apache2
root@ubuntu:~# apt-cache search mysql-server
mysql-server - MySQL database server (metapackage depending on the latest version)
mysql-server-5.7 - MySQL database server binaries and system database setup
mysql-server-core-5.7 - MySQL database server binaries
auth2db - Powerful and eye-candy IDS logger, log viewer and alert generator
mariadb-server-10.0 - MariaDB database server binaries
mariadb-server-core-10.0 - MariaDB database core server files
percona-server-server-5.6 - Percona Server database server binaries
percona-xtradb-cluster-server-5.6 - Percona XtraDB Cluster database server binaries


root@ubuntu:~# apt-get install mysql-server-5.7
(password: toor)

root@ubuntu:~# apt-get install mysql-server mysql-client
root@ubuntu:~# add-apt-repository ppa:ondrej/php
root@ubuntu:~# apt-get update
root@ubuntu:~# apt-get install php5.6 php5.6-common
root@ubuntu:~# apt-get install php5.6-mysql php5.6-curl php5.6-xml php5.6-zip php5.6-gd php5.6-mbstring php5.6-mcrypt
root@ubuntu:~# sh -c 'echo "<?php phpinfo(); ?>" > /var/www/html/info.php'
root@ubuntu:~# php -v


```

