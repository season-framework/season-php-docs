<div class="d-flex">
  <h2 class="h1 mt-0 mb-3">Segment</h2>
</div>

<p>
  $segment object is used by the controller.
  By analyzing the user's request path, URI information can be received as a parameter and processed.
</p>

<h3>$segment->get($key, $default = null)</h3>

<p>
  The get function of $segment receives a specific key and retrieves the relevant information.
  It can be used in the form below.
</p>

<pre>
# for detecting [id1] in path /mymodule/mycontroller/[id1]/[id2], default 0
$id1 = $segment->get(0, 0);

# for detecting [id2] in path /mymodule/mycontroller/[id1]/[id2], default null
$id2 = $segment->get(1, null);

# for detecting [id1] in path /mymodule/mycontroller/[id1]/[id2], must required id1
$id1 = $segment->get(1, True);
</pre>

<p>
  If you want to receive variables based on segment name, not index
</p>

<pre>
# for detecting [user_id] in path 
#   /mymodule/mycontroller/user/[user_id]/post/[post_id]
# default user_id is null
$user_id = $segment->get('user_id', null);

# for detecting [post_id] in path 
#   /mymodule/mycontroller/user/[user_id]/post/[post_id]
# must required post_id
$post_id = $segment->get('post', True);
</pre>