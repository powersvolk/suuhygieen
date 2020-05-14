<?php $text = __('SEARCH','suuhygieen');?>
<?php 
$search_text = empty($_GET['s']) ? $text : get_search_query(); ?>
<form method="get" class="header-search-form" id="searchform" action="<?php bloginfo('home'); ?>/"> 
	<button type="submit">
		<img src="<?php bloginfo('template_url');?>/img/icons/search.svg">
	</button>
	<input type="text" value="<?php echo $search_text; ?>" 
            name="s" id="s"  onblur="if (this.value == '')  {this.value = '<?php echo $search_text; ?>';}"  
            onfocus="if (this.value == '<?php echo $search_text; ?>') {this.value = '';}" />

</form>

