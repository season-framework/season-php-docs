<div class="d-flex">
  <h2 class="h1 mt-0 mb-3">Concepts</h2>
</div>

<h2>Request Lifecycle</h2>

<p>
  When using the framework, understanding how it works is a great help in development.
  The goal of this document is to provide a high-level overview of how the season-php framework works.
  This document will help you understand the framework by defining terms for how season-php works and its components.
</p>

<p>The flow of operation in season-php to process user's request is as follows. (You can check the order of the operation flow in the <code class="bg-orange-lt">framework/core/process.php</code> file.)</p>

<ol>
  <li>All requests to season-php originate from <code class="bg-orange-lt">public/index.php</code></li>
  <li>First, call the module to see if it corresponds to the user's request</li>
  <li>If user requests resources, returns a file with a specific path as a response.</li>
  <li>If the user's request is not a resource, it passes through the user-defined filter and performs a common action for all requests.</li>
  <li>After passing the filter, load the module and perform the actions of the controller defined in the module.</li>
</ol>

<h2>Main Concepts</h2>

<p>In this document, terminological definitions of the main concepts are explained, and explanations of their usage are covered in the structure document. The main concepts of season-php are as follows.</p>

<ul>
  <li>resources</li>
  <li>filter</li>
  <li>module</li>
  <li>lib</li>
  <li>util</li>
  <li>model</li>
  <li>controller</li>
  <li>view</li>
</ul>

<h3>Resources</h3>

<p>season-php defines the concept of resources to support routing over static data. You can upload static data to resources folder and pass it to users. In the case of resources, it is not possible to manage permissions for each resource because it does not go through a separate filter. The following items can be defined as resources.</p>

<ul>
  <li>javascript or css library (like jquery, bootstrap)</li>
  <li>images (like logo file)</li>
  <li>custom javascript or css files</li>
</ul>

<h3>Filter</h3>

<p>Filters are abstract functions that perform operations on all requests other than resources. Filters allow you to check the user's privileges or define common tasks that should be performed. Filters can be defined with the code below.</p>

<pre>
class SampleFilter extends \framework\interfaces\Filter
{

    public function process()
    {
        if ($this->request->match("/")) {
            $this->response->redirect("/docs/intro");
        }

        $this->ui->set_error_layout("/theme/error");
        $this->ui->set_layout("/theme/layout");
        $this->ui->set_view("head", "/theme/components/head");
        $this->ui->set_view("footer", "/theme/components/footer");
    }
}
</pre>

<p>
  Filters are defined by inheriting the \framework\interfaces\Filter class.
  Inside the filter, you can call the object defined in season-php to define various actions such as checking whether to log in or checking the route.
  If the filter responds to the user, no further action is taken.
  The main objects used in season-php are described in detail in the components document.
</p>

<h3>Module</h3>

<p>
  season-php is configured to work independently based on the user's access path.
  The concept of working independently according to function is a module.
  The module defines the content to be displayed to the user through the controller, and the screen to be displayed to the user through the view.
  Modules are organized in the form of independent folders, and models, utils, libs, and resources can be independently defined if needed.
</p>

<h3>Lib</h3>

<p>
  The lib defines a function that performs the task in connection with season-php's request processing flow.
  Examples of lib provided by season-php include config, databaes, request, response.
  In addition, you can define additional functions you need (For example, a function for connecting elastic search).
  The code below shows the functions defined to access the database.
</p>

<pre>
class database extends \framework\LibBase {

    private static $cache = array();

    private $config;

    public function __construct() {
        parent::__construct();
        $this->config = $this->lib("config");
        $this->config->load("database");
    }

    private function load_config($namespace, $key, $default = "") {
        $dbconfig = $this->config->get($namespace, array());
        if ( isset( $dbconfig[$key] ) )
            return $dbconfig[$key];
        return $default;
    }

    public function pdo($ns='system') {
        if ( isset ( self::$cache[$ns] ) ) 
            return self::$cache[$ns];

        $dbtype = $this->load_config($ns, "type", "mysql");
        $host = $this->load_config($ns, "host", "127.0.0.1");
        $user = $this->load_config($ns, "user", "root");
        $password = $this->load_config($ns, "password", "");
        $database = $this->load_config($ns, "database", "");
        $charset = $this->load_config($ns, "charset", "utf8");
        
        $dsn = "$dbtype:host={$host};dbname={$database};charset={$charset}";
        self::$cache[$ns] = new \PDO($dsn, $user, $password);
        return self::$cache[$ns];
    }
    
}
</pre>

<p>
  All lib classes are defined by inheriting the \framework\LibBase class.
  In the lib class you can define the function by calling any function used in the season-php processing flow.
</p>

<h3>Util</h3>

<p>
  The util class defines functions that run independently.
  Examples that can be defined with util include encryption functions, file management functions, and string handling functions.
  The code below shows the crypto util.
</p>

<pre>
class crypto {
    
    private $key;
    private $cipher;
    private $mode;

    public function encode($message) {
        $key = $this->key;
        $cipher = $this->cipher;

        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_length);
    
        for( $i = 0 ; $i < $iv_length ; $i++ )
            $message = " " . $message;

        $ciphertext = openssl_encrypt($message, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($ciphertext); 
    }

    public function decode($message) {
        $key = $this->key;
        $cipher = $this->cipher;
        $message = base64_decode($message);

        $iv_size = openssl_cipher_iv_length($cipher);
        $iv = substr($message, 0, $iv_size);
        $message = substr($message, $iv_size);

        $message = openssl_decrypt($message, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return $message; 
    }

    public function load($key, $cipher = "aes128") {
        $this->key = $key;
        $this->cipher = $cipher;
        return $this; 
    }

}
</pre>

<h3>Model</h3>

<p>
  The model is used to insert, update, select, and search data through database access.
  The structure of the model is as follows.
</p>

<pre>
class board_model extends framework\interfaces\Model
{

    public function __construct() {
        parent::__construct();
        $this->pdo = $this->lib("database")->pdo("db");
        $this->tablename = "board";
    }

    public function get($id) {
        $table = $this->tablename;
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `id`=:id");
        $stmt->bindValue(":id", $id);
        $status = $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
    }

    public function delete($id) {
        $table = $this->tablename;
        $stmt = $this->pdo->prepare("DELETE FROM `$table` WHERE `id`=:id");
        $stmt->bindValue(":id", $id);
        $status = $stmt->execute();
        return array( "status"=> $status , "table"=>$id);
    }

    public function update($values = array(), $force_insert = False) {
        $table = $this->tablename;
        if ( isset( $values["id"] ) && $force_insert === False ) {
            $update = $this->build_update($values);

            $set = $update->set;
            $bind = $update->bind;
            $bind[":where_id"] = $values["id"];

            $stmt = $this->pdo->prepare("UPDATE `$table` SET $set WHERE id=:where_id");
            foreach ( $bind as $k => $v ) $stmt->bindValue($k, $v);
        } else {
            unset($values["id"]);
            $insert = $this->build_insert($values);
            $fields = $insert->fields;
            $values = $insert->values;
            $bind = $insert->bind;

            $stmt = $this->pdo->prepare("INSERT INTO `$table`($fields) VALUES($values)");
            foreach ( $bind as $k => $v ) $stmt->bindValue($k, $v);
        }

        $status = $stmt->execute();

        if ( isset( $values["id"] ) ) $insert_id = $values["id"];
        else $insert_id = $this->pdo->lastInsertId();

        return array( "status"=> $status, "id"=> $insert_id );
    }

    public function list($category, $page = 1, $dump = 20)
    {
        $start = ($page - 1) * $dump;
        $pdo = $this->pdo;
        $stmt = $pdo->prepare("SELECT * FROM board WHERE `category`='$category' ORDER BY `priority` ASC, `updated` DESC LIMIT $start, $dump");
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $rows;
    }

    public function lastpage($category, $dump = 20)
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare("SELECT count(*) as cnt FROM board WHERE `category`='$category'");
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return ceil($rows[0]["cnt"] / $dump);
    }
}
</pre>

<h3>Controller</h3>

<p>
  Controllers are used to define actions to be taken on user access.
  Controllers behave similarly to routing functions.
  The controller defines the screen to load or display data according to the user's request.
  The controller is defined as follows in the module.
</p>

<pre>
class index_controller extends framework\interfaces\Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function main($segment)
    {
        $menu = $segment->get(0, True);
        $lang = $this->lang();
        $this->ui->set_view("doc", "docs/$lang/$menu");
        $this->ui->set_view("content", "docs/layout");
        $this->response->render();
    }
}
</pre>

<h3>View</h3>

<p>
  the view contains the definition of the screen to be displayed to the user.
  A view is a kind of template and uses the data loaded from the controller to compose the screen to be displayed to the user in html form.
</p>