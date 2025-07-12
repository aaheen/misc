<?php
$flags['noicons'] = true;
$flags['noheader'] = true;
$flags['nobody'] = true;

tng_header( $sitename ? "" : $text['ourhist'], $flags );
if(!$cms['support'] && $sitever != "mobile")
	echo "<body id=\"bodytop\" class=\"" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "\">\n";

$dadlabel = getTemplateMessage('t22_dadside');
$momlabel = getTemplateMessage('t22_momside');
$title = getTemplateMessage('t22_maintitle');

$search_header = "<h2 class=\"site-head\">{$text['search']}</h2>";

$search = "<div>\n";
if($sitever != "mobile")
	$search .= "<br />\n";
$search .= "<form action=\"search.php\" method=\"get\">\n";
$search .= "<label for=\"myfirstname\">{$text['mnufirstname']}:</label>\n";
$search .= "<input type=\"text\" name=\"myfirstname\" class=\"mediumfield\" style=\"margin-bottom:10px\"/><br />\n";
$search .= "<label for=\"mylastname\">{$text['mnulastname']}: </label>\n";
$search .= "<input type=\"text\" name=\"mylastname\" class=\"mediumfield\"  style=\"margin-bottom:10px\"/><br />\n";
$search .= "<input type=\"hidden\" name=\"mybool\" value=\"AND\" />\n";
$search .= "<input type=\"submit\" id=\"search-submit\" class=\"btn\" value=\"{$text['search']}\"/>\n";
$search .= "</form>\n";
$search .= "<br />\n<ul class=\"home-menus\">\n";
$search .= "<li><a href=\"surnames.php\">{$text['surnames']}</a></li>\n";
$search .= "<li><a href=\"searchform.php\">{$text['mnuadvancedsearch']}</a></li>\n";
$search .= "</ul><br />\n</div>\n";
?>
 
<div id="art-main">
    <div class="cleared reset-box"></div>
	<div class="art-nav">
		<div class="art-nav-outer">
			<div class="art-nav-wrapper">
				<div class="art-nav-inner">
					<ul class="art-hmenu">
<?php
	if($dadlabel) {
?>
						<li>
							<a href="<?php echo $cms['tngpath']; ?>pedigree.php?personID=<?php echo $tmp['t22_dadperson']; ?>&amp;tree=<?php echo $tmp['t22_dadtree']; ?>"><span class="l"></span><span class="r"></span><span class="t"><?php echo $dadlabel; ?></span></a>
						</li>	
<?php		
	}
	if($momlabel) {
?>
						<li>
							<a href="<?php echo $cms['tngpath']; ?>pedigree.php?personID=<?php echo $tmp['t22_momperson']; ?>&amp;tree=<?php echo $tmp['t22_momtree']; ?>"><span class="l"></span><span class="r"></span><span class="t"><?php echo $momlabel; ?></span></a>
						</li>	
<?php		
	}
	echo showLinks(getTemplateMessage('t22_featurelinks'),false,"","<span class=\"l\"></span><span class=\"r\"></span><span class=\"t\">xxx</span>");
?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="cleared reset-box"></div>
	<div class="art-sheet">
        <div class="art-sheet-cc"></div>
        <div class="art-sheet-body">
            <div class="art-content-layout">
                <div class="art-content-layout-row">
<?php if($sitever != "mobile") { ?>
                    <div class="art-layout-cell art-sidebar1" id="tsearchbox">
						<div class="art-block">
    						<div class="art-block-body">
                				<div class="art-blockheader">
                					<?php echo $search_header; ?>
                				</div>
                				<div class="art-blockcontent">
                    				<div class="art-blockcontent-body">
										<?php echo $search; ?>
<!-- RANDOM PHOTO CODE STARTS HERE -->
<!-- If you don't want to have a random photo displayed, just remove this section down to 'RANDOM PHOTO CODE ENDS HERE' -->
										<div class="tsidesection">
											<h3><?php echo $text['featphoto']; ?></h3>
						<?php
							$rp_maxwidth = "100%";
						    include("randomphoto.php");
						?>
										</div>
<!-- RANDOM PHOTO CODE ENDS HERE -->
                                		<div class="cleared"></div>
	                   				</div>
                				</div>
								<div class="cleared"></div>
    						</div>
						</div>

                      	<div class="cleared"></div>
                    </div>
<?php } ?>
                    <div class="art-layout-cell art-content">
						<div class="art-post">
						    <div class="art-post-body">
								<div class="art-post-inner art-article">
                                	<div class="art-postcontent"<?php if($sitever != "mobile") echo " style=\"display: flex;\""; ?>>
                                		<div>
											<div>
												<p class="big-header">
													<?php echo $title; ?>
												</p>
											</div>
											<div>
												<div style="font-size:16px; line-height:1.24em">
													<?php 
														if($chooselang) {
															$query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
															$result = tng_query($query);
															$numlangs = tng_num_rows( $result );

															if($numlangs > 1) {
																echo getFORM( "savelanguage2", "get", "tngmenu3", "" );
																echo "<select name=\"newlanguage3\" id=\"newlanguage3\" style=\"font-size:11px;\" onchange=\"document.tngmenu3.submit();\">";

																while( $row = tng_fetch_assoc($result)) {
																	echo "<option value=\"{$row['languageID']}\"";
																	if( $languages_path . $row['folder'] == $mylanguage )
																		echo " selected=\"selected\"";
																	echo ">{$row['display']}</option>\n";
																}
																echo "</select>\n";
																echo "<input type=\"hidden\" name=\"instance\" value=\"3\" /></form>\n";
															}

															tng_free_result($result);
														}

														if( $currentuser ) {
														    echo "<p><strong>{$text['welcome']}, $currentuserdesc.</strong> | <a href=\"logout.php\">{$text['mnulogout']}</a></p>\n";
														}
														else {
															echo "<p><a href=\"login.php\">{$text['mnulogon']}</a>";
															if(!$tngconfig['disallowreg']) {
																echo " | <a href=\"newacctform.php\">{$text['mnuregister']}</a></li></p>";
															}
															echo "</p>";
														}
														
														echo getTemplateMessage('t22_mainpara');
														$text['contactus_long'] = str_replace( "suggest.php", "suggest.php?page=" . urlencode($title), $text['contactus_long'] );
													?>
												</div>
												<h3><?php echo $text['contactus']; ?></h3>
												<p class="contact"><img src="<?php echo $cms['tngpath'] . $templatepath; ?>img/email.gif" alt="email image" class="emailimg" /><?php echo $text['contactus_long']; ?></p>

<?php 
	if($sitever == "mobile") {
		echo $search_header;
		echo $search;
?>
<!-- RANDOM PHOTO CODE STARTS HERE -->
<!-- If you don't want to have a random photo displayed, just remove this section down to 'RANDOM PHOTO CODE ENDS HERE' -->
											<h3><?php echo $text['featphoto']; ?></h3>
							<?php
								$rp_maxwidth = "100%";
							    include("randomphoto.php");
							?>
										</div>
<!-- RANDOM PHOTO CODE ENDS HERE -->
	<?php } ?>

							<!--EDIT MENU LINKS BELOW HERE.  EDITS ABOVE THIS LINE WILL AFFECT THE PAGE DESIGN STRUCTURE-->
												<div id="menubar">
													<br />
												    <a href="whatsnew.php"><?php echo $text['mnuwhatsnew']; ?></a>
													&nbsp;&#x2022&nbsp; <a href="browsemedia.php"><?php echo $text['allmedia']; ?></a>
								                    &nbsp;&#x2022&nbsp; <a href="browsealbums.php"><?php echo $text['albums']; ?></a>
								                    &nbsp;&#x2022&nbsp; <a href="mostwanted.php"><?php echo $text['mostwanted']; ?></a>
								                    &nbsp;&#x2022&nbsp; <a href="reports.php"><?php echo $text['mnureports']; ?></a>
								                    &nbsp;&#x2022&nbsp; <a href="cemeteries.php"><?php echo $text['mnucemeteries']; ?></a>
										            &nbsp;&#x2022&nbsp; <a href="anniversaries.php"><?php echo $text['anniversaries']; ?></a>
										            &nbsp;&#x2022&nbsp; <a href="calendar.php"><?php echo $text['calendar']; ?></a>
										            &nbsp;&#x2022&nbsp; <a href="places.php"><?php echo $text['places']; ?></a>
										            &nbsp;&#x2022&nbsp; <a href="browsenotes.php"><?php echo $text['notes']; ?></a>
										            &nbsp;&#x2022&nbsp; <a href="browsesources.php"><?php echo $text['mnusources']; ?></a>
										            &nbsp;&#x2022&nbsp; <a href="browserepos.php"><?php echo $text['repositories']; ?></a>
							<?php
							    if( !$tngconfig['hidedna'] ) {
							?>
									            	&nbsp;&#x2022&nbsp; <a href="browse_dna_tests.php"><?php echo $text['dna_tests']; ?></a>
							<?php
								}
								?>
									           		&nbsp;&#x2022&nbsp; <a href="statistics.php"><?php echo $text['mnustatistics']; ?></a>
									           		&nbsp;&#x2022&nbsp; <a href="bookmarks.php"><?php echo $text['bookmarks']; ?></a>
										            &nbsp;&#x2022&nbsp; <a href="suggest.php"><?php echo $text['contactus']; ?></a>
							<?php
								if( !empty($allow_admin) ) {
									echo "&nbsp;&#x2022&nbsp; <a href=\"showlog.php\">{$text['mnushowlog']}</a>\n";
									echo "&nbsp;&#x2022&nbsp; <a href=\"admin.php\">{$text['mnuadmin']}</a>\n";
								}
							?>

							<!--EDIT MENU LINKS ABOVE HERE.  EDITS BELOW THIS LINE WILL AFFECT THE PAGE DESIGN STRUCTURE-->
												</div>
											</div>
										</div>
<!-- Begin Postcards -->
										<div class="snips-container"">
											<div class="snip-row">
										        <article class="contentBox4a">
										        	<a href="<?php echo $tmp['t22_sniplink-1']; ?>">
								                        <div class="postcard">
								                            <div class="thumbnail">
								                                <figure><img src="<?php echo $cms['tngpath'] . $templatepath . $tmp['t22_snipimage-1']; ?>"></figure>
								                                <div class="caption">
								                                    <p class="title2"><?php echo getTemplateMessage('t22_snipname-1'); ?></p>
								                                    <p><?php echo getTemplateMessage('t22_snipinfoone-1'); ?></p>
								                            	</div>
							                        		</div>
														</div>
								                     </a>
												</article>
												<article class="contentBox4b">
													<a href="<?php echo $tmp['t22_sniplink-2']; ?>">
								                      	<div class="postcard">
								                            <div class="thumbnail">
								                                <figure><img src="<?php echo $cms['tngpath'] . $templatepath . $tmp['t22_snipimage-2']; ?>"></figure>
								                                <div class="caption">
								                                    <p class="title2"><?php echo getTemplateMessage('t22_snipname-2'); ?></p>
								                                    <p><?php echo getTemplateMessage('t22_snipinfoone-2'); ?></p>
								                                </div>
								                            </div>
								                        </div>
								                     </a>
												</article>
											</div>
											<div class="snip-row">
												<article class="contentBox4c">
				                                    <a href="<?php echo $tmp['t22_sniplink-3']; ?>">
									                    <div class="postcard">
								                            <div class="thumbnail">
								                                <figure><img src="<?php echo $cms['tngpath'] . $templatepath . $tmp['t22_snipimage-3']; ?>"></figure>
								                                <div class="caption">
								                                    <p class="title2"><?php echo getTemplateMessage('t22_snipname-3'); ?></p>
								                                    <p><?php echo getTemplateMessage('t22_snipinfoone-3'); ?></p>
								                                </div>
								                            </div>
									                     </div>
								                     </a>
												</article>
												<article class="contentBox4d">
													<a href="<?php echo $tmp['t22_sniplink-4']; ?>">
								                    	<div class="postcard">
								                            <div class="thumbnail">
								                                <figure><img src="<?php echo $cms['tngpath'] . $templatepath . $tmp['t22_snipimage-4']; ?>"></figure>
								                                <div class="caption">
								                                    <p class="title2"><?php echo getTemplateMessage('t22_snipname-4'); ?></p>
								                                    <p><?php echo getTemplateMessage('t22_snipinfoone-4'); ?></p>
								                                    
								                                </div>
								                            </div>
								                        </div>
							                        </a>
												</article>
											</div>
										</div>
                					</div>
                					<div class="cleared"></div>
                				</div>

								<div class="cleared"></div>
    						</div>
						</div>

                      	<div class="cleared"></div>
                    </div>
                </div>
            </div>
            <div class="cleared"></div>
            <div class="art-footer">
                <div class="art-footer-body">
                	<div class="art-footer-text">


<?php
	$flags['basicfooter'] = true;
	tng_footer($flags);
?>


                    </div>
                    <div class="cleared"></div>
                </div>
            </div>
    		<div class="cleared"></div>
        </div>
    </div>
    <div class="cleared"></div>
</div>

</body>
</html>