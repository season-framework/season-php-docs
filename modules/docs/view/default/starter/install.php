<div class="d-flex">
  <h2 class="h1 mt-0 mb-3">Installation</h2>
</div>

<p>To build the sample environment, follow the script below (in Ubuntu)</p>

<h2>System Requirements</h2>

<ul>
  <li>Apache or Nginx</li>
  <li>PHP 7.0 or upper</li>
  <li>MySQL (if you needed)</li>
</ul>

<pre>
apt-get install apache2 libapache2-mod-php7.2 -y
apt-get install php7.2-gd php7.2-json php7.2-mysql php7.2-curl php7.2-mbstring php7.2-intl php-imagick php7.2-xml php7.2-zip -y
apt install mariadb-server -y
</pre>

<p>Database configuration</p>

<pre>
mysql -u root
> GRANT ALL PRIVILEGES ON *.* TO &lt;dbuser&gt;@'%' IDENTIFIED BY '&lt;dbpassword&gt;';
</pre>

<p>edit <code class="bg-orange-lt">/etc/mysql/mariadb.conf.d/50-server.cnf</code> for allow external access.</p>

<pre>
[mysqld]
user		= mysql
pid-file	= /var/run/mysqld/mysqld.pid
socket		= /var/run/mysqld/mysqld.sock
port		= 3306
basedir		= /usr
datadir		= /var/lib/mysql
tmpdir		= /tmp
...

# bind-address	= 127.0.0.1
bind-address	= 0.0.0.0
</pre>

<p>Restart MySQL</p>

<pre>
service mysql restart
</pre>

<h2>Install season-php</h2>

<pre>
cd /var/www
mkdir &lt;projectname&gt;
cd &lt;projectname&gt;
mkdir websrc
git clone https://github.com/season-framework/season-php
</pre>

<p>for using season-php, create <code class="bg-orange-lt">/var/www/&lt;projectname&gt;/season-php/public/_include.php</code> file.</p>

<pre>
&lt;?php
define('PATH_BASE', '/var/www/&lt;projectname&gt;/websrc');
</pre>

<p>Apache configuration for season-php, edit <code class="bg-orange-lt">/etc/apache2/sites-available/&lt;your-domain.com&gt;.conf</code> file.</p>
<pre>
&lt;VirtualHost *:80&gt;
  ServerName &lt;your-domain.com&gt;
  ServerAdmin webmaster@localhost
  DocumentRoot /var/www/&lt;projectname&gt;/season-php/public
  ErrorLog ${APACHE_LOG_DIR}/error.log
  CustomLog ${APACHE_LOG_DIR}/access.log combined

  &lt;Directory /var/www/&lt;projectname&gt;/&gt;
    Options FollowSymLinks
    AllowOverride All
    Order allow,deny
    Allow from all
  &lt;/Directory&gt;
&lt;/VirtualHost&gt;
</pre>

<p>add domain configuration and restart apache.</p>

<pre>
a2enmod rewrite headers
a2ensite &lt;your-domain.com&gt;.conf
service apache2 restart
</pre>
