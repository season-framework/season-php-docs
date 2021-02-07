<div class="d-flex">
  <h2 class="h1 mt-0 mb-3">Response</h2>
</div>

<p>
  $this->response is a global object used by controllers, models, and filters.
</p>

<h3>$this->response->language( $language )</h3>

<p>
  Change the user's language.
</p>


<h3>$this->response->redirect( $uri )</h3>

<p>
  redirect to another page or website
</p>

<pre>
# redirect to google
$this->response->redirect('https://google.com');

# redirect in website, if baseurl is /myapp then redirect to /myapp/dashboard
$this->response->redirect('/dashboard');
</pre>


<h3>$this->response->send( $message, $content_type='text' )</h3>
<p>
  response some value
</p>
<pre>
# Send hello 
$this->response->send('hello');

# send as html
$this->response->send('&lt;h1&gt;hello&lt;/h1&gt;', 'text/html');
</pre>


<h3>$this->response->json( $obj )</h3>
<p>
  response object or array as json
</p>
<pre>
$myarr = array();
$myarr[] = 'hello';
$myarr[] = 'world';
$this->response->json($myarr);
# response: ['hello', 'world']
</pre>


<h3>$this->response->error( $e )</h3>
<p>
  response to error page defined as error ui.
  If not defined error ui, then response as json format.
</p>


<h3>$this->response->render()</h3>
<p>
  render as setting view.
  For usage related to view composition, refer to $this->ui.
</p>

<pre>
$this->ui->layout('myapp/page');
$this->response->render();
</pre>


<h3>$this->response->download( $filename, $file=null )</h3>
<p>
  send file at path.
  If you want to change the access path and file name, specify the name of the file to be downloaded.
</p>

<pre>
# download file.xlsx
$this->response->download("/var/data/file.xlsx");

# download file.xlsx as output.xlsx
$this->response->download("/var/data/file.xlsx", "output.xlsx");
</pre>