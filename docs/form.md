# Form
**JREAM Library**

The Form class makes posting, formatting, and validating your POST requests easy.
You should wrap these in a try catch statement. Always call **submit** after you are done.

Here is an example:

    try {
        $form = new jream\Form();
        $form->post('fieldname');
        $form->submit();
    } catch (Exception $e) {
        // Outputs your errors
        echo $e->getMessage();
    }
    
**Required Field**
    $form->post('fieldname', true)

**Format**

    $form->post('fieldname')->format('md5');
    $form->post('fieldname')->format('url_encode');
    $form->post('fieldname')->format('url_decode');

**Validate**

    $form->post('fieldname')->validate('maxlength', 5);
    $form->post('fieldname')->validate('minlength', 5);
    $form->post('fieldname')->validate('matchany', array('test', 'test2'));
    // Case Insensitive 
    $form->post('fieldname')->validate('matchany', array('test', 'test2'), false); 
    
**Chain**

    $form
        ->post('fieldname')
        ->validate('length', array(5, 10))
        ->format('md5')

        // Careful! In this order, it will validate the length of MD5 string
        ->post('age')
        ->format('md5') 
        ->validate('length', array(5, 10))
        

        
        ->post('other')
        ->validate('test');
        
    $form->submit();
    
***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)