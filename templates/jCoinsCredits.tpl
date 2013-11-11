{include file='documentHeader'}

<head>
	<title>TODO - {PAGE_TITLE|language}</title>

	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
	{include file='header' sandbox=false}

	<header class="boxHeadline">
		<hgroup>
			<h1>Entwicklung jCoins</h1>
		</hgroup>
	</header>

	{include file='userNotice'}

	<div class="marginTop jCoinsDev">
		<div class="container marginTop">
			<ol class="containerList doubleColumned userList">
				<li>
					<div class="">
						<div class="details userInformation">
							<hgroup class="containerHeadline">
								<h1>jCoins</h1> 
								<h2>
									<ul class="dataList">
										<li>Entwickelt von <a href="http://www.joshsboard.de/">Joshua Rüsweg</a></li>
									</ul>
								</h2>
							</hgroup>	
						</div>
					</div>
				</li>					
			</ol>
		</div>

		{event name='additionalPackages'}
	</div>

	<div class="copyright"><a href="{link controller='JCoinsCredits'}{/link}">jCoins entwickelt von <strong>Joshua Rüsweg</strong></a></div>

	{include file='footer' sandbox=false}
</body>
</html>