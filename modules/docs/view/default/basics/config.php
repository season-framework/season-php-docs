<div class="d-flex">
  <h2 class="h1 mt-0 mb-3">Config</h2>
</div>

<p>
  $this->config is a global object used by controllers, models, and filters.
  Settings defined in app/config can be loaded through the config object.
  The config file is defined in the following structure. (app/config/config_name.php)
</p>

<pre>
$config = array();
$config['maintenance'] = False;
$config["baseurl"] = "/";
$config["filter"] = array();
$config["filter"][] = "Nav";
$config["filter"][] = "IndexFilter";
</pre>

<h3>$this->config->load( $name="config" )</h3>

<p>
  The load function finds and loads configuration information in app/config based on the configuration name.
  By default, configuration information is loaded from the app/config/config.php file.
  If you want to load the configuration information of the app/config/database.php file, you can call it as follows.
</p>

<pre>
$this->config->load('database');
</pre>

<h3>$this->config->get( $key, $default = null )</h3>

<p>
  If you want to load specific variable from the config file, use the get function.
  The code below is an example of loading the baseurl variable from the config_name.php file.
</p>

<pre>
$this->config->load('config_name');
$baseurl = $this->config->get('baseurl', '/');
</pre>