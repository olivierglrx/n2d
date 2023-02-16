<?php
function script_annuaire()
{
  global $annuaire_page_name;
  if (is_page($annuaire_page_name)) {
    wp_register_style('annuaire_css', plugin_dir_url(__FILE__) . 'annuaire.css');
    wp_enqueue_style('annuaire_css');

    wp_register_script('annuaire_js', plugin_dir_url(__FILE__) . 'annuaire.js');
    wp_enqueue_script('annuaire_js');
  }
}

add_action('wp_enqueue_scripts', 'script_annuaire');
add_shortcode('annuaire_css', 'shortcode_annuaire_css');

function shortcode_annuaire_css()
{
wp_reset_query();
  if ($_SESSION['ML']=='FR'){
    $args = array(
      'numberposts' => -1,
      'post_type' => 'team',
      'meta_key' => 'team_name_fr',
      'orderby' => 'meta_value',
      'order' => 'ASC',
    );
  }else{
	$args = array(
      'numberposts' => -1,
      'post_type' => 'team',
      'meta_key' => 'team_name',
      'orderby' => 'meta_value',
      'order' => 'ASC',
    );
  }
  $teams = get_posts($args);

  wp_reset_query();

  $args = array(
    'numberposts' => -1,
    'post_type' => 'member',
    'meta_key' => 'member_is_alumni',
	'meta_value' => 0, 
    'order' => 'asc',
  );
  $members = get_posts($args);
	
if ($_SESSION['ML']=='FR'){
  $lang='FR';
}else{
  $lang='EN';
}
  $button = ($lang == 'FR') ? 'En savoir plus' : 'Read more';
  $alumni = ($lang == 'FR') ? 'Nos Alumni' : 'Our Alumni';
  $status_list = ($lang == 'FR') ? get_terms( 'member_status_tax_fr') : get_terms( 'member_status_tax');
  $placeholder = ($lang == 'FR') ? 'Recherchez' : 'Search';

  $select_status_label = ($lang == 'FR') ? 'Statuts (Tous)' : 'Status (All)';
  $select_team_label = ($lang == 'FR') ? 'Equipes (Tous)' : 'Teams (All)';
	
  $banner = get_field("section_member_image",'option')['sizes']["large"];
  $titre= ($lang == 'FR') ? 'Annuaire' : 'Directory';

  ?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="rb-container flex justify-center items-center"
     style="background-size: cover;
           background-position: center;
           background-image: url(<?php echo $banner; ?>);">
           <div class="rb-overlay w-full h-full flex justify-center items-center">
<h1 class="rb-font font-bold"><?php echo $titre; ?></h1>
</div>
</div>

<div style="width:80%; margin:auto;" class="o-wrapper" >
	<div class="flex flex-wrap">
  		<div class="select_container w-3/12 grow">
  			<input id="annuaire_search"  oninput="show_member()" type="text"   placeholder="<?php echo $placeholder;?>">
 		</div>

	<div class="select_container w-3/12 grow">
		<div class="custom-select">
	 		<select id="select_status"  onchange="show_member();">
		  	<option value=""><?php echo $select_status_label ;?> </option>
			  <?php
			   foreach ($status_list as $status) {
				 echo '<option value="'.$status->name.'">'.$status->name.'</option>"';
			   }
			   ?>
	 		</select>
	   </div>
	</div>


  <div class="select_container w-3/12 grow">
    <div class="custom-select">
      <select id="select_team"  onchange="show_member();">
          <option value=""><?php echo $select_team_label ;?> </option>
          <?php
           foreach ($teams as $team) {
             $id=$team->ID;
             $team_name=($lang == 'FR') ? get_field('team_name_fr',$id): get_field('team_name',$id);
             echo '<option value="'.$team_name.'">'.$team_name.'</option>"';
           }
           ?>
      </select>
    </div>
  </div>
		
		<a href="https://icr.univ-amu.fr/alumni/" class="select_container w-3/12 flex grow">
		<button class="but mx-auto mb-2 py-2 px-2 no-underline  grow
			   hover:no-underline hover:bg-slate-300 hover:text-blue-800
			   focus:bg-white focus:text-blue-800 ">
		<?php echo $alumni; ?> </button>
		</a>
		
</div>


  <div id="team" class="flex flex-col justify-evenly">
    <div class="flex mx-auto">

      <div class="wrapper flex flex-wrap justify-left gap-5">

<?php

          foreach ($members as $member) {
            $id = $member->ID;
            if (get_field('member_team', $id)){
              $member_team_id=get_field('member_team', $id)[0]->ID;
              $team_name=($lang == 'FR') ? get_field('team_name_fr',$member_team_id): get_field('team_name',$member_team_id);
            }
            else{
              $team_name="None";
            }

            $status= ($lang == 'FR') ? get_field('member_status_fr', $id) :  get_field('member_status', $id);

            if (empty((get_field('member_picture', $id)))) {
              $image = "https://icr.univ-amu.fr/wp-content/uploads/2023/01/membre-icr-amu.webp";
            } else {
              $image = get_field('member_picture', $id)['sizes']['medium'];
            }
?>
		  
          <div class="bg-orange-600 box-orange member-card"
          data_team="<?php echo $team_name;?>"
          data_status="<?php echo($status);?>"
          data_name="<?php echo get_field('member_last_name',$id).' '.get_field('member_first_name',$id);?>">

              <div class="container">
                <img src="<?php echo $image; ?>"
                  alt="<?php echo get_field('member_first_name', $id); ?>     <?php echo get_field('member_last_name', $id); ?>">


                <div class="overlay flex flex-col">
                  <h3 class="text_overlay px-2 pt-6 text-center">
                  <?php echo $status; ?>
                  </h3>
                  <h4 class="px-2 text-xs text-center">
                    <?php echo get_field('member_email', $id); ?>
                  </h4>
                  <a href="<?php echo get_post_permalink( $id ); ?>" class="flex no-underline hover:no-underline">
                  <button class="but mx-auto mb-2 py-2 px-2 no-underline hover:no-underline focus:bg-white focus:text-blue-800 hover:bg-white hover:text-blue-800"><?php echo $button; ?> </button>
                   </a>
                </div>
              </div>

            <div class="py-2 text-lg text-white text-center no-underline hover:no-underline">
                  <?php echo get_field('member_first_name', $id); ?> <br>
                  <?php echo get_field('member_last_name', $id); ?>
				  <?php  if (get_field('member_is_alumni', $id)) {
								echo "(alumni)";
							   }	?>
				
                </div>
          </div>



        <?php
        }
        echo ' </div> </div> </div></div>';
}
