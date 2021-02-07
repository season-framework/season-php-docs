<div class="d-flex">
  <h2 class="h1 mt-0 mb-3">UI</h2>
</div>

<p>
  $this->ui is a global object used by controllers, models, and filters.
</p>

<h3>$this->ui->set_layout( $uri )</h3>

<p>
  Specifies the path of the view to be rendered.
  The uri is defined as:
</p>

<pre>
# for load ./modules/mymodule/view/myview.php
$this->ui->set_layout('mymodule/myview');

# for load ./modules/mymodule/view/components/mycomp.php
$this->ui->set_layout('mymodule/components/mycomp');
</pre>


<h3>$this->ui->set_view( $uri )</h3>

<p>
  The set_view function designates the view to be used in the view designated as layout.
</p>

<pre>
# for load ./modules/mymodule/view/mycontent.php
$this->ui->set_view('content', 'mymodule/mycontent');
</pre>

<p>
  The specified view is used in the layout's code as shown below.
  (./modules/mymodule/view/myview.php file)
</p>

<pre>
&lt;html&gt;
  &lt;body&gt;
    ...
    &lt;?= $view->load('content') ?&gt;
    ...
  &lt;/body&gt;
&lt;/html&gt;
</pre>


<h3>$this->ui->set_error_layout( $uri )</h3>

<p>
  Specifies the path of the view to be rendered when error occured.
</p>


<h3>$this->ui->script( $valname, $val )</h3>

<p>
  Convert php variable to javascript variable and print it.
</p>

<pre>
&lt;?= $this->ui->script('info', $info) ?&gt;
</pre>