<div class="wrap">
<h1>JMS POST URL Rewrite Rule Generator</h1>

<form name="form" method="post">
<input type="hidden" id="action" name="action" value="fixed_rule">
<?php wp_nonce_field( 'fixed_rule' ); ?>

<h2 class="title">Generate URL Rewrite Rules for Fixed URL</h2>
<p>This plugin offers you a way to generate URL Rewrite rules to make 301 permanent redirection. In this section, you can generate URL Rewrite rules for fixed url. Please provide your old url and new url, we will provide the URL rewrite rule. You can copy and paste the rule in .htaccess. Check <a href="https://jmsliu.com/4315/improving-site-structure-in-wordpress.html">this post</a> about why you need this plugin.</p>

<table class="form-table permalink-structure">
	<tbody>
	<tr>
		<th><label for="old_permalink">Old URL</label></th>
		<td>
			<input name="old_permalink" id="old_permalink" type="text" value="<?php if(isset($oldPermalink)) {echo $oldPermalink;} ?>" class="regular-text code">
			<div style="margin: 5px 0;"><code>http://jmsliu.com/category/android-2/</code></div>
		</td>
	</tr>
	<tr>
		<th><label for="new_permalink">New URLg</label></th>
		<td>
			<input name="new_permalink" id="new_permalink" type="text" value="<?php if(isset($newPermalink)) {echo $newPermalink;} ?>" class="regular-text code">
			<div style="margin: 5px 0;"><code>http://jmsliu.com/category/android/</code></div>
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