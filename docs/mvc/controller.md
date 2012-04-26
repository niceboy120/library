# Controller
**JREAM Library**

Once you have your index.php file setup with the Bootstrap you are ready to create a controller. The controller must extend the base controller, here is an example you would place in your controllers folder:

    <?php

	class Index extends jream\MVC\Controller
	{
		public function index()
		{
			echo 'This is the default home page';
		}
		
		public function about()
		{
			echo 'This is the about page';
		}
	}
    
If there is a model with the same name it will be loaded and automatically accessible through the controller.

   <?php

	class Index extends jream\MVC\Controller
	{
		public function index()
		{
			// calls method from index_model.php 
			$this->model->method();
		}
	}
	
Rendering a view is easy

   <?php

	class Index extends jream\MVC\Controller
	{
		public function index()
		{
			// Will render /views/index.php
			$this->view->render('index');
		}
	}


***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)