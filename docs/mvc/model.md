# Model
**JREAM Library**

Your model is called from your controller to handle the business logic. This is an example of a model.

    <?php

	class File extends jream\MVC\Model
	{		
		public function get()
		{
			return $this->db->select("SELECT * FROM file");
		}
	}
    
In the above example a database connection is automatically included inside the model.

***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)