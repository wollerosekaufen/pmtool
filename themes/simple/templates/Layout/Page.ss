<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<% if $CurrentMember %>
            <p style="float:right">Eingeloggt als $myGroup <strong>$CurrentMember.Username</strong> (<a href="{$BaseHref}Security/logout">Logout</a>)</p>
		<% else %>
			<h1>Login</h1>
		<% end_if %>

		<div class="content">$Content</div>

	</article>
	$Form
	$CommentForm
</div>