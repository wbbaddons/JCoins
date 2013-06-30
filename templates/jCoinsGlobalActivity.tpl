{include file='documentHeader'}

<head>
	<title>{lang}wcf.jcoins.globalactivity.title{/lang} - {PAGE_TITLE|language}</title>
	
	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header' sandbox=false}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.jcoins.globalactivity.title{/lang}</h1>
	</hgroup>
</header>
		
{include file='userNotice'}

<div class="marginTop statementBox">
    {if $entrys|count == 0}
	<p class="info">{lang}wcf.jcoins.globalactivity.noresults{/lang}</p>
    {else}
	    
    <table class="table">
	<thead>
		<tr>
			<th class="columnID">{lang}wcf.jcoins.statement.id{/lang}</th>
			<th class="columnText">{lang}wcf.jcoins.statement.reciveuser{/lang}</th>
			<th class="columnText">{lang}wcf.jcoins.statement.reason{/lang}</th>
			<th class="columnText">{lang}wcf.jcoins.statement.user{/lang}</th>
			<th class="columnSum">{lang}wcf.jcoins.statement.sum{/lang}</th>
			<th class="columnDate">{lang}wcf.jcoins.statement.date{/lang}</th>


		</tr>
	</thead>
	<tbody>
		{foreach from=$entrys item=item}
		    <tr class="statementTableRow">
			<td>{#$item->entryID}{if $item->isTrashed} <span class="icon icon16 icon-trash"></span>{/if}</td>
			<td>{if $item->userID == 0}{lang}wcf.jcoins.systemuser{/lang}{else}<a href="{link controller='User' object=$item->getUser()}{/link}">{$item->getUser()->username}</a>{/if}</td>
			<td>{if $item->link != ""}<a href="{$item->link}">{/if}{$item->reason|language}{if $item->link != ""}</a>{/if}</td>
			<td>{if $item->executedUserID == 0}{lang}wcf.jcoins.systemuser{/lang}{else}<a href="{link controller='User' object=$item->getExecutedUser()}{/link}">{$item->getExecutedUser()->username}</a>{/if}</td>
			<td>{if $item->sum > 0}<span class="badge green">+{#$item->sum}</span>{else}<span class="badge red">{#$item->sum}</span>{/if}</td>
			<td>{@$item->time|time} </td>
		    </tr>
		{/foreach}
	</tbody>
    </table>
    {/if}
</div>
    
    <div class="copyright"><a href="{link controller='JCoinsCredits'}{/link}">jCoins entwickelt von <strong>Joshua Rüsweg</strong></a></div>
		
{include file='footer' sandbox=false}
</body>
</html>
