// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(function() {
	// Create the data table.
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Name');
	data.addColumn('number', 'Amount');
	data.addRows([
<?php foreach ($data as $d): ?>
		['<?php echo $d[0]; ?>',<?php echo abs($d[1]); ?>],
<?php endforeach; ?>
	]);

	// Set chart options
	var options = {'pieHole': 0.25};

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.PieChart(
		document.getElementById(<?php echo "'$id'"; ?>)
	);

	chart.draw(data, options);
});
