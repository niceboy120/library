# Database
**JREAM Library**

The Database class is a convenience wrapper to make database queries easy.
The first thing you need is your **configuration**:

    <?php
	$config = array(
		'type' => 'mysql'
		,'host' => 'localhost'
		,'name' => 'test'
		,'user' => 'root'
		,'pass' => ''
	);

The next thing you do is instantiate the database. It's recommended to wrap it inside of a **try/catch** statement

    try {
        $db = new jream\Database($config);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

**Select**

	// Return array (Results)
    $data = $db->select("SELECT * FROM user WHERE id = :id", array('id', 25));
	print_r($data);
	
	// Optionally return data in a different format only for this query
	$data = $db->select("SELECT * FROM user WHERE id = :id", array('id', 25), \PDO::FETCH_NUM);
	

**Insert**

	// Return boolean
    $db->insert("user", array('name' => 'jesse'));
	$db->id(); // Get the last Insert ID
	
**Update**

	// Return boolean
    $db->update("user", array('name' => 'juicy), "id = '25'");

**Delete**

	// Return integer (Affected Rows)
    $db->delete("user", "id = '25'");
	
**Utility**

    $result = $db->showColumns("user");
	print_r($result);
	
**Global**

    $db->setFetchMode(\PDO::FETCH_CLASS);
	

***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)