<?php 
include_once 'functions.php';
get_header(); 
?>

<div class="container-fluid body">
	<div class="col-lg-12 col-md-12">
		<section id="content" role="main">
			<div class="container" id="project-list">
				<?php
				$projects =  fetch_all_projects(); 
				foreach($projects as $i){
					echo
					'<div class="well project">
						<div class="media">
							<div class="media-body">
								<h4 class="media-heading"><a href="'.home_url("project?pid=".$i[0]).'">'.$i[1].'</a></h4>
								<p class="text-right">Author: '. $i[3].'</p>
								<div class="col-lg-6 audio">
									<audio controls>
										<source src="'.$site_root.$i[1].'" type="audio/mpeg" />
										<source src="" type="audio/wav" />
										<a href="http://www.w3schools.com/html/horse.mp3" style="position:relative; z-index: 2;">horse</a>
									</audio>
								</div>
								<div class="col-lg-6 hero-unit">
									<p>'.$i[4].'</p>
									<ul class="list-inline list-unstyled">
										<li><span><i class="glyphicon glyphicon-calendar"></i>'. $i[2].'</span></li>
										<li>|</li>
										<li>'.$i[5].' Branch</li>
										<li>|</li>
										<li>'.$i[6].' commits</li>
										<li>|</li>
										<li>'.$i[7].' Contributor</li>
									</ul>
								</div>
							</div>
						</div>
					</div>';				
				}

				get_footer();
				?>
			</div>

			
		<!--
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'entry' ); ?>
		<?php comments_template(); ?>
		<?php endwhile; endif; ?>
		<?php get_template_part( 'nav', 'below' ); ?>
		-->		
		</section>
	</div>
</div>
</body>
</html>