<div class="wrap">
<h1>JMS POST URL Rewrite Rule Generator</h1>

<form name="form" method="post">
<input type="hidden" id="action" name="action" value="post_rule">
<?php wp_nonce_field( 'post_rule' ); ?>
<p>This plugin offers you a way to generate URL Rewrite rules to make 301 permanent redirection. If you have 50+, 100+ or 200+ posts and you want to restructure your website URL structure. This plugin will help you generate all redirection rules for you. Just copy and paste the rules into your .htaccess files. A <a href="https://codex.wordpress.org/Using_Permalinks">number of tags are available</a> here. If you have any questions, please contact us here.</p>

<h2 class="title">Generate URL Rewrite Rules for POST</h2>
<table class="form-table permalink-structure">
	<tbody>
	<tr>
		<th><label for="old_permalink">Old Permalink Setting</label></th>
		<td>
			<input name="old_permalink" id="old_permalink" type="text" value="<?php if(isset($oldPermalink)) {echo $oldPermalink;} ?>" class="regular-text code">
			<div style="margin: 5px 0;"><code>http://jmsliu.com/%post_id%/%postname%.html</code></div>
		</td>
	</tr>
	<tr>
		<th><label for="new_permalink">New Permalink Setting</label></th>
		<td>
			<input name="new_permalink" id="new_permalink" type="text" value="<?php if(isset($newPermalink)) {echo $newPermalink;} ?>" class="regular-text code">
			<div style="margin: 5px 0;"><code>http://jmsliu.com/%category%/%postname%.html</code></div>
		</td>
	</tr>
</tbody></table>


<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Generate Rules"></p>
</form>

<?php
	if(isset($rules)) {
?>
	<textarea class="large-text code" rows="<?php echo count($rules) > 3 ? count($rules) : 3; ?>"><?php
		foreach ($rules as $rule) {
			echo $rule."\n";
		}
	?></textarea>
<?php
	}
?>
</div>