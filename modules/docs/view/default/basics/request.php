<div class="d-flex">
  <h2 class="h1 mt-0 mb-3">Request</h2>
</div>

<p>
  $this->request is a global object used by controllers, models, and filters.
</p>

<h3>$this->request->method()</h3>

<p>
  method function returns the user requested method (GET/PUT/POST ..).
</p>

<h3>$this->request->client_ip()</h3>

<p>
  client_ip function returns the user's access ip address.
</p>

<h3>$this->request->language()</h3>

<p>
  language function returns the user's language.
</p>


<h3>$this->request->uri()</h3>

<p>
  uri function returns the user's request uri.
</p>


<h3>$this->request->match( $pattern, $flags = 0 )</h3>

<p>
  match function compares a specific string and uri.
  String comparisons use regular expression syntax.
</p>

<pre>
$is_dashboard = $this->request->match("/dashboard/*");
</pre>


<h3>$this->request->query( $name=null, $required=False )</h3>

<p>
  query function returns parameters passed as POST or GET.
  If a parameter name is specified, the value for a specific parameter is returned. If not entered separately, all parameters passed are returned.
</p>

<pre>
$query = $this->request->query(); // all request query

# parse query likes /request/uri?page=10
$page = $this->request->query("page", 1); 

# if page parameter is required
$page = $this->request->query("page", True);
</pre>