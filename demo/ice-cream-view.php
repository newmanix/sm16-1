<?php
/**
 * ice-cream-view.php along with ice-cream-list.php creates a list/view application
 *
 * @package SM16
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 0.1 2016/07/13
 * @link http://www.newmanix.com/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see ice-cream-list.php
 * @see Pager.php
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to ice-cream-list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "demo/ice-cream-list.php");
}

//sql statement to select individual item
$sql = "select * from sm16_IceCream where IceCreamID = " . $myID;
//---end config area --------------------------------------------------

$foundRecord = FALSE; # Will change to true, if record found!
   
# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	   $foundRecord = TRUE;	
	   while ($row = mysqli_fetch_assoc($result))
	   {
			$Flavor = dbOut($row['Flavor']);
            $Brand = dbOut($row['Brand']);
            $Calories = dbOut($row['Calories']);
            $Description = dbOut($row['Description']);
            /*
            $MuffinName = dbOut($row['MuffinName']);
			$Description = dbOut($row['Description']);
			$Price = (float)$row['Price'];
			$MetaDescription = dbOut($row['MetaDescription']);
			$MetaKeywords = dbOut($row['MetaKeywords']);
            */
	   }
}

@mysqli_free_result($result); # We're done with the data!


/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/
# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h3 align="center"><?=smartTitle();?></h3>

<p>This page, along with <b>ice-cream-list.php</b>, demonstrate a List/View web application.</p>
<p>It was built on the mysqli shared web application page, <b>demo_shared.php</b></p>
<p>This page is to be used only with <b>ice-cream-list.php</b>, and is <b>NOT</b> the entry point of the application, meaning this page gets <b>NO</b> link on your web site.</p>
<p>Use <b>ice-cream-list.php</b> and <b>ice-cream-view.php</b> as a starting point for building your own List/View web application!</p> 
<?php
if($foundRecord)
{#records exist - show muffin!
?>
	<h3 align="center"><?=$Flavor;?> Ice Cream!</h3>
	<div align="center"><a href="<?=VIRTUAL_PATH;?>demo/ice-cream-list.php">More Ice Cream?!?</a></div>
	<table align="center">
		<tr>
			<td><img src="<?=VIRTUAL_PATH;?>upload/m<?=$myID;?>.jpg" /></td>
			<td>Made by <?=$Brand;?>!</td>
		</tr>
		<tr>
			<td colspan="2">
				<blockquote><?=$Description;?></blockquote>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<h3><i>Only!!:</i> <font color="red">$<?=number_format($Calories);?></font> Calories!</h3>
			</td>
		</tr>
	</table>
<?
}else{//no such muffin!
    echo '<div align="center">What! No such muffin? There must be a mistake!!</div>';
    echo '<div align="center"><a href="' . VIRTUAL_PATH . 'demo/ice-cream-list.php">Another Muffin?</a></div>';
}

get_footer(); #defaults to theme footer or footer_inc.php
?>
