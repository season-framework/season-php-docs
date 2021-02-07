<div class="d-flex">
    <h2 class="h1 mt-0 mb-3">Base Model</h2>
</div>

<p>This is skeleton interface for mysql data model. copy code to <code class="bg-orange-lt">./app/interfaces/base_model.php</code></p>

<pre>
namespace framework\interfaces;

class base_model extends \framework\interfaces\Model
{

    public function __construct()
    {
        parent::__construct();
        $this->pdo = $this->lib("database")->pdo("db");
        $this->pk = "id";
    }

    public function get($id)
    {
        $pk = $this->pk;
        $table = $this->tablename;
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `$pk`=:id");
        $stmt->bindValue(":id", $id);
        $status = $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
    }

    public function delete($id)
    {
        $pk = $this->pk;
        $table = $this->tablename;
        $stmt = $this->pdo->prepare("DELETE FROM `$table` WHERE `$pk`=:id");
        $stmt->bindValue(":id", $id);
        $status = $stmt->execute();
        return array("status" => $status, "id" => $id);
    }

    public function update($values = array())
    {
        $pk = $this->pk;
        $table = $this->tablename;
        $update = $this->build_update($values);
        $set = $update->set;
        $bind = $update->bind;
        $bind[":where_id"] = $values[$pk];
        $stmt = $this->pdo->prepare("UPDATE `$table` SET $set WHERE `$pk`=:where_id");
        foreach ($bind as $k => $v) $stmt->bindValue($k, $v);
        $status = $stmt->execute();
        if (isset($values[$pk])) $insert_id = $values[$pk];
        else $insert_id = $this->pdo->lastInsertId();
        return array("status" => $status, "id" => $insert_id);
    }

    public function insert($values = array())
    {
        $pk = $this->pk;
        $table = $this->tablename;
        $insert = $this->build_insert($values);
        $fields = $insert->fields;
        $values = $insert->values;
        $bind = $insert->bind;
        $stmt = $this->pdo->prepare("INSERT INTO `$table`($fields) VALUES($values)");
        foreach ($bind as $k => $v) $stmt->bindValue($k, $v);
        $status = $stmt->execute();
        if (isset($values[$pk])) $insert_id = $values[$pk];
        else $insert_id = $this->pdo->lastInsertId();
        return array("status" => $status, "id" => $insert_id);
    }

    public function upsert($values = array())
    {
        $pk = $this->pk;
        $table = $this->tablename;

        $update = $this->build_update($values);
        $set = $update->set;

        $insert = $this->build_insert($values);
        $fields = $insert->fields;
        $values = $insert->values;
        $bind = $insert->bind;

        $stmt = $this->pdo->prepare("INSERT INTO `$table`($fields) VALUES($values) ON DUPLICATE KEY UPDATE $set");
        foreach ($bind as $k => $v) $stmt->bindValue($k, $v);

        $status = $stmt->execute();

        if (isset($values[$pk])) $insert_id = $values[$pk];
        else $insert_id = $this->pdo->lastInsertId();

        return array("status" => $status, "id" => $insert_id);
    }
}
</pre>

<p>This interface using like below,</p>

<pre>
class board_model extends framework\interfaces\base_model
{

    public function __construct()
    {
        parent::__construct();
        $this->tablename = "board";
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

<p>This model used like below (in controller),</p>

<pre>
$data["title"] = "title";
$data["content"] = "something";
$this->model('board')->upsert($data);
</pre>