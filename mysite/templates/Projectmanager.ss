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
	<link rel="shortcut icon" href="$ThemeDir/images/favicon.ico" />
    <!--<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">-->
	<% require css('mysite/css/pure-min.css') %>
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
		<h1>Projekt&uuml;bersicht</h1>

	<div class="pure-u-1-4">
		<div class="pure-menu pure-menu-horizontal">
			<ul class="pure-menu-list">
				<li style="background-color: #e7e7e7" class="pure-menu-item pure-menu-selected" id="1" onclick="change(1)"><a href="#" class="pure-menu-link">Aktiv <span class="project-count">($ActiveProjects.Count)</span></a></li>
				<li class="pure-menu-item pure-menu-selected" id="2" onclick="change(2)"><a href="#" class="pure-menu-link">Archiv <span class="project-count">($ArchivedProjects.Count)</span></a></li>
			</ul>
		</div>		
		
		<div id="active">
			<%-- We are iterating through the active projects, generating one div.project-item per loop. --%>
			<% loop $ActiveProjects %>
            <%-- Inside if this block we are in the project scope so the fields $Title, $Start, ... are available --%>
	    	<div class="project-item<% if $Top.ActiveProject.ID == $ID %> project-item-active<% end_if %>">
				<%-- OK, here we are building our URL to switch projects. $BaseHref fetches the Root URL over the base_tag, than we have our self-defined "projects" route and at the end we are adding the ID of the current project (scope) --%>
				<h5 class="project-name"><a href="{$BaseHref}projectmanager/$ID" class="project-subject">$Title</a></h5>
	        </div>
			<% end_loop %>
		</div>
		<div id="archive" style="display:none">
			<%-- We are iterating through the archived projects, generating one div.project-item per loop. --%>
			<% loop $ArchivedProjects %>
            <%-- Inside if this block we are in the project scope so the fields $Title, $Start, ... are available --%>
	    	<div class="project-item<% if $Top.ActiveProject.ID == $ID %> project-item-active<% end_if %>">
				<%-- OK, here we are building our URL to switch projects. $BaseHref fetches the Root URL over the base_tag, than we have our self-defined "projects" route and at the end we are adding the ID of the current project (scope) --%>
				<h5 class="project-name"><a href="{$BaseHref}projectmanager/$ID" class="project-subject">$Title</a></h5>
	        </div>
			<% end_loop %>
		</div>
	</div><div class="pure-u-3-4">
		<%-- Check if there is an active/chosen project. --%>
        <% if $ActiveProject %>
            <%-- Switch to the scope of the active project. --%>
            <% with $ActiveProject %>
                <div class="project-content">
                    <div class="project-content-header pure-g">
                        <div class="pure-u-5-8">
                            <h1 class="project-content-title">$Title</h1>
                            <p class="project-content-subtitle">
                                Projektlaufzeit <span>$Start.Format('d.m.Y')<% if $End %> - $End.Format('d.m.Y')<% end_if %></span>
                            </p>
                        </div>
						
						<div style="float:right" class="project-content-controls pure-u-8-24">
							<a href="{$BaseHref}projectmanager/newproject" class="secondary-button pure-button">New Project</a>
							<a href="{$BaseHref}projectmanager/newtask"  class="secondary-button pure-button">New Task</a>
							<a  class="secondary-button pure-button">Delete</a>
                        </div>
                    </div>

                    <div class="project-content-body">
                        $Description

						<%-- Checking if there are any tasks --%>
                        <% if $Tasks %>
                            <h2>Tasks</h2>
                            <table class="pure-table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                </tr>
                                </thead>

                                <tbody>
                                    <% loop $Tasks %>
                                    <tr>
                                        <td><a href="{$BaseHref}projectmanager/$Project.ID/tasks/$ID">$Title</a></td>
                                    </tr>
                                    <% end_loop %>
                                </tbody>
                            </table>
                        <% end_if %>
						
                    </div>
                </div>
            <% end_with %>
        <% else %>
		<div class="project-content">
			<div class="project-content-header pure-g">
				<div class="pure-u-1-3"><p style="margin: 6px 20px;"><b>Kein Projekt ausgew&auml;hlt.</b></p></div>
					<div style="float:right" class="project-content-controls pure-u-8-24">
						<a href="{$BaseHref}projectmanager/newproject" class="secondary-button pure-button">New Project</a>
						<a href="{$BaseHref}projectmanager/newtask"  class="secondary-button pure-button">New Task</a>
						<a  class="secondary-button pure-button">Delete</a>
                   </div>
			</div>
		</div>
        <% end_if %>
	</div>	
	
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
<script>
	function change(divId){
		if(divId==1){ // Aktiv
			document.getElementById("1").style.background = "#e7e7e7";
			document.getElementById("2").style.background = "#ffffff";
			document.getElementById("active").style.display = "block";
			document.getElementById("archive").style.display = "none";
		}
		else{ // Archiv  
			document.getElementById("2").style.background = "#e7e7e7";
			document.getElementById("1").style.background = "#ffffff";
			document.getElementById("active").style.display = "none";
			document.getElementById("archive").style.display = "block";
		}
	}
</script>
</body>
</html>
