<?php
/**
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 */
global $TO;
?>
</div>
</div>
</div>
</div>
<!-- footer -->
<div id="footer" style = "background-color: black">




    <center> <!-- center -->

<div style="overflow: hidden; width:100%; height:150px; background-color:white;">

<object id="myId" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="980" height="150" style="visibility: visible; ">
				<param name="movie" value="http://app.imcreator.com/static/.swf">
        			<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="http://app.imcreator.com/images/swf/flashticker.swf" width="980" height="150">
				<!--<![endif]-->
				<div>
					<h4>Alternative content</h4>
					<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"></a></p>
				</div>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>

</div>

    <div style = "overflow: hidden; width:100%;">
        
        
            <style type="text/css" media="screen">
    <!--
 
a IMG
{
	border: none;
}


.sliderGallery .desc
{
    color: white;
    font-size: 10pt;
    left: 0;
    position: absolute;
    text-align: center;
    top: 430px;
    width: 100%;
}

  
 .preview
{
	display: block;
	width: 400px;
	height: 300px;	
	position: absolute;
	top: 0;
	left: 0;
}


        
        /* slider specific CSS */
        .sliderGallery {
            overflow: visible;
            position: relative;
            padding: 10px;
            height: 600px;
            width: 980px;
        }
        
        .sliderGallery UL {
            position: absolute;
            left: 0;
            top: 0;
            list-style: none;
            white-space: nowrap;
            padding: 0;
            margin: 0;
             margin-top: 40px;
             width: 9000px;
             height: 404px;
             float: left;
             display: block;
        }
        
        .sliderGallery UL LI 
        {
        	list-style: none;
        	margin: 0;
        	padding: 0;
        }
        

        
.file
{
	position: relative;
	display: inline;
	float: left;
	margin: 0;
	padding: 0;
	height: 374px;
	width: 400px;
	cursor: pointer;
	text-decoration: none;
	text-align: center;
	
}
        .wrapper {
            background: url('http://www.imcreator.com/static/scroller.png') no-repeat;            
            height: 17px;
            left: 65px;
            padding: 1px;
            position: absolute;
            top: 550px;
            width: 900px;
        }        
        .slider {
            width: 718px;
            height: 17px;
            padding: 1px;
            position: absolute;
            top: 550px;
            left: 65px;
            z-index: 5000;
            /*background: url('http://www.imcreator.com/static/scroller.png') no-repeat;*/
        }
        
        .handle{
            display:none;
        }
        .ui-slider-handle {
            position: absolute;
            cursor: move;
            height: 17px;
            width: 181px;
            top: 0;
            background: url(http://static.jqueryfordesigners.com/demo/images/productbrowser_scroller_20080115.png) no-repeat;
            z-index: 100;
        }
        
        .slider span {
            color: #bbb;
            font-size: 80%;
            cursor: pointer;
            position: absolute;
            z-index: 110;
            top: 30px;
        }
        
        .slider .slider-lbl1 {
            left: 50px;
        }
        
        .slider .slider-lbl2 {
            left: 107px;
        }
        
        .slider .slider-lbl3 {
            left: 156px;
        }

        .slider .slider-lbl4 {
            left: 290px;
        }

        .slider .slider-lbl5 {
            left: 460px;
        }

.slider .slider-lbl6 {
            left: 590px;
        }

.slider .slider-lbl7 {
            left: 700px;
        }

.slider .slider-lbl8 {
            left: 850px;
        }

        .author {
            font-style: italic;
            font-family : serif ; 
            color: gray;
        }


.preview_btn {
            visibility: hidden;
            width: 400px;
            position: absolute;
            top: 290px;
            left: 0;
            z-index: 999;
        }
    -->
    </style>

    <!-- updated to jQ 1.2.6 and UI 1.5.2 2008-11-28 -->
    <!--<script src="http://www.imcreator.com/static/jquery-1.2.6.js" type="text/javascript" charset="utf-8"></script>-->
    <!--<script src="http://www.imcreator.com/static/jquery-ui-full-1.5.2.min.js" type="text/javascript" charset="utf-8"></script>-->
    <script src="http://www.imcreator.com/static/jquery-ui-1.9.2.custom.js" type="text/javascript" charset="utf-8"></script>
    
    <script type="text/javascript" charset="utf-8">
    	window.onload = function ()
    	{
    		
//cookies things

function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name + "=" + c_value+"; domain=.imcreator.com";
}

function getCookie(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}



function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}





function checkCookie()
{
var username=getCookie("cookie_test");
  if (username!=null && username!="")
  {
  
  }
else 
  {
 var uri = location.href;
 setCookie("cookie_test",uri,365);

}


var exp=getCookie("expr");
  if (exp!=null && exp!="")
  {
  
  }
else 
  {
 var exp_from_uri = getUrlVars()["exp"];;
 setCookie("expr",exp_from_uri ,365);

}






}
checkCookie()

//end of cookies thing


    		var container = $('div.sliderGallery');
    		var ul = $('ul', container);

    		var itemsWidth = $('.sliderGallery ul li').length * $('li.file:first').width();
    		var itemsWidthMinusPage = itemsWidth - $('.sliderGallery').innerWidth();            
    		ul.css('width', itemsWidth + 'px');
    		$('.slider', container).slider({
    			min: 0,
    			max: itemsWidthMinusPage,
    			/*handle: '.handle',*/
    			stop: function (event, ui)
    			{
    				ul.animate({ 'left': ui.value * -1 }, 500);
    			},
    			slide: function (event, ui)
    			{
    				ul.css('left', ui.value * -1);
    			}
    		});

    		$(".file").mouseover(function ()
    		{
    			$(".preview_btn", this).css("visibility", "visible")
    		});

    		$(".file").mouseout(function ()
    		{
    			$(".preview_btn", this).css("visibility", "hidden")
    		});

    	};


  

    </script>
        
        
        
        
        <div style = "left: 0px"><img style = "margin-top: 50px; margin-left: -400px; z-index: 499;" src="http://im_static.s3.amazonaws.com/collection_header.png" /></div>
        <div class="sliderGallery" style = "margin-top: -30px;">
              <div class="wrapper"></div><div class="slider ui-slider">
                <div class="ui-slider-handle"></div> 
                <!-- <span class="slider-lbl1">New</span>
                <span class="slider-lbl3">Portfolios</span>
                <span class="slider-lbl4">Photographers</span>
                <span class="slider-lbl5">Designers</span>
                <span class="slider-lbl6">Artists</span>
                <span class="slider-lbl7">Restaurants</span> -->
                <span class="slider-lbl8"><a href="http://app.imcreator.com/new" style="color: white">More</a></span>
            </div>
			  <ul>
      
<li class="file"> <a href="http://app.imcreator.com/preview?vbid=C1ADE52BC25C4CD2B071C0BC9D79E0DE"  target="_blank">
                 <span class="preview_btn"><img src="http://im_static.s3.amazonaws.com/preview_btn.png" /></span>
                 <span class="preview"><img src="http://imthumbs.s3.amazonaws.com/vbid_C1ADE52BC25C4CD2B071C0BC9D79E0DE.jpg" /></span>
                 <span class="desc">
			 			<span class="inner">
			 				<span class="name">Getting Married</span>
							<span class="author">by IM Design LAB</span>
						</span>
			  	 </span>
			  	 </a>
                </li>          


<li class="file"> <a href="http://app.imcreator.com/preview?vbid=C454AACAF6A1472C98AF82C600B69DA4"  target="_blank">
                 <span class="preview_btn"><img src="http://im_static.s3.amazonaws.com/preview_btn.png" /></span>
                 <span class="preview"><img src="http://im_static.s3.amazonaws.com/yoshi_sushi.jpg" /></span>
                 <span class="desc">
			 			<span class="inner">
			 				<span class="name">Yoshi Sushi</span>
							<span class="author">by IM Design LAB</span>
						</span>
			  	 </span>
			  	 </a>
                </li>  

 <li class="file"> <a href="http://app.imcreator.com/preview?vbid=855914835E6C484F820DD5D5338D40E0"  target="_blank">
                 <span class="preview_btn"><img src="http://im_static.s3.amazonaws.com/preview_btn.png" /></span>
                 <span class="preview"><img src="http://imthumbs.s3.amazonaws.com/vbid_855914835E6C484F820DD5D5338D40E0.jpg" /></span>
                 <span class="desc">
			 			<span class="inner">
			 				<span class="name">Wedding Stripes</span>
							<span class="author">by IM Design LAB</span>
						</span>
			  	 </span>
			  	 </a>
                </li>          



<li class="file"> <a href="http://app.imcreator.com/preview?vbid=5C5B0A50F1244DC38AEF9B8AD6EBAC77"  target="_blank">
                 <span class="preview_btn"><img src="http://im_static.s3.amazonaws.com/preview_btn.png" /></span>
                 <span class="preview"><img src="http://imthumbs.s3.amazonaws.com/vbid_5C5B0A50F1244DC38AEF9B8AD6EBAC77.jpg" /></span>
                 <span class="desc">
			 			<span class="inner">
			 				<span class="name">Smith Associates</span>
							<span class="author">by IM Design LAB</span>
						</span>
			  	 </span>
			  	 </a>
                </li> 

<li class="file"> <a href="http://app.imcreator.com/preview?vbid=C63EB35569D2475589EA175C533FE4E5"  target="_blank">
                 <span class="preview_btn"><img src="http://im_static.s3.amazonaws.com/preview_btn.png" /></span>
                 <span class="preview"><img src="http://imthumbs.s3.amazonaws.com/vbid_C63EB35569D2475589EA175C533FE4E5.jpg" /></span>
                 <span class="desc">
			 			<span class="inner">
			 				<span class="name">Fields Bio</span>
							<span class="author">by IM Design LAB</span>
						</span>
			  	 </span>
			  	 </a>
                </li> 





<li class="file"> <a href="http://app.imcreator.com/preview?vbid=FD5ACF4ABDD74286BB42B554423AF0D9"  target="_blank">
                 <span class="preview_btn"><img src="http://im_static.s3.amazonaws.com/preview_btn.png" /></span>
                 <span class="preview"><img src="http://im_static.s3.amazonaws.com/lakes_in.jpg" /></span>
                 <span class="desc">
			 			<span class="inner">
			 				<span class="name">Lakes Inn</span>
							<span class="author">by IM Design LAB</span>
						</span>
			  	 </span>
			  	 </a>
                </li>   


<li class="file"> <a href="http://app.imcreator.com/preview?vbid=5DCEC7F9A03344B3AA296A954F4DF44D"  target="_blank">
                 <span class="preview_btn"><img src="http://im_static.s3.amazonaws.com/preview_btn.png" /></span>
                 <span class="preview"><img src="http://im_static.s3.amazonaws.com/interia_black.jpg" /></span>
                 <span class="desc">
			 			<span class="inner">
			 				<span class="name">Interia Black</span>
							<span class="author">by IM Design LAB</span>
						</span>
			  	 </span>
			  	 </a>
                </li>   


 

<li class="file"> <a href="http://app.imcreator.com/preview?vbid=C04E39E3AF57448E84D8D1FF36E6D5CC"  target="_blank">
                 <span class="preview_btn"><img src="http://im_static.s3.amazonaws.com/preview_btn.png" /></span>
                 <span class="preview"><img src="http://im_static.s3.amazonaws.com/interia_white.jpg" /></span>
                 <span class="desc">
			 			<span class="inner">
			 				<span class="name">Interia White</span>
							<span class="author">by IM Design LAB</span>
						</span>
			  	 </span>
			  	 </a>
                </li>  






<li class="file"> <a href="http://app.imcreator.com/preview?vbid=12EED6F222364D3C8333B1A17B10AF03"  target="_blank">
                 <span class="preview_btn"><img src="http://im_static.s3.amazonaws.com/preview_btn.png" /></span>
                 <span class="preview"><img src="http://im_static.s3.amazonaws.com/antonio_sabatti.jpg" /></span>
                 <span class="desc">
			 			<span class="inner">
			 				<span class="name">Antonio Sabatti</span>
							<span class="author">by IM Design LAB</span>
						</span>
			  	 </span>
			  	 </a>
                </li>
           
            </ul>

        </div>
    </div>






<div id="ui-datepicker-div" style="display: none;"></div></center> <!-- center -->









    <script type="text/javascript">

    	function readCookie(name)
    	{
    		var nameEQ = name + "=";
    		var ca = document.cookie.split(';');
    		for (var i = 0; i < ca.length; i++)
    		{
    			var c = ca[i];
    			while (c.charAt(0) == ' ') c = c.substring(1, c.length);
    			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    		}
    		return null;
    	}

    	function getUrlVars()
    	{
    		var vars = [], hash;
    		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    		for (var i = 0; i < hashes.length; i++)
    		{
    			hash = hashes[i].split('=');
    			vars.push(hash[0]);
    			vars[hash[0]] = hash[1];
    		}
    		return vars;
    	}
    	//Tracking.StartImTrackingAndTrackPage();
    	//alert("hello "+document.referrer);
    	utm_source = getUrlVars()['utm_source']
    	utm_medium = getUrlVars()['utm_medium']
    	utm_campaign = getUrlVars()['utm_campaign']
    	if (readCookie('im_cookie') != '123')
    	{
    		document.cookie = 'im_cookie=123; expires=Fri, 27 Jul 2019 02:47:11 UTC; domain=.imcreator.com; path=/'
    		document.cookie = 'referral=' + document.referrer + '; expires=Fri, 27 Jul 2019 02:47:11 UTC; domain=.imcreator.com; path=/'
		document.cookie = 'hreff=' + window.location.href + document.referrer + '; expires=Fri, 27 Jul 2019 02:47:11 UTC; domain=.imcreator.com; path=/'
    		document.cookie = 'utm_source=' + utm_source + '; expires=Fri, 27 Jul 2019 02:47:11 UTC; domain=.imcreator.com; path=/'
    		document.cookie = 'utm_medium=' + utm_medium + '; expires=Fri, 27 Jul 2019 02:47:11 UTC; domain=.imcreator.com; path=/'
    		document.cookie = 'utm_campaign=' + utm_campaign + '; expires=Fri, 27 Jul 2019 02:47:11 UTC; domain=.imcreator.com; path=/'
    		//alert('new cookie just placed')

    	} else
    	{
    		//alert('cookie already placed')
    	}
		
	</script>





	<div class="f1">
		<div class="f2">
			<!-- footer-container -->
			<div id="footer-container">
				
				<div class="footer-bottom-holder">



<!-- footer-links -->


<div>

<style>

.footer_im {
	position: relative;
	height: 230px;
	width: 938px;
	border: 1px solid #333333;
	padding: 0px;
}

.seperator_line {
	position: relative;
	height: 1px;
	width: 100%;
	border-top: 1px solid #c0c0c0;
	padding: 0px;
}

.footer_col {
position: relative;
float: left;
margin: 17px;
}

.footer_cols {
position: relative;
height: 200px;
width: 100%;
}

.footer_col ul{
list-style:none;
padding: 10px;
padding-top: 2px;
margin: 5px;
}

.footer_col h3 
{
margin: 0px !important;
color:gray !important;
font: Arial !important;
text-align:left !important;
font-size:10pt !important;
padding: 3px !important;
}

.footer_col li
{
margin: 0px;
color:gray;
font: Arial;
text-align:left;
font-size:10pt;
padding: 3px;
}

.bottomStrip 
{
	float: right;
	position: relative;
	top: 0px;
	right: 0px;
	width: 545px;
	height: 50px;
	
}

.strip
{
	display: block;
	float: right;
	width: 100%;
	padding-top: 6px;
}

.socialStrip 
{
	float: left;
	position: relative;
	top: 0px;
	left: 0px;
	width: 200px;
	margin-top: 10px;
	margin-left: 20px;
	height: 50px;
	
}

.bottomStrip ul
{
	top: 0px;
	right: 0px;
	font-family: Arial;
	text-align:left;
	font-size:10pt;
	display: block;
	width: 600px;
	float: left;
	padding: 0px;
	
	list-style:none;
}


.bottomStrip ul li a
{
float: left;
display: block;
padding: 0 0 0 1.5em;
margin-left: 1.5em;
font-size: 12px;
color: #08C;
border-left: 1px solid #c0c0c0;
text-decoration: none;
}

</style>


<div class = 'footer_im'>

<div class = 'footer_cols'>

	<div class='footer_col'>
		<h4>The Company</h4>
		<ul>
			<li><a href="http://imcreator.com/about">About us</a></li>
			<li><a href="http://imcreator.com/whitelabel">White Label</a></li>
			<li><a href="http://imcreator.com/affiliates">Affiliates</a></li>
			<li><a href="http://imcreator.com/support">Contact us</a></li>
		</ul>
	</div>
	
	<div class='footer_col'>
		<h4>Website Templates</h4>
		<ul>
			<li><a href="http://app.imcreator.com/new">Popular</a></li>
			<li><a href="http://app.imcreator.com/new">Wedding</a></li>
			<li><a href="http://app.imcreator.com/new">Bio</a></li>
			<li><a href="http://app.imcreator.com/new">Fashion</a></li>
			<li><a href="http://app.imcreator.com/new">Restaurant</a></li>
			<li><a href="http://app.imcreator.com/new">Business</a></li>

		</ul>
	</div>
	
	<div class='footer_col'>
		<h4>IM PRO</h4>
		<ul>
			<li><a href="http://imcreator.com/designers">Professionals</a></li>
			<li><a href="http://imcreator.com/knowledge/html-vs-flash">HTML5</a></li>
			<li><a href="http://imcreator.com/featured">Featured</a></li>
		</ul>
	</div>
	
	<div class='footer_col'>
		<h4>Support & Contact</h4>
		<ul>
			<li><a href="http://imcreator.com/create-a-website">Manual</a></li>
			<li><a href="http://imcreator.com/category/howto">How-tos</a></li>
			<li><a href="http://imcreator.com/knowledge">Knowledge</a></li>
			<li><a href="http://imcreator.com/support">Contact us</a></li>

			
		</ul>
	</div>
	
	<div class='footer_col'>
		<h4>Our Friends</h4>
		<ul>
			<li><a href="http://www.imcreator.com/free">IM Free</a></li>
			<li><a href="http://ixm.imcreator.com">IXM Mobile Builder</a></li>
			<li><a href="http://apps.imcreator.com">AppSite</a></li>
			<li><a href="http://thenextweb.com/apps/2011/08/16/im-creator-takes-on-squarespace-with-an-easy-way-to-build-beautiful-websites-in-your-browser/">The Next Web</a></li>
		</ul>
	</div>
	
		<div class='footer_col'>
		<h4>Social</h4>
		<ul>
			<li><a href="http://www.facebook.com/imcreator">Facebook</a></li>
			<li><a href="http://www.pinterest.com/imcreator">Pinterest</a></li>
			<li><a href="https://plus.google.com/106360478113697036854/posts">Google+</a></li>
			<li><a href="https://twitter.com/IMC_official‎">Twitter</a></li>
		</ul>
	</div>
	
</div>

</div>

</div>

</div>








					<a href="<?=bloginfo('url');?>" class="footer-logo">IM-CREATOR.COM</a>
					<span class="copyright"><?=$TO->get_option('copy','footer');?><a>    |    </a><a href="http://imcreator.com/terms-of-service">Terms of Service</a></span>
				</div>
			</div>
		</div>
	</div>
</div>
<? wp_footer(); ?>






<!-- One Analytics: 
ReTargetting via Google Analytics is enabled by running dc.js instead of ga.js
However, dc.js is an AdWords code that is disabled by AdBlockers
The solution: if an AdBlocker is on, run the original ga.js instead of dc.js (so that GA data is always collected).
The method: By default, gaAdsBlocked=true (i.e. assuming AdBlock is on), so ga.js will run.
The file ./advertising.com changes gaAdsBlocked to false, but this file will only run if AdBlock is off.
  -- One Analytics-->

<script>
var gaAdsBlocked=true;
</script>

<script type="text/javascript" src="http://imcreator.com/wp-content/uploads/2013/01/advertising.js"></script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
  _gaq.push(['_require', 'inpage_linkid', pluginUrl]);
  _gaq.push(['_setAccount', 'UA-21520422-1']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_addIgnoredRef', 'imcreator.com']);
  _gaq.push(['_addIgnoredRef', 'i-m.co']);  
  _gaq.push(['_addIgnoredRef', 'im-creator.appspot.com']);
  _gaq.push(['_setDomainName', '.imcreator.com']);
  _gaq.push(['_trackPageview']);

 
(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

	if (gaAdsBlocked==true)
		{
	   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 	   }
    else
       	   {
		   ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
        }
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>




</body>
</html>