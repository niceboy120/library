# View
**JREAM Library**

Your view is called from the controller. The view is compiled when destructed, as it is the last process to happen in this MVC pattern.

    <?php

	class User extends jream\MVC\Controller
	{		
		public function index()
		{
			$this->view->render('header');
			$this->view->render('index/home');
			$this->view->render('footer');
		}
	}

***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)