<!DOCTYPE html>
<!--
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Simple. by Sara (saratusar.com, @saratusar) for Innovatif - an awesome Slovenia-based digital agency (innovatif.com/en)
Change it, enhance it and most importantly enjoy it!
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-->

<!--[if !IE]><!-->
<html lang="$ContentLocale">
<!--<![endif]-->
<!--[if IE 6 ]><html lang="$ContentLocale" class="ie ie6"><![endif]-->
<!--[if IE 7 ]><html lang="$ContentLocale" class="ie ie7"><![endif]-->
<!--[if IE 8 ]><html lang="$ContentLocale" class="ie ie8"><![endif]-->
<head>
	<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$MetaTags(false)
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<% require themedCSS('reset') %>
	<% require themedCSS('typography') %>
	<% require themedCSS('form') %>
	<% require themedCSS('layout') %>
    <% require css('mysite/css/pure-min.css') %>
	<link rel="shortcut icon" href="$ThemeDir/images/favicon.ico" />
</head>
<body class="$ClassName<% if not $Menu(2) %> no-sidebar<% end_if %>" <% if $i18nScriptDirection %>dir="$i18nScriptDirection"<% end_if %>>
<% include Header %>
<div class="main" role="main">
	<div class="inner typography line">
		<!--$Layout-->
		<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<% if $CurrentMember %>
		<p style="float:right">Eingeloggt als $myGroup <strong>$CurrentMember.Username</strong> (<a href="{$BaseHref}Security/logout">Logout</a>)</p>
		<h1>Mitarbeiterliste</h1>
		<a style="float:right" href="{$BaseHref}admin"><strong>CMS</strong></a>


            <table class="pure-table pure-table-horizontal">
                <thead>
                <tr>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Username</th>
                    <th>E-Mail</th>
                    <th>Rolle</th>
                </tr>
                </thead>
                <tbody>
					<% loop $Members %>
                    <tr>
                        <td>$FirstName</td>
                        <td>$Surname</td>
                        <td>$Username</td>
                        <td>$Email</td>
						<% if $ClassName == "Member" %>
                            <td>Administrator</td>
						<% else %>
                            <td>$ClassName</td>
						<% end_if %>
                    </tr>
					<% end_loop %>
                </tbody>
            </table>

		<% end_if %>

		<div class="content">$Content</div>

	</article>
	$Form
	$CommentForm
</div>
	</div>
</div>
<% include Footer %>

<% require javascript('framework/thirdparty/jquery/jquery.js') %>
<%-- Please move: Theme javascript (below) should be moved to mysite/code/page.php  --%>
<script type="text/javascript" src="{$ThemeDir}/javascript/script.js"></script>

</body>
</html>
