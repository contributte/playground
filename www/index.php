<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Contribuute playground</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
	<div class="content">
		<h2>Examples</h2>
		<table>
			<tr>
				<th>Title</th>
			</tr>
			<?php foreach(glob('../*', GLOB_ONLYDIR) as $dir) { ?>
			<tr class="text-center">
			<?php
			if ($dir !== '../www') {
				echo '<td>';
				$dir = str_replace('../', '', $dir);
				echo "<a href=\"http://$dir.localhost\" target='_blank'>$dir</a>";
				echo '</td>';
			}
			?>
			</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>

