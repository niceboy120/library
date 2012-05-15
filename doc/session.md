# Session

The Session is a static class for making it a tad bit easier to work with a session. Here is an example:

	// Alias to make this short
	use jream\Session as s;
	
	// Initialize a Session
    s::start();
	
	// Set your session data
	s::set('userid', 50);
	
	// Fetch your session data
	$userid = s::get('userid');
	
	// See whats in the session
	s::dump();
	
	// Kill it
	s::destroy();

	
***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)