<?php

/* 

	Template Name: Home Page

	This is the default homepage layout provided
	by the Visualyze Framework. 

*/


get_header(); 

$i		= 1;
$ii		= 1;
$meta 	= get_post_meta(get_the_ID()); 
$timg	= $meta['_viz_top_image'][0];

$oneupName	= $meta['_viz_oneup_name'][0];
$oneupImg	= $meta['_viz_oneup_img'][0];

?>

<div id="content-container" class="row">

	<section id="top-home-section" class="viz-section small-12 column">
	
		<img src="<?php echo $timg ?>" alt="Boo Fuckity">
	
	</section>

	<section id="features-section" class="viz-section small-12 column">		
				
		<div class="section-inner columns clearfix">
		
			<?php
			
			for($i; $i < 4; $i++) {
				
				$name	= $meta['_viz_feature_name' . $i][0];
				$icon	= $meta['_viz_feature_icon' . $i][0];
				$desc	= $meta['_viz_feature_desc' . $i][0];
				
				?>
				
				<div class="section-col text-center small-12 medium-4 large-4 column">
				
					<div class="icon"><img src="<?php echo $icon ?>" alt="Feature" height="48" width="48"></div>
					
					<h4 class="name"><?php echo $name ?></h4>
					
					<p class="desc"><?php echo $desc ?></p>
				
				</div>
				
				<?php
				
			}
			
			?>
		
		</div>
		
		<img src="<?php echo $oneupImg ?>" alt="Featured Theme">
						
	</section>

	<section id="themes-section" class="viz-section small-12 column">
		
		<header class="section-heading">
		
			<h2 class="section-title">We Came Like Kings</h2>
			<span class="section-subtitle">and brought good themes</span>
		
		</header>
		
		<div class="section-inner columns clearfix">
		
			<?php
			
			for($ii; $ii < 4; $ii++) {
				
				$name	= $meta['_viz_theme_name' . $ii][0];
				$image	= $meta['_viz_theme_icon' . $ii][0];
				
				?>
				
				<div class="section-col text-center small-12 medium-4 large-4 column">
				
					<div class="image"><img src="<?php echo $image ?>" alt="<?php echo $name ?>"></div>
					
					<h4 class="name"><?php echo $name ?></h4>
				
				</div>
				
				<?php
				
			}
			
			?>
		
		</div>
		
	</section>
	
	<section id="responsive-section" class="viz-section small-12 column">
		
		<header class="section-heading">
		
			<h2 class="section-title">Responsive Ready</h2>
			<span class="section-subtitle">because thats how we do</span>
		
		</header>	
			
		<div class="section-inner columns clearfix">
		
			<div class="image small-6 column"></div>
			
			<div class="info small-6 columns">
			
				<div class="info-thumbs column">
					<div class="thumb small-3 column"><span></span></div>
					<div class="thumb small-3 column"><span></span></div>
					<div class="thumb small-3 column"><span></span></div>
					<div class="thumb small-3 column"><span></span></div>
				</div>
			
				<p>
				Uncle Gob? was Aunt Lindsay ever pregnant? Yeah, sure, dozens of times. Fried cheese? with club sauce. Well, they got the Asian right? "hotties" might be a stretch. I don't care if it takes from now till the end of Shrimpfest. Are all the guys in here? you know? George Sr: No not all of them. Barry: Yeah. It's never the ones you hope. I'm a scholar. I enjoy scholarly pursuits.  
				</p>
				<p>
				In prison, you just have to close your eyes and take it, but here you have to close your eyes and give it. So you take your mom to work every day? Bummer. Moms are such a pain in the ass, huh? It's, like, die already!
				</p>
				
				<button class="button cta">Plans & Pricing &rarr;</button>
				
				
			</div>
		
		</div>
	
	</section>
	
	<!--
<section id="end-section" class="viz-section small-12 column">
	
		<header class="section-heading">
		
			<h2 class="section-title">Get Started Today</h2>
			<span class="section-subtitle">Plans starting from $8 per month</span>
		
		</header>
		
		<button class="button cta">Plans & Pricing</button>
	
	</section>
-->

</div>

<?php get_footer(); ?>